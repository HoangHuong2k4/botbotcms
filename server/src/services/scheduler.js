const cron = require('node-cron');
const { getDb } = require('../db/database');
const { sendMessage, reconnectAllAccounts, updateAccountStatus } = require('./telegramClient');
const { unspin } = require('../utils/spintax');
const path = require('path');

// Lưu trữ các cron jobs đang chạy
const activeJobs = new Map();
// Trạng thái của dispatcher
let isRunning = false;
let currentRun = null;

/**
 * Trộn ngẫu nhiên mảng (Fisher-Yates shuffle)
 */
function shuffleArray(arr) {
  const a = [...arr];
  for (let i = a.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [a[i], a[j]] = [a[j], a[i]];
  }
  return a;
}

/**
 * Ngủ trong khoảng thời gian ngẫu nhiên
 */
function randomDelay(minSec, maxSec) {
  const ms = (Math.floor(Math.random() * (maxSec - minSec + 1)) + minSec) * 1000;
  return new Promise(resolve => setTimeout(resolve, ms));
}

/**
 * Ghi nhật ký vào database
 */
function writeLog(groupIdentifier, groupTitle, templateId, templateName, status, errorMessage = null) {
  const db = getDb();
  db.prepare(`
    INSERT INTO send_logs (group_identifier, group_title, template_id, template_name, status, error_message)
    VALUES (?, ?, ?, ?, ?, ?)
  `).run(groupIdentifier, groupTitle, templateId, templateName, status, errorMessage);
}

/**
 * Chọn template ngẫu nhiên trong danh sách active
 */
function pickRandomTemplate(templates) {
  if (!templates || templates.length === 0) return null;
  return templates[Math.floor(Math.random() * templates.length)];
}

/**
 * Dispatch: Gửi tin nhắn đến nhóm (tất cả hoặc 1 nhóm cụ thể)
 */
async function dispatch(targetGroupId = null) {
  if (isRunning) {
    console.log('⏳ Dispatcher đang chạy, bỏ qua lần này');
    return { skipped: true, reason: 'Dispatcher đang chạy' };
  }

  const db = getDb();

  // Lấy tài khoản đang connected
  const account = db.prepare("SELECT * FROM accounts WHERE status = 'connected' LIMIT 1").get();
  if (!account) {
    console.warn('⚠️ Không có tài khoản nào đang kết nối');
    return { skipped: true, reason: 'Không có tài khoản kết nối' };
  }

  // Kiểm tra flood wait
  if (account.flood_wait_until && account.flood_wait_until > Date.now()) {
    const remaining = Math.ceil((account.flood_wait_until - Date.now()) / 1000);
    console.warn(`⏰ Tài khoản đang FloodWait, còn ${remaining}s`);
    return { skipped: true, reason: `FloodWait: còn ${remaining}s` };
  }

  // Lấy danh sách nhóm
  let groups;
  if (targetGroupId) {
    groups = db.prepare('SELECT * FROM groups WHERE id = ?').all(targetGroupId);
  } else {
    groups = db.prepare('SELECT * FROM groups WHERE is_active = 1').all();
  }

  if (groups.length === 0) {
    console.warn('⚠️ Không có nhóm nào đang active');
    return { skipped: true, reason: 'Không có nhóm active' };
  }

  // Lấy templates active (fallback toàn bộ nếu nhóm không cài riêng)
  const allTemplates = db.prepare('SELECT * FROM templates WHERE is_active = 1').all();
  if (allTemplates.length === 0) {
    console.warn('⚠️ Không có template nào');
    return { skipped: true, reason: 'Không có template' };
  }


  // Lấy cài đặt
  const settings = db.prepare('SELECT key, value FROM settings').all();
  const settingsMap = Object.fromEntries(settings.map(s => [s.key, s.value]));
  const delayMin = parseInt(settingsMap.delay_min) || 35;
  const delayMax = parseInt(settingsMap.delay_max) || 65;
  const shuffle = settingsMap.shuffle_groups !== '0';

  // Đảo thứ tự nhóm nếu được bật
  if (shuffle) {
    groups = shuffleArray(groups);
  }

  isRunning = true;
  let successCount = 0;
  let failCount = 0;

  currentRun = {
    startedAt: new Date().toISOString(),
    total: groups.length,
    done: 0,
    success: 0,
    fail: 0,
  };

  console.log(`🚀 Bắt đầu dispatch: ${groups.length} nhóm`);

  for (let i = 0; i < groups.length; i++) {
    if (!isRunning) break; // Cho phép dừng giữa chừng

    const group = groups[i]

    // Lấy template của nhóm này (nếu có gán riêng), không thì dùng tất cả
    const groupTemplates = db.prepare(`
      SELECT t.* FROM templates t
      INNER JOIN group_templates gt ON gt.template_id = t.id
      WHERE gt.group_id = ? AND t.is_active = 1
    `).all(group.id)

    const templatePool = groupTemplates.length > 0 ? groupTemplates : allTemplates
    const template = pickRandomTemplate(templatePool)


    // Spin nội dung
    let messageText;
    try {
      messageText = unspin(template.content);
    } catch (_) {
      messageText = template.content;
    }

    // Lấy đường dẫn ảnh nếu có
    let imagePath = null;
    if (template.image_path) {
      const resolvedPath = path.resolve(process.env.UPLOADS_DIR || './uploads', template.image_path);
      if (require('fs').existsSync(resolvedPath)) {
        imagePath = resolvedPath;
      }
    }

    try {
      await sendMessage(account.phone, group.identifier, messageText, imagePath);
      writeLog(group.identifier, group.title, template.id, template.name, 'success');
      db.prepare('UPDATE groups SET last_sent_at = CURRENT_TIMESTAMP WHERE id = ?').run(group.id);
      successCount++;
      currentRun.success++;
      console.log(`✅ [${i + 1}/${groups.length}] Gửi thành công → ${group.identifier}`);
    } catch (err) {
      const errMsg = err.message || String(err);

      if (errMsg.startsWith('FLOOD_WAIT:')) {
        const seconds = parseInt(errMsg.split(':')[1]) || 60;
        console.warn(`🚨 FLOOD_WAIT ${seconds}s - Tạm dừng dispatcher`);
        writeLog(group.identifier, group.title, template.id, template.name, 'failed', `FloodWait ${seconds}s`);

        // Cập nhật trạng thái flood wait
        updateAccountStatus(account.phone, 'flood_wait', Date.now() + seconds * 1000);

        // Dừng hoàn toàn và đợi
        isRunning = false;
        failCount++;
        currentRun.fail++;

        // Lên lịch tiếp tục sau khi hết flood wait
        setTimeout(async () => {
          updateAccountStatus(account.phone, 'connected');
        }, seconds * 1000);

        break;
      }

      // Các lỗi khác (nhóm bị cấm, không phải member, v.v.)
      console.warn(`❌ [${i + 1}/${groups.length}] Lỗi → ${group.identifier}: ${errMsg}`);
      writeLog(group.identifier, group.title, template.id, template.name, 'failed', errMsg);
      failCount++;
      currentRun.fail++;
    }

    currentRun.done = i + 1;

    // Nghỉ ngẫu nhiên giữa các nhóm (trừ nhóm cuối)
    if (i < groups.length - 1 && isRunning) {
      console.log(`⏳ Nghỉ ${delayMin}s-${delayMax}s trước nhóm tiếp theo...`);
      await randomDelay(delayMin, delayMax);
    }
  }

  isRunning = false;
  console.log(`🏁 Dispatch hoàn thành: ${successCount} thành công, ${failCount} thất bại`);

  const result = { ...currentRun, success: successCount, fail: failCount };
  currentRun = null;
  return result;
}

