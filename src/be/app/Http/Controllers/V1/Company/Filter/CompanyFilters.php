<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1\Company\Filter;

use App\Filters\ApiFilter;

class CompanyFilters extends ApiFilter
{
    /**
     * @var array[]
     */
    protected array $safeParms = [
        'name' => ['eq', 'lk', 'nlk'],
        'description' => ['eq', 'lk', 'nlk'],
        'status' => ['eq', 'ne', 'in'],
        'createdAt' => ['eq', 'lk', 'lt', 'lte', 'gt', 'gte', 'ne', 'in', 'nin', 'bt', 'nbt'],
        'updatedAt' => ['eq', 'lk', 'lt', 'lte', 'gt', 'gte', 'ne', 'in', 'nin', 'bt', 'nbt'],
    ];
    /**
     * @var string[]
     */
    protected array $columnMap = [
        'name' => 'name',
        'description' => 'description',
        'status' => 'status',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

}
