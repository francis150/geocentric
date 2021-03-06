<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6c8d66727483bcede7b6d2c31017fc8b
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Appsero\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Appsero\\' => 
        array (
            0 => __DIR__ . '/..' . '/appsero/client/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6c8d66727483bcede7b6d2c31017fc8b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6c8d66727483bcede7b6d2c31017fc8b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6c8d66727483bcede7b6d2c31017fc8b::$classMap;

        }, null, ClassLoader::class);
    }
}
