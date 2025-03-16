<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9a526cc6eedc76eb1a8baf8c80e27119
{
    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'setasign\\Fpdi\\' => 14,
        ),
        'T' => 
        array (
            'Test\\Package\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'setasign\\Fpdi\\' => 
        array (
            0 => __DIR__ . '/..' . '/setasign/fpdi/src',
        ),
        'Test\\Package\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'FPDF' => __DIR__ . '/..' . '/setasign/fpdf/fpdf.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9a526cc6eedc76eb1a8baf8c80e27119::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9a526cc6eedc76eb1a8baf8c80e27119::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9a526cc6eedc76eb1a8baf8c80e27119::$classMap;

        }, null, ClassLoader::class);
    }
}
