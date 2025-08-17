<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class TransactionImport implements WithMultipleSheets
{
    protected $saving;
    protected $desc;

    public function __construct($saving, $desc)
    {
        $this->saving = $saving;
        $this->desc = $desc;
    }

    public function sheets(): array
    {
        return [
            '*' => new GeneralSheetImport($this->saving, $this->desc), // '*' menangani semua sheet
        ];
    }
}