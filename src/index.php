<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Refactor\Application\Application;

set_exception_handler(function (\Exception $Exception) {
    http_response_code(500);
    echo 'Internal Error. Please try again';
    return;
});

$Application = new Application();
$Application->run();
