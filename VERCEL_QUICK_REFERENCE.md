# Vercel Deployment Quick Reference

## 🚀 TL;DR - Deploy dalam 5 Langkah

### 1. Persiapan Lokal
```bash
# Cek semua siap
bash verify-deployment.sh

# Commit dan push
git add .
git commit -m "Ready for Vercel deployment"
git push origin main
```

### 2. Buat Vercel Project
- Buka https://vercel.com
- Klik "New Project"
- Import repository Anda
- Select "AgenPekerjaan" project

### 3. Setup Environment Variables
Di Vercel Dashboard → Settings → Environment Variables, tambahkan:

```
APP_NAME=AgenPekerjaan
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_KEY_HERE
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=your-host.planetscale.com
DB_PORT=3306
DB_DATABASE=agency_prod
DB_USERNAME=user
DB_PASSWORD=pass

CACHE_STORE=array
SESSION_DRIVER=cookie
LOG_CHANNEL=stderr
```

### 4. Deploy
- Klik "Deploy"
- Tunggu ~10 menit

### 5. Run Migrations
Setelah deployment sukses:

```bash
# Option A: Via CLI
vercel env pull .env.production
php artisan migrate --force --env=production

# Option B: Manual
# Akses Vercel logs → jalankan migrate command
```

## 📁 File Struktur Vercel

```
✅ vercel.json              - Konfigurasi Vercel
✅ .vercelignore           - File yang di-ignore
✅ api/index.php           - Entry point serverless
✅ vercel-build.sh         - Build script
✅ .env.production         - Referensi env production
✅ VERCEL_DEPLOYMENT.md    - Dokumentasi lengkap
✅ verify-deployment.sh    - Pre-deploy checker
```

## 🗄️ Database Setup

### PlanetScale (Recommended)
```
1. Daftar: https://planetscale.com
2. Buat database
3. Koneksi string: mysql://user:pass@host/db?sslaccept=skip-verify
```

### Neon (PostgreSQL)
```
1. Daftar: https://neon.tech
2. Buat project
3. Copy connection string
```

### Supabase
```
1. Daftar: https://supabase.com
2. Create project
3. Get PostgreSQL URL
```

## ✅ Pre-Deployment Checklist

- [ ] `bash verify-deployment.sh` berhasil
- [ ] Git repository initialized & .env in .gitignore
- [ ] APP_KEY ter-generate: `php artisan key:generate`
- [ ] All files committed: `git push origin main`
- [ ] Vercel project created
- [ ] Database accessible & connection string ready
- [ ] All environment variables set in Vercel
- [ ] Build script passes (no errors)
- [ ] Migrations run successfully

## 🔗 Useful Links

| Resource | URL |
|----------|-----|
| Vercel Dashboard | https://vercel.com/dashboard |
| This Project Logs | https://vercel.com/dashboard/[project]/logs |
| Function Logs | https://vercel.com/dashboard/[project]/functions |
| PlanetScale Console | https://app.planetscale.com |
| Laravel Docs | https://laravel.com/docs |

## 🐛 Common Issues & Fixes

| Issue | Solution |
|-------|----------|
| Build fails: "APP_KEY required" | Set APP_KEY in Vercel environment |
| 500 errors | Check Vercel function logs |
| Database error | Verify connection string format |
| Cannot write files | Use /tmp or cloud storage (S3) |
| Migrations not running | Add migration command to buildCommand |

## 📞 Quick Commands

```bash
# Local testing
php artisan serve

# Build locally like Vercel
bash vercel-build.sh

# Deploy cli
vercel

# Check logs
vercel logs

# Pull env
vercel env pull .env.production

# Run migrations
php artisan migrate --force
```

## 💾 Storage Setup (Optional)

For production file uploads, use AWS S3:

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket
AWS_URL=https://your-bucket.s3.amazonaws.com
```

## 🎉 After Deployment

1. **Test URLs:**
   - Home: https://your-domain.com
   - Login: https://your-domain.com/login
   - Jobs: https://your-domain.com/jobs

2. **Setup Custom Domain:**
   - Vercel Dashboard → Settings → Domains
   - Add your custom domain
   - Update DNS records

3. **Monitor Performance:**
   - Vercel Analytics
   - Function Logs
   - Database Performance

4. **Security:**
   - Enable CORS if needed
   - Setup HTTPS (automatic)
   - Regular backups

---

**Need more help?** → Read VERCEL_DEPLOYMENT.md for detailed guide
