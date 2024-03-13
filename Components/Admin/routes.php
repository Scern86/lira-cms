<?php

return [
    'default'=>[
        '#^/(login|logout)$#'=>\Lira\Components\Admin\Auth\Controller::class,
        '#^/$#' => \Lira\Components\Admin\Index\Index::class,
        '#^/article($|/)#'=>\Lira\Components\Admin\Article\Article::class,
        '#^/articles$#'=>\Lira\Components\Admin\Article\Articles::class,
        '#^/category($|/)#'=>\Lira\Components\Admin\Category\Category::class,
        '#^/categories#'=>\Lira\Components\Admin\Category\Categories::class,
        '#^/messages#'=>\Lira\Components\Admin\Messages\Messages::class,
        '#^/message#'=>\Lira\Components\Admin\Messages\Message::class,

    ]
];