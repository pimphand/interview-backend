# Laravel Project Setup Guide

This project is built with **Laravel 11** and utilizes the following packages:

-   **[Laratrust](https://github.com/santigarcor/laratrust)**: For role and permission management.
-   **[Laravel JWT](https://github.com/tymondesigns/jwt-auth)**: For JSON Web Token (JWT) based authentication.

---

## Requirements

Before starting, ensure your system meets the following requirements:

-   **PHP**: 8.2 or higher
-   **Composer**: 2.7.x
-   **Database**: PostgreSQL or MySQL
-   **Node.js** (optional for front-end assets): Latest stable version

---

## Installation Instructions

### 1. Clone the Repository

Clone the project repository to your local machine:

```bash
git clone <repository-url>
cd <project-directory>
```

### 2. Install Dependencies

Install the required dependencies using Composer:

```bash
composer install
```

### 3. Configure the Environment

Copy the `.env.example` file to `.env` and update the environment variables as needed:

Update the .env file with your application and database settings:

```bash
APP_NAME=LaravelApp
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql # Change to 'pgsql' for PostgreSQL
DB_HOST=127.0.0.1
DB_PORT=3306 # Use 5432 for PostgreSQL
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 4. Run Database Migrations and Seeders

Run the database migrations and seeders to set up the database schema and initial data:

```bash
php artisan migrate --seed
```

### 5. Start the Application

Start the Laravel development server:

```bash
php artisan serve
```

### Running Tests

To run the tests, execute the following command:

```bash
php artisan test
```

### API Documentation

API documentation is available at `https://documenter.getpostman.com/view/13429693/2sAYBYhBEo` after running the application.