/**
 * Dừng dispatcher đang chạy
 */
function stopDispatch() {
  isRunning = false;
}

/**
 * Lấy trạng thái hiện tại của dispatcher
 */
function getDispatchStatus() {
  return {
    isRunning,
    currentRun,
  };
}

/**
 * Đăng ký cron job theo time slot
 */
function registerCronJob(timeSlot, id) {
  // Dừng job cũ nếu có
  if (activeJobs.has(id)) {
    activeJobs.get(id).stop();
    activeJobs.delete(id);
  }

  const [hour, minute] = timeSlot.split(':');
  const cronExpression = `${minute} ${hour} * * *`;

  const job = cron.schedule(cronExpression, async () => {
    console.log(`⏰ Cron trigger: ${timeSlot}`);
    await dispatch();
  }, {
    timezone: 'Asia/Ho_Chi_Minh'
  });

  activeJobs.set(id, job);
  console.log(`📅 Đăng ký cron: ${timeSlot} (${cronExpression})`);
}

/**
 * Tải và khởi động tất cả cron jobs từ DB
 */
async function initScheduler() {
  // Kết nối lại tất cả tài khoản có session
  await reconnectAllAccounts();

  const db = getDb();
  const slots = db.prepare('SELECT * FROM schedule_config WHERE is_active = 1').all();
  
  slots.forEach(slot => {
    registerCronJob(slot.time_slot, slot.id);
  });

  console.log(`📅 Đã load ${slots.length} khung giờ gửi tin`);
}

/**
 * Cập nhật lại toàn bộ cron jobs (gọi khi thay đổi lịch)
 */
async function reloadScheduler() {
  // Dừng tất cả jobs cũ
  activeJobs.forEach(job => job.stop());
  activeJobs.clear();

  // Tải lại từ DB
  const db = getDb();
  const slots = db.prepare('SELECT * FROM schedule_config WHERE is_active = 1').all();
  slots.forEach(slot => {
    registerCronJob(slot.time_slot, slot.id);
  });

  return slots;
}

module.exports = {
  dispatch,
  stopDispatch,
  getDispatchStatus,
  initScheduler,
  reloadScheduler,
  registerCronJob,
};
