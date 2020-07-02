<?php

namespace App\Imports;

use App\Models\Flower;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class FlowersImport implements ToModel,WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //dd($row);
        return new Flower([
            //
            'catalog_id'     => $row['catalog_id'],
            'name'    => $row['name'],
            'color'    => $row['color'],
            'price'    => $row['price'],
            'discount'    => $row['discount'],
            'avatar'    => $row['avatar'],
            'images'    => $row['images'],
            'view'    => $row['view'],
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            'catalog_id' => 'required|exists:catalogs,id',
            'name' => 'required|max:191',
            'color' => 'nullable|alpha',
            'price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'avatar' => 'nullable|string',
            'images' => 'nullable|string',
            'view' => 'nullable|numeric'
        ];
    }
}
