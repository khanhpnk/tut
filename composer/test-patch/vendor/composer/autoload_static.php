<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb46435e2561780a4fe13bf67838c200a
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'cweagans\\Composer\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'cweagans\\Composer\\' => 
        array (
            0 => __DIR__ . '/..' . '/cweagans/composer-patches/src',
        ),
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/../..' . '/lib',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb46435e2561780a4fe13bf67838c200a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb46435e2561780a4fe13bf67838c200a::$prefixDirsPsr4;
            $loader->fallbackDirsPsr4 = ComposerStaticInitb46435e2561780a4fe13bf67838c200a::$fallbackDirsPsr4;

        }, null, ClassLoader::class);
    }
}