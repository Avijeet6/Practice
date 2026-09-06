# 🎓 CampusConnect 2026

## Student Registration & Login Portal on AWS EC2

CampusConnect 2026 is a dynamic student registration and authentication web application built with **PHP, MariaDB, HTML5, and embedded CSS**.

The application is deployed on an **AWS EC2 instance running Amazon Linux** and served publicly through **Nginx on port 80**. PHP requests are processed using **PHP-FPM**, while student registration and login credentials are stored in a MariaDB database.

The project demonstrates a complete practical workflow:

```text
Student
   │
   ▼
Web Browser
   │
   │ HTTP :80
   ▼
AWS EC2
   │
   ▼
Nginx
   │
   ▼
PHP-FPM
   │
   ▼
PHP Application
   │
   ▼
MariaDB
   │
   ▼
campusconnect.students
```

---

# 📌 Project Overview

CampusConnect 2026 provides a simple student event registration and login system.

Students can:

- Register for an event
- Provide personal and college information
- Create a password
- Log in using either Email or Student ID
- Receive a success message after valid authentication
- Receive an error message for invalid credentials
- Log out securely using PHP sessions

The application is designed as an educational cloud deployment project and demonstrates the integration of **Linux, AWS EC2, Nginx, PHP, PHP-FPM, MariaDB, SQL, and server-side authentication**.

---

# ✨ Features

## 📝 Student Registration

The registration form contains:

| Field | Required |
|---|---|
| Full Name | ✅ |
| Student ID | ✅ |
| Email | ✅ |
| College Name | ✅ |
| Location | ✅ |
| Event | ✅ |
| Password | ✅ |

Registration data is stored in the MariaDB `campusconnect` database inside the `students` table.

The application also prevents duplicate Student IDs and email addresses.

---

## 🔐 Student Login

Students can log in using:

```text
Email / Student ID
Password
```

The login system checks the submitted credentials against the database.

### Successful Login

```text
🟢 Login successful! Welcome to CampusConnect!
```

### Invalid Login

```text
🔴 Invalid username or password.
```

Passwords are verified using PHP's `password_verify()` function.

---

## 🔒 Password Security

Passwords are never intentionally stored as plain text.

During registration, PHP uses:

```php
password_hash()
```

During login, PHP uses:

```php
password_verify()
```

This allows the database to store a password hash rather than the original password.

---

## 👤 Session Management

After successful authentication, PHP creates a session containing the logged-in student's information.

Example session values:

```php
$_SESSION["student_id"]
$_SESSION["full_name"]
```

The logout page destroys the session and returns the user to the login page.

---

# 🛠️ Technology Stack

| Technology | Purpose |
|---|---|
| Amazon Linux | Cloud server operating system |
| AWS EC2 | Cloud compute instance |
| Nginx | Web server |
| PHP | Server-side application logic |
| PHP-FPM | PHP processing for Nginx |
| MariaDB | Relational database |
| SQL | Database creation and queries |
| HTML5 | Page structure |
| Embedded CSS | Page styling inside PHP files |
| SSH | Remote server administration |
| Linux CLI | Server management |

> This project uses **LEMP-style architecture**: Linux + Nginx + MariaDB + PHP/PHP-FPM.

---

# 📂 Project Structure

The deployed application contains the following files:

```text
/var/www/campusconnect/
│
├── index.php
├── register.php
├── login.php
├── welcome.php
├── logout.php
└── db.php
```

No separate CSS file is required in this version. The page styling is written directly inside the PHP pages using `<style>` blocks.

---

# 📄 File Description

## `index.php`

The homepage of CampusConnect 2026.

It provides navigation to:

- Student Registration
- Student Login

---

## `register.php`

Contains the student registration form and registration processing logic.

Main responsibilities:

1. Accept student information
2. Validate required fields
3. Hash the password
4. Insert the registration into MariaDB
5. Prevent duplicate Student IDs and email addresses
6. Display a registration success or error message

---

## `login.php`

Contains the student login form and authentication logic.

Main responsibilities:

1. Accept Email or Student ID
2. Accept password
3. Search the `students` table
4. Verify the stored password hash
5. Create a PHP session after successful authentication
6. Display a green success message for valid credentials
7. Display an error message for invalid credentials

---

## `welcome.php`

This page is accessible only after a successful login session has been created.

It displays:

```text
Welcome to CampusConnect!
```

and the logged-in student's name.

---

## `logout.php`

Destroys the active PHP session and redirects the student to the login page.

---

## `db.php`

Contains the database connection settings used by the application.

