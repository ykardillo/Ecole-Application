<?php

namespace App\Exports;

use App\Model\Student;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentHasToPayExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::getStudentsWhoHaventPaidExcel();
    }
}
