<?php

return [
    'default'=>[
        '#^/(en)($|/)#'=>Lira\Components\Lang::class,
        '#^/admin($|/)#' => \Lira\Components\Admin\Admin::class,
        '#^(?!/admin)($|/)#' => \Lira\Components\Front\Front::class,

    ],
];