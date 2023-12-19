<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DynamicFilterService
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function applyFilters(Model $model, array $columns)
    {
        $query = $model->newQuery();

        foreach ($columns as $column) {
            $value = $this->request->input($column);

            if ($value !== null) {
                // Check if the value contains wildcard characters for LIKE
                if (str_contains($value, '%')) {
                    $query->where($column, 'LIKE', $value);
                } else {
                    $query->where($column, $value);
                }
            }
        }

        // Get offset and limit from the request
        $offset = $this->request->input('offset');
        $limit = $this->request->input('limit');

        if (!is_null($offset) && is_numeric($offset)) {
            $query->offset($offset);
        }

        if (!is_null($limit) && is_numeric($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    public function getTotalRowCount(Model $model)
    {
        return $model->newQuery()->count();
    }
}
