<?php

namespace App\Imports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Maatwebsite\Excel\Exceptions\EncryptedFileException;
use App\Imports\TransactionImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use function Pest\Laravel\json;

class TransactionProtectedImport implements ToCollection
{
    public $data;

    public function endColumn(): string
    {
        // Tentukan kolom terakhir yang ingin Anda impor
        return 'X'; 
    }

    public function collection(Collection $collection)
    {
        // Lakukan pemrosesan manual di sini
        $mappedCollection = $collection->map(function ($row) {
            return [
                $row[1], // B
                $row[2], // C
                $row[4], // E
                $row[5], // F
                $row[7], // H
                $row[8], // I
                $row[9], // J
                $row[10], // K
                $row[11], // L
                $row[12], // M
                $row[15], // P
                $row[16], // Q
                $row[18], // S
                $row[19], // T
                $row[21], // V
                $row[22], // W
                $row[23], // X
            ];
        });

        $this->data = $mappedCollection;
    }
    // public function importLockedExcel(Request $request)
    // {
    //     $file = $request->file('excel_file');

    // // Tentukan kata sandi
    // $password = 'password_anda_di_sini'; 

    // try {
    //     // Impor file Excel, berikan kata sandi sebagai opsi
    //     Excel::import(new TransactionImport($file,null,), $file, null, \Maatwebsite\Excel\Excel::XLSX, [
    //         'password' => $password
    //     ]);

    //     return back()->with('success', 'File berhasil diimpor!');

    // } catch (EncryptedFileException $e) {
    //     // Tangani jika kata sandi salah
    //     return back()->with('error', 'Kata sandi file Excel salah.');
        
    // } catch (\Exception $e) {
    //     // Tangani kesalahan lain
    //     return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    // }

    // }
}
