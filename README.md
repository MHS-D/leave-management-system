
# Laravel Employee Leave Management System

## 🧾 Project Overview

This is a demo Laravel-based dashboard-style backend system designed to manage employee leave requests. It allows employees to submit leave requests and enables admins/managers to review, approve, or reject them.

---

## ✨ Core Features

- ✅ Employees can submit leave requests
- ✅ Admins/Managers can view, approve, or reject leave requests
- ✅ Each request has a status: `Pending`, `Approved`, or `Rejected`
- ✅ Role-based authentication and access control (Employee vs Admin)
- ✅ User management with roles
- ✅ Departments association (optional but implemented)

---

## 🛠 Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd leave-management-system
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Configure the environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Set up the database**
   - Create a database (e.g. `leave_management`)
   - Update `.env` with your DB credentials

5. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

6. **Serve the application**
   ```bash
   php artisan serve
   ```

---

## 🔐 Login Credentials

### Admin (Super Admin)
- **Username:** `super_admin`
- **Password:** `123456789`

### Employee
- **Username:** `employee`
- **Password:** `123456789`

---
## 📚 Additional Notes

Feel free to contact me if you need any further clarification. Thanks for reviewing the demo!
```

---
