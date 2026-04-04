# 🔧 Railway Database Connection Fix

## ❌ **Critical Issue Found:**

Your deployment logs show:
```
SQLSTATE[HY000] [2002] Connection refused 
(Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: laravel)
```

**Problem:** Laravel is using **default values** instead of your Railway MySQL variables!

---

## 🎯 **Root Causes:**

### **1. Config Caching Issue (FIXED)**
The old `railway-entrypoint.sh` was running `php artisan config:cache` BEFORE migrations.
When config is cached, Laravel **ignores environment variables**!

**Solution:** Updated script to:
1. Clear cache first
2. Run migrations (reads env vars)
3. THEN cache config

### **2. Database Variables Not Set Correctly**

You need to check your Railway dashboard to ensure MySQL variables are properly configured.

---

## ✅ **How to Fix in Railway Dashboard:**

### **Step 1: Verify MySQL Service Exists**

1. Go to Railway dashboard
2. Check your project structure:
   ```
   Your Project
   ├── Web Service (Laravel app)
   └── MySQL Database  ← Should be here!
   ```

**If MySQL is MISSING:**
1. Click **"+ New"**
2. Select **"Database"**
3. Choose **"Add MySQL"**
4. Wait for it to provision (~1 minute)

### **Step 2: Check Service Variables**

Click on your **web service** → **Variables** tab

**You should see these MySQL variables** (auto-created by Railway):
- `MYSQLHOST`
- `MYSQLPORT`
- `MYSQLDATABASE`
- `MYSQLUSER`
- `MYSQLPASSWORD`
- `MYSQL_URL`

**If you DON'T see these,** the MySQL service is not linked to your web service!

---

## 🔧 **Recommended Environment Variable Setup:**

### **Option 1: Use DATABASE_URL (SIMPLEST - Recommended)**

In Railway Variables tab, add/update:

```env
# Remove these if they exist:
DB_HOST=${{MYSQLHOST}}  ← DELETE
DB_PORT=${{MYSQLPORT}}  ← DELETE
DB_DATABASE=${{MYSQLDATABASE}}  ← DELETE
DB_USERNAME=${{MYSQLUSER}}  ← DELETE
DB_PASSWORD=${{MYSQLPASSWORD}}  ← DELETE

# Add just these:
DB_CONNECTION=mysql
DATABASE_URL=$MYSQL_URL
```

**That's it!** Laravel will automatically parse the URL.

### **Option 2: Use Individual Variables (Alternative)**

```env
DB_CONNECTION=mysql
DB_HOST=$MYSQLHOST
DB_PORT=$MYSQLPORT
DB_DATABASE=$MYSQLDATABASE
DB_USERNAME=$MYSQLUSER
DB_PASSWORD=$MYSQLPASSWORD
```

**Important:** Use `$VARIABLE` NOT `${{VARIABLE}}`!

---

## 📝 **Complete Working Variables**

Here's your COMPLETE set that should work:

```env
# Application
APP_NAME=Blood Bank Management System
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:z0jDiBIZtoSovsPsrJa8QhagckUpzVKihwWfFmHtbMQ=
APP_URL=https://your-app.railway.app
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

# Database - Option 1 (Simplest)
DB_CONNECTION=mysql
DATABASE_URL=$MYSQL_URL

# Session & Cache
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_STORE=file

# Queue
QUEUE_CONNECTION=sync

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error
LOG_STACK=single

# Other
BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
BCRYPT_ROUNDS=12
```

---

## 🚀 **Deployment Steps:**

### **1. Update Files (Already Done)**

The `railway-entrypoint.sh` has been fixed. Push to GitHub:

```bash
cd BloodBank_Management_System-app
git add railway-entrypoint.sh RAILWAY_DATABASE_FIX.md
git commit -m "Fix Railway database connection - clear cache before migrations"
git push origin main
```

### **2. Update Railway Variables**

In Railway dashboard:

