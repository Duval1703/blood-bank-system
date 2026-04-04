# 🚀 Railway Deployment Guide - Blood Bank Management System

This guide will help you deploy the Blood Bank Management System to Railway.app in minutes.

## 📋 Prerequisites

- A [Railway.app](https://railway.app) account (free tier available)
- Git repository (GitHub, GitLab, or Bitbucket)
- Basic understanding of environment variables

---

## 🎯 Quick Deployment (5 Minutes)

### Step 1: Push Code to Git Repository

```bash
# If not already in a git repository
cd BloodBank_Management_System-app
git init
git add .
git commit -m "Initial commit - Blood Bank Management System"

# Push to GitHub/GitLab
git remote add origin YOUR_GIT_REPOSITORY_URL
git push -u origin main
```

### Step 2: Create New Project on Railway

1. Go to [Railway.app](https://railway.app)
2. Click **"New Project"**
3. Select **"Deploy from GitHub repo"**
4. Choose your Blood Bank Management System repository
5. Railway will automatically detect it's a Laravel app

### Step 3: Configure Environment Variables

In Railway dashboard, go to **Variables** tab and add these:

#### Required Variables:
```env
APP_NAME=Blood Bank Management System
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app
DB_CONNECTION=sqlite
```

#### Generate APP_KEY:
Run this locally to generate a key:
```bash
php artisan key:generate --show
```
Copy the output and add it to Railway as:
```env
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
```

### Step 4: Deploy!

Railway will automatically:
- ✅ Install PHP 8.2 dependencies
- ✅ Install Node.js dependencies
- ✅ Build frontend assets
- ✅ Run database migrations
- ✅ Seed default users and establishments
- ✅ Deploy your application

Your app will be live in 3-5 minutes! 🎉

---

## 🔐 Default Login Credentials

After deployment, you can log in with these accounts:

### System Administrator
- **Email:** `admin@bloodbank.com`
- **Password:** `password`
- **Access:** Full system access, manages all establishments

### Blood Bank Managers
1. **Central Blood Bank Manager**
   - **Email:** `manager@bloodbank.com`
   - **Password:** `password`

2. **Hospital Manager**
   - **Email:** `hospital@bloodbank.com`
   - **Password:** `password`

3. **Clinic Manager**
   - **Email:** `clinic@bloodbank.com`
   - **Password:** `password`

**⚠️ IMPORTANT:** Change these passwords immediately after first login!

---

## 🗄️ Database Options

### Option 1: SQLite (Default - Recommended for Testing)

Already configured! No additional setup needed.

**Pros:**
- ✅ Zero configuration
- ✅ Free
- ✅ Perfect for testing/demo
- ✅ Fast deployment

**Cons:**
- ⚠️ Data resets on each deployment
- ⚠️ Not suitable for production with persistent data

**Configuration:**
```env
DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite
```

### Option 2: PostgreSQL (Recommended for Production)

1. In Railway dashboard, click **"+ New"** → **"Database"** → **"Add PostgreSQL"**
2. Railway automatically creates these variables: `PGHOST`, `PGPORT`, `PGDATABASE`, `PGUSER`, `PGPASSWORD`
3. Update your environment variables:

```env
DB_CONNECTION=pgsql
DB_HOST=${{PGHOST}}
DB_PORT=${{PGPORT}}
DB_DATABASE=${{PGDATABASE}}
DB_USERNAME=${{PGUSER}}
DB_PASSWORD=${{PGPASSWORD}}
```

**Pros:**
- ✅ Persistent data storage
- ✅ Production-ready
- ✅ Better performance at scale
- ✅ Automatic backups (paid plan)

### Option 3: MySQL (Alternative)

1. In Railway dashboard, click **"+ New"** → **"Database"** → **"Add MySQL"**
2. Update environment variables:

```env
DB_CONNECTION=mysql
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}
```

---

## ⚙️ Advanced Configuration

### All Available Environment Variables

```env
# Application
APP_NAME="Blood Bank Management System"
APP_ENV=production
APP_KEY=base64:YOUR_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app.railway.app

# Database (Choose one option above)
DB_CONNECTION=sqlite

# Session & Cache
SESSION_DRIVER=file
CACHE_STORE=file

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error

# Mail (Optional - for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@bloodbank.com
MAIL_FROM_NAME="${APP_NAME}"

# Queue (Optional - for background jobs)
QUEUE_CONNECTION=database
```

### Enable Email Notifications

To send real emails:

1. Sign up for a service like [SendGrid](https://sendgrid.com), [Mailgun](https://www.mailgun.com), or [Postmark](https://postmarkapp.com)
2. Add these variables to Railway:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=YOUR_SENDGRID_API_KEY
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
```

---

## 🔧 Troubleshooting

### Issue: Deployment Fails

**Check build logs:**
1. Go to Railway dashboard
2. Click on your service
3. Check **"Deployments"** tab
4. Click on failed deployment to see logs

**Common fixes:**
- Ensure `APP_KEY` is set
- Check PHP version compatibility (requires PHP 8.2+)
- Verify all composer dependencies are correct

### Issue: White Screen / 500 Error

**Solution:**
1. Set `APP_DEBUG=true` temporarily in Railway variables
2. Visit your site to see detailed error
3. Fix the issue
4. Set `APP_DEBUG=false` again

### Issue: Database Connection Failed

**For SQLite:**
```env
DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite
```

**For PostgreSQL/MySQL:**
- Ensure database service is running
- Check connection variables are correct
- Use Railway's reference variables: `${{PGHOST}}`

### Issue: Assets Not Loading

**Solution:**
1. Ensure `npm run build` completed successfully
2. Check `public/build` directory exists
3. Verify `APP_URL` matches your Railway domain

### Issue: Data Lost After Redeployment

**Cause:** Using SQLite (ephemeral storage)

**Solution:** Switch to PostgreSQL or MySQL for persistent storage

---

## 📊 Monitoring & Maintenance

### View Application Logs

1. Railway Dashboard → Your Service
2. Click **"Logs"** tab
3. Real-time logs appear here

### Metrics & Usage

1. Railway Dashboard → Your Service
2. Click **"Metrics"** tab
3. View CPU, Memory, Network usage

### Manual Database Operations

**Run migrations manually:**
```bash
# In Railway's settings, add this to "Deploy Command"
php artisan migrate --force
```

**Reset database (⚠️ Deletes all data):**
```bash
php artisan migrate:fresh --seed --force
```

---

## 🔄 Redeployment & Updates

### Automatic Deployments

Railway automatically redeploys when you push to your main branch:

```bash
git add .
git commit -m "Your changes"
git push origin main
```

Railway detects the push and redeploys automatically!

### Manual Redeployment

1. Railway Dashboard → Your Service
2. Click **"Deployments"** tab
3. Click **"Redeploy"** on any previous deployment

---

## 🎨 Custom Domain (Optional)

### Add Your Own Domain

1. Railway Dashboard → Your Service → **"Settings"**
2. Scroll to **"Domains"** section
3. Click **"Add Domain"**
4. Enter your domain (e.g., `bloodbank.yourdomain.com`)
5. Add the provided CNAME record to your DNS provider:
   ```
   CNAME: bloodbank.yourdomain.com → your-app.railway.app
   ```
6. Update `APP_URL` in Railway variables:
   ```env
   APP_URL=https://bloodbank.yourdomain.com
   ```

Railway automatically provisions SSL certificates! 🔒

---

## 💰 Pricing & Limits

### Free Tier (Hobby Plan)
- ✅ $5/month free credit
- ✅ Automatic HTTPS
- ✅ Unlimited deploys
- ⚠️ Services sleep after inactivity
- ⚠️ Limited resources

### Developer Plan ($5/month)
- ✅ No sleeping
- ✅ More resources
- ✅ Better performance

### Team Plan ($20/month)
- ✅ Team collaboration
- ✅ Priority support
- ✅ Advanced metrics

[View full pricing](https://railway.app/pricing)

---

## 📚 Post-Deployment Checklist

- [ ] Change all default passwords
- [ ] Set `APP_DEBUG=false`
- [ ] Configure proper database (PostgreSQL for production)
- [ ] Set up custom domain (optional)
- [ ] Configure email service (optional)
- [ ] Test all features:
  - [ ] User login (Admin & Manager)
  - [ ] Donor management
  - [ ] Blood inventory
  - [ ] Distribution tracking
  - [ ] Alert system
- [ ] Set up monitoring/alerts
- [ ] Create admin user guide for your team
- [ ] Schedule regular backups (if using paid plan)

---

## 🆘 Support & Resources

### Official Documentation
- [Railway Docs](https://docs.railway.app/)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)
- [Livewire Documentation](https://livewire.laravel.com/docs)

### Community Support
- [Railway Discord](https://discord.gg/railway)
- [Laravel Discord](https://discord.gg/laravel)

### App-Specific Issues
- Check application logs in Railway
- Review Laravel logs: `storage/logs/laravel.log`
- Enable debug mode temporarily to see detailed errors

---

## 🎉 Success!

Your Blood Bank Management System is now live and accessible worldwide!

**Next Steps:**
1. Share the URL with your team
2. Change default passwords
3. Start managing blood inventory
4. Configure email notifications for alerts

**Application Features:**
- 👥 Multi-establishment support
- 🩸 Blood inventory management (8 blood types)
- 💉 Donor tracking with eligibility rules
- 📦 Distribution management
- 🚨 Automated alerts for low stock & expiring units
- 📊 Real-time dashboards
- 🔐 Role-based access control

---

**Need Help?** Check the troubleshooting section above or consult the Railway documentation.

**Happy Managing! 🩸**
