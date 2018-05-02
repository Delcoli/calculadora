<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit35c84a40d5af541773ab2b875aae0f82
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'Util\\' => 5,
        ),
        'M' => 
        array (
            'Model\\Dao\\' => 10,
            'Model\\Classe\\' => 13,
        ),
        'C' => 
        array (
            'Controller\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Util\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Util',
        ),
        'Model\\Dao\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Model/Dao',
        ),
        'Model\\Classe\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Model/Class',
        ),
        'Controller\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Controller',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit35c84a40d5af541773ab2b875aae0f82::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit35c84a40d5af541773ab2b875aae0f82::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
