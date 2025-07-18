⚙️ Versions

PHP version: 8.3

Node version: v22.17.0
🔧 Setup Instructions

<code>composer install
npm install
php artisan key:generate
php artisan migrate:fresh --seed</code>

Seeder Credentials

Username: admin@gmail.com

Password: password

Endpoint Register: POST http://localhost:8000/register
<code>
Body:
{
  "name": "name",
  "email": "email@example.com",
  "password": "password",
  "password_confirmation": "password"
}
</code>

<code>
Response: 
{
    "message": "User registered successfully",
    "token": "2|Je7HNq0YxM8SFG9oYSUE1vyaEywlPltnLFCvA6xD55e8685b",
    "user": {
        "name": "Willy Dharmawan",
        "email": "willy@example.com",
        "id": "01980338-1a76-7074-9916-8f554ab28ae9",
        "updated_at": "2025-07-13T09:57:45.000000Z",
        "created_at": "2025-07-13T09:57:45.000000Z"
    }
}
</code>

- Ambil token untuk menggunakan api lainnya.
- Belum ada handler untuk scenario gagal. 

--- 

Endpoint Register: POST http://localhost:8000/login
<code>
Body:
{
  "email": "admin@gmail.com",
  "password": "password"
}
</code>

<code>
Response Login Success:
{
    "message": "Login successful",
    "token": "3|ZUWVm9itDSQcEGD7iN3MiGX5qF6yb1NfarMZZhVf623bb6bd",
    "user": {
        "id": "6334e06a-e439-44da-b722-ce26f0ccf73c",
        "name": "Admin",
        "is_vendor": false,
        "is_admin": false,
        "email": "admin@gmail.com",
        "email_verified_at": null,
        "created_at": "2025-07-13T09:28:04.000000Z",
        "updated_at": "2025-07-13T09:28:04.000000Z"
    }
}
</code>

<code>
Response Login Failed: 
{
    "message": "Invalid credentials"
}
</code>

- Ambil token untuk menggunakan api lainnya.
- user_id dibutuhkan untuk register vendor. 

---

Endpoint List Vendors (Public) : GET http://localhost:8000/api/vendors?size=...
<code>
Response: 
{
    "current_page": 1,
    "data": [],
    "per_page": ...,
}
</code>
- Size untuk pagination.

---

Endpoint Create Vendors: POST http://localhost:8000/api/vendors
<code>
Body: 
{
  "user_id": "6334e06a-e439-44da-b722-ce26f0ccf73c",
  "name": "Toko Sukses Makmur",
  "address": "Jl. Raya No.1",
  "phone": "08123456789"
}
Response Success:
{
    "id": "9c08dddb-2300-494d-9ac4-2b01449d4521",
    "user_id": "6334e06a-e439-44da-b722-ce26f0ccf73c",
    "name": "Toko Sukses Makmur",
    "address": "Jl. Raya No.1",
    "phone": "08123456789",
    "updated_at": "2025-07-13T10:51:33.000000Z",
    "created_at": "2025-07-13T10:51:33.000000Z"
}
</code>

Response Failed:
{
    "message": "Already registered with vendor id: 39996ade-1ce8-4ff4-bbc7-cb79eca3ae89"
}

---

Endpoint Detail Vendors: GET http://localhost:8000/api/vendors/{vendor_id}
<code>
Response:
{
    "id": "9c08dddb-2300-494d-9ac4-2b01449d4521",
    "user_id": "6334e06a-e439-44da-b722-ce26f0ccf73c",
    "name": "Toko Sukses Makmur",
    "address": "Jl. Raya No.1",
    "phone": "08123456789",
    "status": "pending",
    "created_at": "2025-07-13T10:51:33.000000Z",
    "updated_at": "2025-07-13T10:51:33.000000Z"
}
</code>

---

Endpoint Update Vendors: PUT http://localhost:8000/api/vendors/{vendor_id}
<code>
Body: 
{
  "user_id": "6334e06a-e439-44da-b722-ce26f0ccf73c",
  "name": "Toko Sukses Makmur",
  "address": "Jl. Raya No.1",
  "phone": "08123456789"
}
</code>

