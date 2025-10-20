# AACOE Student Result Management System

## Overview

This is a Laravel-based web application designed for managing student results at Adamu Augie College of Education, Argungu (AACOE). The system allows examiners to add, edit, and release student results, while students can register for courses and check their results. It includes features for bulk result uploads via CSV, notifications via email and SMS, and role-based access control.

## Features

- **User Authentication**: Secure login and registration with role-based access (Examiner and Student).
- **Role-Based Permissions**: Examiners can manage students, results, courses, and departments. Students can register for courses and view results.
- **Result Management**:
  - Add results individually or upload via CSV.
  - Edit, delete, and change status of results (pending/release).
  - Bulk status updates for entire semesters or specific courses.
- **Course and Department Management**: Create, edit, and delete courses and departments.
- **Student Course Registration**: Students can register for courses.
- **Notifications**: Automatic email and SMS notifications when results are released.
- **Grading System**: Automatic grade assignment based on scores (A, B, C, D, F).
- **Dashboard**: Role-specific dashboards for examiners and students.
- **Responsive UI**: Built with Tailwind CSS for a modern, responsive interface.

## Technologies Used

- **Framework**: Laravel 9
- **PHP**: ^7.3|^8.0
- **Database**: MySQL (configured via Laravel's database config)
- **Frontend**: Blade templates, Tailwind CSS, JavaScript
- **Packages**:
  - Spatie Laravel Permission for role management
  - RealRashid Sweet Alert for notifications
  
- **Queue System**: For processing result notifications in batches
- **SMS Integration**: Custom CloudSms trait for sending SMS

## Installation

### Prerequisites

- PHP 7.3 or 8.0+
- Composer
- Node.js and npm (for frontend assets)
- MySQL or compatible database


### Steps

1. **Clone the Repository**:
   ```bash
   git clone git@github.com:ybmtech/adamu-augie-result.git
   cd aacoe
   ```

2. **Install PHP Dependencies**:
   ```bash
   composer install
   ```

3. **Install Node Dependencies**:
   ```bash
   npm install
   ```

4. **Environment Configuration**:
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update the `.env` file with your database credentials, app key, and other settings (e.g., mail, SMS API keys).

5. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

6. **Run Migrations and Seeders**:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Build Frontend Assets**:
   ```bash
   npm run dev
   # Or for production:
   npm run build
   ```

8. **Start the Server**:
   ```bash
   php artisan serve
   ```
   The application will be available at `http://localhost:8000`.

9. **Queue Worker (for notifications)**:
   ```bash
   php artisan queue:work
   ```

## Usage

### For Examiners
- Log in with examiner credentials.
- Navigate to the dashboard to manage students, results, courses, and departments.
- Add results individually or upload CSV files.
- Release results to notify students via email and SMS.

### For Students
- Register and log in.
- Register for courses.
- Check results once released.

## Database Schema

Key tables include:
- `users`: User accounts with roles.
- `profiles`: User profiles (e.g., phone for SMS).
- `courses`: Course details.
- `departments`: Department information.
- `student_courses`: Junction table for student-course enrollments with scores and status.
- `sessions`, `semesters`, `levels`: Academic session management.


**Note**: Ensure all environment variables are properly set, especially for SMS and email services, to enable full functionality.
