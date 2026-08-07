<?php
declare(strict_types=1);

require_once __DIR__ . '/siteHelpers.php';
require_once __DIR__ . '/components.php';

/**
 * @param array<string, mixed> $page
 */
function aswproject_render_page_start(array $page): void
{
    $site = aswproject_load_site_config();
    $title = trim((string) ($page['title'] ?? 'A Migrant\'s Diary'));
    $description = trim((string) ($page['description'] ?? ''));
    $canonical = trim((string) ($page['canonical'] ?? ''));
    $siteTitle = trim((string) ($site['site_title'] ?? 'A Migrant\'s Diary'));
    $currentPage = trim((string) ($page['current'] ?? ''));

    $fullTitle = $title === $siteTitle ? $title : $title . ' — ' . $siteTitle;
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <title><?= aswproject_escape($fullTitle) ?></title>
<?php if ($description !== ''): ?>
  <meta name="description" content="<?= aswproject_escape($description) ?>">
<?php endif; ?>
<?php if ($canonical !== ''): ?>
  <link rel="canonical" href="<?= aswproject_escape($canonical) ?>">
  <meta property="og:url" content="<?= aswproject_escape($canonical) ?>">
<?php endif; ?>
  <meta property="og:title" content="<?= aswproject_escape($fullTitle) ?>">
<?php if ($description !== ''): ?>
  <meta property="og:description" content="<?= aswproject_escape($description) ?>">
<?php endif; ?>
  <meta property="og:type" content="website">
  <meta name="twitter:card" content="summary">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+Sinhala:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/figtree.css">
  <link rel="stylesheet" href="assets/css/site.css">
  <link rel="stylesheet" href="assets/css/site-mobile.css" media="screen and (max-width: 768px)">
</head>
<body class="amd-page">
  <div class="amd-shell">
    <?php aswproject_render_site_header($currentPage); ?>
    <main class="amd-main">
<?php
}

function aswproject_render_page_end(): void
{
    ?>
    </main>
    <?php aswproject_render_site_footer(); ?>
  </div>
</body>
</html>
<?php
}
