const express = require('express');
const router = express.Router();
const { getDb } = require('../db/database');
const { sendOtp, verifyOtp, disconnectClient, getActiveClients } = require('../services/telegramClient');

// GET /api/accounts - Lấy danh sách tài khoản
router.get('/', (req, res) => {
  try {
    const db = getDb();
    const accounts = db.prepare(`
      SELECT id, phone, api_id, username, first_name, status, flood_wait_until, created_at, updated_at
      FROM accounts
    `).all();

    // Gắn trạng thái realtime từ active clients
    const activeClients = getActiveClients();
    const enriched = accounts.map(acc => ({
      ...acc,
      is_online: activeClients.has(acc.phone) && activeClients.get(acc.phone).connected,
      flood_wait_remaining: acc.flood_wait_until > Date.now()
        ? Math.ceil((acc.flood_wait_until - Date.now()) / 1000)
        : 0
    }));

    res.json({ success: true, data: enriched });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// POST /api/accounts/send-otp - Bước 1: Gửi OTP
router.post('/send-otp', async (req, res) => {
  const { phone, api_id, api_hash } = req.body;

  if (!phone || !api_id || !api_hash) {
    return res.status(400).json({ success: false, error: 'Thiếu thông tin: phone, api_id, api_hash' });
  }

  try {
    await sendOtp(phone, api_id, api_hash);
    res.json({ success: true, message: 'OTP đã được gửi về Telegram của bạn' });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// POST /api/accounts/verify-otp - Bước 2: Xác thực OTP
router.post('/verify-otp', async (req, res) => {
  const { phone, code, password } = req.body;

  if (!phone || !code) {
    return res.status(400).json({ success: false, error: 'Thiếu phone hoặc code' });
  }

  try {
    const result = await verifyOtp(phone, code, password);
    res.json({ success: true, data: result, message: 'Đăng nhập thành công!' });
  } catch (err) {
    if (err.message === 'NEED_2FA_PASSWORD') {
      return res.status(428).json({ success: false, error: 'NEED_2FA_PASSWORD', need2fa: true });
    }
    res.status(500).json({ success: false, error: err.message });
  }
});

// DELETE /api/accounts/:id - Xóa tài khoản
router.delete('/:id', async (req, res) => {
  try {
    const db = getDb();
    const account = db.prepare('SELECT * FROM accounts WHERE id = ?').get(req.params.id);
    if (!account) {
      return res.status(404).json({ success: false, error: 'Tài khoản không tồn tại' });
    }

    await disconnectClient(account.phone);
    db.prepare('DELETE FROM accounts WHERE id = ?').run(req.params.id);

    res.json({ success: true, message: 'Đã xóa tài khoản' });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// POST /api/accounts/:id/disconnect - Ngắt kết nối
router.post('/:id/disconnect', async (req, res) => {
  try {
    const db = getDb();
    const account = db.prepare('SELECT * FROM accounts WHERE id = ?').get(req.params.id);
    if (!account) {
      return res.status(404).json({ success: false, error: 'Tài khoản không tồn tại' });
    }

    await disconnectClient(account.phone);
    res.json({ success: true, message: 'Đã ngắt kết nối' });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

module.exports = router;
