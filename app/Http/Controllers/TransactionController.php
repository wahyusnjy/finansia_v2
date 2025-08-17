<?php

namespace App\Http\Controllers;

use App\Imports\TransactionImport;
use App\Models\Transaction;
use App\Models\Items;
use App\Models\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaction = Transaction::orderBy('created_at','DESC')->paginate(10);
        $saving = Saving::where('user_id',Auth::user()->id)->get();
        return view('pages.transaksi.transaksi')
        ->with('transaction',$transaction)
        ->with('saving',$saving);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $saving = Saving::where('user_id',Auth::user()->id)->get();
        return view('pages.transaksi.create')
        ->with('saving',$saving);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $all = $request->all();
        $duarr = explode(',', $request->grand_total);
        $grand_total = implode($duarr);

        $query= [
                'save_id' => $request->save_id,
                'business_id' => $request->business_id,
                'type' => $request->type,
                'description' => $request->description,
            ];
        // if($request->type == 'Cash In'){
        //     $query= [
        //         'save_id' => $request->save_id,
        //         'business_id' => $request->business_id,
        //         'type' => $request->type,
        //         'description' => $request->description,
        //     ];


        //     $saving  = Saving::find($request->save_id);
        //     $plus = $saving->saldo + $grand_total;
        //     Saving::where('id',$request->save_id)->update([
        //         'saldo' => $plus
        //     ]);
        // }else if($request->type == 'Cash Out') {
        //     $query= [
        //         'save_id' => $request->save_id,
        //         'business_id' => $request->business_id,
        //         'type' => $request->type,
        //         'description' => $request->description,
        //     ];

        //     $saving = Saving::find($request->save_id);
        //     if($saving->saldo > $grand_total){
        //         $minus = $saving->saldo - $grand_total;
        //     }else {
        //         $minus =  $grand_total - $saving->saldo;
        //     }
        //     Saving::where('id',$request->save_id)->update([
        //         'saldo' => $minus
        //     ]);
        // }

        $transaksi = Transaction::create($query);

        foreach ($all['item'] as $item => $value) {
            $data2 = array(
                'transaction_id'             => $transaksi->id,
                'name'                       => $all['item'][$item] ?? '-',
                'quantity'                   => $all['qty'][$item],
                'unit_price'                 => $all['unit_price'][$item],
                'total'                      => $all['total'][$item],
                'grand_total'                => $grand_total,
            );
            Items::create($data2);
        }

        return redirect()->back()->with('message','Success Simpan Transaksi');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $saving = Saving::where('user_id',Auth::user()->id)->get();
        return view('pages.transaksi.edit')
        ->with('saving',$saving);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $transaksi = Transaction::find($id);

        $query = [];
        if($request->type == 'Cash In'){
            $query= [
                'save_id' => $request->save_id,
                'business_id' => $request->business_id,
                'type' => $request->type,
                'description' => $request->description,
                'fee' => $request->fee,
            ];

            $savings = Saving::find($request->save_id);
            //Jika Ganti CashIn
            if($savings->saldo < $transaksi->fee){
                $returnPlus = $transaksi->fee - $savings->saldo;
            }else if($savings->saldo > $transaksi->fee){
                $returnPlus = $savings->saldo - $transaksi->fee;
            }

            Saving::where('id',$transaksi->save_id)->update([
                'saldo' => $returnPlus
            ]);

            $plus = $savings->saldo + $request->fee;
            Saving::where('id',$request->save_id)->update([
                'saldo' => $plus
            ]);
        }else if($request->type == 'Cash Out') {
            $query= [
                'save_id' => $request->save_id,
                'business_id' => $request->business_id,
                'type' => $request->type,
                'description' => $request->description,
                'fee' => $request->fee,
            ];

            $savings = Saving::find($request->save_id);

            if($savings->saldo < $transaksi->fee){
                $returnMinus = $transaksi->fee + $savings->saldo;
            }else if($savings->saldo > $transaksi->fee){
                $returnMinus = $savings->saldo + $transaksi->fee;
            }

            Saving::where('id',$transaksi->save_id)->update([
                'saldo' => $returnMinus
            ]);

            if($savings->saldo > $request->fee){
                $minus = $savings->saldo - $request->fee;
            }else {
                $minus =  $request->fee - $savings->saldo;
            }
            Saving::where('id',$request->save_id)->update([
                'saldo' => $minus
            ]);
        }

        $transaksi->update($query);

        return redirect()->back()->with('message','Success Simpan Transaksi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }


    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);
        $saving = $request->input('save_id');
        $desc = $request->input('desc');
        if ($request->hasFile('file')) {
            //UPLOAD FILE
            $file = $request->file('file'); //GET FILE
            // dd($file);
            Excel::import(new TransactionImport($saving, $desc), $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload file data !']);
        }

        return redirect()->back()->with(['error' => 'Please choose file before!']);
    }
}