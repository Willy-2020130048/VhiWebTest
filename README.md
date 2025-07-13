Laravel API Documentation

⚙️ Versions

PHP version: 8.3

Node version: v22.17.0

🔧 Setup Instructions

composer install
npm install
php artisan key:generate
php artisan migrate:fresh --seed

Seeder Credentials

Username: admin@gmail.com

Password: password

🔐 Authentication

📝 Register

POST /register

Body:

{
  "name": "name",
  "email": "email@example.com",
  "password": "password",
  "password_confirmation": "password"
}

Response:

{
  "message": "User registered successfully",
  "token": "<token>",
  "user": {
    "name": "Willy Dharmawan",
    "email": "willy@example.com",
    "id": "<uuid>",
    "created_at": "...",
    "updated_at": "..."
  }
}

✅ Gunakan token untuk akses endpoint lainnya.
⚠️ Belum ada handler untuk skenario gagal.

🔐 Login

POST /login

Body:

{
  "email": "admin@gmail.com",
  "password": "password"
}

Success Response:

{
  "message": "Login successful",
  "token": "<token>",
  "user": {
    "id": "<uuid>",
    "name": "Admin",
    "email": "admin@gmail.com"
  }
}

Failed Response:

{
  "message": "Invalid credentials"
}

📌 user_id diperlukan untuk registrasi vendor.

🧾 Vendors

📃 List Vendors (Public)

GET /api/vendors?size=...

{
  "current_page": 1,
  "data": [],
  "per_page": 10
}

➕ Create Vendor

POST /api/vendors

Body:

{
  "user_id": "<uuid>",
  "name": "Toko Sukses Makmur",
  "address": "Jl. Raya No.1",
  "phone": "08123456789"
}

Success Response:

{
  "id": "<uuid>",
  "name": "Toko Sukses Makmur",
  ...
}

Failed Response:

{
  "message": "Already registered with vendor id: <uuid>"
}

📄 Vendor Detail

GET /api/vendors/{vendor_id}

✏️ Update Vendor

PUT /api/vendors/{vendor_id}

🗑️ Delete Vendor

DELETE /api/vendors/{vendor_id}

📦 Products

📃 List Products (Public)

GET /api/products?size=...

📃 List Vendor Products (Private)

GET /api/vendor/my-products?size=...

➕ Create Product

POST /api/vendor/products

Body:

{
  "name": "Kemeja Linen Premium",
  "description": "Bahan linen premium",
  "price": 179000,
  "active": true
}

📄 Product Detail

GET /api/vendor/products/{product_id}

✏️ Update Product

PUT /api/vendor/products/{product_id}

🗑️ Delete Product

DELETE /api/vendor/products/{product_id}

🔁 Status Management

🔁 Change Vendor Status

POST /api/vendors/{vendor_id}/status

Body:

{
  "status": "approved"
}

🔁 Change Product Status

POST /api/vendor/my-products/{product_id}/status

Body:
