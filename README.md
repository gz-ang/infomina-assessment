# Fitness Membership Management System (MVP)

This project is a **Minimum Viable Product (MVP)** for a fitness centre membership management system.  
It allows administrators to manage member profiles and membership plans through a modern web-based interface.

The application is built using **Laravel 12** for the backend, **Vue 3 with Inertia.js** for the frontend, **MySQL** for data storage, and **Vite** for asset bundling and hot module reloading.

---

## ✨ Features

- Authentication (Login / Logout) via Laravel Breeze
- Member CRUD (Create, Read, Update, Delete)
- Membership Plan management
- Referential integrity using database foreign keys
- Responsive UI (desktop & mobile friendly)
- Inertia-powered SPA-like experience
- Clean separation between web routes and API checks

---

## 🛠 Tech Stack

- **Backend:** PHP 8.2, Laravel 12
- **Frontend:** Vue 3, Inertia.js
- **Database:** MySQL
- **Build Tool:** Vite
- **Styling:** Tailwind CSS
- **Auth Scaffolding:** Laravel Breeze

---

## 📋 Requirements

Make sure the following are installed on your system:

- PHP **8.2+**
- Composer **2.x**
- Node.js **18+**
- npm **9+**
- MySQL **8.0+**
- Git

---

## 🚀 Installation Guide

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/gz-ang/infomina-assessment
cd infomina-assessment
```

### 2️⃣ Install PHP Dependencies

```bash
composer install
```

### 3️⃣ Install JavaScript Dependencies

```bash
npm install
```

### 4️⃣ Environment Configuration
Copy the example environment file:
```bash
cp .env.example .env
```
Update the .env file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fitness_mms
DB_USERNAME=root
DB_PASSWORD=
```

### 5️⃣ Generate Application Key

```bash
php artisan key:generate
```

### 6️⃣ Run Database Migrations
This project is designed to be safely reset during development.

```bash
php artisan migrate:fresh --seed
```
This should run all migrations and also seed the tables with random data.

Or if you don't want to seed the database, just run:
```bash
php artisan migrate:fresh
```

### 7️⃣ Build Frontend Assets (Development)
Run Vite for hot reload during development:
```bash
npm run dev
```

### 8️⃣ Serve the Application

```bash
php artisan serve
```
The app should be reachable at your [localhost](http://localhost:8000/)

---
## 🔐 Authentication

Laravel Breeze is used for authentication, you may login with the credentials below if you have seeded the database.

```
Email: admin@admin.com 
Password: P@$$W0rd!
```

or you can create a new user:

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => '[your_emai]',
    'password' => bcrypt('[your_password]'),
]);
```
---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
