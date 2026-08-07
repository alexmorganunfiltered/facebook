<?php
declare(strict_types=1);

require __DIR__ . '/includes/layout.php';

$site = aswproject_load_site_config();
$content = aswproject_load_content_json('policy-comparison.json');

$pageTitle = trim((string) ($content['page_title'] ?? 'Current comparison'));
$canonical = aswproject_site_base_url() !== ''
    ? aswproject_page_url(aswproject_policy_comparison_href())
    : 'https://staffservices.huntingtower.vic.edu.au/custom/aswproject_dev/policy-comparison.php';

aswproject_render_page_start([
    'title' => $pageTitle,
    'description' => trim((string) ($content['intro'] ?? 'Migration policy comparison across major parties.')),
    'canonical' => $canonical,
]);

aswproject_render_content_table($content);

aswproject_render_page_end();
