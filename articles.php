<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/layout.php';

$content = aswproject_load_content_json('articles.json');

aswproject_render_page_start([
    'title' => 'Articles',
    'description' => trim((string) ($content['meta_description'] ?? '')),
    'canonical' => aswproject_page_canonical('articles'),
    'current' => 'articles',
]);

aswproject_render_articles_index_heading();

$articles = $content['articles'] ?? [];
if (is_array($articles)) {
    aswproject_render_news_cards($articles);
}

aswproject_render_page_end();
