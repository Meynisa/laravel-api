<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter {
    protected $safeParms = [];

    protected $columnMap = [];

    protected $operatorMap = [];

    public function transform(Request $request) {
        $eloQuery = [];

        foreach ($this->safeParms as $parm => $operators) {
            $query = $request->query($parm);

            if (!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            // If the query is not an array (no operator brackets), assume 'eq'
            if (!is_array($query)) {
                if (in_array('eq', $operators)) {
                    $eloQuery[] = [$column, '=', $query];
                }
                continue;
            }

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[($operator)], $query[$operator]];
                }
            }
        }

        return $eloQuery;
    }
}