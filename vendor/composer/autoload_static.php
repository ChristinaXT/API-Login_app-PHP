<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5a4c8f9d8ff2edf9071d9784f5ebd928
{
    public static $prefixesPsr0 = array (
        'M' => 
        array (
            'Monolog' => 
            array (
                0 => __DIR__ . '/..' . '/monolog/monolog/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit5a4c8f9d8ff2edf9071d9784f5ebd928::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit5a4c8f9d8ff2edf9071d9784f5ebd928::$classMap;

        }, null, ClassLoader::class);
    }
}