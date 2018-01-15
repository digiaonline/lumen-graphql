<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

$app->register(\Digia\Lumen\GraphQL\GraphQLServiceProvider::class);

return $app;
