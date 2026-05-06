colima start


docker-compose stop
docker-compose start

SRP
# Error Handling

# User Logging Activity
event tracking
Audit Trails
Performance Monitoring
Usage Analytics
1. Table: categories (หมวดหมู่สินค้า)
เก็บข้อมูลหมวดหมู่เพื่อใช้แสดงผลทางซ้ายมือ

id (INT, Primary Key, Auto Increment)
slug (VARCHAR) - ตัวระบุที่เป็นภาษาอังกฤษ เช่น coffee, bakery
name (VARCHAR) - ชื่อหมวดหมู่ เช่น 'Coffee & Drinks'
icon (VARCHAR) - คลาสของ FontAwesome เช่น 'fa-mug-hot'
color (VARCHAR) - สีของหมวดหมู่ เช่น '#D97706'
status (TINYINT) - สถานะ (1=เปิดใช้งาน, 0=ปิดการใช้งาน)
created_at, updated_at (TIMESTAMP)
2. Table: products (สินค้า)
เก็บข้อมูลสินค้าแต่ละตัว

id (INT, Primary Key, Auto Increment)
category_id (INT, Foreign Key) - เชื่อมกับตาราง categories
name (VARCHAR) - ชื่อสินค้า เช่น 'Espresso'
price (DECIMAL(10,2)) - ราคาสินค้า เช่น 3.50
img (VARCHAR) - URL หรือ Path รูปภาพของสินค้า
status (TINYINT) - สถานะ (1=พร้อมขาย, 0=หมด/ระงับการขาย)
created_at, updated_at (TIMESTAMP)
3. Table: orders (คำสั่งซื้อ/บิล)
เก็บข้อมูลส่วนหัวของบิล ทั้งบิลที่ขายเสร็จแล้ว (Completed) และบิลที่พักไว้ (Held)

id (INT, Primary Key, Auto Increment)
order_number (VARCHAR) - เลขที่บิล (เช่น INV-20260506-001)
status (ENUM) - สถานะบิล เช่น 'completed', 'held', 'cancelled'
subtotal (DECIMAL(10,2)) - ยอดรวมก่อนหักส่วนลดและภาษี
discount_type (ENUM) - ประเภทส่วนลด ('percent', 'fixed') หรือ NULL
discount_value (DECIMAL(10,2)) - ค่าของส่วนลดที่กรอก (เช่น 10% หรือ $5)
discount_amount (DECIMAL(10,2)) - จำนวนเงินที่ลดจริง
tax_rate (DECIMAL(5,2)) - อัตราภาษีตอนที่ขาย (เช่น 8.00)
tax_amount (DECIMAL(10,2)) - จำนวนเงินภาษี
total (DECIMAL(10,2)) - ยอดรวมสุทธิที่ต้องจ่าย
payment_method (ENUM) - ช่องทางการจ่าย ('cash', 'card', 'digital') หรือ NULL ถ้าสถานะเป็น held
cash_received (DECIMAL(10,2)) - เงินสดที่รับมา (กรณีจ่ายเงินสด)
cash_change (DECIMAL(10,2)) - เงินทอน (กรณีจ่ายเงินสด)
cashier_id (INT) - ID ของพนักงานที่ทำรายการ (เชื่อมตารางพนักงาน)
created_at, updated_at (TIMESTAMP)
4. Table: order_items (รายการสินค้าในคำสั่งซื้อ)
เก็บข้อมูลว่าบิลแต่ละใบซื้ออะไรบ้าง (แยก 1 รายการต่อ 1 แถว)

id (INT, Primary Key, Auto Increment)
order_id (INT, Foreign Key) - เชื่อมกับตาราง orders
product_id (INT, Foreign Key) - เชื่อมกับตาราง products (เป็น NULL ได้ถ้าเป็นสินค้าประเภท Custom Item)
product_name (VARCHAR) - ชื่อสินค้า (แนะนำให้เก็บชื่อด้วย เพื่อป้องกันการสับสนหากชื่อในตาราง products ถูกเปลี่ยนในอนาคต)
price (DECIMAL(10,2)) - ราคาต่อหน่วย ณ วันที่ขาย
quantity (INT) - จำนวนชิ้น
line_total (DECIMAL(10,2)) - ราคารวมของรายการนี้ (price * quantity)
note (TEXT) - หมายเหตุ (เช่น หวานน้อย, เพิ่มช็อต)
is_custom (TINYINT) - 1 ถ้าเป็นสินค้าเพิ่มเอง (Custom Item), 0 ถ้าเป็นสินค้าจากในระบบ
created_at, updated_at (TIMESTAMP)
5. Table: users / cashiers (พนักงาน) แถมให้ครับ ปกติ POS ต้องมี
เพื่อเก็บว่าใครเป็นคนล็อกอินเข้ามาทำรายการ

id (INT, Primary Key, Auto Increment)
username / pin (VARCHAR) - รหัสเข้าใช้งาน
name (VARCHAR) - ชื่อแสดงผล (เช่น JD ในมุมขวาบน)
role (ENUM) - ระดับสิทธิ์ เช่น 'admin', 'cashier'
created_at, updated_at (TIMESTAMP)