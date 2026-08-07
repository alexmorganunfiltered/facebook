# Public site — no authentication

**aswproject_dev** is intentionally **fully public**. Anyone on the internet may view every page.

## Rules for this project

- **Do not** add SchoolBox launch, HMAC/JWT verification, `staffId` / `staffEmail` checks, or session login.
- **Do not** require staff portal / Synergetic / portalDb / staffDb identity to view content.
- **Do not** add ICT-only or role-based access (no `$itAdminUsers`, no `userRoles.php`).
- **Do not** add Apache/server config changes from this app — hosting access control is out of scope here.
- Content is **non-private** information only (e.g. migration policy comparison, links to Facebook).

## What we use instead

- Plain PHP pages that read local JSON and render HTML.
- Output escaping (`aswproject_escape`) for XSS safety — not for access control.
- Self-contained assets under `assets/` (`site.css`, `site-mobile.css`, `figtree.css`) — no runtime dependency on other staffservices apps.

## When moving to Azure Static Web Apps

- Deploy as static HTML (or SWA routes) with **no** Azure Easy Auth, Entra login, or API keys on public pages.
- Custom domain + HTTPS only; no visitor authentication.

## Pages (all public)

| File | Purpose |
|------|---------|
| `index.php` | Redirect to Facebook |
| `policy-comparison.php` | Migration policy comparison table |
| `404.html` | Not found |
