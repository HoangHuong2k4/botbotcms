const express = require('express');
const router = express.Router();
const { getDb } = require('../db/database');

// GET /api/groups - Lấy tất cả nhóm
router.get('/', (req, res) => {
  try {
    const db = getDb();
    const groups = db.prepare('SELECT * FROM groups ORDER BY created_at DESC').all();
    res.json({ success: true, data: groups });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// POST /api/groups - Thêm nhóm (1 hoặc nhiều)
router.post('/', (req, res) => {
  try {
    const db = getDb();
    const { identifier, bulk } = req.body;

    if (bulk) {
      // Nhập hàng loạt: mỗi dòng 1 nhóm
      const lines = bulk.split('\n')
        .map(l => l.trim())
        .filter(l => l.length > 0);

      const insertGroup = db.prepare(`
        INSERT OR IGNORE INTO groups (identifier, title)
        VALUES (?, ?)
      `);

      let added = 0;
      const insertMany = db.transaction(() => {
        for (const line of lines) {
          // Chuẩn hóa identifier
          let ident = line.trim();
          if (ident.includes('t.me/')) {
            if (!ident.startsWith('http')) ident = 'https://' + ident;
            
            const parts = ident.split('t.me/')[1].split('/');
            if (parts.length === 1 && !parts[0].startsWith('+')) {
              ident = '@' + parts[0];
            }
          } else if (!ident.startsWith('@') && !ident.startsWith('-') && !ident.startsWith('+') && !ident.startsWith('http')) {
            ident = '@' + ident;
          }

          const result = insertGroup.run(ident, ident);
          if (result.changes > 0) added++;
        }
      });

      insertMany();
      return res.json({ success: true, message: `Đã thêm ${added} nhóm`, added });
    }

    if (!identifier) {
      return res.status(400).json({ success: false, error: 'Thiếu identifier' });
    }

    let ident = identifier.trim();
    if (ident.includes('t.me/')) {
      if (!ident.startsWith('http')) ident = 'https://' + ident;
      
      const parts = ident.split('t.me/')[1].split('/');
      if (parts.length === 1 && !parts[0].startsWith('+')) {
        ident = '@' + parts[0];
      }
    } else if (!ident.startsWith('@') && !ident.startsWith('-') && !ident.startsWith('+') && !ident.startsWith('http')) {
      ident = '@' + ident;
    }


    db.prepare('INSERT OR IGNORE INTO groups (identifier, title) VALUES (?, ?)').run(ident, ident);
    const group = db.prepare('SELECT * FROM groups WHERE identifier = ?').get(ident);
    res.json({ success: true, data: group });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// PUT /api/groups/:id - Cập nhật nhóm
router.put('/:id', (req, res) => {
  try {
    const db = getDb();
    const { title, is_active } = req.body;
    const group = db.prepare('SELECT * FROM groups WHERE id = ?').get(req.params.id);
    if (!group) {
      return res.status(404).json({ success: false, error: 'Nhóm không tồn tại' });
    }

    db.prepare('UPDATE groups SET title = ?, is_active = ? WHERE id = ?')
      .run(title ?? group.title, is_active ?? group.is_active, req.params.id);

    const updated = db.prepare('SELECT * FROM groups WHERE id = ?').get(req.params.id);
    res.json({ success: true, data: updated });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// PATCH /api/groups/:id/toggle - Bật/Tắt nhóm
router.patch('/:id/toggle', (req, res) => {
  try {
    const db = getDb();
    const group = db.prepare('SELECT * FROM groups WHERE id = ?').get(req.params.id);
    if (!group) {
      return res.status(404).json({ success: false, error: 'Nhóm không tồn tại' });
    }

    const newStatus = group.is_active ? 0 : 1;
    db.prepare('UPDATE groups SET is_active = ? WHERE id = ?').run(newStatus, req.params.id);

    res.json({ success: true, data: { ...group, is_active: newStatus } });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// DELETE /api/groups/:id - Xóa nhóm
router.delete('/:id', (req, res) => {
  try {
    const db = getDb();
    db.prepare('DELETE FROM groups WHERE id = ?').run(req.params.id);
    res.json({ success: true, message: 'Đã xóa nhóm' });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// DELETE /api/groups - Xóa nhiều nhóm
router.delete('/', (req, res) => {
  try {
    const { ids } = req.body;
    if (!ids || !Array.isArray(ids)) {
      return res.status(400).json({ success: false, error: 'Cần truyền mảng ids' });
    }
    const db = getDb();
    const deleteMany = db.transaction(() => {
      ids.forEach(id => db.prepare('DELETE FROM groups WHERE id = ?').run(id));
    });
    deleteMany();
    res.json({ success: true, message: `Đã xóa ${ids.length} nhóm` });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// GET /api/groups/:id/templates - Lấy danh sách template được gán cho nhóm
router.get('/:id/templates', (req, res) => {
  try {
    const db = getDb();
    const group = db.prepare('SELECT * FROM groups WHERE id = ?').get(req.params.id);
    if (!group) {
      return res.status(404).json({ success: false, error: 'Nhóm không tồn tại' });
    }
    const assigned = db.prepare(`
      SELECT t.* FROM templates t
      INNER JOIN group_templates gt ON gt.template_id = t.id
      WHERE gt.group_id = ?
      ORDER BY t.name
    `).all(req.params.id);
    res.json({ success: true, data: assigned });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

// PUT /api/groups/:id/templates - Cập nhật danh sách template cho nhóm
router.put('/:id/templates', (req, res) => {
  try {
    const db = getDb();
    const group = db.prepare('SELECT * FROM groups WHERE id = ?').get(req.params.id);
    if (!group) {
      return res.status(404).json({ success: false, error: 'Nhóm không tồn tại' });
    }
    const { template_ids } = req.body; // [] = gửi tất cả, [1,2,3] = chỉ những template này
    if (!Array.isArray(template_ids)) {
      return res.status(400).json({ success: false, error: 'template_ids phải là mảng' });
    }
    const update = db.transaction(() => {
      db.prepare('DELETE FROM group_templates WHERE group_id = ?').run(req.params.id);
      const insert = db.prepare('INSERT INTO group_templates (group_id, template_id) VALUES (?, ?)');
      for (const tid of template_ids) {
        insert.run(req.params.id, tid);
      }
    });
    update();
    res.json({ success: true, message: `Đã gán ${template_ids.length} kịch bản cho nhóm` });
  } catch (err) {
    res.status(500).json({ success: false, error: err.message });
  }
});

module.exports = router;

