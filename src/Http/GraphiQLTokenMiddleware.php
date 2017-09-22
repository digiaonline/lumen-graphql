<?php

namespace Digia\Lumen\GraphQL\Http;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GraphiQLTokenMiddleware
{

    /**
     * @var boolean
     */
    private $enableGraphiql;

    /**
     * @var string|null
     */
    private $graphiqlToken;

    /**
     * GraphiQLTokenMiddleware constructor.
     *
     * @param bool        $enableGraphiql
     * @param string|null $graphiqlToken
     */
    public function __construct($enableGraphiql, $graphiqlToken)
    {
        $this->enableGraphiql = $enableGraphiql;
        $this->graphiqlToken  = $graphiqlToken;
    }

    /**
     * @inheritDoc
     * @throws NotFoundHttpException if the interface is not enabled
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->enableGraphiql || ($this->graphiqlToken !== null && $request->get('token') === $this->graphiqlToken)) {
            return $next($request);
        }

        // Pretend the interface is not there if not enabled
        throw new NotFoundHttpException();
    }
}
