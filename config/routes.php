<?php

return [
    '#^/(ru|en)($|/)#'=>Lira\Components\Lang::class,
    '#^/$#' => \Lira\Components\Front\Index\Index::class,
];