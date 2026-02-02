# Inventory Management System

A modern Laravel-based inventory management system with a beautiful glassmorphic UI for managing products, suppliers, purchase orders, and stock movements.

## Features

- **Product Management** - Complete CRUD with SKU generation and stock tracking
- **Category Management** - Hierarchical product categorization
- **Supplier Management** - Supplier information and contact management
- **Purchase Orders** - Order lifecycle from pending to received
- **Stock Tracking** - Real-time movement history and low-stock alerts
- **Analytics Dashboard** - Reports, charts, and business insights
- **User Authentication** - Secure login system with role-based access

## Tech Stack

- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: Tailwind CSS, Alpine.js, Vite
- **Database**: SQLite (configurable)
- **UI Design**: Glassmorphic dark theme with smooth animations

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm

### Quick Setup
```bash
# Clone the repository
git clone <repository-url>
cd inventory-system

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate
php artisan migrate

# Build assets
npm run build

# Start development server
php artisan serve
```

### Automated Setup
```bash
composer run setup
```

## Development

### Available Commands
```bash
# Start all development services
composer run dev

# Run tests
composer run test

# Build for production
npm run build
```

### Project Structure
```
app/
├── Http/Controllers/Admin/    # Admin controllers
├── Models/                    # Eloquent models
└── Providers/                 # Service providers

database/
├── migrations/                # Database schema
├── seeders/                   # Test data
└── factories/                 # Model factories

resources/
├── views/admin/               # Blade templates
├── css/admin.css              # Custom styling
└── js/admin.js                # JavaScript functionality
```

## Screenshots

The application features a modern glassmorphic design with:
- Responsive dashboard with key metrics
- Intuitive product and inventory management
- Real-time stock tracking and alerts
- Comprehensive reporting interface

## License

This project is open-source and available under the [MIT License](LICENSE).