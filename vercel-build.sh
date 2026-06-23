#!/bin/bash

# Vercel Build Script for Laravel
# This script runs during Vercel deployment

set -e

echo "🔨 Building AgenPekerjaan for Vercel..."

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

# Install Node dependencies
echo "📦 Installing Node dependencies..."
npm ci

# Build frontend assets
echo "🎨 Building frontend assets with Vite..."
npm run build

# Generate APP_KEY if not exists
echo "🔑 Ensuring APP_KEY..."
if [ -z "$APP_KEY" ]; then
  php artisan key:generate --force
fi

# Cache configuration
echo "⚙️  Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage symlink
echo "🔗 Creating storage symlink..."
php artisan storage:link --force

# Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force --no-interaction

# Clear and optimize
echo "🧹 Clearing cache..."
php artisan optimize:clear
php artisan optimize

echo "✅ Build complete! Ready to deploy."
