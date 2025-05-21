<?php

namespace App;

use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Nette\DI\Extensions\DIExtension;
use Nette\DI\Extensions\ExtensionsExtension;
use Nette\StaticClass;

class DependencyContainer
{
    use StaticClass;

    private static ?Container $container = null;

    public static function i(): Container
    {
        self::createDirs();

        if (self::$container !== null) {
            return self::$container;
        }

        $loader = new ContainerLoader(__DIR__ . '/../tmp', true);

        $class = $loader->load(function (Compiler $compiler) {
            $compiler->loadConfig(__DIR__ . '/../config/config.neon');
            $compiler->loadConfig(__DIR__ . '/../config/services.neon');

            $compiler->addExtension('di', new DIExtension());
//            $compiler->addExtension('extensions', new ExtensionsExtension());
        });

        /** @var Container $container */
        $container = new $class;

        self::$container = $container;

        return self::$container;
    }

    private static function createDirs(): void
    {
        if (!file_exists(__DIR__ . '/../tmp')) {
            mkdir(__DIR__ . '/../tmp');
        }
    }
}
