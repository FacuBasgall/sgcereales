<?php

namespace App\Exports;

use App\Aviso;
use Maatwebsite\Excel\Concerns\FromCollection;

class RomaneoExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Aviso::all();
    }
}
