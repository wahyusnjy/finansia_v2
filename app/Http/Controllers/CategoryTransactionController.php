<?php

namespace App\Http\Controllers;

use App\Models\CategoryTransaction;
use Illuminate\Http\Request;
use App\Models\Saving;
use Illuminate\Support\Facades\Auth;

class CategoryTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategoryTransaction::paginate(10);
        return view('pages.categories.categories')
        ->with('categories',$categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saving = Saving::create([
            'user_id' => Auth::user()->id,
            'bank_id' => $request->bank,
            'saldo'   => $request->saldo ? $request->saldo : 0,
            'rekening'=> $request->rekening,
        ]);

        return redirect()->route('savings')->with('message', 'Sucess Save new Saving');
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryTransaction $CategoryTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryTransaction $CategoryTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryTransaction $CategoryTransaction)
    {
        //
    }

    /**`
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryTransaction $CategoryTransaction)
    {
        //
    }
}