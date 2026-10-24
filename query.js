const mysql = require('mysql2/promise');
require('dotenv').config({ path: './api-tele/.env' });

async function run() {
  const conn = await mysql.createConnection({
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASS,
    database: process.env.DB_NAME
  });
  
  const [rows] = await conn.execute(`SELECT * FROM telehub_deposit_requests WHERE customer_id = (SELECT id FROM telehub_customers WHERE telegram_id = '7687338362' LIMIT 1)`);
  console.log("Deposit requests:");
  console.log(rows);
  
  await conn.execute(`UPDATE telehub_deposit_requests SET status = 'failed' WHERE customer_id = (SELECT id FROM telehub_customers WHERE telegram_id = '7687338362' LIMIT 1) AND status = 'pending' AND usdt_amount > 0`);
  console.log("Updated pending usdt requests to failed.");
  
  await conn.end();
}
run().catch(console.error);
