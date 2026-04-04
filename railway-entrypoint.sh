#!/bin/bash
# Railway Entrypoint Script - Runs migrations before starting server

set -e

echo "🚀 Starting Blood Bank Management System..."

# Print environment info for debugging
echo "📊 Environment Check:"
echo "   DB_CONNECTION: ${DB_CONNECTION:-not set}"
echo "   DB_HOST: ${DB_HOST:-not set}"
echo "   DB_DATABASE: ${DB_DATABASE:-not set}"
echo "   MYSQL_URL: ${MYSQL_URL:-not set}"
echo "   DATABASE_URL: ${DATABASE_URL:-not set}"

# Clear any cached config to ensure environment variables are read
echo "🧹 Clearing cached configuration..."
php artisan config:clear || true
php artisan cache:clear || true

# Wait for database to be ready
echo "⏳ Waiting for database connection..."
sleep 10

# Test database connection
echo "🔌 Testing database connection..."
php artisan db:show || echo "⚠️  Database info not available"

# Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

# Seed default data if tables are empty
echo "🌱 Seeding default data..."
php artisan db:seed --force --class=EstablishmentSeeder || true

# NOW cache config (after migrations are done)
echo "⚙️  Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Setup complete! Starting web server..."

# Start the web server
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
