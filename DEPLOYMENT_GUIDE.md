# 🚀 Blood Bank Management System - Free Deployment Guide

This guide provides step-by-step instructions to deploy the Blood Bank Management System using **100% free tier services**.

---

## 📋 Table of Contents
1. [Deployment Options Overview](#deployment-options-overview)
2. [Option 1: Railway (Recommended)](#option-1-railway-recommended)
3. [Option 2: Render](#option-2-render)
4. [Option 3: InfinityFree + GitHub](#option-3-infinityfree--github)
5. [Local Development Setup](#local-development-setup)
6. [Post-Deployment Configuration](#post-deployment-configuration)
7. [Troubleshooting](#troubleshooting)

---

## 🎯 Deployment Options Overview

| Service | Free Tier | Database | Best For |
|---------|-----------|----------|----------|
| **Railway** | 500 hours/month, $5 credit | PostgreSQL/MySQL | Best overall (Recommended) |
| **Render** | Free tier available | PostgreSQL | Good alternative |
| **InfinityFree** | Unlimited hosting | MySQL | Manual deployment |
| **Heroku** | Limited free tier | PostgreSQL | ⚠️ Limited hours |

**We'll focus on Railway (best option) with alternatives.**

---

# 🚂 Option 1: Railway (Recommended)

Railway offers the best free tier for Laravel applications with automatic deployments from GitHub.

## Prerequisites
- GitHub account
- Railway account (sign up at https://railway.app)

## Step 1: Prepare Your Repository

### 1.1 Create GitHub Repository
```bash
# Initialize git if not already done
cd BloodBank_Management_System-app
git init
git add .
git commit -m "Initial commit"

# Create repository on GitHub, then:
git remote add origin https://github.com/YOUR_USERNAME/blood-bank-system.git
git branch -M main
git push -u origin main
```

### 1.2 Add Production Files

Create `Procfile` in project root:
```procfile
web: php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && heroku-php-apache2 public/
```

Create `nixpacks.toml` in project root (Railway-specific):
```toml
[phases.setup]
nixPkgs = ["php82", "php82Packages.composer"]

[phases.install]
cmds = ["composer install --no-dev --optimize-autoloader"]

[phases.build]
cmds = [
  "php artisan config:cache",
  "php artisan route:cache",
  "php artisan view:cache",
  "npm ci && npm run build"
]

[start]
cmd = "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"
```

### 1.3 Update Composer.json
Add to `composer.json` in the `scripts` section:
```json
"post-install-cmd": [
    "@php artisan key:generate --ansi"
],
"post-deployment": [
    "php artisan migrate --force",
    "php artisan db:seed --force --class=EstablishmentSeeder"
]
```

Commit these changes:
```bash
git add Procfile nixpacks.toml composer.json
git commit -m "Add deployment configuration"
git push
```

## Step 2: Deploy on Railway

### 2.1 Create New Project
1. Go to https://railway.app
2. Click **"New Project"**
3. Select **"Deploy from GitHub repo"**
4. Authenticate with GitHub
5. Select your `blood-bank-system` repository

### 2.2 Add Database
1. Click **"+ New"** in your project
2. Select **"Database"** → **"Add PostgreSQL"** (or MySQL)
3. Railway will automatically provision the database

### 2.3 Configure Environment Variables
1. Click on your Laravel service
2. Go to **"Variables"** tab
3. Add the following variables:

```env
APP_NAME="Blood Bank Management System"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://your-app.railway.app

# Database (Railway auto-provides these, but verify)
DB_CONNECTION=pgsql
DB_HOST=${{PGHOST}}
DB_PORT=${{PGPORT}}
DB_DATABASE=${{PGDATABASE}}
DB_USERNAME=${{PGUSER}}
DB_PASSWORD=${{PGPASSWORD}}

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Mail (use log for now)
MAIL_MAILER=log

# Security
BCRYPT_ROUNDS=12
```

**Important:** Railway auto-generates `APP_KEY` on first deployment, or generate it locally:
```bash
php artisan key:generate --show
```

### 2.4 Deploy
1. Railway will automatically deploy on push
2. Click **"Deployments"** to monitor progress
3. Wait for deployment to complete (5-10 minutes first time)

### 2.5 Run Database Migrations
1. Once deployed, click **"Deploy Logs"**
2. Migrations should run automatically
3. If not, use Railway CLI:
```bash
# Install Railway CLI
npm i -g @railway/cli

# Login
railway login

# Link to project
railway link

# Run migrations
railway run php artisan migrate --seed
```

### 2.6 Get Your URL
1. Click **"Settings"** tab
2. Under **"Domains"**, click **"Generate Domain"**
3. Your app will be available at: `https://your-app.railway.app`

### 2.7 Seed Initial Data
```bash
railway run php artisan db:seed --class=EstablishmentSeeder
```

**Default Login Credentials:**
- Admin: `admin@bloodbank.com` / `password`
- Manager: `manager@bloodbank.com` / `password`

---

# 🎨 Option 2: Render

Render provides free hosting for web services with PostgreSQL database.

## Step 1: Prepare Repository
Same as Railway Step 1.1-1.3, but create `render.yaml`:

```yaml
services:
  - type: web
    name: blood-bank-system
    env: php
    buildCommand: |
      composer install --no-dev --optimize-autoloader
      php artisan config:cache
      php artisan route:cache
      php artisan view:cache
      npm ci && npm run build
    startCommand: |
      php artisan migrate --force
      php artisan serve --host=0.0.0.0 --port=$PORT
    envVars:
      - key: APP_NAME
        value: Blood Bank Management System
      - key: APP_ENV
        value: production
      - key: APP_DEBUG
        value: false
      - key: SESSION_DRIVER
        value: database
      - key: CACHE_STORE
        value: database
      - key: DB_CONNECTION
        value: pgsql
      - key: APP_KEY
        generateValue: true

databases:
  - name: bloodbank-db
    plan: free
    databaseName: bloodbank
    user: bloodbank
```

## Step 2: Deploy on Render

1. Go to https://render.com
2. Click **"New +"** → **"Blueprint"**
3. Connect your GitHub repository
4. Select the repository with `render.yaml`
5. Click **"Apply"**
6. Render will create both web service and database
7. Wait for deployment (10-15 minutes)

## Step 3: Configure

1. Go to your web service dashboard
2. Click **"Environment"**
3. Add `APP_URL` with your Render URL
4. Click **"Shell"** and run:
```bash
php artisan db:seed --class=EstablishmentSeeder
```

---

# 🌐 Option 3: InfinityFree + GitHub

For traditional shared hosting with unlimited bandwidth.

## Step 1: Sign Up for InfinityFree

1. Go to https://infinityfree.net
2. Click **"Sign Up"**
3. Create account and verify email
4. Create a new account (choose subdomain or use custom domain)

## Step 2: Prepare Files

### 2.1 Build Assets Locally
```bash
npm install
npm run build
```

### 2.2 Install Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

### 2.3 Update .env for Shared Hosting
```env
APP_NAME="Blood Bank Management System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.infinityfreeapp.com

DB_CONNECTION=mysql
DB_HOST=sqlXXX.infinityfree.com
DB_PORT=3306
DB_DATABASE=epiz_XXXXXXX_bloodbank
DB_USERNAME=epiz_XXXXXXX
DB_PASSWORD=your_db_password

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

### 2.4 Create .htaccess in Root
Create `.htaccess` in project root (not public):
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

## Step 3: Upload Files

### Option A: FTP Upload
1. Download FileZilla: https://filezilla-project.org
2. Get FTP credentials from InfinityFree dashboard
3. Connect to FTP
4. Upload entire project to `htdocs` folder
5. Set permissions:
   - `storage/` → 755
   - `bootstrap/cache/` → 755

### Option B: GitHub Integration
1. Create deployment script `deploy.php`:
```php
<?php
// Simple GitHub webhook deployment
$secret = 'your_secret_key';
$repo = 'https://github.com/YOUR_USERNAME/blood-bank-system.git';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payload = file_get_contents('php://input');
    $sig = "sha1=" . hash_hmac('sha1', $payload, $secret);
    
    if (hash_equals($sig, $_SERVER['HTTP_X_HUB_SIGNATURE'])) {
        shell_exec("cd /home/YOUR_USERNAME/htdocs && git pull");
        echo "Deployment successful!";
    }
}
?>
```

## Step 4: Setup Database

1. Go to InfinityFree Control Panel
2. Click **"MySQL Databases"**
3. Create new database
4. Note credentials (host, database name, username, password)
5. Use phpMyAdmin to import migrations or run:
```bash
php artisan migrate --seed
```

## Step 5: Optimize

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

# 💻 Local Development Setup

Before deploying, test locally:

## Step 1: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

## Step 2: Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create SQLite database
touch database/database.sqlite
```

## Step 3: Configure Database

Edit `.env`:
```env
DB_CONNECTION=sqlite
# Comment out other DB_ lines
```

## Step 4: Run Migrations & Seed

```bash
php artisan migrate:fresh --seed
```

## Step 5: Build Assets

```bash
npm run build
```

## Step 6: Start Development Server

```bash
# Option 1: Single command
php artisan serve

# Option 2: Full development environment (recommended)
composer run dev
```

Access at: http://localhost:8000

**Default Credentials:**
- Admin: `admin@bloodbank.com` / `password`
- Manager: `manager@bloodbank.com` / `password`

---

# ⚙️ Post-Deployment Configuration

## 1. Security Hardening

### Update Default Passwords
```bash
php artisan tinker
```
```php
$user = App\Models\User::where('email', 'admin@bloodbank.com')->first();
$user->password = bcrypt('new_secure_password');
$user->save();
```

### Disable Debug Mode
In `.env`:
```env
APP_DEBUG=false
```

### Enable HTTPS (if not automatic)
In `.env`:
```env
APP_URL=https://yourdomain.com
```

## 2. Configure Email (Optional)

### Using Gmail (Free)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your.email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your.email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Using SendGrid (Free tier: 100 emails/day)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your_sendgrid_api_key
MAIL_FROM_ADDRESS=noreply@yourdomain.com
```

## 3. Setup Scheduled Tasks

For automated expiry checks and alerts:

**Railway/Render:** Use their cron job feature
**InfinityFree:** Use external cron service like cron-job.org

Add to `routes/console.php` or create command:
```php
Schedule::command('blood:check-expiry')->daily();
```

External cron URL:
```
https://yourdomain.com/api/cron?token=your_secret_token
```

## 4. Backup Strategy

### Database Backups
```bash
# PostgreSQL (Railway/Render)
pg_dump DATABASE_URL > backup.sql

# MySQL (InfinityFree)
mysqldump -u username -p database_name > backup.sql
```

### Automated Backups
Use Railway/Render backup features or create cron job:
```bash
0 2 * * * pg_dump $DATABASE_URL > /backups/backup-$(date +\%Y\%m\%d).sql
```

---

# 🔧 Troubleshooting

## Common Issues

### 1. "500 Internal Server Error"

**Solution:**
```bash
# Check logs
tail -f storage/logs/laravel.log

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Fix permissions
chmod -R 755 storage bootstrap/cache
```

### 2. "Mix Manifest Not Found"

**Solution:**
```bash
npm run build
```

### 3. Database Connection Failed

**Solution:**
- Verify environment variables
- Check database credentials
- Ensure database service is running

### 4. Asset Loading Issues (CSS/JS)

**Solution:**
In `.env`:
```env
ASSET_URL=https://yourdomain.com
```

In `config/app.php`:
```php
'asset_url' => env('ASSET_URL', null),
```

### 5. Railway: App Not Starting

**Check:**
- Build logs for errors
- Ensure `nixpacks.toml` is correct
- Verify environment variables
- Check Railway metrics for memory/CPU limits

---

# 📊 Performance Optimization

## 1. Enable OpCache (Railway/Render)

Add to `php.ini` or configure in platform:
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
```

## 2. Cache Configuration

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 3. Database Indexing

Already optimized in migrations, but verify:
```sql
SHOW INDEX FROM blood_units;
SHOW INDEX FROM donors;
```

## 4. CDN for Assets (Optional)

Use Cloudflare (free tier) for static asset delivery.

---

# 🔐 Security Checklist

- [ ] `APP_DEBUG=false` in production
- [ ] Strong `APP_KEY` generated
- [ ] Default passwords changed
- [ ] HTTPS enabled
- [ ] Database credentials secure
- [ ] File permissions set correctly (755 for directories, 644 for files)
- [ ] `.env` file not committed to git
- [ ] CSRF protection enabled (default)
- [ ] SQL injection protection (Eloquent ORM)
- [ ] XSS protection (Blade templating)

---

# 📱 Custom Domain (Optional)

## Railway
1. Go to Settings → Domains
2. Click "Custom Domain"
3. Add your domain
4. Update DNS records:
   - Type: CNAME
   - Name: www (or @)
   - Value: your-app.railway.app

## Render
1. Go to Settings → Custom Domain
2. Add domain
3. Update DNS:
   - Type: CNAME
   - Value: provided by Render

## InfinityFree
1. Control Panel → Addon Domains
2. Add your domain
3. Update nameservers at domain registrar

**Free Domain Options:**
- Freenom: .tk, .ml, .ga, .cf, .gq domains
- GitHub Student Pack: Free .me domain

---

# 📞 Support & Resources

## Documentation
- Laravel: https://laravel.com/docs
- Livewire: https://livewire.laravel.com
- Railway: https://docs.railway.app
- Render: https://render.com/docs

## Community
- Laravel Discord: https://discord.gg/laravel
- Stack Overflow: Tag `laravel`
- Laracasts: https://laracasts.com

---

# ✅ Deployment Checklist

Before going live:

- [ ] Test all features locally
- [ ] Run `php artisan test` (if tests exist)
- [ ] Backup database
- [ ] Update environment variables
- [ ] Run migrations on production
- [ ] Seed establishment data
- [ ] Test login with default accounts
- [ ] Change default passwords
- [ ] Verify email functionality
- [ ] Test blood unit creation
- [ ] Test distribution workflow
- [ ] Check alert system
- [ ] Monitor error logs
- [ ] Test on mobile devices
- [ ] Setup monitoring (UptimeRobot - free)

---

# 🎉 You're Live!

Your Blood Bank Management System is now deployed and accessible worldwide! 

**Next Steps:**
1. Share the URL with your team
2. Create establishment accounts
3. Import donor data (if migrating)
4. Configure alert thresholds
5. Train users on the system

**Need Help?** Check the troubleshooting section or open an issue on GitHub.

---

**Last Updated:** April 2026  
**Version:** 1.0  
**License:** MIT
