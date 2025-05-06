# Metafit Wellness API

**A RESTful API for Metafit Wellness, built using PHP CodeIgniter**

## Table of Contents
- [Introduction](#introduction)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Configuration](#configuration)
- [Project Structure](#project-structure)
- [Contribution](#contribution)
- [License](#license)

## Introduction
Metafit Wellness API is the backend service for the Metafit Wellness application, providing endpoints for user authentication, wellness content, and various health-related features. It is built using CodeIgniter, a lightweight and powerful PHP framework.

## Features
- **User Authentication**: JWT-based authentication system.
- **Yoga & Ayurveda APIs**: Fetch wellness-related content.
- **Secure API Requests**: CSRF protection and input validation.
- **Role-Based Access**: User and admin-level access control.

## Tech Stack
- **Framework**: CodeIgniter 3
- **Database**: MySQL
- **Authentication**: JWT (JSON Web Token)
- **Server**: Apache / Nginx

## Configuration
Update the database configuration in `application/config/database.php`:
   ```php
   $db['default'] = array(
       'dsn'   => '',
       'hostname' => 'localhost',
       'username' => 'root',
       'password' => 'password',
       'database' => 'metafit_db',
       'dbdriver' => 'mysqli',
       'dbprefix' => '',
       'pconnect' => FALSE,
       'db_debug' => (ENVIRONMENT !== 'production'),
       'cache_on' => FALSE,
       'char_set' => 'utf8',
       'dbcollat' => 'utf8_general_ci'
   );
   ```

## Project Structure
```
metafit-api/
│-- application/
│   │-- config/  # App Config, Database Settings
│   │-- controllers/  # API Controllers
│   │-- models/       # Database Models
│   │-- views/        # HTML Templates (if any)
│-- public/          # Public index.php
│-- writable/        # Cache & Logs
│-- composer.json    # Dependencies & autoloading
```

## Contribution
Private Repo

## License
This project is licensed under the [MIT License](LICENSE).

