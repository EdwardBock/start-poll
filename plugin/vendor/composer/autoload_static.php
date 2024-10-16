<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitee7d827deefa11a9aa8b18519a3d7c53
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Palasthotel\\WordPress\\StartPoll\\' => 32,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Palasthotel\\WordPress\\StartPoll\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitee7d827deefa11a9aa8b18519a3d7c53::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitee7d827deefa11a9aa8b18519a3d7c53::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitee7d827deefa11a9aa8b18519a3d7c53::$classMap;

        }, null, ClassLoader::class);
    }
}
