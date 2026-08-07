<?php
declare(strict_types=1);

require __DIR__ . '/includes/redirectTarget.php';

$target = aswproject_get_facebook_redirect_url();

header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('Location: ' . $target, true, 302);
exit;
