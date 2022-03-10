<?php

$twig = new \Twig\Environment($loader, [
    'debug' => true,
    // ...
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());