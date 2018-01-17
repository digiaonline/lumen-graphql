<?php

namespace Digia\Lumen\GraphQL\Tests;

use Digia\Lumen\GraphQL\Execution\Processor;
use Digia\Lumen\GraphQL\GraphQLService;
use Youshido\GraphQL\Schema\Schema;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class GraphQLServiceTest extends TestCase
{
    /**
     * @var GraphQLService
     */
    protected $service;

    /**
     * @var CacheRepository
     */
    protected $cache;

    /**
     * @var Processor
     */
    protected $processor;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|CacheRepository $cacheRepository */
        $this->cache = $this->getMockBuilder(CacheRepository::class)
                             ->setMethods(['get', 'forever'])
                             ->getMockForAbstractClass();

        $this->processor = new Processor(new Schema());
        $this->service = new GraphQLService($this->processor, $this->cache);
    }


    public function testGetProcessor()
    {
        $this->cache->expects($this->any())
                     ->method('get')
                     ->with(GraphQLService::PROCESSOR_CACHE_KEY)
                     ->willReturn($this->processor);

        $this->assertEquals($this->processor, $this->service->getProcessor());
    }

    /**
     * Tests that a processor instance is stored in the cache if it doesn't exist yet
     */
    public function testGetProcessorNotCached()
    {
        // get() should return null
        $this->cache->expects($this->once())
                        ->method('get')
                        ->willReturn(null);

        // forever() should be called
        $this->cache->expects($this->once())
                        ->method('forever')
                        ->with(GraphQLService::PROCESSOR_CACHE_KEY);

        $this->service->getProcessor();
    }

    /**
     * Tests that the cache is left untouched if a cached instance exists
     */
    public function testGetProcessorCached()
    {
        // get() should return Processor
        $this->cache->expects($this->once())
                        ->method('get')
                        ->willReturn($this->processor);

        // forever() should be never be called
        $this->cache->expects($this->never())
                        ->method('forever');
        $processor = new Processor(new Schema());

        $this->assertEquals($processor, $this->service->getProcessor());
    }

    /**
     * Tests that the cache is really cleared
     */
    public function testForgetProcessor()
    {
        // forget() should be called once
        $this->cache->expects($this->once())
                        ->method('forget')
                        ->with(GraphQLService::PROCESSOR_CACHE_KEY);

        $this->service->forgetProcessor();
    }
}
