# 🔧 Database Connection Fix

## ❌ Problem: Database Variables Not Working

Your current configuration:
```env
DB_CONNECTION=mysql
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}
```

**Issue:** The `${{VARIABLE}}` syntax doesn't work in Railway environment variables!

---

## ✅ Two Solutions Available

### **OPTION 1: Use Railway's Reference Variables (Recommended)**

In Railway, when you add a MySQL database, it creates these variables automatically:
- `MYSQLHOST`
- `MYSQLPORT`
- `MYSQLDATABASE`
- `MYSQLUSER`
- `MYSQLPASSWORD`

**To reference them properly, use this syntax:**

```env
DB_CONNECTION=mysql
DB_HOST=$MYSQLHOST
DB_PORT=$MYSQLPORT
DB_DATABASE=$MYSQLDATABASE
DB_USERNAME=$MYSQLUSER
DB_PASSWORD=$MYSQLPASSWORD
```

**Notice:** Use `$VARIABLE` NOT `${{VARIABLE}}`

---

### **OPTION 2: Use the MYSQL_URL (Easiest)**

Railway provides a complete connection URL. Just use:

```env
DB_CONNECTION=mysql
DATABASE_URL=$MYSQL_URL
```

Then Laravel will automatically parse it!

---

## 🚀 How to Fix in Railway Dashboard

### Step 1: Go to Railway Dashboard
1. Open your project
2. Click on your web service
3. Go to "Variables" tab

### Step 2: Check if MySQL Database is Connected

**Do you see these variables?**
- `MYSQLHOST`
- `MYSQLPORT`
- `MYSQLDATABASE`
- `MYSQLUSER`
- `MYSQLPASSWORD`

**If YES:** Continue to Step 3
**If NO:** You need to add MySQL database first (see bottom of this file)

### Step 3: Update Your Variables

**Delete these (they're wrong):**
```
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}
```

**Add these instead:**
```
DB_CONNECTION=mysql
DB_HOST=$MYSQLHOST
DB_PORT=$MYSQLPORT
DB_DATABASE=$MYSQLDATABASE
DB_USERNAME=$MYSQLUSER
DB_PASSWORD=$MYSQLPASSWORD
```

### Step 4: Redeploy

After updating variables, Railway will automatically redeploy.

---

## 🎯 Complete Working Environment Variables

Here's your COMPLETE set of variables that should work:

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
APP_MAINTENANCE_DRIVER=file

# Database - MySQL (Reference Railway's MySQL service)
DB_CONNECTION=mysql
DB_HOST=$MYSQLHOST
DB_PORT=$MYSQLPORT
DB_DATABASE=$MYSQLDATABASE
DB_USERNAME=$MYSQLUSER
DB_PASSWORD=$MYSQLPASSWORD

# Session & Cache
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

# Other
BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
CACHE_STORE=file
LOG_CHANNEL=stack
LOG_LEVEL=error
LOG_STACK=single
BCRYPT_ROUNDS=12
```

---

## 🔍 How to Verify MySQL Service is Connected

In Railway dashboard:

1. **Check your project structure:**
   ```
   Your Project
   ├── Web Service (your Laravel app)
   └── MySQL Database
   ```

2. **In MySQL service, you should see:**
   - Status: Running
   - Variables created automatically

3. **In Web Service, under Variables tab:**
   - You should see MYSQLHOST, MYSQLPORT, etc. appear automatically
   - These are references to the MySQL service

---

## ⚠️ If MySQL Database is NOT Connected

### Add MySQL Database to Your Project:

1. In Railway dashboard, click **"+ New"**
2. Select **"Database"**
3. Choose **"Add MySQL"**
4. Wait for it to provision (~1 minute)
5. Railway automatically creates connection variables
6. Go back to your web service
7. The MySQL variables should now be available

### Then Link Services (if not auto-linked):

1. Go to your web service
2. Click "Variables" tab
3. You should see a section "Service Variables"
4. MySQL variables should appear there automatically

---

## 🧪 Test Database Connection

After fixing variables and redeploying, check the logs for:

```
🚀 Starting Blood Bank Management System...
⏳ Waiting for database connection...
🗄️  Running database migrations...
   Migration table created successfully.
   Migrating: 2026_03_04_172810_create_establishments_table
   Migrated:  2026_03_04_172810_create_establishments_table
   ...
🌱 Checking if seeding is needed...
✅ Setup complete! Starting web server...
```

If you see migration errors, the database connection is still wrong.

---

## 📝 Quick Checklist

- [ ] MySQL database service added to Railway project
- [ ] MySQL service is running (green status)
- [ ] Removed `${{VARIABLE}}` syntax from environment variables
- [ ] Changed to `$VARIABLE` syntax (single dollar sign, no braces)
- [ ] Kept `DB_CONNECTION=mysql`
- [ ] Redeployed after changing variables
- [ ] Checked logs for successful migrations

---

## 🆘 Still Not Working?

### Try the Simplified Approach:

**Remove all DB_ variables and add just ONE:**

```env
DATABASE_URL=$MYSQL_URL
```

Laravel will automatically parse the URL and configure the connection!

### Check Railway Logs for Specific Errors:

Look for lines like:
- `SQLSTATE[HY000] [2002] Connection refused` - MySQL not running
- `SQLSTATE[HY000] [1045] Access denied` - Wrong credentials
- `SQLSTATE[HY000] [2002] No such file` - Wrong host

Share the specific error and we can fix it!

---

**Next Step:** Update your variables in Railway dashboard and redeploy!
