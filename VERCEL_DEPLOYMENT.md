# Vercel Deployment Guide - AgenPekerjaan

Panduan lengkap untuk deploy aplikasi Laravel AgenPekerjaan ke Vercel.

## 📋 Prerequisites

- Akun GitHub, GitLab, atau Bitbucket
- Akun Vercel (gratis di https://vercel.com)
- Database yang dapat diakses dari Vercel (PlanetScale, Neon, Supabase, dll)
- Email service (SendGrid, Mailgun, dll) untuk production

## 🚀 Deployment Steps

### 1. Push ke Repository

```bash
# Initialize git jika belum
git init

# Add all files
git add .

# Commit
git commit -m "Ready for Vercel deployment"

# Push ke GitHub/GitLab/Bitbucket
git push origin main
```

### 2. Setup Database

**Pilih salah satu:**

#### Option A: PlanetScale (MySQL) ✅ RECOMMENDED
```bash
# 1. Daftar di https://planetscale.com
# 2. Buat database baru
# 3. Dapatkan connection string
# 4. Format: mysql://[username]:[password]@[host]/[database]?sslaccept=skip-verify
```

#### Option B: Neon (PostgreSQL)
```bash
# 1. Daftar di https://neon.tech
# 2. Buat project & database
# 3. Copy connection string
```

#### Option C: Supabase (PostgreSQL)
```bash
# 1. Daftar di https://supabase.com
# 2. Buat project
# 3. Copy PostgreSQL connection string
```

### 3. Connect Vercel ke Repository

1. Buka https://vercel.com
2. Klik "Add New" → "Project"
3. Import repository Anda
4. Select project: "AgenPekerjaan"

### 4. Configure Environment Variables di Vercel

Di Vercel Dashboard → Project Settings → Environment Variables, tambahkan:

```env
# App Configuration
APP_NAME=AgenPekerjaan
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_URL=https://your-domain.com

# Locale
APP_LOCALE=id
APP_FALLBACK_LOCALE=en

# Database (sesuaikan dengan pilihan Anda)
DB_CONNECTION=mysql
DB_HOST=your-host.planetscale.com
DB_PORT=3306
DB_DATABASE=agency_prod
DB_USERNAME=your_username
DB_PASSWORD=your_secure_password

# Cache & Session (serverless-optimized)
CACHE_STORE=array
SESSION_DRIVER=cookie
LOG_CHANNEL=stderr
LOG_LEVEL=warning

# Filesystem
FILESYSTEM_DISK=public

# Queue & Broadcasting
QUEUE_CONNECTION=sync
BROADCAST_CONNECTION=log

# Mail
MAIL_MAILER=log
```

### 5. Deploy

1. Kembali ke Vercel dashboard
2. Klik "Deploy"
3. Tunggu build process selesai (±5-10 menit)

```
✅ Build Success!
✅ Deployment Live!
```

### 6. Run Migrations

Setelah deployment pertama berhasil:

```bash
# Method 1: Via Vercel CLI
vercel env pull .env.production
php artisan migrate --force --env=production

# Method 2: Manual via Dashboard
# - Buka Vercel Function Logs
# - Jalankan migrate command via SSH/custom endpoint
```

Atau gunakan automated migration script dengan menambahkan ke `buildCommand` di `vercel.json`:

```json
"buildCommand": "composer install --no-dev && npm run build && php artisan migrate --force && php artisan storage:link"
```

## 🔧 Configuration Details

### Storage (Public Files)

Untuk production, gunakan AWS S3 atau Vercel Blob:

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket
AWS_URL=https://your-bucket.s3.amazonaws.com
```

### Email

Setup SMTP untuk production:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=SG.your_sendgrid_key
MAIL_FROM_ADDRESS=noreply@agenpekerjaan.com
MAIL_FROM_NAME=AgenPekerjaan
```

### Cache

Untuk production dengan high traffic:

```env
CACHE_STORE=redis
REDIS_HOST=your-redis-host
REDIS_PASSWORD=your_password
REDIS_PORT=6379
```

## 📊 Project Structure untuk Vercel

```
agency/
├── api/
│   └── index.php          # Vercel Serverless Entry Point
├── app/                   # Laravel App
├── public/
│   ├── index.php         # Fallback untuk static routes
│   ├── build/            # Vite compiled assets
│   └── storage/          # Symlink untuk storage
├── storage/               # Laravel storage
├── config/               # Configuration
├── database/
│   └── migrations/       # Auto-run on build
├── vercel.json           # ✅ Vercel Configuration
├── .vercelignore         # ✅ Ignore files list
├── .env.production       # ✅ Production env reference
├── composer.json         # Dependencies
├── package.json          # Node dependencies
└── tailwind.config.js    # Tailwind config
```

## ✅ Verification Checklist

- [ ] Repository ter-push ke GitHub/GitLab/Bitbucket
- [ ] Vercel project ter-create
- [ ] Semua environment variables ter-set
- [ ] Database accessible dari Vercel
- [ ] Build successful (tidak ada error)
- [ ] Domain custom ter-setup (optional)
- [ ] SSL certificate auto-renew (Vercel handles)
- [ ] Test home page: https://your-deployment.vercel.app
- [ ] Test login page: https://your-deployment.vercel.app/login
- [ ] Test public jobs: https://your-deployment.vercel.app/jobs

## 🐛 Troubleshooting

### Build Error: APP_KEY not set
```bash
# Generate APP_KEY locally
php artisan key:generate
# Lalu copy ke Vercel env
```

### Database Connection Error
```bash
# Verify connection string format
# MySQL: mysql://user:pass@host:3306/database?sslaccept=skip-verify
# PostgreSQL: postgresql://user:pass@host:5432/database
```

### 500 Internal Server Error
- Check Vercel function logs: https://vercel.com/dashboard/[project]/functions
- Verify APP_DEBUG=false (production)
- Check error logs: `vercel logs`

### Storage Permission Denied
```bash
# Vercel uses read-only /var/task directory
# Use /tmp or cloud storage (S3) instead
```

### Migrations Not Running
```bash
# Add to vercel.json buildCommand:
"buildCommand": "composer install --no-dev && php artisan migrate --force && npm run build"
```

## 🔒 Security Best Practices

1. **Never commit .env files**
   ```bash
   # Already in .gitignore
   ```

2. **Use strong APP_KEY**
   ```bash
   php artisan key:generate
   # Generate locally, then set in Vercel
   ```

3. **Enable HTTPS** (Automatic on Vercel)
   - All traffic redirects to HTTPS

4. **Set proper CORS headers** (jika ada API)
   ```php
   // config/cors.php
   'allowed_origins' => ['*'], // Restrict in production
   ```

5. **Monitor Vercel Logs** regularly
   - https://vercel.com/dashboard/[project]/logs

## 📞 Support Resources

- **Vercel Docs**: https://vercel.com/docs/frameworks/laravel
- **Laravel Docs**: https://laravel.com/docs
- **PlanetScale Docs**: https://planetscale.com/docs
- **Neon Docs**: https://neon.tech/docs
- **Supabase Docs**: https://supabase.com/docs

## 💡 Tips & Optimization

1. **Cache Config in Production**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Use Asset CDN** (Vercel Blobs atau S3)
   - Faster asset delivery globally

3. **Setup Custom Domain**
   - Vercel → Project Settings → Domains
   - Add your custom domain
   - Update DNS records

4. **Monitor Performance**
   - Vercel Analytics
   - Use Laravel Telescope (local development only)

5. **Auto-Deploy from Branch**
   - Setup production branch
   - Auto-deploy on merge
   - Preview deployments for PR

## 🎉 Next Steps

1. Akses aplikasi Anda di: `https://your-domain.com`
2. Setup admin account
3. Test semua fitur
4. Setup backup strategy
5. Monitor logs dan performance

---

**Last Updated**: 2026-06-23
**Laravel Version**: 13.0
**PHP Version**: 8.5
