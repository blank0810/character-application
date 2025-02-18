# Star Wars Character App

A web application for managing and displaying Star Wars characters. Users can save characters from the Star Wars API, check for existing characters, and delete characters from their list. The application features user authentication, including email verification, and utilizes AJAX for seamless interactions.

## Prerequisites

Before you begin, ensure you have the following installed:

- XAMPP (with PHP >= 7.4)
- MySQL Server
- Web Browser (Chrome, Firefox, or Edge recommended)
- Composer (PHP package manager)

## Installation

1. **Clone the repository**:

   ```bash
   git clone <repository-url>
   ```

   Replace `<repository-url>` with the URL of your repository.

2. **Place the project files in your XAMPP's htdocs directory**:

   ```
   C:\xampp\htdocs\character-app
   ```

3. **Database Setup**:

   - Open phpMyAdmin through XAMPP.
   - Create a new database named `character_app` or run the following SQL command:
     ```sql
     CREATE DATABASE character_app;
     ```

4. **Environment Configuration**:

   - Copy the `.env.example` file to `.env`.
   - Update the following variables in your `.env` file:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=character_app
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

5. **Run database migrations**:

   ```bash
   php artisan migrate
   ```

## Usage

1. Start your XAMPP Apache and MySQL servers.
2. Navigate to `http://localhost/character-app` in your web browser.
3. Use the web interface to manage your Star Wars characters.