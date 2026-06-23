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

# Create storage symlink
echo "🔗 Creating storage symlink..."
php artisan storage:link --force

# Run migrations only if database is configured
echo "🗄️  Checking database configuration..."
if [ -n "$DB_HOST" ] && [ -n "$DB_DATABASE" ]; then
  echo "🗄️  Running database migrations..."
  php artisan migrate --force --no-interaction || {
    echo "⚠️  Migration warning - database might not be ready yet"
  }
else
  echo "⚠️  Database not configured, skipping migrations"
fi

# Cache views
echo "📄 Caching views..."
php artisan view:cache || {
  echo "⚠️  View cache warning - continuing anyway"
}

# Clear and optimize
echo "🧹 Clearing cache..."
php artisan optimize:clear
php artisan optimize

echo "✅ Build complete! Ready to deploy."
