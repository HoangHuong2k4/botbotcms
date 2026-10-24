require('dotenv').config();
const express = require('express');
const cors = require('cors');
const morgan = require('morgan');
const fileUpload = require('express-fileupload');
const path = require('path');
const fs = require('fs');

const { initDatabase } = require('./db/database');
const { initScheduler } = require('./services/scheduler');

// Routes
const accountRoutes = require('./routes/accounts');
const groupRoutes = require('./routes/groups');
const templateRoutes = require('./routes/templates');
const schedulerRoutes = require('./routes/scheduler');
const logRoutes = require('./routes/logs');
const statsRoutes = require('./routes/stats');
const importRoutes = require('./routes/import');

const app = express();
const PORT = process.env.PORT || 3001;

// Tạo thư mục uploads nếu chưa có
const uploadsDir = process.env.UPLOADS_DIR || './uploads';
if (!fs.existsSync(uploadsDir)) {
  fs.mkdirSync(uploadsDir, { recursive: true });
}

// Tạo thư mục data nếu chưa có
const dataDir = './data';
if (!fs.existsSync(dataDir)) {
  fs.mkdirSync(dataDir, { recursive: true });
}

// Middleware
app.use(cors({
  origin: ['http://localhost:5173', 'http://localhost:3000', 'http://127.0.0.1:5173'],
  credentials: true
}));

// Basic Auth Middleware để bảo vệ an toàn (Chỉ bật khi cấu hình .env)
const ADMIN_USER = process.env.ADMIN_USER;
const ADMIN_PASS = process.env.ADMIN_PASS;

if (ADMIN_USER && ADMIN_PASS) {
  app.use((req, res, next) => {
    const b64auth = (req.headers.authorization || '').split(' ')[1] || '';
    const [login, password] = Buffer.from(b64auth, 'base64').toString().split(':');

    if (login && password && login === ADMIN_USER && password === ADMIN_PASS) {
      return next();
    }

    res.set('WWW-Authenticate', 'Basic realm="TeleBroadcast Admin"');
    res.status(401).send('Authentication required.');
  });
}

app.use(morgan('dev'));
app.use(express.json({ limit: '50mb' }));
app.use(express.urlencoded({ extended: true, limit: '50mb' }));
app.use(fileUpload({
  limits: { fileSize: 50 * 1024 * 1024 }, // 50MB
  useTempFiles: false
}));

// Phục vụ file uploads tĩnh
app.use('/uploads', express.static(path.resolve(uploadsDir)));

// API Routes
app.use('/api/accounts', accountRoutes);
app.use('/api/groups', groupRoutes);
app.use('/api/templates', templateRoutes);
app.use('/api/scheduler', schedulerRoutes);
app.use('/api/logs', logRoutes);
app.use('/api/stats', statsRoutes);
app.use('/api/import', importRoutes);

// Health check
app.get('/api/health', (req, res) => {
  res.json({ status: 'ok', time: new Date().toISOString() });
});

// Phục vụ React build trong production
if (process.env.NODE_ENV === 'production') {
  const clientBuild = path.join(__dirname, '../../client/dist');
  app.use(express.static(clientBuild));
  app.get('*', (req, res) => {
    res.sendFile(path.join(clientBuild, 'index.html'));
  });
}

// Khởi động server
async function start() {
  try {
    // Khởi tạo database
    initDatabase();
    console.log('✅ Database khởi tạo thành công');

    // Khởi động scheduler
    await initScheduler();
    console.log('✅ Scheduler khởi động thành công');

    app.listen(PORT, () => {
      console.log(`🚀 TeleBroadcast Hub Server đang chạy tại http://localhost:${PORT}`);
    });
  } catch (error) {
    console.error('❌ Lỗi khởi động server:', error);
    process.exit(1);
  }
}

start();

module.exports = app;
