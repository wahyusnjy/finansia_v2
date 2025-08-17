<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $business = Business::get();
        return view('pages.bussines.busines')
        ->with('business',$business);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.bussines.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $create = Business::create([
                'name'      => $request->name,
                'owner'     => Auth::user()->name,
                'occupant'  => $request->occupant,
                'cost'      => $request->cost
            ]);

            return redirect()->route('business');
    }

    /**
     * Display the specified resource.
     */
    public function show(Business $business)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Business $business)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Business $business)
    {
        //
    }
}