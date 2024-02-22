<?php

namespace App\Imports;


use App\Models\Product;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportUsers implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $data = [
            'id' => $row[0],
            'title' => $row[1],
            'alias' => $row[2],
            'price' => $row[3],
            'show_price' => $row[4] ?? (string) "0",
            'old_price' => $row[5],
            'brend' => $row[6],
            'collection' => $row[7],
            'new' => $row[8],
            'articular' => $row[9],
            'products_like' => $row[10],
            'parent_id' => $row[11],
            'keywords' => $row[12],
            'description' => $row[13],
            'description2' => $row[14],
            'sort' => $row[15] ?? 0,
            'hits' => (string)$row[16],
            'seo_h1' => $row[17],
            'seo_title' => $row[18],
            'seo_description' => $row[19],
            'seo_keywords' => $row[20],
            'seo_text' => $row[21],
            'blueprints_text' => $row[22],
            'status' => (string)$row[23],
            'created_at' => $row[24],
            'updated_at' => $row[25],
            'measurement' => $row[26],

        ];
//        dump($row);
//        $product = Product::updateOrCreate(['alias' => $row[4]], $data);


        if ($row[0] != "ID"){
            $product = Product::updateOrCreate([
                'alias' => $row[2]
            ], array_merge($data, []));
            return $product;
        }
//

    }
}
