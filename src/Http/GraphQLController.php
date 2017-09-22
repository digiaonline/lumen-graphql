<?php

namespace Digia\Lumen\GraphQL\Http;

use Digia\Lumen\GraphQL\GraphQLService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Lumen\Routing\Controller;

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
     * @return JsonResponse
     */
    public function process(Request $request)
    {
        $processor = $this->graphqlService->getProcessor();

        $query     = $request->get('query');
        $variables = $request->has('variables') ? $request->get('variables') : [];

        $responseData = $processor->processPayload($query, $variables)->getResponseData();

        return response()->json($this->responseDataToJson($responseData));
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
        return json_encode($responseData);
    }
}
