<?php

namespace Digia\Lumen\GraphQL;

use Digia\Lumen\GraphQL\Contracts\TypeResolverInterface;
use Youshido\GraphQL\Execution\Processor;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class GraphQLService
{

    /**
     * The cache key used when caching processor instances
     */
    const PROCESSOR_CACHE_KEY = 'graphql_processor';

    /**
     * Path to graphql introspection file
     */
    const INTROSPECTION_QUERY_PATH = 'graphql/Introspection.graphql';


    /**
     * @var Processor
     */
    private $processor;

    /**
     * @var TypeResolverInterface
     */
    private $typeResolver;

    /**
     * @var CacheRepository
     */
    private $cacheRepository;

    /**
     * GraphQLController constructor.
     *
     * @param Processor $processor
     */
    public function __construct(Processor $processor, CacheRepository $cacheRepository)
    {
        $this->processor       = $processor;
        $this->cacheRepository = $cacheRepository;
    }

    /**
     * Processor instantiation takes a while so we cache the instance forever. The processor cache can be cleared by
     * running "php artisan graphql:clear:processor:cache".
     *
     * @return Processor
     */
    public function getProcessor()
    {
        $processor = $this->cacheRepository->get(self::PROCESSOR_CACHE_KEY);

        if ($processor === null) {
            $processor = $this->processor;

            $this->cacheRepository->forever(self::PROCESSOR_CACHE_KEY, $processor);
        }

        return $processor;
    }

    /**
     * Removes the currently cached processor instance, if any
     */
    public function forgetProcessor()
    {
        $this->cacheRepository->forget(self::PROCESSOR_CACHE_KEY);
    }

    /**
     * @return array
     */
    public function getIntrospectionQueryResponse(): array
    {
        return $this->getProcessor()->processPayload($this->getIntrospectionQuery())->getResponseData();
    }

    /**
     * @return string
     *
     * @throws FileNotFoundException
     */
    private function getIntrospectionQuery(): string
    {
        $path = resource_path(self::INTROSPECTION_QUERY_PATH);

        if (!file_exists($path)) {
            throw new FileNotFoundException('Could not find introspection query file');
        }

        return file_get_contents($path);
    }
}
