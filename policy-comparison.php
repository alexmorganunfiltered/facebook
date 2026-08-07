<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/layout.php';

$content = aswproject_load_content_json('policy-comparison.json');
$sources = aswproject_load_content_json('policy-comparison-sources.json');

$pageTitle = trim((string) ($content['page_title'] ?? 'Current comparison'));

aswproject_render_page_start([
    'title' => $pageTitle,
    'description' => trim((string) ($content['intro'] ?? 'Migration policy comparison across major parties.')),
    'canonical' => aswproject_page_canonical('policy-comparison'),
    'current' => 'policy-comparison',
]);

aswproject_render_policy_comparison($content);

$sourceList = is_array($sources['sources'] ?? null) ? $sources['sources'] : [];
if ($sourceList !== []) {
    aswproject_render_source_list($sourceList);
}

$note = trim((string) ($sources['note'] ?? ''));
if ($note !== '') {
    echo '<p class="amd-note" lang="en">' . aswproject_escape($note) . '</p>';
    echo '<p class="amd-note" lang="si">පක්ෂ ප්‍රතිපත්ති වෙනස් විය හැක. මෙම table compile කළ අවස්ථාවේ publish කළ policy pages reflect කරයි. Share කිරීමට පෙර primary sources පරීක්ෂා කරන්න.</p>';
}

aswproject_render_page_end();
