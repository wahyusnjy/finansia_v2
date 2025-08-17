<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class GeneralSheetImport implements ToCollection
{
    protected $saving;
    protected $desc;

    public function __construct($saving, $desc)
    {
        $this->saving = $saving;
        $this->desc = $desc;
    }

    public function collection(Collection $collection)
    {
        // Proses data dari setiap sheet
        foreach ($collection as $row) {
            // Tangani data per baris dari setiap sheet
        }
    }
}