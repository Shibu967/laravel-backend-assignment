


# Product Management System (Laravel)

## Overview

This is a **backend-focused Laravel application** built to demonstrate:

* Multi-authentication (Admin & Customer)
* Real-time updates using WebSockets
* Large-scale **CSV product import** using queues
* Clean and maintainable backend architecture

The UI is minimal and focuses only on demonstrating backend functionality.

---

## Features

* Separate authentication for **Admin** and **Customer**
* Admin dashboard for product and category management
* Product CRUD operations
* **Bulk CSV import** (up to 100,000 products)
* Queue-based background processing
* Real-time user online/offline status using WebSockets
* Feature tests for core functionality

---

## Technology Stack

* Laravel 12
* PHP 8.2+
* MySQL / SQLite
* Laravel Queues
* Laravel Reverb (WebSockets)
* Laravel Excel (CSV processing)
* Blade (minimal UI)
* PHPUnit (testing)

---

## Bulk Product Import (CSV Only)

* Supports CSV file upload
* Processes records using chunk reading
* Each row is validated before import
* Uses queues to prevent timeouts
* Default product image is assigned if missing
* Sample CSV file included:

```
products_sample_import.csv
```

---

## Real-Time Features

* Real-time user presence using WebSockets
* Presence channels for Admin and Customer users
* Online/offline status stored in database
* No AJAX polling used

---

## Testing

* Includes feature tests for key flows (e.g. product creation)
* Run tests using:

```bash
php artisan test
```

---

## Setup Instructions

```bash
git clone <repository-url>
cd project-directory
composer install

cp .env.example .env
php artisan key:generate

npm install
npm run dev

php artisan migrate
php artisan db:seed

php artisan queue:work --timeout=120 --tries=3
php artisan install:broadcasting --reverb
php artisan reverb:start
php artisan serve
```

Update `.env` with database and broadcasting configuration.

---

## Architecture Notes

* Multi-authentication implemented using Laravel guards
* Queue-based CSV imports improve performance
* WebSockets enable real-time updates
* Repository pattern used for cleaner data access
* Codebase follows clean and readable structure


