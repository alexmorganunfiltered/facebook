<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/layout.php';

$content = aswproject_load_content_json('australia-explained.json');

aswproject_render_page_start([
    'title' => 'Australia explained',
    'description' => trim((string) ($content['meta_description'] ?? '')),
    'canonical' => aswproject_page_canonical('australia-explained'),
    'current' => 'australia-explained',
]);

aswproject_render_hero($content['hero'] ?? []);

$topics = $content['topics'] ?? [];
if (is_array($topics)) {
    aswproject_render_topic_grid($topics);
}

$sources = $content['sources'] ?? [];
if (is_array($sources)) {
    aswproject_render_source_list($sources);
}

if (is_array($content['my_thoughts'] ?? null)) {
    aswproject_render_my_thoughts($content['my_thoughts']);
}

aswproject_render_page_end();
