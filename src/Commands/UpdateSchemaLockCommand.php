<?php

namespace Digia\Lumen\GraphQL\Commands;

use Digia\Lumen\GraphQL\Helpers\JsonEncoder;
use Digia\Lumen\GraphQL\GraphQLService;
use Digia\Lumen\GraphQL\LockFile;
use Illuminate\Console\Command;
use Jalle19\Laravel\LostInterfaces\Console\Command as CommandInterface;

/**
 * Class UpdateSchemaLockCommand
 * @package Digia\Lumen\GraphQL\Commands
 */
class UpdateSchemaLockCommand extends Command implements CommandInterface
{

    /**
     * @var string
     */
    protected $signature = 'graphql:schema:lock:update';

    /**
     * @var string
     */
    protected $description = 'Updates the schema.lock file';

    /**
     * @var GraphQLService
     */
    private $graphQlService;

    /**
     * UpdateSchemaLockCommand constructor.
     *
     * @param GraphQLService $graphQlService
     */
    public function __construct(GraphQLService $graphQlService)
    {
        parent::__construct();

        $this->graphQlService = $graphQlService;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $response = $this->graphQlService->getStoredQueryResponse('graphql/Introspection.graphql');

        file_put_contents(LockFile::getAbsolutePath(), JsonEncoder::encode($response));
    }
}
