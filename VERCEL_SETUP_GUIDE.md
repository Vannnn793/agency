# AgenPekerjaan - Vercel Deployment Configuration

Dokumentasi lengkap konfigurasi untuk deployment ke Vercel.

## 📦 Yang Telah Dikonfigurasi

### 1. **vercel.json** ✅
Konfigurasi utama untuk Vercel dengan:
- PHP runtime (vercel-php@0.7.1)
- Routes handling untuk static files dan dynamic requests
- Environment variables production-ready
- Build commands yang terotomasi
- Memory allocation (1024MB) dan timeout (30s)

```json
{
  "version": 2,
  "functions": {
    "api/index.php": {
      "runtime": "vercel-php@0.7.1",
      "memory": 1024,
      "maxDuration": 30
    }
  }
}
```

### 2. **.vercelignore** ✅
File/folder yang tidak diperlukan di Vercel:
- `vendor/` dan `node_modules/`
- Test files (`tests/`)
- Development files
- Log files
- Cache files

### 3. **api/index.php** ✅
Entry point untuk Vercel serverless functions:
```php
require __DIR__ . '/../public/index.php';
```

### 4. **vercel-build.sh** ✅
Build script otomatis yang:
- Install PHP dependencies (`composer install`)
- Install Node dependencies (`npm ci`)
- Build frontend assets (Vite)
- Cache configuration
- Create storage symlink
- Run database migrations
- Optimize application

### 5. **package.json** ✅
Ditambahkan production script untuk npm

### 6. **Environment Variables** ✅
Dikonfigurasi untuk production:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `CACHE_STORE=array` (serverless-optimized)
- `SESSION_DRIVER=cookie`
- `LOG_CHANNEL=stderr`

### 7. **Documentation Files** ✅

| File | Deskripsi |
|------|-----------|
| `VERCEL_DEPLOYMENT.md` | Panduan deployment lengkap (step-by-step) |
| `VERCEL_QUICK_REFERENCE.md` | Quick start guide (TL;DR) |
| `.env.production` | Template environment variables |

### 8. **Setup Scripts** ✅

| Script | Fungsi |
|--------|--------|
| `setup-vercel.sh` | Setup awal & generate APP_KEY |
| `verify-deployment.sh` | Pre-deployment checklist |
| `vercel-build.sh` | Build script untuk Vercel |

## 🚀 Cara Deploy

### Opsi A: Setup Otomatis (Recommended)

```bash
# 1. Run setup script
bash setup-vercel.sh

# 2. Commit changes
git add .
git commit -m "Configure for Vercel deployment"
git push origin main

# 3. Go to https://vercel.com
# 4. Import repository
# 5. Set environment variables
# 6. Deploy!
```

### Opsi B: Setup Manual

```bash
# 1. Verify readiness
bash verify-deployment.sh

# 2. Ensure APP_KEY is generated
php artisan key:generate

# 3. Commit & push
git add .
git commit -m "Configure for Vercel deployment"
git push origin main

# 4. Go to Vercel dashboard
```

## 🗄️ Database Setup

### Rekomendasi: PlanetScale (MySQL)

```bash
# 1. Sign up: https://planetscale.com
# 2. Create database
# 3. Get connection string
# 4. In Vercel env set:

DB_CONNECTION=mysql
DB_HOST=your-host.planetscale.com
DB_PORT=3306
DB_DATABASE=agency_prod
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Alternatif: Neon (PostgreSQL)

```bash
# 1. Sign up: https://neon.tech
# 2. Create project
# 3. Get connection URL
# 4. Update DB_* variables
```

## 🔑 Environment Variables

Minimal yang dibutuhkan di Vercel dashboard:

```env
# Application
APP_NAME=AgenPekerjaan
APP_KEY=base64:YOUR_KEY_HERE (generate with php artisan key:generate)
APP_URL=https://your-domain.com

# Database (sesuaikan dengan pilihan Anda)
DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_secure_password
```

Optional untuk production lebih lengkap:

```env
# Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=SG.your_sendgrid_api_key
MAIL_FROM_ADDRESS=noreply@agenpekerjaan.com

