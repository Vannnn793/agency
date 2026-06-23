#!/bin/bash

# Vercel Deployment Setup Script
# Automatically prepare your Laravel project for Vercel deployment

echo "🚀 AgenPekerjaan - Vercel Deployment Setup"
echo "==========================================="
echo ""

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if git is initialized
if [ ! -d ".git" ]; then
  echo -e "${YELLOW}⚠️  Git repository not initialized${NC}"
  echo "Run: git init"
  exit 1
fi

# Ensure scripts are executable
echo "🔧 Making scripts executable..."
chmod +x vercel-build.sh
chmod +x verify-deployment.sh

# Generate APP_KEY if not exists
if ! grep -q "^APP_KEY=base64:" .env; then
  echo "🔑 Generating APP_KEY..."
  php artisan key:generate
else
  echo "✅ APP_KEY already configured"
fi

# Show next steps
echo ""
echo -e "${GREEN}✅ Setup complete!${NC}"
echo ""
echo "📝 Next steps:"
echo ""
echo "1️⃣  Verify deployment readiness:"
echo "   bash verify-deployment.sh"
echo ""
echo "2️⃣  Commit changes:"
echo "   git add ."
echo "   git commit -m 'Configure for Vercel deployment'"
echo "   git push origin main"
echo ""
echo "3️⃣  Go to https://vercel.com"
echo "   - Import your repository"
echo "   - Set environment variables"
echo "   - Click Deploy"
echo ""
echo "4️⃣  For detailed guide, read:"
echo "   - VERCEL_QUICK_REFERENCE.md (quick start)"
echo "   - VERCEL_DEPLOYMENT.md (detailed guide)"
echo ""
echo "📖 Key files created/modified:"
echo "   ✓ vercel.json (Vercel configuration)"
echo "   ✓ .vercelignore (Ignore patterns)"
echo "   ✓ vercel-build.sh (Build script)"
echo "   ✓ .env.production (Production env template)"
echo "   ✓ VERCEL_DEPLOYMENT.md (Full documentation)"
echo "   ✓ VERCEL_QUICK_REFERENCE.md (Quick reference)"
echo ""
echo "🎯 Environment variables to set in Vercel:"
echo "   - APP_KEY (already generated)"
echo "   - DB_HOST, DB_USERNAME, DB_PASSWORD"
echo "   - APP_URL (your deployed domain)"
echo ""
echo "💡 Tips:"
echo "   • Use PlanetScale for MySQL database"
echo "   • Use Neon or Supabase for PostgreSQL"
echo "   • Set LOG_LEVEL=warning in production"
echo "   • Monitor Vercel function logs after deploy"
echo ""
