const Database = require('better-sqlite3');
const path = require('path');

const DB_PATH = process.env.DB_PATH || './data/telebroadcast.db';

let db;

function getDb() {
  if (!db) {
    db = new Database(path.resolve(DB_PATH));
    db.pragma('journal_mode = WAL');
    db.pragma('foreign_keys = ON');
  }
  return db;
}

function initDatabase() {
  const db = getDb();

  // Bảng tài khoản Telegram
  db.exec(`
    CREATE TABLE IF NOT EXISTS accounts (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      phone TEXT NOT NULL UNIQUE,
      api_id TEXT NOT NULL,
      api_hash TEXT NOT NULL,
      session_string TEXT,
      status TEXT DEFAULT 'disconnected',
      flood_wait_until INTEGER DEFAULT 0,
      username TEXT,
      first_name TEXT,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
  `);

  // Bảng nhóm mục tiêu
  db.exec(`
    CREATE TABLE IF NOT EXISTS groups (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      identifier TEXT NOT NULL UNIQUE,
      title TEXT,
      member_count INTEGER DEFAULT 0,
      is_active INTEGER DEFAULT 1,
      last_sent_at DATETIME,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
  `);

  // Bảng mẫu tin nhắn (templates)
  db.exec(`
    CREATE TABLE IF NOT EXISTS templates (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      name TEXT NOT NULL,
      content TEXT NOT NULL,
      image_path TEXT,
      is_active INTEGER DEFAULT 1,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
  `);

  // Bảng cấu hình lịch gửi
  db.exec(`
    CREATE TABLE IF NOT EXISTS schedule_config (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      time_slot TEXT NOT NULL,
      is_active INTEGER DEFAULT 1,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
  `);

  // Bảng nhật ký gửi tin
  db.exec(`
    CREATE TABLE IF NOT EXISTS send_logs (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      group_identifier TEXT NOT NULL,
      group_title TEXT,
      template_id INTEGER,
      template_name TEXT,
      status TEXT NOT NULL,
      error_message TEXT,
      sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY (template_id) REFERENCES templates(id) ON DELETE SET NULL
    )
  `);

  // Bảng quan hệ nhóm ↔ kịch bản (nhiều-nhiều)
  db.exec(`
    CREATE TABLE IF NOT EXISTS group_templates (
      group_id INTEGER NOT NULL,
      template_id INTEGER NOT NULL,
      PRIMARY KEY (group_id, template_id),
      FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
      FOREIGN KEY (template_id) REFERENCES templates(id) ON DELETE CASCADE
    )
  `);

  // Bảng cài đặt chung
  db.exec(`
    CREATE TABLE IF NOT EXISTS settings (
      key TEXT PRIMARY KEY,
      value TEXT NOT NULL
    )
  `);

  // Thêm giờ mặc định nếu chưa có
  const existingSlots = db.prepare('SELECT COUNT(*) as count FROM schedule_config').get();
  if (existingSlots.count === 0) {
    const insertSlot = db.prepare('INSERT INTO schedule_config (time_slot, is_active) VALUES (?, 1)');
    insertSlot.run('09:00');
    insertSlot.run('14:00');
    insertSlot.run('20:00');
  }

  // Cài đặt mặc định
  const insertSetting = db.prepare('INSERT OR IGNORE INTO settings (key, value) VALUES (?, ?)');
  insertSetting.run('delay_min', '35');
  insertSetting.run('delay_max', '65');
  insertSetting.run('shuffle_groups', '1');

  console.log('📦 Database schema đã sẵn sàng');
  return db;
}

module.exports = { getDb, initDatabase };
