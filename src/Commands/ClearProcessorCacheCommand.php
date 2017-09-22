<?php

namespace Digia\Lumen\GraphQL\Commands;

use Digia\Lumen\GraphQL\GraphQLService;
use Illuminate\Console\Command;

class ClearProcessorCacheCommand extends Command
{

    /**
     * @var string
     */
    protected $signature = 'graphql:clear:processor:cache';

    /**
     * @var string
     */
    protected $description = 'Clears the GraphQL processor cache';

    /**
     * @var GraphQLService
     */
    private $graphqlService;

    /**
     * ClearProcessorCacheCommand constructor.
     *
     * @param GraphQLService $graphqlService
     */
    public function __construct(GraphQLService $graphqlService)
    {
        parent::__construct();
        
        $this->graphqlService = $graphqlService;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $this->graphqlService->forgetProcessor();
    }
}
