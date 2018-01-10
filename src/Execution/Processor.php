<?php

namespace Digia\Lumen\GraphQL\Execution;

use Youshido\GraphQL\Execution\Processor as BaseProcessor;

class Processor extends BaseProcessor
{

    /**
     * @inheritdoc
     */
    public function getResponseData(): array
    {
        $result = [];

        if (!empty($this->data)) {
            $result['data'] = $this->data;
        }

        if ($this->executionContext->hasErrors()) {
            $result['errors']     = $this->executionContext->getErrorsArray();
            $result['exceptions'] = $this->executionContext->getErrors();
        }

        return $result;
    }
}
