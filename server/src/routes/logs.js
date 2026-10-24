const express = require('express');
const router = express.Router();
const { getDb } = require('../db/database');

// GET /api/logs - Lấy nhật ký gửi tin
router.get('/', (req, res) => {
  try {
    const db = getDb();
    const { page = 1, limit = 50, status, group, date } = req.query;
    const offset = (parseInt(page) - 1) * parseInt(limit);

    let where = [];
    let params = [];

    if (status) {
      where.push('status = ?');
      params.push(status);
    }
    if (group) {
      where.push('group_identifier LIKE ?');
      params.push(`%${group}%`);
    }
    if (date) {
      where.push("DATE(sent_at) = ?");
      params.push(date);
    }

    const whereClause = where.length > 0 ? 'WHERE ' + where.join(' AND ') : '';

    const total = db.prepare(`SELECT COUNT(*) as count FROM send_logs ${whereClause}`).get(...params);
    const logs = db.prepare(`
      SELECT * FROM send_logs ${whereClause}
      ORDER BY sent_at DESC
      LIMIT ? OFFSET ?
    `).all(...params, parseInt(limit), offset);

    res.json({
      success: true,
      data: logs,
      pagination: {
        total: total.count,
        page: parseInt(page),
        limit: parseInt(limit),
        pages: Math.ceil(total.count / parseInt(limit))
      }
    });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// DELETE /api/logs - Xóa toàn bộ log
router.delete('/', (req, res) => {
  try {
    const db = getDb();
    db.prepare('DELETE FROM send_logs').run();
    res.json({ success: true, message: 'Đã xóa toàn bộ nhật ký' });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

module.exports = router;
