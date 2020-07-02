<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CustomersImport implements ToModel,WithHeadingRow, WithValidation, SkipsOnFailure
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
        return new Customer([
            //
            'last_name'     => $row['last_name'],
            'first_name'    => $row['first_name'],
            'email'    => $row['email'],
            'password'    => $row['password'],
            'address'    => $row['address'],
            'phone'    => $row['phone'],
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            'last_name' => 'required|max:191',
            'first_name' => 'required|max:191',
            'email' => 'required|unique:customers,email|email',
            'password' =>'required|min:1|max:8',
            'phone' => 'required|size:9',
            'address' => 'required'
        ];
    }
}
