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
        if ($index > 0) {
            echo '<p class="amd-cell-block amd-cell-block--spaced">';
        } else {
            echo '<p class="amd-cell-block">';
        }
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

function aswproject_policy_comparison_href(): string
{
    return aswproject_page_href('policy-comparison');
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
