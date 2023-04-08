<?php 
// Root Controller
spl_autoload_register(function( $class ){
    require_once __DIR__ . '/' . $class . '.php';
    require_once __DIR__ . '/db-kompetensi' . $class . '.php';
    require_once __DIR__ . '/db-siswa' . $class . '.php';
});
