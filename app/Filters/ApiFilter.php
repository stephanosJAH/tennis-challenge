<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{
    /**
     * The safe parameters.
     * 
     * @var array
     */
    protected $safeParameters = [];

    /**
     * The columns map.
     * 
     * @var array
     */
    protected $columnsMap = [];

    /**
     * The operators map.
     * 
     * @var array
     */
    protected $operatorsMap = [];

    /**
     * Generate the where clause for the query.
     * 
     * @param array $safeParameters
     * @param array $columnsMap
     * @param array $operatorsMap
     */
    public function where(Request $request)
    {
        $eloQuery = [
            'where' => [],
            'where_in' => []
        ];

        foreach ($this->safeParameters as $param => $operators) {
            $query = $request->query($param);

            if (!$query) continue;

            $column = $this->columnsMap[$param] ?? $param;

            foreach ($operators as $operator) {

                if(!isset($query[$operator])) continue;

                $queryParam = null;
                $queryParamIn = null;

                switch ($this->operatorsMap[$operator]) {
                    case 'in':
                        $queryParamIn = explode(',', $query[$operator]);
                        break;
                    case 'like':
                        $queryParam = "%{$query[$operator]}%";
                        break;
                    default:
                        $queryParam = $query[$operator];
                        break;
                }

                if ($queryParamIn)
                    $eloQuery['where_in'][] = [$column, $queryParamIn];

                if ($queryParam)
                    $eloQuery['where'][] = [$column, $this->operatorsMap[$operator], $queryParam];
            }
        }

        return $eloQuery;
    }

    /**
     * Generate the order by clause for the query.
     * 
     * @param Request $request
     * @return array
     */
    public function orderBy(Request $request)
    {
        $order = $request->query('order_by');
        $direction = $request->query('direction');

        if ($order && $direction) {
            return [$order, $direction];
        }

        return ['id', 'desc'];
    }

    /**
     * Generate the pagination for the query.
     * 
     * @param Request $request
     * @return array
     */
    public function paginate(Request $request)
    {
        $perPage = $request->query('per_page');
        
        return $perPage ?? 1000;
    }

}