# Site images

## Logo

Upload your logo to this folder and set the path in `site-config.json`:

```json
"site_logo": "assets/images/logo.png"
```

**Recommended**

| Setting | Value |
|---------|--------|
| **Folder** | `assets/images/` in this repo |
| **Formats** | PNG (transparent) or SVG |
| **Size** | ~400–800 px wide; displays ~40 px tall in the header |
| **Filename** | e.g. `logo.png`, `logo.svg` |

After adding the file:

1. Set `"site_logo": "assets/images/logo.png"` in `site-config.json`
2. Push to GitHub — the logo is copied to `_site/` on build/deploy automatically

**GitHub repo path:** put the file in the same place locally, commit, and push:

```text
aswproject_dev/assets/images/logo.png
```

Article thumbnails go in `assets/images/articles/` (see that folder’s README).
