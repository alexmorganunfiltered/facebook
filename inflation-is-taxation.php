<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/layout.php';

$content = aswproject_load_content_json('inflation-is-taxation.json');
$pageTitle = trim((string) ($content['page_title'] ?? 'Article'));

aswproject_render_page_start([
    'title' => $pageTitle,
    'description' => trim((string) ($content['meta_description'] ?? '')),
    'canonical' => aswproject_article_canonical('inflation-is-taxation'),
    'current' => '',
]);

aswproject_render_full_article($content);

aswproject_render_page_end();
