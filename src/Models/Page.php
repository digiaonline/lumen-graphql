<?php

namespace Digia\Lumen\GraphQL\Models;

class Page
{

    const DEFAULT_SIZE = 10;

    /**
     * The actual data.
     *
     * @var array
     */
    private $data;

    /**
     * The amount of total items on this page.
     *
     * @var int
     */
    private $total;

    /**
     * The index of the first index on this page. (defaults to 0)
     *
     * @var int
     */
    private $from;

    /**
     * Page constructor.
     *
     * @param array    $data
     * @param int|null $total
     * @param int      $from
     */
    public function __construct(array $data, $total = null, $from = 0)
    {
        $this->data  = $this->keyData($data, $from);
        $this->total = $total ?: count($data);
        $this->from  = $from;
    }

    /**
     * @return mixed
     */
    public function getFirst()
    {
        return !empty($this->data) ? head($this->data) : null;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param array $data
     * @param int   $from
     *
     * @return array
     */
    private function keyData(array $data, $from)
    {
        $newData = [];

        foreach ($data as $index => $item) {
            $newData[(string)($from + $index)] = $item;
        }

        return $newData;
    }
}
