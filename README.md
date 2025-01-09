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
- Login & Registration
- Edit Profile Information

Staff:
- Record attendance (user location info will be tracked)
- View personal attendance report

Admin:  
- Track active staff location status
- View staff attendance report
- Approve new users
- Edit user settings
- Edit role settings


##  Dependencies
- Laravel 11
- Livewire 3
- Google Maps API
- Pusher API
- Location Picker library


## Page related
1. Dashboard admin
- view : app/resources/views/livewire/admin/dashboard/show.blade.php
- function : app/http/livewire/user/attendance.php

2. Take attendance (dashboard staff)
- view : app/resources/views/livewire/user/attendance/show.blade.php
- function : app/http/livewire/user/attendance.php

3. Attendance report (Staff side)
- view : app/resources/views/livewire/staff/report.blade.php
- function : app/http/livewire/user/attendance.php

4. Attendance report (Staff side)
- view : app/resources/views/livewire/admin/attendance-report.blade.php
- function : app/http/livewire/user/attendance.php

5. Attendance status 
- view : app/resources/views/livewire/admin/attendance-status.blade.php
- function : app/http/livewire/user/attendance.php

6. Backlog
- view : app/resources/views/livewire/task-management/backlog.blade.php
- function : app/http/livewire/sprintcontroller.php

7. Daily Task
- view : app/resources/views/livewire/task-management/components/daily-task-page.blade.php
- function : app/http/livewire/sprintcontroller.php

8. Add Sprint
- view : app/resources/views/livewire/task-management/backlog.blade.php
- function : app/http/livewire/sprintcontroller.php

9. Add Task di Backlog
- view : app/resources/views/livewire/task-management/components/add-task.blade.php
- function : app/http/livewire/sprintcontroller.php

9. Add comment di Backlog
- view : app/resources/views/livewire/task-management/components/comment.blade.php
- function : app/http/livewire/sprintcontroller.php

10. User setting
- view : app/resources/views/livewire/admin/user-settings/show.blade.php
- function : app/http/livewire/Admin/UserSettings.php

11. Role setting
- view : app/resources/views/livewire/admin/role-settings/show.blade.php
- function : app/http/livewire/Admin/RoleSettings.php