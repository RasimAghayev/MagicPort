<?php

namespace app\Filters\V1;

use App\Filters\ApiFilter;

class TaskFilters extends ApiFilter
{
    /**
     * @var array[]
     */
    protected array $safeParms = [
        'companyId' =>  ['eq', 'lt', 'lte', 'gt', 'gte', 'ne', 'in', 'nin', 'bt', 'nbt'],
        'userId' => ['eq', 'lt', 'lte', 'gt', 'gte', 'ne', 'in', 'nin', 'bt', 'nbt'],
        'projectId' => ['eq', 'lt', 'lte', 'gt', 'gte', 'ne', 'in', 'nin', 'bt', 'nbt'],
        'description' => ['eq', 'lk'],
        'status' => ['eq', 'ne', 'in'],
        'createdAt' => ['eq', 'lk', 'lt', 'lte', 'gt', 'gte', 'ne', 'in', 'nin', 'bt', 'nbt'],
        'updatedAt' => ['eq', 'lk', 'lt', 'lte', 'gt', 'gte', 'ne', 'in', 'nin', 'bt', 'nbt'],
    ];
    /**
     * @var string[]
     */
    protected array $columnMap = [
        'companyId' =>  'company_id',
        'userId' => 'user_id',
        'projectId' => 'project_id',
        'name' => 'name',
        'description' => 'description',
        'status' => 'status',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];
}
