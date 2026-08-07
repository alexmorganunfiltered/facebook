<?php
declare(strict_types=1);

require_once __DIR__ . '/siteHelpers.php';

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
    $siteSubtitle = trim((string) ($site['site_subtitle'] ?? 'සිංහල ඔසියා'));
    $facebookUrl = trim((string) ($site['facebook_page_url'] ?? ''));

    $fullTitle = $title === $siteTitle ? $title : $title . ' — ' . $siteTitle;
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
  <link rel="stylesheet" href="assets/css/figtree.css">
  <link rel="stylesheet" href="assets/css/site.css">
  <link rel="stylesheet" href="assets/css/site-mobile.css" media="screen and (max-width: 768px)">
</head>
<body class="amd-page">
  <div class="amd-shell">
    <header class="amd-header">
      <h1 class="amd-header__brand"><?= aswproject_escape($siteTitle) ?></h1>
      <p class="amd-header__subtitle"><?= aswproject_escape($siteSubtitle) ?></p>
      <nav class="amd-header__links" aria-label="Site links">
<?php if ($facebookUrl !== ''): ?>
        <a class="amd-link" href="<?= aswproject_escape($facebookUrl) ?>" rel="noopener noreferrer" target="_blank">Facebook page</a>
<?php endif; ?>
        <a class="amd-link amd-link--secondary" href="<?= aswproject_escape(aswproject_policy_comparison_href()) ?>">Policy comparison</a>
      </nav>
    </header>
    <main>
<?php
}

function aswproject_render_page_end(): void
{
    $site = aswproject_load_site_config();
    $siteTitle = trim((string) ($site['site_title'] ?? 'A Migrant\'s Diary'));
    ?>
    </main>
    <footer class="amd-footer">
      <p><?= aswproject_escape($siteTitle) ?></p>
    </footer>
  </div>
</body>
</html>
<?php
}

/**
 * @param array<string, mixed> $content
 */
function aswproject_render_content_table(array $content): void
{
    $pageTitle = trim((string) ($content['page_title'] ?? 'Content'));
    $intro = trim((string) ($content['intro'] ?? ''));
    $columns = $content['columns'] ?? [];
    $rows = $content['rows'] ?? [];

    if (!is_array($columns) || !is_array($rows)) {
        echo '<section class="amd-card"><p class="amd-empty">Table configuration is invalid.</p></section>';
        return;
    }
    ?>
    <section class="amd-card">
      <h2 class="amd-card__title"><?= aswproject_escape($pageTitle) ?></h2>
<?php if ($intro !== ''): ?>
      <p class="amd-card__intro"><?= aswproject_escape($intro) ?></p>
<?php endif; ?>
<?php if ($columns === []): ?>
      <p class="amd-empty">No table columns configured.</p>
<?php elseif ($rows === []): ?>
      <p class="amd-empty">No table rows configured yet.</p>
<?php else: ?>
      <div class="amd-table-wrap">
        <table class="amd-table amd-table--compare">
          <thead>
            <tr>
<?php foreach ($columns as $column): ?>
<?php
    if (!is_array($column)) {
        continue;
    }
    $label = trim((string) ($column['label'] ?? ''));
?>
              <th scope="col"><?php aswproject_render_cell_text($label); ?></th>
<?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
<?php foreach ($rows as $row): ?>
<?php
    if (!is_array($row)) {
        continue;
    }
?>
            <tr>
<?php foreach ($columns as $column): ?>
<?php
    if (!is_array($column)) {
        continue;
    }
    $key = trim((string) ($column['key'] ?? ''));
    $type = trim((string) ($column['type'] ?? 'text'));
    $cell = $row[$key] ?? '';
?>
              <td>
<?php if ($type === 'link' && is_string($cell) && $cell !== ''): ?>
                <a href="<?= aswproject_escape($cell) ?>" rel="noopener noreferrer" target="_blank">Open</a>
<?php else: ?>
                <?php aswproject_render_cell_text($cell); ?>
<?php endif; ?>
              </td>
<?php endforeach; ?>
            </tr>
<?php endforeach; ?>
          </tbody>
        </table>
      </div>
<?php endif; ?>
    </section>
<?php
}
