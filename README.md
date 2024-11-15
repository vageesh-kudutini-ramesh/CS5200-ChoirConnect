# CS5200 Final Project - Membership Portal

## Project Overview

This Membership Portal is a PHP-based web application designed to manage member information, attendance, dues, and reporting within an organization. The application provides role-based access for different types of users (Admin, Treasurer, Secretary) to ensure that each user sees content relevant to their role.

## Features

- **Role-Based Access Control**: Different content displayed on the dashboard based on the user’s role.
- **Data Entry**: Forms for attendance and dues entry, as well as an option to upload bulk data using CSV/Excel.
- **Reporting Interface**: Summaries of donations and dues for easy reporting.
- **Session Management**: Secure login and logout functionality with session timeout.

## Technologies Used

- PHP
- HTML
- CSS (basic styling, optional)
- XAMPP (Apache server and MySQL)
- PhpSpreadsheet library (optional for handling CSV/Excel uploads)

## File Structure

```
membership_portal/
├── UserLogin.php         # Login page for user authentication
├── dashboard.php         # Dashboard with role-specific content and navigation links
├── data_entry.php        # Page for entering attendance and dues data
├── data_process.php      # Processes data entry forms and bulk uploads
├── report.php            # Displays reports for dues and donations
├── logout.php            # Logs out the user and redirects to the login page
└── README.md             # Project documentation
```

## Setup Instructions

1. **Install XAMPP**:
   - Download and install [XAMPP](https://www.apachefriends.org/index.html) to set up a local Apache server with PHP and MySQL.

2. **Place Project Files in XAMPP's `htdocs` Directory**:
   - Move the `membership_portal` folder to XAMPP’s `htdocs` directory, typically located at:
     ```
     /Applications/XAMPP/htdocs/CS5200FinalProject/
     ```
   - Your main files (like `UserLogin.php`) should be in `CS5200FinalProject/membership_portal`.

3. **Start Apache in XAMPP**:
   - Open the XAMPP Control Panel and start Apache (and MySQL if using a database).

4. **Access the Project in a Browser**:
   - Open your browser and go to:
     ```
     http://localhost/CS5200FinalProject/membership_portal/UserLogin.php
     ```

## Usage

1. **Login**:
   - Use the following credentials to log in as different roles:
     - **Admin**: Username: `admin`, Password: `admin123`
     - **Treasurer**: Username: `treasurer`, Password: `treasurer123`
     - **Secretary**: Username: `secretary`, Password: `secretary123`

2. **Dashboard**:
   - After logging in, you’ll be redirected to the dashboard, where you’ll see role-specific content and navigation links to other sections:
     - **Data Entry**: For attendance and dues entry.
     - **Reports**: Summarized reports on donations and dues.
     - **Logout**: To securely end the session.

3. **Data Entry**:
   - Access `data_entry.php` to enter individual attendance and dues records or upload a bulk file (CSV/Excel).

4. **Reports**:
   - Access `report.php` to view summaries of donations and dues.

5. **Logout**:
   - Use the logout link on `dashboard.php` to end your session and return to the login page.

## Optional: Database Setup

If you plan to integrate a MySQL database for managing data:

1. **Create Database**:
   - Use phpMyAdmin or MySQL commands to create a database and tables (e.g., `users`, `attendance`, `dues`).

2. **Connect to Database**:
   - Use PHP’s `PDO` or `mysqli` in `data_process.php` and `report.php` to interact with the database.

3. **PhpSpreadsheet Library for CSV/Excel**:
   - To handle CSV/Excel uploads in `data_process.php`, install [PhpSpreadsheet](https://phpspreadsheet.readthedocs.io/en/latest/) by following the installation instructions on their website.

## Notes

- **Session Timeout**: The application includes a session timeout feature to automatically log users out after 30 minutes of inactivity.
- **Input Validation**: Ensure all user input is sanitized in production environments to prevent SQL injection and other security vulnerabilities.
- **File Permissions**: Ensure appropriate file permissions are set for files and folders within the project.

