<?php

namespace app\Filters;

use Illuminate\Http\Request;

class ApiFilter
{
    /**
     * @var array
     */
    protected array $safeParms = [];
    /**
     * @var array
     */
    protected array $columnMap = [];
    /**
     * @var array|string[]
     */
    protected array $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'ne' => '!=',
        'lk' => 'LIKE',
        'bt' => 'BETWEEN',
        'in' => 'IN',
        'nlk' => 'NOT LIKE',
        'nbt' => 'NOT BETWEEN',
        'nin' => 'NOT IN',
    ];

    /**
     * @param Request $request
     * @return array
     */

    public function transform(Request $request): array
    {
        $eloQuery = [];

        foreach ($this->safeParms as $parm => $operators) {
            $query = $request->query($parm);
            if (!$query) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $value = $query[$operator];
                    $eloQuery[] = $this->buildQuery($column, $operator, $value);
                }
            }
        }

        return $eloQuery;
    }

    /**
     * @param $column
     * @param $operator
     * @param $value
     * @return array|null
     */
    private function buildQuery($column, $operator, $value): ?array
    {
        $mappedOperator = $this->operatorMap[$operator] ?? null;
        if (!$mappedOperator) {
            return null;
        }

        if (in_array($operator, ['lk', 'nlk'])) {
            return [$column, $mappedOperator, '%' . $value . '%'];
        }

        if (in_array($operator, ['bt', 'nbt'])) {
            if (is_array($value) && count($value) === 2) {
                return [$column, $mappedOperator, $value];
            }
        }

        if (in_array($operator, ['in', 'nin'])) {
            if (is_array($value)) {
                return [$column, $mappedOperator, $value];
            }
        }

        return [$column, $mappedOperator, $value];
    }
}