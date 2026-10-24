const express = require('express');
const router = express.Router();
const { getDb } = require('../db/database');
const { unspin } = require('../utils/spintax');
const path = require('path');
const fs = require('fs');

const UPLOADS_DIR = process.env.UPLOADS_DIR || './uploads';

// GET /api/templates
router.get('/', (req, res) => {
  try {
    const db = getDb();
    const templates = db.prepare('SELECT * FROM templates ORDER BY created_at DESC').all();
    res.json({ success: true, data: templates });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// POST /api/templates - Tạo template mới
router.post('/', (req, res) => {
  try {
    const db = getDb();
    const { name, content, is_active } = req.body;

    if (!name || !content) {
      return res.status(400).json({ success: false, error: 'Thiếu name hoặc content' });
    }

    let image_path = null;

    // Xử lý upload ảnh
    if (req.files && req.files.image) {
      const file = req.files.image;
      const ext = path.extname(file.name) || '.jpg';
      const filename = `${Date.now()}_${Math.random().toString(36).substr(2, 9)}${ext}`;
      const savePath = path.join(path.resolve(UPLOADS_DIR), filename);
      file.mv(savePath);
      image_path = filename;
    }

    const result = db.prepare(`
      INSERT INTO templates (name, content, image_path, is_active)
      VALUES (?, ?, ?, ?)
    `).run(name, content, image_path, is_active !== undefined ? (is_active ? 1 : 0) : 1);

    const template = db.prepare('SELECT * FROM templates WHERE id = ?').get(result.lastInsertRowid);
    res.json({ success: true, data: template });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// PUT /api/templates/:id - Cập nhật template
router.put('/:id', (req, res) => {
  try {
    const db = getDb();
    const { name, content, is_active } = req.body;
    const template = db.prepare('SELECT * FROM templates WHERE id = ?').get(req.params.id);
    if (!template) {
      return res.status(404).json({ success: false, error: 'Template không tồn tại' });
    }

    let image_path = template.image_path;

    // Xử lý ảnh mới nếu có
    if (req.files && req.files.image) {
      // Xóa ảnh cũ
      if (template.image_path) {
        const oldPath = path.join(path.resolve(UPLOADS_DIR), template.image_path);
        if (fs.existsSync(oldPath)) fs.unlinkSync(oldPath);
      }
      const file = req.files.image;
      const ext = path.extname(file.name) || '.jpg';
      const filename = `${Date.now()}_${Math.random().toString(36).substr(2, 9)}${ext}`;
      const savePath = path.join(path.resolve(UPLOADS_DIR), filename);
      file.mv(savePath);
      image_path = filename;
    }

    // Xóa ảnh nếu client yêu cầu
    if (req.body.remove_image === '1' || req.body.remove_image === 'true') {
      if (template.image_path) {
        const oldPath = path.join(path.resolve(UPLOADS_DIR), template.image_path);
        if (fs.existsSync(oldPath)) fs.unlinkSync(oldPath);
      }
      image_path = null;
    }

    db.prepare(`
      UPDATE templates SET name = ?, content = ?, image_path = ?, is_active = ?, updated_at = CURRENT_TIMESTAMP
      WHERE id = ?
    `).run(
      name ?? template.name,
      content ?? template.content,
      image_path,
      is_active !== undefined ? (is_active ? 1 : 0) : template.is_active,
      req.params.id
    );

    const updated = db.prepare('SELECT * FROM templates WHERE id = ?').get(req.params.id);
    res.json({ success: true, data: updated });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// DELETE /api/templates/:id
router.delete('/:id', (req, res) => {
  try {
    const db = getDb();
    const template = db.prepare('SELECT * FROM templates WHERE id = ?').get(req.params.id);
    if (!template) {
      return res.status(404).json({ success: false, error: 'Template không tồn tại' });
    }

    // Xóa file ảnh
    if (template.image_path) {
      const imgPath = path.join(path.resolve(UPLOADS_DIR), template.image_path);
      if (fs.existsSync(imgPath)) fs.unlinkSync(imgPath);
    }

    db.prepare('DELETE FROM templates WHERE id = ?').run(req.params.id);
    res.json({ success: true, message: 'Đã xóa template' });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// POST /api/templates/preview-spintax - Xem trước spintax
router.post('/preview-spintax', (req, res) => {
  try {
    const { content } = req.body;
    if (!content) {
      return res.status(400).json({ success: false, error: 'Thiếu content' });
    }

    // Tạo nhiều biến thể để xem trước
    const previews = [];
    for (let i = 0; i < 5; i++) {
      try {
        previews.push(unspin(content));
      } catch (_) {
        previews.push(content);
      }
    }

    res.json({ success: true, data: { previews } });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

module.exports = router;
