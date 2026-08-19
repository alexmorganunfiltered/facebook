# Article images

Place article images here, then reference them from article JSON.

Example in `content/inflation-is-taxation.json`:

```json
"hero_image": {
  "src": "assets/images/articles/inflation-hero.jpg",
  "alt": "Short description for screen readers",
  "caption": "Optional caption shown under the image"
},
"images": [
  {
    "after_paragraph": 6,
    "src": "assets/images/articles/us-debt-chart.jpg",
    "alt": "Chart showing rising national debt",
    "caption": "Optional caption"
  }
]
```

- Use JPG, PNG, or WebP.
- Keep file sizes reasonable for GitHub Pages (under ~500 KB per image when possible).
- Images are copied to `_site/` automatically when you run `php .scripts/build-static.php`.
