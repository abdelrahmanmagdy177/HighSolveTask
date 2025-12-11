# Dynamic Task Widget - Laravel Full-Stack Feature

A complete task management widget demonstrating **Database → Laravel API → Blade + AJAX** workflow.

## 🎯 Project Overview

This project implements a full-stack task management feature with:
- **Backend**: Laravel 12 API with authentication
- **Frontend**: Blade templates with AJAX (no page reloads)
- **Database**: MySQL with proper relationships


## 📹 Demo Video

See `demo_video.webp` in the repository root for a complete demonstration showing:
1. Running the project locally (`php artisan serve`)
2. Viewing the "My Tasks" widget on the dashboard
3. Adding new tasks using the form (AJAX POST)
4. Tasks appearing instantly without page reload
5. Toggling task completion using checkboxes (AJAX PUT)
6. Visual updates (grey text + strikethrough when completed)

## 🚀 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL or SQLite
- Node.js & NPM

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd highsolve
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```


3. **Set up database**
   - Update `.env` with your database credentials highsolve
   - Run migrations:
   ```bash
   php artisan migrate
   ```



4. **Start the development server**
   ```bash
   php artisan serve
   ```

5. **Visit the application**
   - Open http://localhost:8000
   - Register a new account
   - Start managing your tasks!

## 📁 Project Structure

### Backend Files

```
app/
├── Http/Controllers/
│   └── TaskController.php          # API endpoints for tasks
├── Models/
│   ├── Task.php                    # Task model with relationships
│   └── User.php                    # User model (updated)
database/
└── migrations/
    └── 2025_12_10_191215_create_tasks_table.php
routes/
└── web.php                         # Task routes
```

### Frontend Files

```
resources/
└── views/
    └── dashboard.blade.php         # Task widget with AJAX
```

## 🔌 API Endpoints

All endpoints require authentication (`auth` middleware).

### GET /tasks
Retrieve all tasks for the authenticated user.

**Response:**
```json
[
  {
    "id": 1,
    "title": "Complete Laravel project",
    "is_completed": false,
    "user_id": 1,
    "created_at": "2025-12-10T19:17:00.000000Z",
    "updated_at": "2025-12-10T19:17:00.000000Z"
  }
]
```

### POST /tasks
Create a new task.

**Request:**
```json
{
  "title": "New task description"
}
```

**Response (201):**
```json
{
  "id": 2,
  "title": "New task description",
  "is_completed": false,
  "user_id": 1,
  "created_at": "2025-12-10T19:18:00.000000Z",
  "updated_at": "2025-12-10T19:18:00.000000Z"
}
```

### PUT /tasks/{task}
Toggle task completion status.

**Response:**
```json
{
  "id": 1,
  "title": "Complete Laravel project",
  "is_completed": true,
  "user_id": 1,
  "created_at": "2025-12-10T19:17:00.000000Z",
  "updated_at": "2025-12-10T19:19:00.000000Z"
}
```

## 🗄️ Database Schema

### tasks table
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| title | string | Task description |
| is_completed | boolean | Completion status (default: false) |
| user_id | bigint | Foreign key to users table |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

### Relationships
- `Task` belongs to `User`
- `User` has many `Tasks`

## 🎨 Frontend Features

### AJAX Operations

1. **Load Tasks (on page load)**
   - Fetches all user tasks via GET request
   - Displays in a clean, organized list

2. **Add Task**
   - Submits form via POST request
   - Adds task to list instantly without reload
   - Shows pulse animation on new task

3. **Toggle Completion**
   - Updates task via PUT request
   - Applies strikethrough and grey color when completed
   - Smooth visual transition


All features have been manually tested:

- ✅ User registration and login
- ✅ Task creation via AJAX
- ✅ Task loading on page load
- ✅ Task completion toggle
- ✅ Visual updates without page reload
- ✅ Authorization (users can't access other users' tasks)
- ✅ Error handling

## 🛠️ Technologies Used

- **Backend**: Laravel 12
- **Frontend**: Blade Templates, Vanilla JavaScript
- **Database**: MySQL
- **Authentication**: Laravel Breeze

**Author**: abdelrahman magdy 
**Date**: December 10, 2025  
