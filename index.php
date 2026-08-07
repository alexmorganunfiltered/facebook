<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/layout.php';

$content = aswproject_load_content_json('home.json');
$site = aswproject_load_site_config();
$siteTitle = trim((string) ($site['site_title'] ?? 'A Migrant\'s Diary'));

aswproject_render_page_start([
    'title' => $siteTitle,
    'description' => trim((string) ($content['meta_description'] ?? '')),
    'canonical' => aswproject_page_canonical('home'),
    'current' => 'home',
]);

aswproject_render_hero($content['hero'] ?? []);

$discuss = $content['what_we_discuss'] ?? [];
if (is_array($discuss)) {
    aswproject_render_topic_grid(
        is_array($discuss['items'] ?? null) ? $discuss['items'] : [],
        trim((string) ($discuss['title'] ?? '')),
        trim((string) ($discuss['title_si'] ?? ''))
    );
}

$interests = $content['interests'] ?? [];
if (is_array($interests)) {
    aswproject_render_text_section($interests);
}

$featured = $content['featured_links'] ?? [];
if (is_array($featured)) {
    echo '<section class="amd-featured">';
    echo '<h2 class="amd-section-title">Explore</h2>';
    aswproject_render_policy_cards($featured);
    echo '</section>';
}

if (is_array($content['my_thoughts'] ?? null)) {
    aswproject_render_my_thoughts($content['my_thoughts']);
}

aswproject_render_page_end();