Example configuration:

```php
<?php

$host = "localhost";
$dbname = "campusconnect";
$username = "campususer";
$password = "YOUR_DATABASE_PASSWORD";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>
```

> Do not publish real database credentials in GitHub or any public repository.

---

# 🗄️ Database Configuration

## Database Name

```text
campusconnect
```

## Table Name

```text
students
```

## Table Structure

```sql
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    student_id VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    college_name VARCHAR(150) NOT NULL,
    location VARCHAR(100) NOT NULL,
    event VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Columns

| Column | Type | Description |
|---|---|---|
| `id` | INT | Auto-increment primary key |
| `full_name` | VARCHAR(100) | Student full name |
| `student_id` | VARCHAR(50) | Unique student ID |
| `email` | VARCHAR(100) | Unique email |
| `college_name` | VARCHAR(150) | College name |
| `location` | VARCHAR(100) | Student location |
| `event` | VARCHAR(150) | Selected event |
| `password` | VARCHAR(255) | Hashed password |
| `created_at` | TIMESTAMP | Registration timestamp |

---

# 🗃️ Database Setup

Connect to MariaDB:

```bash
sudo mysql
```

Create the database:

```sql
CREATE DATABASE campusconnect;
```

Select the database:

```sql
USE campusconnect;
```

Create the table:

```sql
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    student_id VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    college_name VARCHAR(150) NOT NULL,
    location VARCHAR(100) NOT NULL,
    event VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Verify the table:

```sql
SHOW TABLES;
```

Check the structure:

```sql
DESCRIBE students;
```

View registered students:

```sql
SELECT student_id, full_name, email, college_name, location, event
FROM students;
```

---

# 👤 Dedicated Database User

A dedicated MariaDB user is used by the PHP application instead of connecting the web application as `root`.

Create the user:

```sql
CREATE USER 'campususer'@'localhost'
IDENTIFIED BY 'YOUR_STRONG_PASSWORD';
```

Grant access:

```sql
GRANT ALL PRIVILEGES
ON campusconnect.*
TO 'campususer'@'localhost';
```

Apply privileges:

```sql
FLUSH PRIVILEGES;
```

Test the database user:

```bash
mysql -u campususer -p
```

> Replace `YOUR_STRONG_PASSWORD` with the password configured in your local `db.php`.

---

# ☁️ AWS EC2 Deployment

The application is deployed on an AWS EC2 instance.

## Deployment Architecture

```text
                         Internet
                            │
                            │ HTTP :80
                            ▼
                    ┌──────────────────┐
                    │    AWS EC2       │
                    │  Amazon Linux    │
                    └────────┬─────────┘
                             │
                             ▼
                         Nginx
                             │
                             ▼
                         PHP-FPM
                             │
                             ▼
                        PHP Pages
                             │
                             ▼
                          MariaDB
                             │
                             ▼
                 campusconnect.students
```

---

# 🔐 EC2 Security Group

For public website access, the Security Group should allow HTTP traffic on port 80.

Recommended inbound rules:

| Type | Port | Source | Purpose |
|---|---:|---|---|
| SSH | 22 | Your IP | Remote administration |
| HTTP | 80 | `0.0.0.0/0` | Public website access |

MariaDB does not need to be exposed publicly because the PHP application and MariaDB run on the same EC2 server.

---

# 🐧 Linux Server Setup

Connect to the Amazon Linux EC2 instance using SSH:

```bash
ssh -i your-key.pem ec2-user@YOUR_EC2_PUBLIC_IP
```

Check the current user:

```bash
whoami
```

Check the current directory:

```bash
pwd
```

Check the website directory:

```bash
ls /var/www/campusconnect
```

Expected files:

```text
db.php
index.php
login.php
logout.php
register.php
welcome.php
```

---

# 🌐 Nginx Installation

Install Nginx:

```bash
sudo dnf install -y nginx
```

Enable and start Nginx:

```bash
sudo systemctl enable --now nginx
```

Check its status:

```bash
sudo systemctl status nginx
```

Expected:

```text
Active: active (running)
```

Check the installed version:

```bash
nginx -v
```

---

# 🐘 PHP and PHP-FPM Installation

Install PHP, PHP-FPM and the MariaDB PHP driver:

```bash
sudo dnf install -y php php-fpm php-mysqlnd
```

Check PHP:

```bash
php -v
```

Enable and start PHP-FPM:

```bash
sudo systemctl enable --now php-fpm
```

Check PHP-FPM:

```bash
sudo systemctl status php-fpm
```

Expected:

