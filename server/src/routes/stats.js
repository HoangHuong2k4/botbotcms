const express = require('express');
const router = express.Router();
const { getDb } = require('../db/database');

// GET /api/stats - Thống kê tổng quan
router.get('/', (req, res) => {
  try {
    const db = getDb();
    const today = new Date().toISOString().split('T')[0];

    // Tổng nhóm active
    const activeGroups = db.prepare("SELECT COUNT(*) as count FROM groups WHERE is_active = 1").get();

    // Số tin gửi hôm nay
    const todaySent = db.prepare(`
      SELECT COUNT(*) as count FROM send_logs
      WHERE DATE(sent_at) = ? AND status = 'success'
    `).get(today);

    // Số tin gửi thành công tổng
    const totalSuccess = db.prepare("SELECT COUNT(*) as count FROM send_logs WHERE status = 'success'").get();
    const totalFail = db.prepare("SELECT COUNT(*) as count FROM send_logs WHERE status = 'failed'").get();
    const totalLogs = db.prepare("SELECT COUNT(*) as count FROM send_logs").get();

    // Tỷ lệ thành công
    const successRate = totalLogs.count > 0
      ? ((totalSuccess.count / totalLogs.count) * 100).toFixed(1)
      : 0;

    // Lịch gửi sắp tới hôm nay
    const activeSlots = db.prepare("SELECT time_slot FROM schedule_config WHERE is_active = 1 ORDER BY time_slot").all();

    // Log 5 mục gần nhất
    const recentLogs = db.prepare("SELECT * FROM send_logs ORDER BY sent_at DESC LIMIT 5").all();

    // Thống kê 7 ngày
    const last7Days = db.prepare(`
      SELECT DATE(sent_at) as date,
        SUM(CASE WHEN status = 'success' THEN 1 ELSE 0 END) as success,
        SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) as failed
      FROM send_logs
      WHERE sent_at >= DATE('now', '-6 days')
      GROUP BY DATE(sent_at)
      ORDER BY date ASC
    `).all();

    res.json({
      success: true,
      data: {
        activeGroups: activeGroups.count,
        todaySent: todaySent.count,
        totalSuccess: totalSuccess.count,
        totalFail: totalFail.count,
        successRate: parseFloat(successRate),
        activeSlots: activeSlots.map(s => s.time_slot),
        recentLogs,
        last7Days,
      }
    });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

module.exports = router;
