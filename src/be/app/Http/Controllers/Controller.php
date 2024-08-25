<?php

namespace App\Http\Controllers;

use RuntimeException;
use Illuminate\Routing\Controller as BaseController;
abstract class Controller extends BaseController
{
    /**
     * @throws RuntimeException
     */
    protected function checkIfModelExists($model, $conditions, $fieldName): void
    {

        $query = $model::query();
        foreach ($conditions as $column => $value) {
            $query->where($column, $value);
        }
        if (!$query->exists()) {
            $friendlyNames = [
                'id' => "{$fieldName} ID",
                'user_id' => 'User ID',
                'company_id' => 'Company ID',
                'project_id' => 'Project ID',
                'task_id' => 'Task ID',
            ];
            $conditionString = implode(', ', array_map(
                static fn($v, $k) => sprintf("%s = %s", $friendlyNames[$k] ?? $k, $v),
                $conditions,
                array_keys($conditions)
            ));
            $errorResponse = [
                'message' => "{$fieldName} with conditions ({$conditionString}) not found.",
                'status' => 'error'
            ];
            abort(response()->json($errorResponse, 404));
        }
    }

    /**
     * @param $model
     * @param $request
     * @param array $fields
     * @return void
     */
    protected function validateModelsExistence(array $fields): void
    {
        foreach ($fields as $field) {
            $conditions = [];
            foreach ($field['request'] as $column => $value) {
                $conditions[$column] = $value;
            }
            $this->checkIfModelExists(
                $field['model'],
                $conditions,
                $field['message']
            );
        }
    }
}
