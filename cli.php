#!/usr/bin/env php
<?php 

require __DIR__. "/vendor/autoload.php";

use Cmd\LoadTest;

if(PHP_SAPI !== 'cli') { 
    die("Script permitido apenas no terminal.");
}

function show()
{
    echo "***** Como usar: cli.php <command> *****\n";
    echo "*";
    echo "*";
    echo "*";
    echo "***** Comandos: *****\n";
    echo "*";
    echo "*";
    echo "*";
    echo "***** load-test     Faz a insercao de 1000000 produtos teste no banco. *****\n";
}

function handler(array $argv)
{
    array_shift($argv);   
    $cmd = $argv[0];

    switch($cmd){
        case 'load-test': 
            $cmd = new LoadTest();
            $cmd->handler();
            break;
        default: 
            echo "Comando nao encontrado";
            show();
            exit(1);
    }
}

if(empty($argv)) {
    show();
    exit(1);
}

handler($argv);
