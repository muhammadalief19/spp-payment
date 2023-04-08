<?php 
// root Controller
spl_autoload_register(function( $class ){
    require_once __DIR__ . './Controller/' . $class . '.php';
});

// siswa
spl_autoload_register(function( $class ){
    require_once __DIR__ . '../Controller/db-siswa/' . $class . '.php';
});

// kompetensi
spl_autoload_register(function( $class ){
    require_once __DIR__ . '../Controller/db-kompetensi/' . $class . '.php';
});

// kelas
spl_autoload_register(function( $class ){
    require_once __DIR__ . '../Controller/db-kelas/' . $class . '.php';
});

// spp
spl_autoload_register(function( $class ){
    require_once __DIR__ . '../Controller/db-spp/' . $class . '.php';
});

// petugas
spl_autoload_register(function( $class ){
    require_once __DIR__ . '../Controller/db-petugas/' . $class . '.php';
});

// transaksi
spl_autoload_register(function( $class ){
    require_once __DIR__ . '../Controller/db-transaksi/' . $class . '.php';
});