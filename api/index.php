<?php

$compiled = getenv('VIEW_COMPILED_PATH') ?: ($_SERVER['VIEW_COMPILED_PATH'] ?? null);

if (is_string($compiled) && $compiled !== '' && ! is_dir($compiled)) {
    @mkdir($compiled, 0777, true);
}

require __DIR__.'/../public/index.php';
