const express = require('express');
const router = express.Router();
const { getDb } = require('../db/database');
const { dispatch, stopDispatch, getDispatchStatus, reloadScheduler } = require('../services/scheduler');

// GET /api/scheduler/config - Lấy cấu hình lịch
router.get('/config', (req, res) => {
  try {
    const db = getDb();
    const slots = db.prepare('SELECT * FROM schedule_config ORDER BY time_slot').all();
    const settings = db.prepare('SELECT key, value FROM settings').all();
    const settingsMap = Object.fromEntries(settings.map(s => [s.key, s.value]));

    res.json({ success: true, data: { slots, settings: settingsMap } });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// POST /api/scheduler/config/slots - Thêm khung giờ
router.post('/config/slots', async (req, res) => {
  try {
    const { time_slot } = req.body;
    if (!time_slot || !/^\d{2}:\d{2}$/.test(time_slot)) {
      return res.status(400).json({ success: false, error: 'time_slot không hợp lệ (định dạng HH:MM)' });
    }

    const db = getDb();
    const existing = db.prepare('SELECT id FROM schedule_config WHERE time_slot = ?').get(time_slot);
    if (existing) {
      return res.status(409).json({ success: false, error: 'Khung giờ đã tồn tại' });
    }

    const result = db.prepare('INSERT INTO schedule_config (time_slot, is_active) VALUES (?, 1)').run(time_slot);
    await reloadScheduler();

    const slot = db.prepare('SELECT * FROM schedule_config WHERE id = ?').get(result.lastInsertRowid);
    res.json({ success: true, data: slot });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// PATCH /api/scheduler/config/slots/:id - Bật/Tắt khung giờ
router.patch('/config/slots/:id/toggle', async (req, res) => {
  try {
    const db = getDb();
    const slot = db.prepare('SELECT * FROM schedule_config WHERE id = ?').get(req.params.id);
    if (!slot) {
      return res.status(404).json({ success: false, error: 'Không tìm thấy khung giờ' });
    }

    const newStatus = slot.is_active ? 0 : 1;
    db.prepare('UPDATE schedule_config SET is_active = ? WHERE id = ?').run(newStatus, req.params.id);
    await reloadScheduler();

    res.json({ success: true, data: { ...slot, is_active: newStatus } });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// DELETE /api/scheduler/config/slots/:id - Xóa khung giờ
router.delete('/config/slots/:id', async (req, res) => {
  try {
    const db = getDb();
    db.prepare('DELETE FROM schedule_config WHERE id = ?').run(req.params.id);
    await reloadScheduler();
    res.json({ success: true, message: 'Đã xóa khung giờ' });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// PUT /api/scheduler/config/settings - Cập nhật settings
router.put('/config/settings', async (req, res) => {
  try {
    const { delay_min, delay_max, shuffle_groups } = req.body;
    const db = getDb();

    const upsert = db.prepare('INSERT OR REPLACE INTO settings (key, value) VALUES (?, ?)');
    const update = db.transaction(() => {
      if (delay_min !== undefined) upsert.run('delay_min', String(delay_min));
      if (delay_max !== undefined) upsert.run('delay_max', String(delay_max));
      if (shuffle_groups !== undefined) upsert.run('shuffle_groups', shuffle_groups ? '1' : '0');
    });
    update();

    res.json({ success: true, message: 'Đã cập nhật cài đặt' });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// POST /api/scheduler/run-now - Chạy thủ công ngay
router.post('/run-now', async (req, res) => {
  try {
    const status = getDispatchStatus();
    if (status.isRunning) {
      return res.status(409).json({ success: false, error: 'Dispatcher đang chạy. Vui lòng đợi.' });
    }

    // Chạy bất đồng bộ và trả về ngay
    dispatch().then(result => {
      console.log('Manual dispatch kết thúc:', result);
    }).catch(err => {
      console.error('Manual dispatch lỗi:', err);
    });

    res.json({ success: true, message: 'Bắt đầu gửi tin. Xem nhật ký để theo dõi tiến trình.' });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// POST /api/scheduler/run-group/:id - Gửi tin ngay cho 1 nhóm cụ thể
router.post('/run-group/:id', async (req, res) => {
  try {
    const status = getDispatchStatus();
    if (status.isRunning) {
      return res.status(409).json({ success: false, error: 'Dispatcher đang chạy. Vui lòng đợi.' });
    }

    dispatch(req.params.id).then(result => {
      console.log(`Manual group ${req.params.id} dispatch kết thúc:`, result);
    }).catch(err => {
      console.error(`Manual group ${req.params.id} dispatch lỗi:`, err);
    });

    res.json({ success: true, message: 'Bắt đầu gửi tin đến nhóm. Xem nhật ký để theo dõi tiến trình.' });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});


// POST /api/scheduler/stop - Dừng dispatcher
router.post('/stop', (req, res) => {
  try {
    stopDispatch();
    res.json({ success: true, message: 'Đã gửi lệnh dừng dispatcher' });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// GET /api/scheduler/status - Trạng thái dispatcher
router.get('/status', (req, res) => {
  try {
    const status = getDispatchStatus();
    res.json({ success: true, data: status });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

module.exports = router;
