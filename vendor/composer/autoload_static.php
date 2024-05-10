<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdf4804476cb7e9be836316f40b17ead6
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Smalot\\PdfParser\\' => 
            array (
                0 => __DIR__ . '/..' . '/smalot/pdfparser/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdf4804476cb7e9be836316f40b17ead6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdf4804476cb7e9be836316f40b17ead6::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitdf4804476cb7e9be836316f40b17ead6::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitdf4804476cb7e9be836316f40b17ead6::$classMap;

        }, null, ClassLoader::class);
    }
}