1. Go to your web service → **Variables**
2. **Delete these (if they exist):**
   - `DB_HOST=${{MYSQLHOST}}`
   - `DB_PORT=${{MYSQLPORT}}`
   - `DB_DATABASE=${{MYSQLDATABASE}}`
   - `DB_USERNAME=${{MYSQLUSER}}`
   - `DB_PASSWORD=${{MYSQLPASSWORD}}`

3. **Add/Update these:**
   - `DB_CONNECTION` = `mysql`
   - `DATABASE_URL` = `$MYSQL_URL`

4. Click **"Redeploy"** or Railway will auto-deploy from GitHub push

### **3. Monitor Deployment**

Watch the logs. You should now see:

```
🚀 Starting Blood Bank Management System...
📊 Environment Check:
   DB_CONNECTION: mysql
   DB_HOST: [actual host from Railway]
   DB_DATABASE: [actual database name]
   DATABASE_URL: mysql://user:pass@host:port/dbname
🧹 Clearing cached configuration...
⏳ Waiting for database connection...
🔌 Testing database connection...
🗄️  Running database migrations...
   Migration table created successfully.
   Migrating: create_establishments_table
   Migrated:  create_establishments_table (XX.XXms)
   ...
🌱 Seeding default data...
   Database seeding completed successfully.
⚙️  Optimizing application...
✅ Setup complete! Starting web server...

Starting Healthcheck
Path: /
Attempt #1 succeeded! ✓
✅ Deployment successful!
```

---

## 🔍 **How to Verify MySQL is Connected:**

### **Check Railway Project Structure:**

1. Open your Railway project
2. You should see **TWO services:**
   - Your Laravel app
   - MySQL database

### **Check MySQL Variables:**

1. Click MySQL service
2. Go to **"Variables"** tab
3. You should see all MYSQL* variables

### **Check Web Service Variables:**

1. Click your web service
2. Go to **"Variables"** tab  
3. Look for **"Service Variables"** or **"Shared Variables"** section
4. MySQL variables should appear there automatically

**If MySQL variables don't appear in your web service:**
- The services might not be linked
- Try removing and re-adding the MySQL service
- Or check Railway docs on linking services

---

## 🐛 **Still Having Issues?**

### **Check the Deployment Logs:**

After redeploying, check for:

**✅ Good Signs:**
```
DB_CONNECTION: mysql
DB_HOST: [actual host, NOT 127.0.0.1]
Migration table created successfully
Migrating: create_establishments_table
Migrated successfully
```

**❌ Bad Signs:**
```
DB_HOST: 127.0.0.1  ← Still using defaults!
Connection refused
SQLSTATE[HY000] [2002]
```

### **If Still Using Defaults:**

The MySQL service is NOT connected. You need to:

1. **Verify MySQL service exists** in your Railway project
2. **Check if variables are being passed** to your web service
3. **Manually set DATABASE_URL** with the actual connection string from MySQL service

---

## 💡 **Manual Database URL (Last Resort)**

If Railway isn't auto-linking the services:

1. Go to MySQL service → **Connect** tab
2. Copy the **"Public URL"** (looks like: `mysql://user:pass@host:port/db`)
3. Go to web service → **Variables**
4. Add:
   ```env
   DATABASE_URL=mysql://actual_user:actual_pass@actual_host:port/actual_db
   ```

**But this is NOT recommended** - variables should auto-link!

---

## ✅ **Checklist:**

- [ ] MySQL database service exists in Railway project
- [ ] MySQL service is running (green status)
- [ ] Fixed railway-entrypoint.sh pushed to GitHub
- [ ] Removed `${{VARIABLE}}` syntax from Railway variables
- [ ] Added `DATABASE_URL=$MYSQL_URL` to Railway variables
- [ ] Set `DB_CONNECTION=mysql`
- [ ] Redeployed (manually or via GitHub push)
- [ ] Checked logs for actual database host (not 127.0.0.1)
- [ ] Migrations completed successfully
- [ ] Healthcheck passed

---

**After fixing:** Your app should deploy successfully and be accessible at your Railway URL! 🎉
