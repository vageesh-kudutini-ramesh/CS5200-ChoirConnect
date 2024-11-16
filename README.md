# ChoirConnect
This project is part of the **CS5200-ChoirConnect** repository, focusing on managing choir attendance and membership data. The work in this branch (`Lily's-branch`) includes the database structure, PHP scripts, and web interface to manage choir records efficiently.

## Features Implemented
### 1. **Database Structure**
- **Tables Created**:
  - `Member`: Stores member information such as name, email, and join date.
  - `Attendance`: Tracks attendance records with fields like date, status (Present/Absent), and absence reason.
  - `Dues`: Records membership dues with payment details.
  - `User`: Contains user credentials and roles for access control.
  - `Role`: Manages role-based permissions.
- **Indexes Added**:
  - Indexed `member_id` and `date` columns in the `Attendance` table for optimized query performance.

### 2. **PHP Scripts**
#### Attendance Management
- **submit_attendance.php**: Inserts new attendance records into the database with validation and error handling.
- **edit_attendance.php**: Allows editing of existing attendance records with proper input validation.
- **delete_attendance.php**: Deletes attendance records from the database securely using prepared statements.
- **get_data.php**: Fetches attendance records with pagination and displays them with user-friendly links.
- **manage_attendance.php**: Provides an interface to view, edit, and delete attendance records.

#### Database Connection
- **db_connection.php**: Centralized script to handle database connections securely.

#### Export Functionality
- **export_data.php**: (Optional) Enables exporting data from the database for external analysis.

### 3. **Web Interface**
- **attendance_form.html**: Provides a user-friendly interface for adding attendance records.
- **Pagination**: Pagination links added with styled navigation for better usability.
- **Validation**:
  - Ensures valid date formats.
  - Verifies the status field to avoid invalid values.
  - Implements search functionality (optional).

## How to Set Up
### Prerequisites
1. Install [XAMPP](https://www.apachefriends.org/) for local development.
2. Import the `choir_management_structure.sql` file into phpMyAdmin to create the required database schema.

### Steps
1. Clone the repository:
   ```bash
   git clone git@github.com:vageesh-kudutini-ramesh/CS5200-ChoirConnect.git
   ```
2. Navigate to the project directory:
   ```bash
   cd CS5200-ChoirConnect
   ```
3. Checkout `Lily's-branch`:
   ```bash
   git checkout Lily's-branch
   ```
4. Set up the database:
   - Import `choir_management_structure.sql` in phpMyAdmin.
   - Configure `db_connection.php` with your local database credentials.

### Testing the Application
1. Run the project in your local XAMPP environment.
2. Open `attendance_form.html` in your browser.
3. Add, edit, delete, or view attendance records.
4. Verify database updates in phpMyAdmin.

## Contributions in This Branch
### Member A Responsibilities
1. Designed the database schema and created the SQL structure file (`choir_management_structure.sql`).
2. Developed and tested PHP scripts for:
   - Data insertion.
   - Data editing and deletion.
   - Pagination and search.
3. Created a styled web interface for data management.
4. Added input validation and error handling for all scripts.

## Improvements
- Added role-based access control for managing sensitive data.
- Implemented indexes in the database for query optimization.
- Styled pagination links for improved user experience.

## Future Work
1. Extend export functionality to support different file formats (e.g., CSV, Excel).
2. Add advanced search and filtering options.
3. Integrate authentication for improved security.
