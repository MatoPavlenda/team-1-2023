<?php
namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class EditDbRecordService
{
    public function editRecord($record, $data)
    {
        foreach ($data as $column) {
            if ($column[1] !== null) {
                if ($column[1] == -1) {
                    $record->{$column[0]} = null;
                } else {
                    $record->{$column[0]} = $column[1];
                }
            }
        }

        return $record;
    }
}