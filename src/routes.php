<?php

namespace App\Controllers;

return [
    'hello/(.*)' => [MainController::class, 'sayHello'],
    '' => [MainController::class, 'main'],
];