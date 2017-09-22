<?php

namespace Digia\Lumen\GraphQL;

use Digia\Lumen\GraphQL\Exception\InvalidConfigurationException;
use Digia\Lumen\GraphQL\Http\GraphiQLTokenMiddleware;
use Digia\Lumen\GraphQL\Contracts\TypeResolverInterface;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use Youshido\GraphQL\Execution\Processor;

class GraphQLServiceProvider extends ServiceProvider
{

    /**
     * @inheritdoc
     */
    public function boot()
    {
        $basePath   = dirname(__DIR__);
        $configPath = $basePath . '/config/graphql.php';

        if ($this->app instanceof LumenApplication) {
            $this->app->configure('graphql');
        } else {
            $this->publishes([$configPath => config_path('graphql.php')]);
        }

        $this->mergeConfigFrom($configPath, 'graphql');

        $this->loadViewsFrom($basePath . '/resources/views', 'graphql');
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $config = config('graphql');

        $this->validateConfig($config);

        $this->app->singleton(GraphQLService::class, function (Application $app) use ($config) {
            $processor = $config['processor'] ?: Processor::class;

            return new GraphQLService(new $processor(new $config['schema']), $app->make(CacheRepository::class));
        });

        $this->app->singleton(TypeResolverInterface::class, function () use ($config) {
            return new $config['type_resolver']();
        });

        $this->app->bind(GraphiQLTokenMiddleware::class, function () use ($config) {
            return new GraphiQLTokenMiddleware($config['enable_graphiql'], $config['graphiql_token']);
        });
    }

    /**
     * @param array $config
     * @throws InvalidConfigurationException
     */
    protected function validateConfig(array $config)
    {
        if (!isset($config['schema'])) {
            throw new InvalidConfigurationException('Configuration value `schema` is required.');
        }

        if (!isset($config['typeResolver'])) {
            throw new InvalidConfigurationException('Configuration value `type_resolver` is required.');
        }
    }
}
