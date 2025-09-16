<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/environment.php';

$isDevMode = env('APP_ENV', 'development') === 'development';

$config = ORMSetup::createAttributeMetadataConfiguration(
    [__DIR__ . '/../app/Entities'],
    $isDevMode
);

$connectionParams = [
    'driver' => env('DB_DRIVER'),
    'host' => env('DB_HOST'),
    'port' => env('DB_PORT'),
    'dbname' => env('DB_NAME'),
    'user' => env('DB_USER'),
    'password' => env('DB_PASSWORD'),
];

try {
    $connection = DriverManager::getConnection($connectionParams);
    $entityManager = new EntityManager($connection, $config);

    return $entityManager;
} catch (\Exception $e) {
    echo "ERRO AO CONECTAR NO BANCO DE DADOS:\n";
    echo $e->getMessage() . "\n";
    die;
}