---

Endpoint Delete Vendors: DELETE http://localhost:8000/api/vendors/{vendor_id}

Response:
{
    "message": "Vendor deleted"
}

---

Endpoint List Product untuk users (Public) : GET http://localhost:8000/api/products?size=...
<code>
Response: 
{
    "current_page": 1,
    "data": [],
    "per_page": ...,
}
</code>
- Size untuk pagination.
---

Endpoint List My-Product untuk vendors (Private) : GET http://localhost:8000/api/vendor/my-products?size=...
<code>
Response: 
{
    "current_page": 1,
    "data": [],
    "per_page": ...,
}
</code>
- Size untuk pagination.


---

Endpoint Create Product: POST http://localhost:8000/api/vendor/products
<code>
Body: 
{
  "name": "Kemeja Linen Premium",
  "description": "Kemeja lengan panjang bahan linen kualitas premium",
  "price": 179000,
  "active": true
}


Response Success: 
{
    "id": "c500468a-1933-4683-b50a-799be358f6e9",
    "vendor_id": "39996ade-1ce8-4ff4-bbc7-cb79eca3ae89",
    "name": "Kemeja Linen Premium",
    "description": "Kemeja lengan panjang bahan linen kualitas premium",
    "price": 179000,
    "updated_at": "2025-07-13T10:36:34.000000Z",
    "created_at": "2025-07-13T10:36:34.000000Z"
}
</code>

Response Failed:
{
    "message": "Unauthorized - Not a vendor"
}

---

Endpoint Detail Product: GET http://localhost:8000/api/vendor/products/{product_id}
<code>
Response:
{
    "id": "800a5e2c-6215-4cd3-b889-ea952b88ed7a",
    "vendor_id": "9c08dddb-2300-494d-9ac4-2b01449d4521",
    "name": "Kemeja Linen",
    "description": "Kemeja lengan panjang bahan linen",
    "price": "179000.00",
    "stock": 0,
    "active": true,
    "created_at": "2025-07-13T10:52:16.000000Z",
    "updated_at": "2025-07-13T10:53:52.000000Z"
}
</code>

--- 

Endpoint Update Product: PUT http://localhost:8000/api/vendor/products/{product_id}
<code>
Body: 
{
  "user_id": "6334e06a-e439-44da-b722-ce26f0ccf73c",
  "name": "Toko Sukses Makmur",
  "address": "Jl. Raya No.1",
  "phone": "08123456789"
}
</code>

---

Endpoint Delete Product: DELETE http://localhost:8000/api/vendor/products/{product_id}

Response:
{
    "message": "Product deleted"
}

---

Endpoint Change Vendor Status: http://localhost:8000/api/vendors/{vendor_id}/status
<code>
Body:
{
  "status": "approved"
}
</code>
<code>
Response:
{
    "message": "Status updated",
    "vendor": {
        "id": "9c08dddb-2300-494d-9ac4-2b01449d4521",
        "user_id": "6334e06a-e439-44da-b722-ce26f0ccf73c",
        "name": "Toko Sukses Makmur",
        "address": "Jl. Raya No.1",
        "phone": "08123456789",
        "status": "approved",
        "created_at": "2025-07-13T10:51:33.000000Z",
        "updated_at": "2025-07-13T10:51:33.000000Z"
    }
}

</code>
---

Endpoint Change Vendor Status: http://localhost:8000/api/vendor/my-products/{product_id}/status

<code>Body:
{
  "active": true
}</code>

<code>
Response:
{
    "message": "Status updated",
    "product": {
        "id": "c2288098-33c3-4fc0-b506-1baf5645af00",
        "vendor_id": "9c08dddb-2300-494d-9ac4-2b01449d4521",
        "name": "Kemeja Linen",
        "description": "Kemeja lengan panjang bahan linen",
        "price": "179000.00",
        "stock": 0,
        "active": false,
        "created_at": "2025-07-13T10:57:12.000000Z",
        "updated_at": "2025-07-13T11:13:00.000000Z"
    }
}
</code>
