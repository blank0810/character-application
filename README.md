# Submission Logs Web App

A web application for managing and tracking submission logs efficiently.

## Description
This web application allows users to manage and track submission logs in a structured manner. It provides an intuitive interface for creating, viewing, and managing submissions with their associated metadata.

## Prerequisites
Before you begin, ensure you have the following installed:
- XAMPP (with PHP >= 7.4)
- MySQL Server
- Web Browser (Chrome, Firefox, or Edge recommended)
- Composer (PHP package manager)

## Installation

1. Place the project files in your XAMPP's htdocs directory:
   ```
   C:\xampp\htdocs\Submission-Logs-Project
   ```

2. Database Setup:
   - Open phpMyAdmin through XAMPP
   - Create a new database named "submission_logs"
   - Or run the following SQL command:
     ```sql
     CREATE DATABASE submission_logs;
     ```

3. Environment Configuration:
   - Copy the `.env.example` file to `.env`
   - Update the following variables in your `.env` file:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=submission_logs
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

4. Run database migrations:
   ```bash
   php artisan migrate
   ```

## Usage
1. Start your XAMPP Apache and MySQL servers
2. Navigate to `http://localhost/Submission-Logs-Project` in your web browser
3. Use the web interface to manage your submission logs