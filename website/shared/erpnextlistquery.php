<?php
class ERPNextListQuery
{
    private array $params = [
        'fields' => null,
        'filters' => null,
        'limit_page_length' => null,
        'limit_start' => null,
        'expand' => null
    ];

    function __construct(?array $fields = null, ?array $filters = null, ?int $pageLength = null, ?int $startPage = null, ?array $expand = null)
    {
        $this->setFields($fields);
        $this->setFilters($filters);
        $this->setPageLength($pageLength);
        $this->setStartPage($startPage);
        $this->setExpands($expand);
    }


    public function setFields(?array $fields)    { $this->setParam('fields', $fields); }
    public function setFilters(?array $filters)  { $this->setParam('filters', $filters); }
    public function setPageLength(?int $length)  { $this->setParam('limit_page_length', $length); }
    public function setStartPage(?int $page)     { $this->setParam('limit_start', $page); }
    public function setExpands(?int $fields)     { $this->setParam('expand', $fields); }


    private function setParam (string $key, mixed $val)
    {
        if (!empty($val))
        {
            $this->params[$key] = is_array($val) ? $this->stringifyArray($val) : strval($val);
        }
        else
        {
            $this->params[$key] = '';
        }
    }


    private function stringifyArray(array $a) : string
    {
        $ret = '';

        foreach ($a as $key => $value)
        {
            // If there are earlier entries, add ',' first
            if (!empty($ret)) { $ret .= ','; }

            // If entry is array, run this function on it. Otherwise, encode and wrap in "quatation marks".
            $ret .= (is_array($value)) ?
                    $this->stringifyArray($value) : // To understand recursion you must first understand recursion :)
                    '"' . rawurlencode($value) . '"';
        }

        return empty($ret) ? $ret : '['.$ret.']';
    }


    public function queryString()
    {
        $qs = '';

        foreach ($this->params as $param => $val)
        {
            if (!empty($val))
            {
                $qs .= (empty($qs) ? '?' : '&') . $param . '=' . $val;
            }
        }

        return $qs;
    }
}
?>