```text
Active: active (running)
```

---

# 🗄️ MariaDB Installation

Install MariaDB:

```bash
sudo dnf install -y mariadb105-server
```

Enable and start the service:

```bash
sudo systemctl enable --now mariadb
```

Check the status:

```bash
sudo systemctl status mariadb
```

Expected:

```text
Active: active (running)
```

---

# ⚙️ Nginx Configuration

The application is hosted from:

```text
/var/www/campusconnect
```

An Nginx server configuration is used to serve PHP files through PHP-FPM.

Example configuration:

```nginx
server {
    listen 80;
    server_name _;

    root /var/www/campusconnect;
    index index.php index.html;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        try_files $uri =404;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass unix:/run/php-fpm/www.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

After creating or changing the configuration, verify it:

```bash
sudo nginx -t
```

Expected output:

```text
syntax is ok
test is successful
```

Restart Nginx:

```bash
sudo systemctl restart nginx
```

---

# 📁 Web Application Directory

The application is deployed in:

```text
/var/www/campusconnect
```

The directory can be created with:

```bash
sudo mkdir -p /var/www/campusconnect
```

Ownership can be assigned to the EC2 user for easier file management:

```bash
sudo chown -R ec2-user:ec2-user /var/www/campusconnect
```

---

# 🧪 PHP Test

To verify that Nginx and PHP-FPM are working together, create a temporary PHP information file:

```bash
echo '<?php phpinfo(); ?>' | sudo tee /var/www/campusconnect/test.php
```

Open:

```text
http://YOUR_EC2_PUBLIC_IP/test.php
```

After verification, remove the file:

```bash
sudo rm /var/www/campusconnect/test.php
```

> `phpinfo()` exposes server configuration information, so the test file should not be left publicly accessible.

---

# 🌍 Accessing the Website

Once the EC2 instance, Security Group, Nginx, PHP-FPM and MariaDB are configured, the website is accessible through the EC2 public IP.

Homepage:

```text
http://YOUR_EC2_PUBLIC_IP/
```

Registration:

```text
http://YOUR_EC2_PUBLIC_IP/register.php
```

Login:

```text
http://YOUR_EC2_PUBLIC_IP/login.php
```

---

# 🔄 Application Flow

## Registration Flow

```text
Student
   │
   ▼
register.php
   │
   ▼
Validate Form
   │
   ▼
password_hash()
   │
   ▼
MariaDB
   │
   ▼
students table
   │
   ▼
Registration Successful
```

## Login Flow

```text
Student
   │
   ▼
login.php
   │
   ▼
Email / Student ID + Password
   │
   ▼
Search students table
   │
   ▼
password_verify()
   │
   ├──────────── Incorrect ───────► Invalid username or password.
   │
   └──────────── Correct
                    │
                    ▼
             Create PHP Session
                    │
                    ▼
          Welcome to CampusConnect!
                    │
                    ▼
               welcome.php
                    │
                    ▼
                logout.php
```

---

# 🧪 Complete Testing Procedure

## 1. Test Homepage

Open:

```text
http://YOUR_EC2_PUBLIC_IP/
```

Verify that the CampusConnect 2026 homepage loads.

---

## 2. Test Registration

Open:

```text
http://YOUR_EC2_PUBLIC_IP/register.php
```

Fill in:

```text
Full Name
Student ID
Email
College Name
Location
Event
Password
```

Click:

```text
REGISTER
```

Expected result:

```text
Registration successful! You can now login.
```

---

## 3. Verify Registration in MariaDB

Run:

```bash
sudo mysql
```

Then:

```sql
USE campusconnect;