# Storage (gunakan S3 untuk production)
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
```

## ✅ Pre-Deployment Checklist

Sebelum deploy, pastikan:

- [ ] Repository ter-push ke GitHub/GitLab/Bitbucket
- [ ] `bash verify-deployment.sh` pass (no errors)
- [ ] APP_KEY ter-generate locally
- [ ] `.env` di-exclude dari git (di `.gitignore`)
- [ ] Database service sudah ready (PlanetScale/Neon/etc)
- [ ] Vercel account created
- [ ] Repository connected ke Vercel
- [ ] Semua environment variables sudah di-set

## 🔍 Troubleshooting

### Build Error: "APP_KEY required"
```bash
# Solusi: Set APP_KEY in Vercel environment
php artisan key:generate  # Generate locally
# Copy value ke Vercel → Settings → Environment Variables
```

### 500 Internal Server Error
```bash
# Check logs:
# Vercel Dashboard → Project → Functions → Logs

# Verify:
# - APP_DEBUG=false di Vercel
# - Database connection string correct
# - All required env variables set
```

### Database Connection Failed
```bash
# Verify connection string format:
# MySQL: mysql://user:pass@host:3306/database?sslaccept=skip-verify
# PostgreSQL: postgresql://user:pass@host:5432/database

# Test connection locally:
# Ganti DB_* di .env.production
# php artisan tinker
# > DB::connection()->getPdo();
```

### Migrations Not Running
```bash
# Vercel build log akan menunjukkan error migration
# Fix: Set migration command di vercel.json
# (sudah dikonfigurasi di vercel-build.sh)
```

### Storage Permission Denied
```bash
# Solusi: Gunakan /tmp atau cloud storage (S3)
# Vercel filesystem read-only, tidak bisa write ke /var/task
```

## 📊 File Structure

```
agency/
├── api/
│   └── index.php                    ✅ Vercel entry point
├── public/
│   ├── index.php
│   ├── build/                       ✅ Vite compiled
│   └── storage/                     ✅ Symlink
├── vercel.json                      ✅ Main config
├── .vercelignore                    ✅ Ignore patterns
├── vercel-build.sh                  ✅ Build script
├── verify-deployment.sh             ✅ Pre-deploy check
├── setup-vercel.sh                  ✅ Setup script
├── .env.production                  ✅ Production template
├── VERCEL_DEPLOYMENT.md             ✅ Full guide
├── VERCEL_QUICK_REFERENCE.md        ✅ Quick start
├── VERCEL_SETUP_GUIDE.md            ✅ Ini file
├── composer.json
├── package.json
├── app/
├── config/
├── database/
└── routes/
```

## 🎯 Deployment Process

```
┌─────────────────────┐
│ Local Development   │
│ - Run setup-vercel  │
│ - Generate APP_KEY  │
│ - Commit & Push     │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ GitHub/GitLab/etc   │
│ (Your Repository)   │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ Vercel Dashboard    │
│ - Connect repo      │
│ - Set env vars      │
│ - Click Deploy      │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ Vercel Build        │
│ - Run vercel-build  │
│ - Install deps      │
│ - Run migrations    │
│ - Compile assets    │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ Live on Vercel! 🎉  │
│ https://your-domain │
└─────────────────────┘
```

## 💡 Tips & Best Practices

### 1. Monitoring
```bash
# Monitor logs after deployment
vercel logs --tail

# Check function logs in Vercel dashboard
# Project → Functions → Click function name
```

### 2. Database Backups
- Enable automated backups di PlanetScale/Neon
- Regular backup strategy

### 3. Performance
- Use Redis cache untuk production (optional)
- Enable CDN untuk static assets
- Setup monitoring & alerts

### 4. Security
- Never commit `.env` files
- Use strong APP_KEY (auto-generated)
- All traffic redirects to HTTPS (Vercel automatic)
- Regular security updates untuk dependencies

### 5. Custom Domain
```bash
# Vercel Dashboard → Project → Settings → Domains
# Add custom domain
# Update DNS records (Vercel provides instructions)
```

## 📞 Support Resources

- **Vercel Docs**: https://vercel.com/docs/frameworks/laravel
- **Laravel Docs**: https://laravel.com/docs
- **PlanetScale Docs**: https://planetscale.com/docs
- **This Project**: See VERCEL_DEPLOYMENT.md & VERCEL_QUICK_REFERENCE.md

## 🎉 What's Next After Deployment

1. ✅ Test aplikasi di production domain
2. ✅ Setup monitoring & alerts
3. ✅ Configure email service untuk production
4. ✅ Setup backup strategy
5. ✅ Monitor Vercel logs & performance metrics
6. ✅ Plan scaling strategy (jika traffic tinggi)

---

**Questions?** Read the guides or check Vercel documentation.

**Ready to deploy?** Run: `bash setup-vercel.sh`
