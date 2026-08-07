# Change log and Bug fixes — aswproject_dev

## 2026-08-07 — Multi-page editorial landing site for GitHub Pages

**Change:** Built responsive static editorial site with five pages (Home, Articles, Policy Comparisons, Australia Explained, About). Reusable components in `includes/components.php` (header, footer, hero, article cards, policy cards, comparison table + mobile stacked cards, sources, My Thoughts, social links). White editorial design with navy/black/grey and limited red accents; Inter + Noto Sans Sinhala fonts. `policy-comparison.json` table data unchanged; sources in separate `policy-comparison-sources.json`. Static build generates all HTML pages (home no longer Facebook redirect).

**Files touched:** `index.php`, `articles.php`, `about.php`, `australia-explained.php`, `policy-comparison.php`, `includes/layout.php`, `includes/components.php`, `includes/siteHelpers.php`, `assets/css/site.css`, `assets/css/site-mobile.css`, `.scripts/build-static.php`, `404.html`, `README.md`, `content/home.json`, `content/articles.json`, `content/about.json`, `content/australia-explained.json`, `content/policy-comparison-sources.json`.

---

## 2026-08-07 — Table cell hover and English text colour

**Change:** English blocks in table cells (`.amd-cell-block--spaced`) use dark blue (`--amd-accent`). Hover highlights single cell only, not entire row.

**Files touched:** `assets/css/site.css`.

---

## 2026-08-07 — Reverted policy table party name wording

**Change:** Restored Sinhala `ලේබර්` and `ලිබරල්–ජාතික සන්ධානය` in `content/policy-comparison.json` (undo of Labor/Liberal–National Coalition replacement in Sinhala text).

**Files touched:** `content/policy-comparison.json`.

---

## 2026-08-07 — Policy table party name wording (reverted)

## 2026-08-07 — GitHub Pages deploy 404 troubleshooting

**Issue:** Actions build succeeded; deploy failed with 404 — Pages not enabled for GitHub Actions source.

**Fix:** Settings → Pages → Source: **GitHub Actions**; Actions → General → Workflow permissions: **Read and write**; re-run workflow.

**Files touched:** `.docs/github-pages.md`.

---

## 2026-08-07 — Isolated git repo and push_to_github.sh

**Issue:** `git push` from `aswproject_dev/` still uploaded ~10k objects / ~500MB because git root was parent `custom/` monorepo, not this folder.

**Fix:** Initialized `.git` inside `aswproject_dev/` only (~32 files). Added `push_to_github.sh` with git-root guard; token still from `/etc/webapp/config/.gitTokens` (`migrantsdiary=`).

**Files touched:** `push_to_github.sh`, `.docs/github-pages.md`.

---

## 2026-08-07 — GitHub Pages deploy for migrantsdiary/facebook

**Change:** Added GitHub Actions workflow and `.scripts/build-static.php` to publish static site to https://migrantsdiary.github.io/facebook/ from repo https://github.com/migrantsdiary/facebook. Set `site_base_url` in `site-config.json`. Nav/canonical URLs switch between `.php` (local) and `.html` (Pages build).

**Files touched:** `.github/workflows/deploy-pages.yml`, `.scripts/build-static.php`, `.gitignore`, `.docs/github-pages.md`, `site-config.json`, `includes/siteHelpers.php`, `includes/layout.php`, `policy-comparison.php`, `404.html`, `README.md`.

**Next:** Push to `main`, enable Pages source “GitHub Actions” in repo Settings.

---

## 2026-08-07 — Darker blue; local-only active CSS

**Change:** Darkened accent/table header blue to `#0a3d71`. Stopped loading `global.css` / `global-mobile.css` at runtime; all active styles now live in `site.css` and `site-mobile.css` with `.amd-*` classes only. Updated `404.html` to use local stylesheets.

**Files touched:** `assets/css/site.css`, `assets/css/site-mobile.css`, `includes/layout.php`, `404.html`, `README.md`.

