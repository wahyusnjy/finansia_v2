<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SavingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $saving = Saving::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(10);
        return view('saving')
        ->with('saving',$saving);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bank = Bank::all();
        return view('saving.create')
        ->with('bank',$bank);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saldo= 0;
        if($request->saldo){
            $duar = explode(',' ,$request->saldo);
            $saldo = implode('', $duar);
        }

        $saving = Saving::create([
            'user_id' => Auth::user()->id,
            'bank_id' => $request->bank,
            'saldo'   => $saldo ? $saldo : 0,
            'rekening'=> $request->rekening,
        ]);

        return redirect()->route('savings')->with('message', 'Sucess Save new Saving');
    }

    /**
     * Display the specified resource.
     */
    public function show(Saving $saving)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Saving $saving,$id)
    {
        $saving = Saving::find($id);
        $bank   = Bank::all();

        return view('pages.savings.edit')
        ->with('saving',$saving)
        ->with('bank',$bank);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $saldo= 0;
        if($request->saldo){
            $duar = explode(',' ,$request->saldo);
            $saldo = implode('', $duar);
        }
        // dd($saldo);
        $old = Saving::find($id);
        $saving = Saving::where('id',$id)->update([
            'user_id' => Auth::user()->id,
            'bank_id' => $request->bank ? $request->bank : $old->bank_id,
            'saldo'   => $saldo ? $saldo : $old->saldo,
            'rekening'=> $request->rekening ? $request->rekening :$old->rekening,
        ]);

        return redirect()->route('savings')->with('message', 'Sucess Save update Saving');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Saving $saving)
    {
        //
    }
}