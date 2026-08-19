<?php
declare(strict_types=1);

require_once __DIR__ . '/layout.php';

function aswproject_render_home_articles_page(): void
{
    $content = aswproject_load_content_json('articles.json');
    $site = aswproject_load_site_config();
    $brand = aswproject_site_brand_name($site);
    $description = trim((string) ($content['meta_description'] ?? ''));
    if ($description === '') {
        $description = trim((string) ($content['site_intro'] ?? ''));
    }

    aswproject_render_page_start([
        'title' => $brand,
        'description' => $description,
        'canonical' => aswproject_page_canonical('home'),
        'current' => 'home',
    ]);

    $intro = trim((string) ($content['site_intro'] ?? ''));
    if ($intro !== '') {
        aswproject_render_site_intro($intro);
    }

    $articles = $content['articles'] ?? [];
    if (is_array($articles)) {
        aswproject_render_news_cards($articles);
    }

    aswproject_render_page_end();
}
