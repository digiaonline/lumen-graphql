<?php

namespace Digia\Lumen\GraphQL\Http;

use Digia\JsonHelpers\JsonEncoder;
use Digia\Lumen\GraphQL\GraphQLService;
use Digia\Lumen\GraphQL\Models\GraphQLError;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Lumen\Routing\Controller;
use Symfony\Component\HttpFoundation\JsonResponse as SymfonyJsonResponse;

class GraphQLController extends Controller
{

    /**
     * @var GraphQLService
     */
    private $graphqlService;

    /**
     * GraphQLController constructor.
     *
     * @param GraphQLService $graphqlService
     */
    public function __construct(GraphQLService $graphqlService)
    {
        $this->graphqlService = $graphqlService;
    }

    /**
     * @param Request $request
     *
     * @return SymfonyJsonResponse
     */
    public function process(Request $request)
    {
        $processor = $this->graphqlService->getProcessor();

        $query     = $request->get('query');
        $variables = $request->get('variables', []);

        $responseData = $processor->processPayload($query, $variables)->getResponseData();

        if (isset($responseData['exceptions'])) {
            $request->attributes->set($this->getErrorAttribute(), new GraphQLError(
                $query, $variables, $responseData['exceptions']
            ));
        }

        $json = $this->responseDataToJson($responseData);

        return new SymfonyJsonResponse($json, 200, [], true);
    }

    /**
     * @return string
     */
    protected function getErrorAttribute()
    {
        return config('graphql.error_attribute', __CLASS__ . '_error');
    }

    /**
     * Renders the GraphiQL interactive query interface.
     *
     * @return View
     */
    public function renderGraphiQL()
    {
        return view('graphql::graphiql');
    }

    /**
     * @param array $responseData
     * @return string
     */
    protected function responseDataToJson(array $responseData)
    {
        return JsonEncoder::encode(array_except($responseData, ['exceptions']));
    }
}
