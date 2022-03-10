<?php

function chargerClasse($classe)
{

    $backslash = '\\';
    $file = str_replace($backslash, DIRECTORY_SEPARATOR, $classe).'.php';

    require $file;
}

spl_autoload_register('chargerClasse');