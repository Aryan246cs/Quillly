# Quillly — Social Blogging Platform

A full-stack blogging platform built with **Laravel 12**, **Tailwind CSS**, and **Alpine.js**. Users can register, write public or private blog posts, like and comment on posts, manage their profile, and view platform-wide analytics.

---

## Features

- User registration and login (username + password)
- Public and private post visibility
- Post categories and search/filter
- Like and comment system (toggle likes, threaded comments)
- User profile with avatar, location (state/district), gender, DOB
- Personal blog report with engagement statistics
- Website analytics dashboard
- Responsive dark UI with glassmorphism design

---

## Tech Stack

| Layer      | Technology                        |
|------------|-----------------------------------|
| Backend    | PHP 8.2+, Laravel 12              |
| Frontend   | Tailwind CSS (CDN), Alpine.js     |
| Database   | SQLite (default) or MySQL/MariaDB |
| Auth       | Laravel built-in session auth     |
| Storage    | Laravel public disk (profile images) |

---

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18 + npm
- SQLite (default, no setup needed) **or** XAMPP/MySQL

---

## Setup & Installation

### 1. Clone the repository

```bash
git clone <your-repo-url>
cd crud_app
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Database setup

**Option A — SQLite (default, easiest)**

The `.env` already points to `database/database.sqlite`. Just run:

```bash
touch database/database.sqlite
php artisan migrate
```

**Option B — MySQL with XAMPP**

1. Start XAMPP and ensure Apache + MySQL are running
2. Open `http://localhost/phpmyadmin` and create a database (e.g. `quillly`)
3. Update `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quillly
DB_USERNAME=root
DB_PASSWORD=
```

4. Run migrations:

```bash
php artisan migrate
```

### 6. Storage symlink (for profile images)

```bash
php artisan storage:link
```

### 7. Seed categories

The app requires categories to exist. Run the seeder or add them manually via tinker:

```bash
php artisan tinker
```

```php
// Inside tinker:
\App\Models\Category::insert([
    ['name' => 'Technology', 'slug' => 'technology', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Lifestyle',  'slug' => 'lifestyle',  'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Travel',     'slug' => 'travel',     'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Education',  'slug' => 'education',  'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Health',     'slug' => 'health',     'created_at' => now(), 'updated_at' => now()],
]);
exit
```

---

## Running the App

### Development (recommended — runs everything together)

```bash
composer run dev
```

This starts the Laravel server, Vite dev server, queue worker, and log watcher concurrently.

### Or run manually in separate terminals

**Terminal 1 — Laravel server:**
```bash
php artisan serve
```

**Terminal 2 — Vite (CSS/JS):**
```bash
npm run dev
```

Then open: **http://localhost:8000**

---

## Running with XAMPP

If you prefer XAMPP's Apache instead of `php artisan serve`:

1. Place the project in `C:\xampp\htdocs\` (Windows) or `/Applications/XAMPP/htdocs/` (Mac)
2. Start Apache and MySQL in XAMPP Control Panel
3. Point your browser to `http://localhost/crud_app/public`
4. Or configure a virtual host in XAMPP for a cleaner URL

> Note: You still need to run `php artisan migrate` and `php artisan storage:link` from the project directory using your system's PHP (not XAMPP's, unless it's in your PATH).

---

## Project Structure

```
app/
  Http/Controllers/
    PostController.php       # CRUD for posts, public feed
    UserControll.php         # Register, login, logout, profile image
    DashboardController.php  # Profile edit/update/delete
    CommentController.php    # Store comments
    LikeController.php       # Toggle likes
    insightController.php    # Analytics
    LocationController.php   # State/district AJAX
  Models/
    User.php, Post.php, Comment.php, Like.php, Category.php

resources/views/
  layouts/app.blade.php      # Shared layout (navbar, footer, flash messages)
  home.blade.php             # Dashboard (auth) + Login/Register (guest)
  public-posts.blade.php     # Explore feed with search, filters, likes, comments
  create-post.blade.php      # New post form
  edit-post.blade.php        # Edit post form
  your-posts.blade.php       # User's own posts list
  edit-dashboard.blade.php   # Edit profile form
  report.blade.php           # Personal blog stats
  website-insight.blade.php  # Platform analytics

routes/web.php               # All application routes
public/states_districts.json # India states/districts data
```

---

## Key Routes

| Method | URL | Description |
|--------|-----|-------------|
| GET | `/` | Public post feed |
| GET | `/login` | Login / Register page |
| POST | `/register` | Register new user |
| POST | `/login` | Login |
| POST | `/logout` | Logout |
| GET | `/dashboard` | User dashboard (auth) |
| GET | `/create-post` | Create post form (auth) |
| POST | `/create-post` | Submit new post (auth) |
| GET | `/your-posts` | User's posts (auth) |
| GET | `/edit-post/{id}` | Edit post form (auth) |
| PUT | `/edit-post/{id}` | Update post (auth) |
| DELETE | `/delete-post/{id}` | Delete post (auth) |
| GET | `/report` | Personal stats (auth) |
| GET | `/web-analytics` | Platform analytics |
| POST | `/post/{id}/like` | Toggle like (auth) |
| POST | `/post/{id}/comment` | Add comment (auth) |
| GET | `/explore-posts/{category?}` | Filter by category |

---

## Built by

Aryan Srivastava — +91 9929894791
