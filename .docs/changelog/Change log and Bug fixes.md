# Change log and Bug fixes — aswproject_dev

## 2026-08-19 — Logo fix and site name Alex Morgan Unfiltered

**Issue:** Logo uploaded to GitHub (`assets/images/logo.jpg`) but live `site-config.json` still had `"site_logo": ""`, so header showed text only.

**Fix:** Set `site_logo` in `site-config.json`. Unified site name to **Alex Morgan Unfiltered** (single `site_title`, empty subtitle). Header shows logo only when configured (no duplicate text). News cards use brand helper.

**Files touched:** `site-config.json`, `includes/siteHelpers.php`, `includes/components.php`, `includes/layout.php`, `assets/css/site.css`, `content/articles.json`, `content/about.json`, `site-config.example.json`, `.scripts/build-static.php`, `README.md`.

---

## 2026-08-19 — GitHub account rename: alexmorganunfiltered

**Change:** Updated push target and Pages URLs from `migrantsdiary` to [alexmorganunfiltered/facebook](https://github.com/alexmorganunfiltered/facebook). Live site: https://alexmorganunfiltered.github.io/facebook/ . `push_to_github.sh` reads `alexmorganunfiltered=` token (falls back to `migrantsdiary=`).

**Files touched:** `push_to_github.sh`, `site-config.json`, `site-config.example.json`, `.docs/github-pages.md`, `README.md`.

---

## 2026-08-19 — Rebrand to Alex Morgan — Unfiltered; logo support

**Change:** Site name updated to **Alex Morgan — Unfiltered** via `site-config.json` (`site_title`, `site_subtitle`). Optional header logo via `site_logo` path. Logo upload docs at `assets/images/README.md`.

**Files touched:** `site-config.json`, `site-config.example.json`, `includes/components.php`, `includes/layout.php`, `assets/css/site.css`, `content/articles.json`, `.scripts/build-static.php`, `assets/images/README.md`, `README.md`.

---

## 2026-08-19 — Articles index news cards redesign

**Change:** Articles page is now a clean news-card grid only — removed hero intro, My thoughts, and coming-soon placeholders. Published articles render as clickable cards with date, tag, excerpt, and optional thumbnail (`image` in JSON).

**Files touched:** `articles.php`, `content/articles.json`, `includes/components.php`, `assets/css/site.css`, `assets/css/site-mobile.css`.

---

## 2026-08-19 — Inflation article page and article images

**Change:** Added full article page “Inflation is taxation without legislation” (`inflation-is-taxation.php` / `.html`) with JSON-driven body copy from the Facebook post. Reusable `aswproject_render_full_article()` supports optional `hero_image` and inline `images` after paragraph indices. Listed on Articles index.

**Files touched:** `content/inflation-is-taxation.json`, `content/articles.json`, `inflation-is-taxation.php`, `includes/components.php`, `includes/siteHelpers.php`, `assets/css/site.css`, `.scripts/build-static.php`, `assets/images/articles/README.md`, `README.md`.

---

## 2026-08-07 — Home page reverted to Facebook redirect

**Change:** Removed editorial landing content from home. `index.php` and static `index.html` again redirect to the Facebook page. Other pages (articles, policy comparison, etc.) unchanged.

**Files touched:** `index.php`, `.scripts/build-static.php`, `README.md`.

---

## 2026-08-07 — Language switcher (EN / සිං) with localStorage

**Change:** Header language toggle shows one language at a time site-wide. Preference saved in browser `localStorage` (works on static GitHub Pages — no server or database). Optional `?lang=en|si` URL param. Policy table cells split Sinhala/English by `\n\n` blocks.

**Files touched:** `assets/js/lang.js`, `includes/layout.php`, `includes/components.php`, `includes/siteHelpers.php`, `assets/css/site.css`, `assets/css/site-mobile.css`, `index.php`, `policy-comparison.php`.

---

## 2026-08-07 — Remove legacy Facebook redirect artifact

**Change:** Deleted unused `azure-index.html` (client-side redirect to Facebook). Added short-lived cache-busting meta tags in layout so browsers drop stale redirect `index.html`. Live GitHub Pages already serves the landing page (verified HTTP 200, no redirect JS).

**Files touched:** `azure-index.html` (removed), `includes/layout.php`.

---

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
