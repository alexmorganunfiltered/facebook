<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    if (!headers_sent()) {
        http_response_code(403);
        header('Content-Type: text/plain; charset=UTF-8');
    }
    exit('Forbidden');
}

/**
 * Build static site for GitHub Pages into _site/.
 *
 * Usage:
 *   php .scripts/build-static.php
 */
putenv('ASWPROJECT_STATIC_BUILD=1');

$root = dirname(__DIR__);
$out = $root . '/_site';

function build_static_remove_tree(string $dir): void
{
    if (!is_dir($dir)) {
        return;
    }

    $items = scandir($dir);
    if ($items === false) {
        return;
    }

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            build_static_remove_tree($path);
            rmdir($path);
            continue;
        }
        unlink($path);
    }
}

function build_static_copy_tree(string $source, string $destination): void
{
    if (!is_dir($source)) {
        return;
    }

    if (!is_dir($destination) && !mkdir($destination, 0755, true) && !is_dir($destination)) {
        throw new RuntimeException('Could not create directory: ' . $destination);
    }

    $items = scandir($source);
    if ($items === false) {
        return;
    }

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $from = $source . '/' . $item;
        $to = $destination . '/' . $item;
        if (is_dir($from)) {
            build_static_copy_tree($from, $to);
            continue;
        }
        if (!copy($from, $to)) {
            throw new RuntimeException('Could not copy: ' . $from);
        }
    }
}

function build_static_write(string $path, string $contents): void
{
    $dir = dirname($path);
    if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
        throw new RuntimeException('Could not create directory: ' . $dir);
    }
    if (file_put_contents($path, $contents) === false) {
        throw new RuntimeException('Could not write: ' . $path);
    }
}

function build_static_render_to_string(callable $renderer): string
{
    ob_start();
    $renderer();
    $html = ob_get_clean();

    return is_string($html) ? $html : '';
}

require $root . '/includes/layout.php';

$site = aswproject_load_site_config();
$facebookUrl = trim((string) ($site['facebook_page_url'] ?? ''));
if ($facebookUrl === '' || str_contains($facebookUrl, 'your.page.here')) {
    fwrite(STDERR, "Set facebook_page_url in site-config.json before building.\n");
    exit(1);
}

if (is_dir($out)) {
    build_static_remove_tree($out);
}
if (!mkdir($out, 0755, true) && !is_dir($out)) {
    fwrite(STDERR, "Could not create _site output directory.\n");
    exit(1);
}

build_static_copy_tree($root . '/assets', $out . '/assets');
build_static_copy_tree($root . '/content', $out . '/content');
copy($root . '/site-config.json', $out . '/site-config.json');
copy($root . '/404.html', $out . '/404.html');

$indexHtml = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Redirecting…</title>
  <meta http-equiv="refresh" content="0;url=' . htmlspecialchars($facebookUrl, ENT_QUOTES, 'UTF-8') . '">
  <meta name="robots" content="noindex">
  <link rel="canonical" href="' . htmlspecialchars($facebookUrl, ENT_QUOTES, 'UTF-8') . '">
</head>
<body>
  <p>Redirecting to <a href="' . htmlspecialchars($facebookUrl, ENT_QUOTES, 'UTF-8') . '">A Migrant\'s Diary on Facebook</a>…</p>
  <script>window.location.replace(' . json_encode($facebookUrl, JSON_UNESCAPED_SLASHES) . ');</script>
</body>
</html>';

build_static_write($out . '/index.html', $indexHtml);

$content = aswproject_load_content_json('policy-comparison.json');
$pageTitle = trim((string) ($content['page_title'] ?? 'Current comparison'));
$policyHtml = build_static_render_to_string(static function () use ($content, $pageTitle): void {
    aswproject_render_page_start([
        'title' => $pageTitle,
        'description' => trim((string) ($content['intro'] ?? 'Migration policy comparison across major parties.')),
        'canonical' => aswproject_page_url('policy-comparison.html'),
    ]);
    aswproject_render_content_table($content);
    aswproject_render_page_end();
});

build_static_write($out . '/policy-comparison.html', $policyHtml);

fwrite(STDOUT, "Static site written to _site/\n");
fwrite(STDOUT, "  index.html -> Facebook redirect\n");
fwrite(STDOUT, "  policy-comparison.html\n");
