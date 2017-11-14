<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
//$loader = require __DIR__.'/../vendor/autoload.php';
$loader = require '/var/www/vhosts/localhost.localdomain/httpdocs/Apps/symfonyapp/vendor/autoload.php';

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
