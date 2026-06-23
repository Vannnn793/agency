#!/bin/bash

# Pre-deployment Verification Script
# Run this before pushing to Vercel to catch common issues

echo "🔍 Pre-Deployment Verification Checklist"
echo "========================================"
echo ""

# Check 1: Verify git is initialized
echo -n "✓ Checking git repository... "
if [ -d ".git" ]; then
  echo "✅"
else
  echo "❌ Not a git repository. Run: git init"
  exit 1
fi

# Check 2: Verify .env is not committed
echo -n "✓ Checking .env in .gitignore... "
if grep -q "^\.env$" .gitignore; then
  echo "✅"
else
  echo "⚠️  .env should be in .gitignore"
fi

# Check 3: Check composer.json exists
echo -n "✓ Checking composer.json... "
if [ -f "composer.json" ]; then
  echo "✅"
else
  echo "❌ composer.json not found"
  exit 1
fi

# Check 4: Check package.json exists
echo -n "✓ Checking package.json... "
if [ -f "package.json" ]; then
  echo "✅"
else
  echo "❌ package.json not found"
  exit 1
fi

# Check 5: Verify vercel.json exists
echo -n "✓ Checking vercel.json... "
if [ -f "vercel.json" ]; then
  echo "✅"
else
  echo "❌ vercel.json not found"
  exit 1
fi

# Check 6: Verify .vercelignore exists
echo -n "✓ Checking .vercelignore... "
if [ -f ".vercelignore" ]; then
  echo "✅"
else
  echo "❌ .vercelignore not found"
  exit 1
fi

# Check 7: Verify migrations exist
echo -n "✓ Checking database migrations... "
if [ -f "database/migrations/0001_01_01_000000_create_users_table.php" ]; then
  echo "✅"
else
  echo "⚠️  No migrations found"
fi

# Check 8: Check if APP_KEY exists in .env
echo -n "✓ Checking APP_KEY... "
if grep -q "^APP_KEY=" .env; then
  KEY=$(grep "^APP_KEY=" .env | cut -d'=' -f2)
  if [ -z "$KEY" ] || [ "$KEY" = "base64:" ]; then
    echo "❌ APP_KEY is empty. Run: php artisan key:generate"
    exit 1
  else
    echo "✅"
  fi
else
  echo "❌ APP_KEY not found in .env. Run: php artisan key:generate"
  exit 1
fi

# Check 9: Verify public/index.php exists
echo -n "✓ Checking public/index.php... "
if [ -f "public/index.php" ]; then
  echo "✅"
else
  echo "❌ public/index.php not found"
  exit 1
fi

# Check 10: Verify api/index.php exists
echo -n "✓ Checking api/index.php... "
if [ -f "api/index.php" ]; then
  echo "✅"
else
  echo "❌ api/index.php not found"
  exit 1
fi

echo ""
echo "========================================"
echo "✅ All checks passed! Ready for deployment."
echo ""
echo "📝 Next steps:"
echo "1. Commit all changes: git add . && git commit -m 'Ready for Vercel'"
echo "2. Push to remote: git push origin main"
echo "3. Go to https://vercel.com and connect your repository"
echo "4. Set environment variables in Vercel dashboard"
echo "5. Deploy!"
echo ""
echo "📖 For more info, read VERCEL_DEPLOYMENT.md"
