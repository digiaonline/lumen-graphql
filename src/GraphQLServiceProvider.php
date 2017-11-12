<?php

namespace Digia\Lumen\GraphQL;

use Digia\Lumen\GraphQL\Contracts\TypeResolverInterface;
use Digia\Lumen\GraphQL\Exceptions\InvalidConfigurationException;
use Digia\Lumen\GraphQL\Http\GraphiQLTokenMiddleware;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;
use Youshido\GraphQL\Execution\Processor;

class GraphQLServiceProvider extends ServiceProvider
{

    /**
     * @inheritdoc
     */
    public function register()
    {
        // Configure
        $this->app->configure('graphql');
        $this->loadViewsFrom(dirname(__DIR__) . '/resources/views', 'graphql');
        $config = config('graphql');
        $this->validateConfig($config);

        // Bind things to the container
        $this->app->singleton(GraphQLService::class, function (Application $app) use ($config) {
            $processor = $config['processor'] ?? Processor::class;

            return new GraphQLService(new $processor(new $config['schema']), $app->make(CacheRepository::class));
        });

        $this->app->singleton(TypeResolverInterface::class, function () use ($config) {
            return new $config['type_resolver']();
        });

        $this->app->bind(GraphiQLTokenMiddleware::class, function () use ($config) {
            return new GraphiQLTokenMiddleware($config['enable_graphiql'], $config['graphiql_token'] ?? null);
        });
    }

    /**
     * @param array $config
     *
     * @throws InvalidConfigurationException
     */
    protected function validateConfig(array $config)
    {
        if (!isset($config['schema'])) {
            throw new InvalidConfigurationException('Configuration value `schema` is required.');
        }

        if (!isset($config['type_resolver'])) {
            throw new InvalidConfigurationException('Configuration value `type_resolver` is required.');
        }
    }
}
