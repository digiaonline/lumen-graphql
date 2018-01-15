<?php

namespace Digia\Lumen\GraphQL;

use Youshido\GraphQL\Execution\Processor;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class GraphQLService
{

    /**
     * The cache key used when caching processor instances
     */
    public const PROCESSOR_CACHE_KEY = 'graphql_processor';

    /**
     * Path to graphql introspection file
     */
    public const INTROSPECTION_QUERY_PATH = 'graphql/Introspection.graphql';


    /**
     * @var Processor
     */
    private $processor;

    /**
     * @var CacheRepository
     */
    private $cacheRepository;

    /**
     * GraphQLController constructor.
     *
     * @param Processor       $processor
     * @param CacheRepository $cacheRepository
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
     * @param string $queryResourcePath
     * @param array  $variables
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getStoredQueryResponse(string $queryResourcePath, array $variables = []): array
    {
        return $this->getQueryResponse($this->getStoredQuery($queryResourcePath), $variables);
    }

    /**
     * @param string $query
     * @param array  $variables (optional)
     *
     * @return array
     *
     * @throws \Exception any underlying exception that occurred while processing the request
     */
    private function getQueryResponse(string $query, array $variables = []): array
    {
        $processor = $this->getProcessor();
        $response  = $processor->processPayload($query, $variables)->getResponseData();

        // Re-throw exceptions, we are not technically doing GraphQL
        if (isset($response['exceptions'])) {
            throw $response['exceptions'][0];
        }

        return $response;
    }

    /**
     * @param string $resourcePath
     *
     * @return string
     *
     * @throws FileNotFoundException
     */
    private function getStoredQuery(string $resourcePath): string
    {
        $path = resource_path($resourcePath);

        if (!file_exists($path)) {
            throw new FileNotFoundException('Could not find the specified query file');
        }

        return file_get_contents($path);
    }
}
