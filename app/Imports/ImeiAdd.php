<?php

namespace App\Imports;

use Log;
use App\Models\TestIMEI;



use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

// class ImportProduct implements ToModel
class ImeiAdd implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.imei' => 'required|string|digits:15|unique:test_imei,imei_1',
         ])->validate();

        foreach ($rows as $row)
        {
            $imei = new TestIMEI;
            $imei->imei_1 = $row['imei'];
            $imei->save();
        }

    }
}
