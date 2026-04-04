"# 🏥 Blood Bank Management System (BBMS)

A comprehensive web-based blood bank management system built with Laravel 12, Livewire, and Flux UI.

## 📋 Features

- **Multi-Establishment Support** - Manage multiple blood banks, hospitals, and clinics
- **Donor Management** - Track donors with eligibility rules and donation history
- **Inventory Management** - Real-time blood unit tracking with expiry monitoring
- **Distribution System** - Reserve and issue blood units to patients
- **Alert System** - Automated alerts for low stock and expiring units
- **Role-Based Access** - System administrators and blood bank managers
- **Dashboard Analytics** - Blood type inventory, usage trends, and statistics
- **Security** - Two-factor authentication, secure password handling

## 🚀 Quick Deploy (Free Hosting)

Deploy your Blood Bank Management System to the cloud in minutes using free tier hosting:

### Railway (Recommended - 5 minutes)
```bash
./deploy.sh  # Choose option 1
```
Or manually:
1. Push to GitHub
2. Connect Railway to your repo at https://railway.app/new
3. Add PostgreSQL database
4. Deploy automatically!

📖 **Full deployment guide:** See [`QUICK_DEPLOY.md`](QUICK_DEPLOY.md) or [`DEPLOYMENT_GUIDE.md`](DEPLOYMENT_GUIDE.md)

## 💻 Local Development

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 20+
- SQLite or MySQL

### Quick Setup
```bash
# Clone repository
git clone <your-repo-url>
cd BloodBank_Management_System-app

# Run automated setup
composer run setup

# Start development server
php artisan serve
```

Or use the interactive deployment script:
```bash
chmod +x deploy.sh
./deploy.sh  # Choose option 3 for local testing
```

### Manual Setup
```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Create database
touch database/database.sqlite

# Run migrations and seeders
php artisan migrate:fresh --seed

# Build assets
npm run build

# Start server
php artisan serve
```

Access at: http://localhost:8000

### Default Credentials
- **Admin:** `admin@bloodbank.com` / `password`
- **Manager:** `manager@bloodbank.com` / `password`

⚠️ **Change these passwords in production!**

## 🛠️ Technology Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Livewire 4 + Flux UI
- **Styling:** Tailwind CSS 4
- **Database:** SQLite/MySQL/PostgreSQL
- **Authentication:** Laravel Fortify (with 2FA)
- **Build Tool:** Vite

## 📊 System Architecture

### Database Models
- **Establishment** - Blood banks, hospitals, clinics
- **User** - System admins and managers
- **Donor** - Blood donors with medical history
- **BloodUnit** - Individual blood unit inventory
- **Distribution** - Blood usage tracking
- **Alert** - Inventory alerts and notifications

### User Roles
- **System Administrator** - Full system access, manages all establishments
- **Blood Bank Manager** - Manages specific establishment data

## 📁 Project Structure

```
BloodBank_Management_System-app/
├── app/
│   ├── Livewire/          # Livewire components
│   │   ├── Admin/         # Admin components
│   │   └── BloodBank/     # Blood bank manager components
│   ├── Models/            # Eloquent models
│   └── Http/              # Controllers
├── database/
│   ├── migrations/        # Database migrations
│   └── seeders/           # Database seeders
├── resources/
│   ├── views/             # Blade templates
│   ├── css/               # Stylesheets
│   └── js/                # JavaScript
├── routes/
│   ├── web.php            # Web routes
│   └── settings.php       # Settings routes
├── deploy.sh              # Interactive deployment script
├── QUICK_DEPLOY.md        # Quick deployment guide
├── DEPLOYMENT_GUIDE.md    # Complete deployment guide
└── DEPLOYMENT_SUMMARY.md  # Deployment overview
```

## 🔧 Available Commands

### Development
```bash
composer run dev           # Start full dev environment
php artisan serve          # Start Laravel server only
npm run dev                # Start Vite dev server
```

### Testing
```bash
composer run test          # Run all tests
composer run lint          # Run code linter
composer run lint:check    # Check code style
```

### Production
```bash
composer run production    # Build for production
composer run deploy:prepare # Prepare deployment
```

### Database
```bash
php artisan migrate:fresh --seed  # Fresh database with seed data
php artisan db:seed --class=EstablishmentSeeder  # Seed establishments only
```

## 📖 Documentation

- **[Quick Deploy Guide](QUICK_DEPLOY.md)** - 5-minute deployment to Railway/Render
- **[Complete Deployment Guide](DEPLOYMENT_GUIDE.md)** - Detailed deployment instructions for all platforms
- **[Deployment Summary](DEPLOYMENT_SUMMARY.md)** - Overview of deployment options and files

## 🔐 Security Features

- Password hashing with bcrypt
- CSRF protection
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade templating)
- Two-factor authentication support
- Session management
- Role-based access control

## 🌐 Deployment Options (All FREE)

| Platform | Setup Time | Auto-Deploy | Database | Recommended |
|----------|------------|-------------|----------|-------------|
| **Railway** | 5 min | ✅ Yes | PostgreSQL | ⭐ Best |
| **Render** | 7 min | ✅ Yes | PostgreSQL | ✅ Good |
| **InfinityFree** | 15 min | ❌ Manual | MySQL | ⚙️ Manual |

See deployment guides for detailed instructions.

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is open-source and available under the [MIT License](LICENSE).

## 🆘 Support

- **Documentation:** See the `docs/` folder and deployment guides
- **Issues:** Open an issue on GitHub
- **Community:** Laravel Discord, Stack Overflow

## 👏 Acknowledgments

- Built with [Laravel](https://laravel.com)
- UI components by [Livewire Flux](https://flux.laravel.com)
- Styled with [Tailwind CSS](https://tailwindcss.com)

---

**Ready to deploy?** Run `./deploy.sh` or see [`QUICK_DEPLOY.md`](QUICK_DEPLOY.md) for instructions!

**Questions?** Check the [`DEPLOYMENT_GUIDE.md`](DEPLOYMENT_GUIDE.md) for comprehensive help." 
