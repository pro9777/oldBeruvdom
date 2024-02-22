<?php

namespace App\Http\exel;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
class ProductImport
{

    public function model(array $row)
    {
        return new User([
            'name' => $row[0],
            'email' => $row[1],
            'password' => $row[2],
        ]);
    }

}
