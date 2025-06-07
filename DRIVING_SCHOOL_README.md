# Driving School Management System

A comprehensive Laravel application for managing driving school operations, built with Filament admin panel and modern UI components.

## Features

### 📊 Dashboard Overview

-   **Statistics Overview**: Total students, active students, instructors, packages, sessions, and monthly revenue
-   **Student Registration Chart**: Monthly trends of new student registrations
-   **Revenue Chart**: Income vs expenses tracking over time
-   **Latest Students**: Quick view of recently registered students
-   **Upcoming Sessions**: Training sessions scheduled for the next 7 days

### 🏫 Core Management Modules

#### 📦 Package Management

-   Create and manage training packages
-   Set pricing, duration, and session counts
-   View associated students and sessions
-   Track package popularity

#### 👨‍🏫 Instructor Management

-   Instructor profiles with contact information
-   Track assigned students
-   Monitor instructor workload
-   Manage instructor availability

#### 🎓 Student Management

-   Complete student registration system
-   Track student progress and status
-   Financial records per student
-   Session attendance tracking
-   Package enrollment management

#### 📅 Session Management

-   Training session scheduling
-   Link sessions to packages and materials
-   Student attendance tracking with pivot data
-   Session status management (scheduled, completed, cancelled, missed)

#### 📚 Material Management

-   Training materials and resources
-   Link materials to specific sessions
-   Track material usage across sessions

#### 💰 Financial Management

-   Income and expense tracking
-   Transaction categorization
-   Monthly revenue reporting
-   Student payment records

## Database Schema

### English Naming Convention

The application uses English best practices for database naming:

-   **packages** - Training packages offered
-   **instructors** - Driving instructors
-   **students** - Enrolled students
-   **training_sessions** - Individual training sessions
-   **materials** - Training materials and resources
-   **student_sessions** - Many-to-many relationship with attendance data
-   **session_materials** - Materials used in sessions
-   **finances** - Financial transactions

### Key Relationships

-   **Package ↔ Students**: Many-to-many through student_sessions
-   **Package ↔ Sessions**: One-to-many
-   **Student ↔ Instructor**: Many-to-one
-   **Student ↔ Sessions**: Many-to-many with pivot data (attendance, status)
-   **Session ↔ Materials**: Many-to-many
-   **Student ↔ Finances**: One-to-many

## Installation & Setup

1. **Clone and Install Dependencies**

    ```bash
    composer install
    npm install
    ```

2. **Environment Configuration**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

3. **Database Setup**

    ```bash
    php artisan migrate
    php artisan db:seed --class=DrivingSchoolSeeder
    ```

4. **Create Admin User**

    ```bash
    php artisan make:filament-user
    ```

5. **Start Development Server**
    ```bash
    php artisan serve
    ```

## Usage

### Accessing the Admin Panel

-   Navigate to `http://localhost:8000`
-   Login with your admin credentials
-   Explore the dashboard and management modules

### Navigation Structure

-   **Dashboard**: Overview widgets and statistics
-   **Driving School** section:
    -   Packages
    -   Instructors
    -   Students
    -   Sessions
    -   Materials
    -   Finances

### Key Features Usage

#### Managing Students

1. Navigate to **Students** from the sidebar
2. Use **Create** to add new students
3. View student details and use relation managers to:
    - Track session attendance
    - Monitor financial transactions
    - Assign to packages

#### Scheduling Sessions

1. Go to **Sessions** to create training sessions
2. Link sessions to packages and assign materials
3. Use the **Students** relation manager to track attendance
4. Mark sessions as completed, cancelled, or missed

#### Financial Tracking

1. Use **Finances** to record income and expenses
2. View revenue trends in the dashboard **Revenue Chart**
3. Track monthly income in the **Statistics Overview**

#### Dashboard Monitoring

-   **Stats Overview**: Key metrics at a glance
-   **Student Registrations**: Monthly registration trends
-   **Revenue Chart**: Financial performance over time
-   **Latest Students**: Recent registrations
-   **Upcoming Sessions**: Next 7 days schedule

## Technical Stack

-   **Backend**: Laravel 11.x
-   **Admin Panel**: Filament 3.x
-   **Database**: SQLite (configurable)
-   **Frontend**: Tailwind CSS, Alpine.js
-   **Charts**: Chart.js integration
-   **Icons**: Heroicons

## File Structure

```
app/
├── Filament/
│   ├── Resources/          # CRUD resources
│   │   ├── PackageResource.php
│   │   ├── InstructorResource.php
│   │   ├── StudentResource.php
│   │   ├── SessionResource.php
│   │   ├── MaterialResource.php
│   │   └── FinanceResource.php
│   └── Widgets/           # Dashboard widgets
│       ├── DrivingSchoolStatsOverview.php
│       ├── StudentRegistrationsChart.php
│       ├── RevenueChart.php
│       ├── LatestStudents.php
│       └── UpcomingSessions.php
├── Models/                # Eloquent models
│   ├── Package.php
│   ├── Instructor.php
│   ├── Student.php
│   ├── Session.php
│   ├── Material.php
│   ├── StudentSession.php
│   ├── SessionMaterial.php
│   └── Finance.php
└── Providers/
    └── Filament/
        └── AdminPanelProvider.php
```

## Customization

### Adding New Widgets

1. Create widget: `php artisan make:filament-widget WidgetName`
2. Implement widget logic
3. Register in `AdminPanelProvider.php`

### Extending Resources

1. Add new fields to resource forms and tables
2. Create custom pages if needed
3. Add relation managers for complex relationships

### Dashboard Customization

-   Modify widget order using `$sort` property
-   Adjust widget column spans
-   Add custom styling and colors

## License

This driving school management system is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
