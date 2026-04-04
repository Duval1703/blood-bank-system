# ⚡ Quick Start - Deploy to Railway in 5 Minutes

## 🎯 Super Fast Deployment

### 1️⃣ Create Railway Account
Go to [railway.app](https://railway.app) and sign up with GitHub

### 2️⃣ Deploy This App
Click this button:

[![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/new)

Then select **"Deploy from GitHub repo"** and choose this repository.

### 3️⃣ Set Environment Variables

In Railway dashboard, add these variables:

```env
APP_NAME=Blood Bank Management System
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app
DB_CONNECTION=sqlite
```

### 4️⃣ Generate APP_KEY

Run locally:
```bash
cd BloodBank_Management_System-app
php artisan key:generate --show
```

Copy the output and add to Railway:
```env
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
```

### 5️⃣ Done! 🎉

Your app will be live in 3-5 minutes at: `https://your-app.railway.app`

---

## 🔐 Login Credentials

**System Admin:**
- Email: `admin@bloodbank.com`
- Password: `password`

**Blood Bank Manager:**
- Email: `manager@bloodbank.com`
- Password: `password`

**⚠️ Change these immediately after first login!**

---

## 🗄️ Want Persistent Data?

SQLite data resets on redeployment. For production:

1. In Railway, click **"+ New"** → **"Database"** → **"PostgreSQL"**
2. Update variables:
```env
DB_CONNECTION=pgsql
DB_HOST=${{PGHOST}}
DB_PORT=${{PGPORT}}
DB_DATABASE=${{PGDATABASE}}
DB_USERNAME=${{PGUSER}}
DB_PASSWORD=${{PGPASSWORD}}
```
3. Redeploy

---

## 📚 Full Documentation

See [RAILWAY_DEPLOYMENT.md](./RAILWAY_DEPLOYMENT.md) for detailed instructions.

---

## ❓ Issues?

1. Check Railway logs in dashboard
2. Ensure `APP_KEY` is set correctly
3. For SQLite: use `DB_CONNECTION=sqlite`
4. For PostgreSQL: ensure database is added and variables are correct

**Happy deploying! 🚀**
