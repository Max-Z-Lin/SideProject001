<?php

namespace App\Imports;

use App\CleanBox;
use Maatwebsite\Excel\Concerns\ToModel;

class CleanBoxImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CleanBox([
            //
        ]);
    }
}
