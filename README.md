# CS5200 Final Project - Choir Management Portal

## Project Overview
The Choir Management Portal is a PHP-based web application designed to help manage choir member information, attendance, dues, and other operational data effectively. The application provides role-based access for different types of users (Admin, Treasurer, Secretary) to ensure that each user sees content relevant to their role.

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

## Project Structure
- **CSS/**: Contains stylesheets used for the website.
- **uploads/**: Stores files uploaded to the system, such as CSV files for data import.
- **.git/**: Git version control folder.
- **choir_management.sql**: SQL script used to set up the database schema for managing the choir's data.
- **db_connection.php**: Establishes the connection to the MySQL database.
- **UserLogin.php**: Handles user authentication, including login.
- **dashboard.php**: Dashboard with role-specific content and navigation links.
- **data_entry.php**: Allows users to enter new choir member data or attendance and dues data.
- **insert_data.php**: Script for inserting new member data into the database.
- **data_process.php**: Processes data entry forms and bulk uploads.
- **get_data.php**: Retrieves data from the database for display.
- **manage_attendance.php**: Provides functionality to manage choir attendance.
- **attendance_form.html**: HTML form used for submitting attendance records.
- **submit_attendance.php**: Processes attendance submissions.
- **edit_attendance.php**: Provides functionality for editing existing attendance records.
- **delete_attendance.php**: Handles deletion of attendance records.
- **report.php**: Displays reports for dues, donations, and attendance based on the available data.
- **upload_csv.php**: Allows users to upload CSV files for bulk data entry.
- **export_data.php**: Exports data from the system into CSV files.
- **logout.php**: Logs users out of the system and redirects to the login page.
- **test.php, test_db_connection.php**: Used for testing purposes, including database connection.

## Installation Instructions
1. **Install XAMPP**:
   - Download and install [XAMPP](https://www.apachefriends.org/index.html) to set up a local Apache server with PHP and MySQL.

2. **Clone the Repository**: Clone the project repository from GitHub using:
   ```
   git clone <repository_url>
   ```

3. **Set Up the Database**:
   - Import the `choir_management.sql` file into your MySQL database to create the required tables.
   - Update the database connection details in `db_connection.php` to match your local database configuration.

4. **Deploy on Local Server**:
   - Move the project files to your local server's root directory (e.g., XAMPP's `htdocs` folder).
   - Start your local server and open the application in your browser.
   - Open your browser and navigate to:
     ```
     http://localhost:8080/CS5200-ChoirConnect-Michael-s-branch/membership_portal/UserLogin.php
     ```

## Usage
- **User Login**: Navigate to `UserLogin.php` to log in to the system.
  - Use the following credentials to log in as different roles:
    - **Admin**: Username: `admin`, Password: `admin123`
    - **Treasurer**: Username: `treasurer`, Password: `treasurer123`
    - **Secretary**: Username: `secretary`, Password: `secretary123`
- **Dashboard**: Once logged in, use the dashboard to access different features like attendance management, data entry, and reporting.
- **Data Entry**: Use `data_entry.php` to add new choir members, or to enter attendance and dues records individually or via bulk upload.
- **Attendance Management**: Record or modify attendance using `attendance_form.html` and `manage_attendance.php`.
- **Reporting**: Generate attendance, dues, and donations reports with `report.php`.
- **Logout**: Use the logout link on `dashboard.php` to end your session and return to the login page.

## Requirements
- **Local Server**: XAMPP or WAMP with PHP and MySQL enabled.
- **Web Browser**: Latest version of Chrome, Firefox, or Edge.

## Optional: Database Setup
If you plan to integrate a MySQL database for managing data:

1. **Create Database**:
   - Use phpMyAdmin or MySQL commands to create a database and tables (e.g., `users`, `attendance`, `dues`).

2. **Connect to Database**:
   - Use PHP’s `PDO` or `mysqli` in `data_process.php` and `report.php` to interact with the database.

3. **PhpSpreadsheet Library for CSV/Excel**:
   - To handle CSV/Excel uploads in `data_process.php`, install [PhpSpreadsheet](https://phpspreadsheet.readthedocs.io/en/latest/) by following the installation instructions on their website.

## Contributing
Feel free to contribute by submitting issues or pull requests. Make sure you follow the coding standards and provide detailed commit messages.

## License
This project is licensed under the MIT License.

## Contact
For any questions or support, please reach out to the project owner.

## Notes
- **Session Timeout**: The application includes a session timeout feature to automatically log users out after 30 minutes of inactivity.
- **Input Validation**: Ensure all user input is sanitized in production environments to prevent SQL injection and other security vulnerabilities.
- **File Permissions**: Ensure appropriate file permissions are set for files and folders within the project.
