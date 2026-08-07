<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/layout.php';

$content = aswproject_load_content_json('about.json');

aswproject_render_page_start([
    'title' => 'About',
    'description' => trim((string) ($content['meta_description'] ?? '')),
    'canonical' => aswproject_page_canonical('about'),
    'current' => 'about',
]);

aswproject_render_hero($content['hero'] ?? []);

$sections = $content['sections'] ?? [];
if (is_array($sections)) {
    foreach ($sections as $section) {
        if (is_array($section)) {
            aswproject_render_text_section($section);
        }
    }
}

if (is_array($content['my_thoughts'] ?? null)) {
    aswproject_render_my_thoughts($content['my_thoughts']);
}

aswproject_render_page_end();
