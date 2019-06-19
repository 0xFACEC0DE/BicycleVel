<?php

use Bicycle\Lib\App;

require __DIR__ . '/../vendor/autoload.php';

try {
    App::run();
} catch (Exception $e){
    App::abortWithErrorPage($e->getMessage(), 500);
}