---

## 2026-08-07 — Bilingual Sinhala/English policy table

**Change:** Updated `content/policy-comparison.json` with full Sinhala and English text for all 11 policy rows and bilingual column headers. Cell renderer splits on blank lines so Sinhala appears above English with spacing in every cell.

**Files touched:** `content/policy-comparison.json`, `includes/siteHelpers.php`, `includes/layout.php`, `assets/css/site.css`.

---

## 2026-08-07 — Desktop layout uses 90% page width

**Change:** Main content shell (`.amd-shell`) now spans 90% of viewport width on desktop instead of a capped 1100px column.

**Files touched:** `assets/css/site.css`.

---

## 2026-08-07 — Document public-site policy (no auth)

**Change:** Recorded that this app is fully public — no SchoolBox, staff login, or session checks. Added `.docs/PUBLIC-SITE.md` and `.cursor/rules/public-no-auth.mdc` so future work does not add authentication.

**Files touched:** `.docs/PUBLIC-SITE.md`, `.cursor/rules/public-no-auth.mdc`, `README.md`, `includes/siteHelpers.php`.

---

## 2026-08-07 — Migration policy comparison table

**Change:** Added full 11-row party comparison table on `policy-comparison.php` (Policy area, One Nation, Labor government, Liberal–National Coalition). Replaced episodes placeholder. Improved comparison table styling (top-aligned cells, wider layout).

**Files touched:** `policy-comparison.php`, `content/policy-comparison.json`, `includes/layout.php`, `assets/css/site.css`, `README.md`. Removed `episodes.php`, `content/episodes.json`.

---

## 2026-08-07 — Episodes page + self-contained Figtree styling

**Change:** Added `episodes.php` with JSON-driven table, local copies of `global.css`, `global-mobile.css`, Figtree fonts, and `site.css` (Facebook-style Figtree theme for [A Migrant's Diary](https://www.facebook.com/people/A-Migrants-Diary-%E0%B7%83%E0%B7%92%E0%B6%82%E0%B7%84%E0%B6%BD-%E0%B6%94%E0%B7%83%E0%B7%92%E0%B6%BA%E0%B7%8F/61574611752422/)). Project assets are fully contained under `aswproject_dev/` for future server migration.

**Files touched:** `episodes.php`, `content/episodes.json`, `assets/css/*`, `assets/fonts/figtree/*`, `includes/layout.php`, `includes/siteHelpers.php`, `site-config.json`, `README.md`.

**Next:** Add episode rows to `content/episodes.json` (table data was not included in the request).

---

## 2026-08-07 — Fix local redirect (no server config changes)

**Issue:** Visiting the site showed “Unable to load redirect configuration.” Apache served `index.html` before `index.php`, and `config/site-config.json` returned 403 over HTTP.

**Fix:** Removed root `index.html`; local entry is `index.php` only. Moved config to public `site-config.json` at project root. Added `azure-index.html` as the static redirect template for future Azure deploy.

**Files touched:** `index.html` (removed), `site-config.json`, `site-config.example.json`, `azure-index.html`, `includes/redirectTarget.php`, `staticwebapp.config.json`, `README.md`, `config/` (removed).

---

## 2026-08-07 — Initial local scaffold

**Change:** Created standalone static site project for future Azure Static Web Apps hosting. Public site with no authentication.

**Behaviour:**
- `index.php` redirects visitors to the Facebook page URL defined in `site-config.json`.
- Redirect target is validated (HTTPS, facebook.com hosts only) to avoid open-redirect misconfiguration.

**Files touched:**
- `index.php`, `index.html`, `404.html`, `staticwebapp.config.json`
- `config/site-config.json`, `config/site-config.example.json`
- `includes/redirectTarget.php`
- `README.md`

**Next:** Set real Facebook URL in `site-config.json`; provision Azure SWA and GitHub workflow when ready.
