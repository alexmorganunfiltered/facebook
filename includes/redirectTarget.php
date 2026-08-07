<?php
declare(strict_types=1);

/**
 * Load and validate the public Facebook redirect URL from site-config.json.
 */
function aswproject_get_facebook_redirect_url(): string
{
    $configPath = dirname(__DIR__) . '/site-config.json';

    if (!is_readable($configPath)) {
        http_response_code(500);
        header('Content-Type: text/plain; charset=UTF-8');
        exit('Site configuration is missing.');
    }

    $raw = file_get_contents($configPath);
    if ($raw === false) {
        http_response_code(500);
        header('Content-Type: text/plain; charset=UTF-8');
        exit('Site configuration could not be read.');
    }

    $config = json_decode($raw, true);
    if (!is_array($config)) {
        http_response_code(500);
        header('Content-Type: text/plain; charset=UTF-8');
        exit('Site configuration is invalid.');
    }

    $url = trim((string) ($config['facebook_page_url'] ?? ''));
    if ($url === '' || !filter_var($url, FILTER_VALIDATE_URL)) {
        http_response_code(500);
        header('Content-Type: text/plain; charset=UTF-8');
        exit('Facebook page URL is not configured.');
    }

    $parsed = parse_url($url);
    $scheme = strtolower((string) ($parsed['scheme'] ?? ''));
    $host = strtolower((string) ($parsed['host'] ?? ''));

    if ($scheme !== 'https') {
        http_response_code(500);
        header('Content-Type: text/plain; charset=UTF-8');
        exit('Facebook page URL must use HTTPS.');
    }

    $allowedHosts = ['www.facebook.com', 'facebook.com', 'm.facebook.com'];
    if (!in_array($host, $allowedHosts, true)) {
        http_response_code(500);
        header('Content-Type: text/plain; charset=UTF-8');
        exit('Facebook page URL must point to facebook.com.');
    }

    if (str_contains($url, 'your.page.here')) {
        http_response_code(503);
        header('Content-Type: text/plain; charset=UTF-8');
        exit('Set your Facebook page URL in site-config.json before use.');
    }

    return $url;
}
