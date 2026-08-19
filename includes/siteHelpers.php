<?php
declare(strict_types=1);

/**
 * Shared helpers for aswproject_dev.
 *
 * PUBLIC SITE — no authentication. Do not add SchoolBox, session, or staff checks here.
 */

/**
 * Load shared site configuration from site-config.json.
 *
 * @return array<string, mixed>
 */
function aswproject_load_site_config(): array
{
    static $cached = null;

    if (is_array($cached)) {
        return $cached;
    }

    $configPath = dirname(__DIR__) . '/site-config.json';

    if (!is_readable($configPath)) {
        return [];
    }

    $raw = file_get_contents($configPath);
    if ($raw === false) {
        return [];
    }

    $config = json_decode($raw, true);
    $cached = is_array($config) ? $config : [];

    return $cached;
}

/**
 * @param mixed $value
 */
function aswproject_escape($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Render cell text with a blank line between Sinhala and English blocks (\n\n).
 *
 * @param mixed $value
 */
function aswproject_render_cell_text($value): void
{
    $text = trim(is_scalar($value) ? (string) $value : '');
    if ($text === '') {
        return;
    }

    $parts = preg_split('/\R\s*\R/u', $text, -1, PREG_SPLIT_NO_EMPTY);
    if (!is_array($parts) || $parts === []) {
        echo aswproject_escape($text);
        return;
    }

    foreach ($parts as $index => $part) {
        $part = trim($part);
        if ($part === '') {
            continue;
        }
        $lang = $index === 0 ? 'si' : 'en';
        $class = 'amd-cell-block';
        if ($index > 0) {
            $class .= ' amd-cell-block--spaced';
        }
        echo '<p class="' . $class . '" lang="' . $lang . '">';
        echo aswproject_escape($part);
        echo '</p>';
    }
}

/**
 * @return array<string, mixed>
 */
function aswproject_load_content_json(string $filename): array
{
    $path = dirname(__DIR__) . '/content/' . $filename;

    if (!is_readable($path)) {
        return [];
    }

    $raw = file_get_contents($path);
    if ($raw === false) {
        return [];
    }

    $data = json_decode($raw, true);

    return is_array($data) ? $data : [];
}

function aswproject_is_static_build(): bool
{
    return getenv('ASWPROJECT_STATIC_BUILD') === '1';
}

function aswproject_site_brand_name(array $site = []): string
{
    if ($site === []) {
        $site = aswproject_load_site_config();
    }

    $title = trim((string) ($site['site_title'] ?? 'Alex Morgan Unfiltered'));
    $subtitle = trim((string) ($site['site_subtitle'] ?? ''));

    if ($subtitle === '') {
        return $title;
    }

    if (stripos($title, $subtitle) !== false) {
        return $title;
    }

    return trim($title . ' ' . $subtitle);
}

function aswproject_site_logo_href(array $site = []): string
{
    if ($site === []) {
        $site = aswproject_load_site_config();
    }

    return trim((string) ($site['site_logo'] ?? ''));
}


function aswproject_policy_comparison_href(): string
{
    return aswproject_page_href('policy-comparison');
}

function aswproject_article_href(string $slug): string
{
    $slug = preg_replace('/[^a-z0-9-]/', '', strtolower($slug));

    return aswproject_is_static_build() ? $slug . '.html' : $slug . '.php';
}

function aswproject_article_canonical(string $slug): string
{
    $base = aswproject_site_base_url();
    if ($base === '') {
        return '';
    }

    return aswproject_page_url(aswproject_article_href($slug));
}

/**
 * @return list<string>
 */
function aswproject_known_page_ids(): array
{
    return ['home', 'articles', 'policy-comparison', 'australia-explained', 'about'];
}

function aswproject_resolve_content_href(string $key): string
{
    $key = trim($key);
    if ($key === '') {
        return '#';
    }

    if (in_array($key, aswproject_known_page_ids(), true)) {
        return aswproject_page_href($key);
    }

    return aswproject_article_href($key);
}

function aswproject_page_href(string $pageId): string
{
    $static = aswproject_is_static_build();

    $map = [
        'home' => $static ? 'index.html' : 'index.php',
        'articles' => $static ? 'articles.html' : 'articles.php',
        'policy-comparison' => $static ? 'policy-comparison.html' : 'policy-comparison.php',
        'australia-explained' => $static ? 'australia-explained.html' : 'australia-explained.php',
        'about' => $static ? 'about.html' : 'about.php',
    ];

    return $map[$pageId] ?? ($static ? 'index.html' : 'index.php');
}

function aswproject_page_canonical(string $pageId): string
{
    $base = aswproject_site_base_url();
    if ($base === '') {
        return '';
    }

    return aswproject_page_url(aswproject_page_href($pageId));
}

function aswproject_site_base_url(): string
{
    $site = aswproject_load_site_config();
    return rtrim(trim((string) ($site['site_base_url'] ?? '')), '/');
}

function aswproject_page_url(string $path): string
{
    $base = aswproject_site_base_url();
    $path = ltrim($path, '/');

    if ($base === '') {
        return $path;
    }

    return $base . '/' . $path;
}
