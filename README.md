># 💰 Financial Management System

> A web-based Financial Management System developed during my internship to simplify financial recording, budget management, and reporting processes.

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4-EF4223?style=for-the-badge&logo=codeigniter)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

---

## 📌 Overview

Financial Management System is a web-based application designed to assist in managing financial records efficiently. The system provides features for recording transactions, organizing financial data, managing users, and generating reports through an intuitive dashboard.

This project was developed during my internship as a practical implementation of web application development using the MVC architecture provided by CodeIgniter 4.

---

## ✨ Features

- 🔐 User Authentication
- 👥 User Management
- 💰 Financial Transaction Recording
- 📊 Dashboard Overview
- 📑 Financial Reports
- 📅 Transaction History
- 🔍 Search & Filter Data
- 📈 Budget Monitoring
- 📱 Responsive User Interface

---

## 🛠 Tech Stack

| Technology | Description |
|------------|-------------|
| PHP | Backend Programming Language |
| CodeIgniter 4 | PHP Framework |
| MySQL | Database |
| Bootstrap 5 | Frontend Framework |
| JavaScript | Client-side Interaction |
| HTML5 & CSS3 | User Interface |

---

## 📂 Project Structure

```text
Financial-management-system/
│
├── app/
├── public/
├── writable/
├── tests/
├── vendor/
├── .env
├── composer.json
├── spark
└── README.md
```

---

## 📸 Screenshots

### Login Page

<img width="830" height="478" alt="image" src="https://github.com/user-attachments/assets/a5d0e3ab-d406-4022-96bd-bf5ca30b9b78" />

```
docs/login.png
```

---

### Dashboard && Financial Records

```

```
<img width="878" height="493" alt="image" src="https://github.com/user-attachments/assets/c46f65f6-55dc-44bd-bc87-029e5229ef19" />

---

## ⚙️ Installation

### Clone Repository

```bash
git clone https://github.com/YOUR_USERNAME/Financial-management-system.git
```

### Go to Project Folder

```bash
cd Financial-management-system
```

### Install Dependencies

```bash
composer install
```

### Create Environment File

```bash
cp env .env
```

Edit:

```
app.baseURL = 'http://localhost:8080'
```

Configure database:

```
database.default.hostname = localhost
database.default.database = your_database
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

---

## ▶️ Run Project

```bash
php spark serve
```

Open:

```
http://localhost:8080
```

---

## 🗄 Database

Import the provided SQL file into MySQL.

```
database.sql
```

Then update the database configuration inside:

```
app/Config/Database.php
```

---

## 📊 Application Modules

- Authentication
- Dashboard
- Financial Recording
- Budget Management
- Report Management
- User Management

---

## 🏗 Architecture

```
Browser
    │
    ▼
CodeIgniter 4
    │
Controllers
    │
Models
    │
MySQL Database
```

---

## 🔒 Security

- Authentication System
- Session Management
- MVC Architecture
- Input Validation
- CSRF Protection (CodeIgniter)

---

## 🚀 Future Improvements

- Export PDF Reports
- Export Excel
- Email Notifications
- Charts & Analytics
- REST API
- Role Based Access Control

---

## 👨‍💻 Author

**Samuel Cristian Saragih | Yous Markus Sibarani | Aldi Azhari Pulunggan **

Software Engineer | Backend Developer | Machine Learning Enthusiast


## 📄 License

This project is licensed under the MIT License.
