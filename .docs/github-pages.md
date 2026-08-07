# GitHub Pages — migrantsdiary/facebook

**Repo:** https://github.com/migrantsdiary/facebook  
**Live URL (after first deploy):** https://migrantsdiary.github.io/facebook/

Public repo · no authentication · GitHub Actions builds static HTML on push to `main`.

---

## One-time GitHub setup

1. Repo is already created: [migrantsdiary/facebook](https://github.com/migrantsdiary/facebook)
2. Push this project to `main` (see below).
3. GitHub → repo **Settings → Pages**:
   - **Source:** GitHub Actions (not “Deploy from branch”)
4. After the first workflow run succeeds, the site is live at the URL above.

---

## Push from staffservices dev server

```bash
cd /var/www/html/staffservices/custom/aswproject_dev

git init
git remote add origin https://github.com/migrantsdiary/facebook.git
git add .
git commit -m "Initial site: policy comparison and GitHub Pages deploy"
git branch -M main
git push -u origin main
```

Use a personal access token or SSH if HTTPS push asks for credentials.

---

## Local static preview

```bash
php .scripts/build-static.php
# Output in _site/ — open _site/policy-comparison.html or serve with:
php -S 127.0.0.1:8080 -t _site
```

---

## How deploy works

1. Push to `main`
2. `.github/workflows/deploy-pages.yml` runs PHP build (`.scripts/build-static.php`)
3. Artifact `_site/` is published to GitHub Pages

**Built files:** `index.html` (Facebook redirect), `policy-comparison.html`, `assets/`, `content/`, `404.html`

**Dev server (PHP):** `index.php` and `policy-comparison.php` remain for local/staffservices testing.

---

## Config

`site-config.json`:

| Key | Purpose |
|-----|---------|
| `facebook_page_url` | Home redirect target |
| `site_base_url` | Canonical URLs (`https://migrantsdiary.github.io/facebook`) |
| `site_title` / `site_subtitle` | Header branding |

---

## Custom domain (optional later)

GitHub Pages → **Custom domain** in repo Settings. DNS CNAME to `migrantsdiary.github.io`.
