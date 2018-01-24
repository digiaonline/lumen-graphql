<?php

namespace Digia\Lumen\GraphQL\Http\Middleware;

use Closure;
use Digia\JsonHelpers\JsonEncoder;
use Digia\Lumen\GraphQL\Models\GraphQLError;
use Digia\Lumen\GraphQL\Exceptions\MalformedNodeId;
use Digia\Lumen\GraphQL\Exceptions\EntityNotFoundException;
use Nord\Lumen\NewRelic\NewRelicMiddleware as BaseNewRelicMiddleware;
use Illuminate\Http\Request;

/**
 * Class NewRelicMiddleware
 * @package Digia\Lumen\GraphQL\Http\Middleware
 */
class NewRelicMiddleware extends BaseNewRelicMiddleware
{

    public const ATTRIBUTE_ERROR = __CLASS__ . '_error';

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        EntityNotFoundException::class,
        MalformedNodeId::class
    ];

    /**
     * @inheritDoc
     */
    public function handle(Request $request, Closure $next)
    {
        $response = parent::handle($request, $next);

        // Manually "notice" GraphQL errors
        $graphqlError = $request->attributes->get(self::ATTRIBUTE_ERROR);

        if ($graphqlError !== null) {
            $this->report($graphqlError);
        }

        return $response;
    }

    /**
     * Report GraphQLError to New Relic
     *
     * @param GraphQLError $graphQLError
     */
    protected function report(GraphQLError $graphQLError)
    {
        foreach ($graphQLError->getExceptions() as $exception) {
            if ($this->shouldReport($exception)) {
                $this->newRelic->noticeError(JsonEncoder::encode([
                    'query'     => $graphQLError->getQuery(),
                    'variables' => $graphQLError->getVariables(),
                    'message'   => $exception->getMessage()
                ]), $exception);
            }
        }
    }

    /**
     * Determine if the exception types is in the "do not report" list.
     *
     * @param \Exception $exception
     *
     * @return bool
     */
    protected function shouldReport(\Exception $exception)
    {
        foreach ($this->dontReport as $type) {
            if ($exception instanceof $type) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getTransactionName(Request $request)
    {
        // Use the "operation name" if available, otherwise fall back to parent implementation
        $operationName = $request->get('operationName');

        if ($operationName !== null) {
            return 'GraphQLController@' . $operationName;
        }

        return parent::getTransactionName($request);
    }

}
