<?php

namespace Digia\Lumen\GraphQL\Tests;

use Digia\Lumen\GraphQL\Execution\Processor;
use Digia\Lumen\GraphQL\GraphQLService;
use Youshido\GraphQL\Schema\Schema;
use \Illuminate\Cache\Repository;

class ServiceTest extends TestCase
{
    /**
     * @var GraphQLService
     */
    protected $service;

    /**
     * @var Repository
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
        $this->cache = $this->getMockBuilder(\Illuminate\Cache\Repository::class)
                             ->disableOriginalConstructor()
                             ->getMock();

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

}
