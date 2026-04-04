#!/bin/bash
# Railway Entrypoint Script - Runs migrations before starting server

set -e

echo "🚀 Starting Blood Bank Management System..."

# Wait for database to be ready
echo "⏳ Waiting for database connection..."
sleep 5

# Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

# Seed default data if tables are empty
echo "🌱 Checking if seeding is needed..."
php artisan db:seed --force --class=EstablishmentSeeder || true

# Clear and cache config
echo "⚙️  Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Setup complete! Starting web server..."

# Start the web server
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
