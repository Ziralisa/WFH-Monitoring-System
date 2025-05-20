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

9.  Seed the database with admin account and the roles and permissions
```bash
    php artisan db:seed --class=RolesAndPermissionsSeeder
``` 
```bash
    php artisan db:seed --class=RolesAndPermissionsSeeder
``` 

##  Features

All Users:
- Login & Registration
- Edit Profile Information
- Task and Daily Task Management

Staff:
- Record attendance (user location info will be tracked)
- View personal attendance report
- Assign task and update task status, comment task
- Assigned task status can be updated from Daily Task page
- Log will be recorded every time task status is updated in task_logs table

Admin:  
- Track active staff location status
- View staff attendance report
- Approve new users
- Edit user settings
- Edit role settings
- Create new projects, tasks, sprints, assign staff to specific tasks



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

<<<<<<< HEAD
4. Attendance report (Staff side)
=======
4. Attendance report (Staff admin)
>>>>>>> a2f031c (initial commit)
- view : app/resources/views/livewire/admin/attendance-report.blade.php
- function : app/http/livewire/user/attendance.php

5. Attendance status 
- view : app/resources/views/livewire/admin/attendance-status.blade.php
- function : app/http/livewire/user/attendance.php

6. Backlog
- view : app/resources/views/livewire/task-management/backlog.blade.php
- function : app/http/livewire/sprintcontroller.php

12. Daily Task
- view: app\resources\views\livewire\daily-task\show.blade.php
- function: app\Http\Livewire\DailyTask.php

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

## Known bugs/flaws/etc.
## Shahrul
1. Online users 
- 1. Online users are only detected when the user is either on Dashboard Admin page or Take Attendance page
- 2. User last online is not accurate. The actual last online may be 1 hour ago but in database last online is 5 days ago (example). 
- Code responsible for online users is resources\views\livewire\user-on-this-page.blade.php
2. Take Attendance
- 1. User location is using the browser's Geolocation API, therefore easy to exploit
- 2. User attendance location log doesnt record all user activity logs, therefore may not potray accurate logs
    - Review app\resources\views\livewire\user\attendance\includes\map.blade.php
3. Daily Task page
- 1. When selecting task in Add To-Do/Completed Task Modal, kalau pilih first option and then save, akan ada bug dimana tak boleh save.
    - In other words, first option is bugged. Second, third, etc. options work just fine.
    - Workaround to choose the first option is : 1. Pilih second option dulu 2. Pilih first option balik 3. Click save and it works fine





