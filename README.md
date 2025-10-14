# 🌾 Farming Management System

## Project Description
A user-friendly web application designed for farmers to efficiently manage their farm activities, easily access relevant government schemes, and track essential data. This comprehensive system includes both a farmer/user-facing interface and a robust admin panel for seamless management.

## Features

### Farmer/User Side
* **User Registration & Login:** Secure authentication for farmers.
* **Dashboard Overview:** Personalized view of farm statistics, pending tasks, and relevant government schemes.
* **Location-based Functionalities:** Tailored experiences based on the user's geographical location.
* **Access Government Schemes:** Detailed information and direct links to various government agricultural schemes.
* **Password Protection & Secure Sessions:** Ensures user data and session integrity.

### Admin Side
* **Admin Login:** Dedicated secure login for administrative control.
* **Admin Dashboard:** Centralized view of system statistics (Total Users, Total Schemes, Pending Tasks).
* **Manage Users:** Functionality to view and delete registered user accounts.
* **Manage Schemes:** Ability to add, view, and delete government scheme information.
* **Secure Logout:** Ensures secure termination of admin sessions.

## Design & UI
* **Aesthetic:** Soft, farmer-themed, and eye-friendly user interface.
* **Color Palette:** Utilizes appealing green gradients for a natural feel.
* **Animations:** Incorporates animated farm objects like tractors, the sun, and fields to enhance user experience.
* **Responsiveness:** Fully responsive design implemented with Tailwind CSS for optimal viewing across devices.

## Technologies Used
* **Frontend:** HTML5, CSS3, Tailwind CSS, JavaScript
* **Backend:** PHP 8.x
* **Database:** MySQL / MariaDB
* **Session Management:** PHP Sessions
* **Animations & Effects:** CSS animations, emojis, and floating objects

## Installation Guide

To set up and run the Farming Management System locally, follow these steps:

1.  **Clone the Repository:**
    ```bash
    git clone [https://github.com/yourusername/farming-management-system.git](https://github.com/yourusername/farming-management-system.git)
    ```

2.  **Setup Database:**
    * Create a new MySQL/MariaDB database (e.g., `farming_system`).
    * Import the `database.sql` file (located in the repository root) into your newly created database.

3.  **Configure Database Connection:**
    * Open the `includes/db.php` file.
    * Update the database connection details to match your setup:
        ```php
        $servername = "localhost";
        $username = "root";         // Your database username
        $password = "";             // Your database password
        $dbname = "farm";           // The name of your database (e.g., farming_system)
        ```

4.  **Admin Login Credentials:**
    * **Username:** `admin`
    * **Password:** `admin123`

5.  **Run the Application:**
    * Place the entire `farming-management-system` project folder into your PHP server's web root directory (e.g., `htdocs` for XAMPP/WAMP, `www` for LAMP).
    * Open your web browser and navigate to:
        ```
        http://localhost/farming-management-system/
        ```

## Project Structure

```
farming-management-system/
├─ includes/
│  ├─ db.php
│  ├─ footer.php
│  ├─ header.php
│  └─ weather.php
├─ admin/
│  ├─ admin_dashboard.php
│  ├─ login.php
│  ├─ manage_schemes.php
│  └─ manage_users.php
├─ pages/
│  ├─ dashboard.php
│  ├─ fertilizer_history.php
│  ├─ fertilizer.php
│  ├─ fetch_weather.php
│  ├─ home.php
│  ├─ login.php
│  ├─ post_quality.php
│  ├─ register.php
│  ├─ schemes.php
│  ├─ weather.php
│  └─ index.php
├─ assets/
│  ├─ css/
│  │  └─ style.css
│  ├─ images/
│  ├─ js/
│  └─ icons/
├─ database.sql
└─ README.md
```

## ⚠️ Security Notes (For Demo Purposes)

* **Password Storage:** Passwords are currently stored in plain text in the database. **For any production environment, it is CRUCIAL to implement strong password hashing** (e.g., using PHP's `password_hash()` and `password_verify()`).
* **Input Validation:** Ensure comprehensive input validation and sanitization for all user inputs to prevent vulnerabilities like Cross-Site Scripting (XSS).
* **SQL Injection:** Implement prepared statements for all database queries to prevent SQL injection attacks.
