🌾 Farming Management System

A user-friendly web application designed for farmers to manage their farm activities, access government schemes, and track essential data. The system includes an admin panel, user login/registration, and dashboard with analytics.

Features

Farmer/User Side
- User Registration & Login with secure authentication.
- Dashboard Overview: View farm statistics, tasks, and schemes.
- Location-based functionalities for personalized experience.
- Access Government Schemes with links and descriptions.
- Password Protection and secure session handling.

Admin Side
- Admin Login for managing users and schemes.
- Admin Dashboard with statistics (Total Users, Total Schemes, Pending Tasks).
- Manage Users: View and delete user accounts.
- Manage Schemes: Add, view, delete government schemes.
- Secure Logout for admin users.

Design & UI
- Soft, farmer-themed, eye-friendly UI with green gradients.
- Animated farm objects like tractors, sun, and fields.
- Responsive design using Tailwind CSS.

Technologies Used
- Frontend: HTML5, CSS3, Tailwind CSS, JavaScript
- Backend: PHP 8.x
- Database: MySQL / MariaDB
- Session Management: PHP Sessions
- Animations & Effects: CSS animations, emojis, and floating objects

Installation

1. Clone the repository
git clone https://github.com/yourusername/farming-management-system.git

2. Setup Database
Create a MySQL database (e.g., farming_system).
Import the database.sql file included in the repository.

3. Configure Database Connection
Open includes/db.php and update:
$servername = "localhost";
$username = "root";       
$password = "";           
$dbname = "farm"; 

Admin Login Credentials
Username: admin
Password: admin123

Run the Application
Place the project in your PHP server (XAMPP/WAMP/LAMP) htdocs or web root.
Open browser → http://localhost/farming-management-system/

Project Structure
farming-management-system/
├─ includes/
├─ admin/
├─ pages/
├─ assets/
├─ database.sql
└─ README.md

Security Notes
Passwords are currently stored in plain text in the database (for demo purposes).
For production, use password hashing (e.g., password_hash() in PHP).
Ensure proper input validation and prepared statements to prevent SQL injection.
