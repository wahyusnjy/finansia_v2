<?php

namespace App\Imports;

use App\Models\Bank;
use App\Models\Items;
use App\Models\Saving;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

// use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class TransactionImport implements ToModel, WithHeadingRow
{
    protected $saving;
    protected $desc;
    private $transaksi_in = null;
    private $transaksi_out = null;

    public function __construct($saving, $desc)
    {
        $this->saving = $saving;
        $this->desc = $desc;
    }

    public function model(array $row)
    {
        // Proses data dari setiap sheet
        dd($row);
        if(!$this->saving){
            Log::error("Import Error, Saving ID Not Found");
            return;
        }

        $saving = Saving::find($this->saving);
        if(!$saving){
            Log::error("Import Error, Bank Not Found");
            return;
        }
        $this->subQuery($saving, $row);
    }

    private function formatAngka($angka) {
        return floatval(str_replace(',', '.', str_replace('.', '', $angka)));
    }

    public function subQuery($saving, $row){
        $bank = Bank::find($saving->bank_id);
        if($bank->name == 'BANK MANDIRI'){
            // Buat transaksi jika belum ada
            if (!isset($this->transaksi_in) && !empty($row['dana_masuk_idr'])) {
                $this->transaksi_in = Transaction::create([
                    'save_id' => 2,
                    'type' => 'Cash In'
                ]);
            }

            if (!isset($this->transaksi_out) && !empty($row['dana_keluar_idr'])) {
                $this->transaksi_out = Transaction::create([
                    'save_id' => 2,
                    'type' => 'Cash Out'
                ]);
            }

            // Inisialisasi total transaksi
            $total_masuk = 0;
            $total_keluar = 0;
            $items_masuk = [];
            $items_keluar = [];

            // Jika ada dana masuk, buat items
            if (!empty($row['dana_masuk_idr']) && isset($this->transaksi_in->id)) {
                $formatted_total = $this->formatAngka($row['dana_masuk_idr']); // Format angka sekali saja
                $total_masuk += $formatted_total;

                $item = Items::create([
                    'transaction_id' => $this->transaksi_in->id,
                    'name' => $row['keterangan'],
                    'quantity' => 1,
                    'total' => $formatted_total,
                    'grand_total' => 0, // Nanti diupdate
                    'tr_date' => Carbon::parse($row['tanggal']),
                ]);
                $items_masuk[] = $item->id;
            }

            // Jika ada dana keluar, buat items
            if (!empty($row['dana_keluar_idr']) && isset($this->transaksi_out->id)) {
                $formatted_total = $this->formatAngka($row['dana_keluar_idr']); // Format angka sekali saja
                $total_keluar += $formatted_total;

                $item = Items::create([
                    'transaction_id' => $this->transaksi_out->id,
                    'name' => $row['keterangan'],
                    'quantity' => 1,
                    'total' => $formatted_total,
                    'grand_total' => 0, // Nanti diupdate
                    'tr_date' => Carbon::parse($row['tanggal']),
                ]);
                $items_keluar[] = $item->id;
            }

            // Update grand_total untuk semua items dalam transaksi yang sama
            if (!empty($items_masuk)) {
                Items::whereIn('id', $items_masuk)->update(['grand_total' => $total_masuk]);
            }

            if (!empty($items_keluar)) {
                Items::whereIn('id', $items_keluar)->update(['grand_total' => $total_keluar]);
            }
        }elseif($bank->name == 'BANK BRI'){
            return $this->brimo($row);
        }elseif($bank->name == 'BANK JAGO'){
            return $this->jago($row);
        }
    }

    public function jago($row){

    }

    public function brimo($row){

    }
}
