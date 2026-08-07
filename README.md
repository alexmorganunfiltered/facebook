# A Migrant's Diary — web site

Standalone **public** personal site — **100% self-contained** in this directory (CSS, fonts, content).

**No authentication** — see `.docs/PUBLIC-SITE.md`.

| Environment | URL |
|-------------|-----|
| **GitHub Pages (production)** | https://migrantsdiary.github.io/facebook/ |
| **GitHub repo** | https://github.com/migrantsdiary/facebook |
| **Local PHP dev** | `/var/www/html/staffservices/custom/aswproject_dev/` |

**Facebook:** [A Migrant's Diary — සිංහල ඔසියා](https://www.facebook.com/people/A-Migrants-Diary-%E0%B7%83%E0%B7%92%E0%B6%82%E0%B7%84%E0%B6%BD-%E0%B6%94%E0%B7%83%E0%B7%92%E0%B6%BA%E0%B7%8F/61574611752422/)

---

## Pages

| Dev (PHP) | GitHub Pages (static) | Purpose |
|-----------|------------------------|---------|
| `index.php` | `index.html` | Redirect to Facebook |
| `articles.php` | `articles.html` | Articles and explainers |
| `policy-comparison.php` | `policy-comparison.html` | One Nation / Labor / Coalition comparison |
| `australia-explained.php` | `australia-explained.html` | Systems newcomers ask about |
| `about.php` | `about.html` | About this project |

---

## GitHub Pages deploy

Push to `main` → GitHub Actions builds `_site/` and publishes Pages.

**Full steps:** `.docs/github-pages.md`

```bash
php .scripts/build-static.php   # local preview → _site/
```

---

## Config & content

- **`site-config.json`** — Facebook URL, titles, `site_base_url` for canonical links
- **`content/policy-comparison.json`** — bilingual comparison table (do not edit casually)
- **`content/*.json`** — page copy for home, articles, about, australia-explained

---

## Styles (local only)

```text
assets/css/figtree.css       — local font fallback
assets/css/site.css          — editorial theme (#0a3d71 navy, limited red accents)
assets/css/site-mobile.css   — stacked policy cards on mobile
```

Google Fonts (Inter + Noto Sans Sinhala) load from the layout header.

`global.css` / `global-mobile.css` in `assets/css/` are unused reference copies.

---

## Project layout

```text
aswproject_dev/
├── .github/workflows/deploy-pages.yml
├── .scripts/build-static.php
├── index.php / articles.php / policy-comparison.php / …
├── site-config.json
├── content/
├── assets/
├── includes/   — layout.php, components.php, siteHelpers.php
└── .docs/
```
