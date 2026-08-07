# GitHub Pages — migrantsdiary/facebook

**Repo:** https://github.com/migrantsdiary/facebook  
**Live URL (after first deploy):** https://migrantsdiary.github.io/facebook/

Public repo · no authentication · GitHub Actions builds static HTML on push to `main`.

---

## One-time GitHub setup

1. Repo: [migrantsdiary/facebook](https://github.com/migrantsdiary/facebook) — code on `main`.
2. **Enable Pages (required — deploy fails with 404 until this is done):**
   - **Settings → Pages**
   - **Build and deployment → Source:** choose **GitHub Actions** (not “Deploy from a branch”)
   - Save if prompted
3. **Settings → Actions → General → Workflow permissions:**
   - **Read and write permissions** (allows `GITHUB_TOKEN` to publish Pages)
4. Re-run the failed workflow: **Actions → Deploy GitHub Pages → Re-run all jobs**

Live URL after success: **https://migrantsdiary.github.io/facebook/**

### If deploy still returns 404

- Confirm step 2 says **GitHub Actions**, not a branch folder.
- Org repo: **migrantsdiary** org settings may need **Pages** enabled for members.
- PAT used for `git push` must include **`workflow`** scope (for pushing `.github/workflows/`).

---

## Push from staffservices dev server

**Use the helper** — it refuses to run if git root is not `aswproject_dev/`:

```bash
cd /var/www/html/staffservices/custom/aswproject_dev
./push_to_github.sh "your commit message"
```

Token: `/etc/webapp/config/.gitTokens` → `migrantsdiary=<PAT>`

**Do not** run `git push` from `/var/www/html/staffservices/custom/` — that is the school monorepo (~500MB, thousands of files).

One-time init (already done if `.git` exists inside `aswproject_dev/`):

```bash
cd /var/www/html/staffservices/custom/aswproject_dev
git init
git add .
git commit -m "Initial site"
git branch -M main
./push_to_github.sh
```

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
