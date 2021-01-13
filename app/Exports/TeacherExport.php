<?php

namespace App\Exports;

use App\Model\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;

class TeacherExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Teacher::exportExcel();
    }
}