SELECT student_id, full_name, email, college_name, location, event
FROM students;
```

The newly registered student should appear in the result.

---

## 4. Test Valid Login

Open:

```text
http://YOUR_EC2_PUBLIC_IP/login.php
```

Enter the registered:

```text
Email or Student ID
Password
```

Expected result:

```text
Login successful! Welcome to CampusConnect!
```

---

## 5. Test Invalid Login

Enter an incorrect password or unknown Student ID.

Expected result:

```text
Invalid username or password.
```

---

## 6. Test Logout

Open the logout option.

The current PHP session should be destroyed and the user should be returned to the login page.

---

# ✅ Service Verification

Check all major services:

```bash
sudo systemctl is-active nginx
sudo systemctl is-active mariadb
sudo systemctl is-active php-fpm
```

Expected:

```text
active
active
active
```

Check port 80:

```bash
sudo ss -tulpn | grep ':80'
```

Nginx should be listening on port 80.

---

# 📊 Practical Verification Checklist

## AWS EC2

- [ ] EC2 instance created
- [ ] Instance running
- [ ] Public IPv4 address available
- [ ] Security Group configured
- [ ] Port 22 available for SSH
- [ ] Port 80 available for HTTP

## Linux

- [ ] SSH connection successful
- [ ] Correct Linux user confirmed
- [ ] `/var/www/campusconnect` created
- [ ] Application files uploaded
- [ ] File permissions/ownership checked

## Nginx

- [ ] Nginx installed
- [ ] Nginx running
- [ ] Nginx configuration created
- [ ] `nginx -t` successful
- [ ] Port 80 listening

## PHP

- [ ] PHP installed
- [ ] PHP version checked
- [ ] PHP-FPM installed
- [ ] PHP-FPM running
- [ ] PHP pages execute through Nginx

## MariaDB

- [ ] MariaDB installed
- [ ] MariaDB running
- [ ] `campusconnect` database created
- [ ] `students` table created
- [ ] Table structure verified
- [ ] Registration data inserted
- [ ] Data verified using `SELECT`

## Website

- [ ] Homepage working
- [ ] Registration form working
- [ ] Successful registration tested
- [ ] Login form working
- [ ] Valid login tested
- [ ] Invalid login tested
- [ ] Welcome message displayed
- [ ] Logout tested
- [ ] Website accessible through EC2 public IP

---

# 📸 Submission Evidence

For practical submission, take clear screenshots of the major stages.

## AWS

1. EC2 instance creation
2. Running EC2 instance
3. Security Group with HTTP port 80

## Linux

4. SSH connection
5. Linux user creation
6. Important Linux commands
7. `/var/www/campusconnect` files

## LEMP

8. Nginx version/installation
9. Nginx status
10. MariaDB status
11. PHP version and PHP-FPM status
12. `nginx -t` successful configuration test

## SQL

13. Database creation
14. `students` table creation/structure
15. Registered student data
16. `SELECT` output

## Website

17. Homepage
18. Registration form
19. Successful registration
20. Login form
21. Successful login with green message
22. Invalid login with error message

## Final Testing

23. Website accessed through EC2 public IP
24. Database verification
25. Service and port verification

---

# 🔐 Security Notes

Never commit or publish:

```text
db.php
```

when it contains real production credentials.

Do not publish:

- Database passwords
- AWS access keys
- AWS secret keys
- Private SSH keys
- Other sensitive credentials

For a production deployment, environment variables or a secrets-management solution should be used for sensitive configuration.

---

# 🚀 Future Improvements

Possible improvements include:

- HTTPS/SSL with a domain name
- Email verification
- Forgot-password functionality
- Admin dashboard
- Event management
- Student profile page
- Event capacity limits
- Search and filtering
- CSRF protection
- Rate limiting for login
- Environment-based configuration
- Database backups
- Application logging
- Cloud monitoring
- Docker deployment
- CI/CD pipeline

---

# 🎯 Project Objective

The main objective of CampusConnect 2026 is to demonstrate the development and cloud deployment of a **PHP-based web application with database-backed authentication**.

The project combines:

```text
Linux
   ↓
AWS EC2
   ↓
Nginx
   ↓
PHP-FPM
   ↓
PHP
   ↓
MariaDB
   ↓
Student Registration
   ↓
Authentication
   ↓
Live Web Application
```

This project provides practical experience with:

- AWS EC2
- Linux administration
- SSH
- Nginx configuration
- PHP and PHP-FPM
- MariaDB and SQL
- Form handling
- Prepared statements
- Password hashing
- Password verification
- PHP sessions
- HTTP port configuration
- Basic web application deployment

---

# 📋 Project Information

| Category | Details |
|---|---|
| Project Name | CampusConnect 2026 |
| Project Type | Student Registration & Login Portal |
| Frontend | HTML5 + Embedded CSS |
| Backend | PHP |
| Database | MariaDB |
| Database Name | `campusconnect` |
| Table Name | `students` |
| Web Server | Nginx |
| PHP Processing | PHP-FPM |
| Server OS | Amazon Linux |
| Cloud Platform | AWS EC2 |
| Web Port | 80 |
| Application Path | `/var/www/campusconnect` |

---

# 👨‍💻 Project Files

```text
CampusConnect 2026
│
├── index.php
├── register.php
├── login.php
├── welcome.php
├── logout.php
├── db.php
└── README.md
```

---

# 📜 License

This project is created for **educational, learning, and practical cloud deployment purposes**.
