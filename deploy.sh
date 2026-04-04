#!/bin/bash

# Blood Bank Management System - Quick Deployment Script
# This script helps you deploy to various platforms quickly

set -e

echo "🏥 Blood Bank Management System - Deployment Helper"
echo "===================================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored messages
print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

print_info() {
    echo -e "${BLUE}ℹ $1${NC}"
}

# Check if git is initialized
if [ ! -d ".git" ]; then
    print_warning "Git repository not initialized. Initializing..."
    git init
    print_success "Git initialized"
fi

# Main menu
echo "Select deployment platform:"
echo ""
echo "1) Railway (Recommended)"
echo "2) Render"
echo "3) Local Testing Only"
echo "4) Prepare for Manual Upload (InfinityFree, etc.)"
echo "5) Exit"
echo ""
read -p "Enter your choice (1-5): " choice

case $choice in
    1)
        print_info "Preparing for Railway deployment..."
        
        # Check if Railway CLI is installed
        if ! command -v railway &> /dev/null; then
            print_warning "Railway CLI not found. Install it with:"
            echo "npm i -g @railway/cli"
            echo ""
            read -p "Do you want to install it now? (y/n): " install_railway
            if [ "$install_railway" = "y" ]; then
                npm i -g @railway/cli
                print_success "Railway CLI installed"
            fi
        fi
        
        print_info "Committing changes..."
        git add .
        git commit -m "Prepare for Railway deployment" || true
        
        print_success "Ready for Railway deployment!"
        echo ""
        echo "Next steps:"
        echo "1. Go to https://railway.app/new"
        echo "2. Click 'Deploy from GitHub repo'"
        echo "3. Select this repository"
        echo "4. Add PostgreSQL database"
        echo "5. Your app will deploy automatically!"
        echo ""
        print_info "Or use Railway CLI:"
        echo "  railway login"
        echo "  railway init"
        echo "  railway up"
        ;;
        
    2)
        print_info "Preparing for Render deployment..."
        
        print_info "Committing changes..."
        git add .
        git commit -m "Prepare for Render deployment" || true
        
        print_success "Ready for Render deployment!"
        echo ""
        echo "Next steps:"
        echo "1. Push to GitHub: git push origin main"
        echo "2. Go to https://render.com/dashboard"
        echo "3. Click 'New +' → 'Blueprint'"
        echo "4. Connect your GitHub repository"
        echo "5. Click 'Apply'"
        echo ""
        print_info "render.yaml is already configured!"
        ;;
        
    3)
        print_info "Setting up local testing environment..."
        
        # Check if .env exists
        if [ ! -f ".env" ]; then
            print_info "Creating .env file..."
            cp .env.example .env
            print_success ".env created"
        fi
        
        # Check if composer is installed
        if ! command -v composer &> /dev/null; then
            print_error "Composer not found. Please install from https://getcomposer.org"
            exit 1
        fi
        
        # Install dependencies
        print_info "Installing PHP dependencies..."
        composer install
        print_success "PHP dependencies installed"
        
        # Generate app key
        print_info "Generating application key..."
        php artisan key:generate
        print_success "Application key generated"
        
        # Create SQLite database
        if [ ! -f "database/database.sqlite" ]; then
            print_info "Creating SQLite database..."
            touch database/database.sqlite
            print_success "Database file created"
        fi
        
        # Run migrations
        print_info "Running database migrations..."
        php artisan migrate:fresh --seed
        print_success "Database migrated and seeded"
        
        # Install Node dependencies
        if command -v npm &> /dev/null; then
            print_info "Installing Node dependencies..."
            npm install
            print_success "Node dependencies installed"
            
            print_info "Building assets..."
            npm run build
            print_success "Assets built"
        else
            print_warning "npm not found. Skipping asset building."
        fi
        
        print_success "Local environment ready!"
        echo ""
        echo "Start the development server with:"
        echo "  php artisan serve"
        echo ""
        echo "Or run full dev environment:"
        echo "  composer run dev"
        echo ""
        echo "Default credentials:"
        echo "  Admin: admin@bloodbank.com / password"
        echo "  Manager: manager@bloodbank.com / password"
        ;;
        
    4)
        print_info "Preparing for manual upload (InfinityFree, cPanel, etc.)..."
        
        # Install production dependencies
        print_info "Installing production dependencies..."
        composer install --no-dev --optimize-autoloader
        print_success "PHP dependencies installed"
        
        # Build assets
        if command -v npm &> /dev/null; then
            print_info "Installing Node dependencies..."
            npm ci
            
            print_info "Building assets..."
            npm run build
            print_success "Assets built"
        fi
        
        # Optimize Laravel
        print_info "Optimizing Laravel..."
        php artisan config:cache
        php artisan route:cache
        php artisan view:cache
        print_success "Laravel optimized"
        
        # Create upload package
        print_info "Creating upload package..."
        
        # Create a temp directory for clean upload
        mkdir -p ../blood-bank-upload
        
        # Copy necessary files (excluding dev dependencies)
        rsync -av --progress . ../blood-bank-upload \
            --exclude node_modules \
            --exclude .git \
            --exclude .github \
            --exclude tests \
            --exclude .env \
            --exclude database/database.sqlite \
            --exclude storage/logs/* \
            --exclude storage/framework/cache/* \
            --exclude storage/framework/sessions/* \
            --exclude storage/framework/views/*
        
        print_success "Upload package created in ../blood-bank-upload/"
        echo ""
        echo "Next steps:"
        echo "1. Upload the contents of '../blood-bank-upload/' to your hosting"
        echo "2. Create MySQL database in your hosting control panel"
        echo "3. Edit .env file with your database credentials"
        echo "4. Run: php artisan migrate --seed"
        echo "5. Set permissions:"
        echo "   chmod -R 755 storage bootstrap/cache"
        echo ""
        print_warning "Remember to create .env file from .env.example!"
        ;;
        
    5)
        print_info "Exiting..."
        exit 0
        ;;
        
    *)
        print_error "Invalid choice. Please run the script again."
        exit 1
        ;;
esac

echo ""
print_success "Done! 🎉"
