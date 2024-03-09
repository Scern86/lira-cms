<?php

return [
    'default'=>[
        '#^/(login|logout)$#'=>\Lira\Components\Admin\Auth\Controller::class,
        '#^/$#' => \Lira\Components\Admin\Index\Index::class,
    ]
];