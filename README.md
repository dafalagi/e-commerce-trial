# E-Commerce Trial Application

A modern e-commerce application built with Laravel 12 and Livewire. **This project is primarily designed for learning purposes** to demonstrate Laravel best practices, e-commerce functionality, and modern web development patterns.

## 📋 Table of Contents

- [About](#about)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Installation](#installation)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [API Documentation](#api-documentation)
- [Contributing](#contributing)
- [License](#license)

## 🎯 About

This e-commerce application serves as a comprehensive learning platform showcasing:
- Modern Laravel development patterns
- E-commerce business logic implementation
- Role-based authentication and authorization
- Real-time notifications and queue management
- Clean architecture with proper separation of concerns

**Note: This is an educational project designed to help developers understand Laravel and e-commerce concepts.**

## ✨ Features

### Core E-commerce Features
- **Shopping Cart**: Add, remove, and manage cart items
- **Order Management**: Complete order lifecycle from cart to completion
- **Role-Based Access Control**: Admin, user roles with permission system

### Advanced Features
- **Real-time Notifications**: Queue-based notification system for low stock alerts
- **Email Reports**: Daily sales reports for administrators
- **Queue Management**: Background job processing for notifications and emails
- **Live Components**: Interactive UI with Livewire components

### Development Tools
- **Laravel Telescope**: Application debugging and monitoring
- **PHPUnit Testing**: Unit and feature test coverage
- **Hot Reload**: Vite for fast frontend development

## 🛠 Technology Stack

**Backend:**
- Laravel 12.x (PHP 8.3+)
- PostgreSQL Database
- Queue Workers for background jobs
- Laravel Telescope & Clockwork for debugging

**Frontend:**
- Livewire 3.x for reactive components
- TailwindCSS 4.x for styling
- Vite for asset building
- Alpine.js (via Livewire)

**Third-party Services:**
- Resend for email delivery
- Pusher for real-time broadcasting

## 🚀 Installation

### Prerequisites
- PHP 8.3 or higher
- Composer
- Node.js & npm
- MySQL/MariaDB
- Redis (optional, for queues)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd e-commerce-trial
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your `.env` file**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ecommerce_trial
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   
   QUEUE_CONNECTION=database
   ```

6. **Run database migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the database**
   ```bash
   php artisan db:seed
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   # or for development
   npm run dev
   ```

9. **Start the application**
    ```bash
    php artisan serve
    ```

10. **Start queue workers** (in a separate terminal)
    ```bash
    php artisan queue:work --queue=notifications,default
    ```

## 🎮 Usage

### Development Mode
```bash
# Start Laravel development server
php artisan serve

# Start Vite development server (hot reload)
npm run dev

# Start queue worker
php artisan queue:work
```

### Production
```bash
# Build assets for production
npm run build

# Optimize Laravel for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📁 Project Structure

```
app/
├── Enums/                 # Application enumerations
│   ├── Notification/      # Notification types
│   └── Order/            # Order and payment statuses
├── Helpers/              # Global helper functions
├── Http/
│   ├── Controllers/      # API and web controllers
│   └── Middleware/       # Custom middleware
├── Jobs/                 # Queue jobs
├── Livewire/            # Livewire components
│   ├── Auth/            # Authentication components
│   ├── Order/           # Order management
│   └── Product/         # Product listing and management
├── Mail/                # Email templates
├── Models/              # Eloquent models
│   ├── Auth/           # User, Role, Permission models
│   ├── Order/          # Cart, Order models
│   └── Product/        # Product models
└── Services/           # Business logic services
```

## 📚 Learning Objectives

This project demonstrates:

1. **Laravel Fundamentals**
   - Eloquent ORM
   - Blade templating engine
   - Authentication and authorization

2. **Advanced Laravel Concepts**
   - Queue and job processing
   - Service oriented architecture

3. **E-commerce Patterns**
   - Shopping cart implementation
   - Order management workflow
   - Inventory tracking
   - Payment status handling

4. **Modern Web Development**
   - Component-based UI with Livewire
   - Real-time features
   - Responsive design with TailwindCSS

## 🧪 Testing

Run the test suite:
```bash
# Run all tests
php artisan test

# Run specific test types
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Generate coverage report
php artisan test --coverage
```

## 🤝 Contributing

Since this is a learning project, contributions are welcome! Please:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🔗 Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://livewire.laravel.com)
- [TailwindCSS Documentation](https://tailwindcss.com)

---

**Happy Learning! 🎓**
