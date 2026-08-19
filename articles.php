<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/siteHelpers.php';

if (aswproject_is_static_build()) {
    require_once __DIR__ . '/includes/homeArticles.php';
    aswproject_render_home_articles_page();
    return;
}

header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('Location: ' . aswproject_page_href('home'), true, 301);
exit;
