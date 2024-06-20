<?php

namespace App\Imports;

use App\CategoryModel;
use Maatwebsite\Excel\Concerns\ToModel;

class Imports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CategoryModel([
            'category_name' => $row[0],
            'meta_keywords' => $row[1],
            'category_desc' => $row[2],
            'category_status' => $row[3],
        ]);
    }
}
