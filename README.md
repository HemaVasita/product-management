# Product Management System

This project is a simple **Product Management System** built using **Laravel**. It allows users to manage products, categories, tags, and product details. Users can also upload images, view products, and perform basic CRUD (Create, Read, Update, Delete) operations.

## Features

- Manage products with details such as title, category, description, price, type, and tags.
- Image upload functionality.
- Category and tag management.
- A user-friendly UI to interact with the product management system.
- Laravel backend for handling product-related actions.

## Requirements

Before running this project, make sure you have the following installed:

- PHP >= 8.2
- Composer
- Laravel 11.x
- MySQL (or a compatible database)
- Node.js (for running frontend build tools)

## Setup Instructions

Follow these steps to set up and run the project:

### 1. Clone the Repository

Start by cloning the repository to your local machine:

```bash
git clone https://github.com/HemaVasita/product-management.git
cd product-management
```

### 2. Install Dependencies

Run the following command to install PHP dependencies using Composer:

```bash
composer install
```

Then, install the JavaScript dependencies:

```bash
npm install
```

### 3. Set Up Environment Configuration

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Open the `.env` file and configure the following settings:

- **Database**: Set up your database credentials (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
- **App Key**: If not already set, generate an app key by running:

```bash
php artisan key:generate
```

### 4. Run Database Migrations

Run the migrations to create the required database tables:

```bash
php artisan migrate
```

If you want to seed the database with sample data, run:

```bash
php artisan db:seed
```

### 5. Set File Permissions

Ensure the `storage` folder is writable for file uploads:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 6. Serve the Application

You can now serve the application using the built-in Laravel development server:

```bash
composer run dev
```

By default, it will be accessible at [http://127.0.0.1:8000](http://127.0.0.1:8000).

### 7. Access the Application

Once the server is running, open your browser and navigate to [http://127.0.0.1:8000](http://127.0.0.1:8000). You should be able to see the product management system in action.

## Troubleshooting

- If you're encountering issues with database migrations or permissions, check the database connection and ensure that the `storage` and `bootstrap/cache` directories are writable.
- If your images are not displaying, verify the `storage:link` command has been run to create a symbolic link to the `public/storage` directory:

```bash
php artisan storage:link
```

## License

This project is open-source and available under the MIT License.
