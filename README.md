# Project Name

## Prerequisites
- PHP >= 8.x
- Composer
- Node.js >= 14.x
- MySQL or other database
- Laravel 11
- Google Maps API Key
- Pusher API Credentials

## Installation Guide
1. Clone the repository:
```bash
   git clone https://github.com/jihuen/wfh.git
   cd repo-name
```

2. Install PHP dependencies:
```bash
    composer install
```
3.  Install Node modules:
```bash
    npm install
```

4.  Set up environment variables:
```bash
    cp .env.example .env
```

5.  Generate application key:
```bash
    php artisan key:generate
```

6.  Run database migrations:
```bash
php artisan migrate
```

7.  Compile assets:
```bash
    npm run dev
```

8.  Start the application:
```bash
    php artisan serve
``` 


##  Features

All Users:
    -   Login & Registration
    -   Edit Profile Information

Staff:
    -   Record attendance (user location info will be tracked)
    -   View personal attendance report
Admin:  
    -   Track active staff location status
    -   View staff attendance report
    -   Approve new users
    -   Edit user settings
    -   Edit role settings


##  Dependencies
- Laravel 11
- Livewire 3
- Google Maps API
- Pusher API
- Location Picker library
