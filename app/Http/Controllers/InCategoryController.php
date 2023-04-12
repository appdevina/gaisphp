<?php

namespace App\Http\Controllers;

use App\Models\InsuranceCategory;
use Illuminate\Http\Request;
use Exception;

class InCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('insurances.incategory.index', [
            'incategories' => InsuranceCategory::paginate(30),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            InsuranceCategory::create($request->all());

            return redirect('incategory')->with('success', 'Data berhasil diinput !');
        } catch (Exception $e) {
            return redirect('incategory')->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(InsuranceCategory $incategory)
    {
        return view('insurances.incategory.edit', [
            'incategory' => $incategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InsuranceCategory $incategory)
    {
        try {
            $incategory->update($request->all());

            return redirect('incategory')->with('success', 'Data berhasil diupdate !');
        } catch (Exception $e) {
            return redirect('incategory')->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(InsuranceCategory $incategory)
    {
        try {
            $incategory->delete($incategory);

            return redirect('incategory')->with('success', 'Data berhasil dihapus !');
        } catch (Exception $e) {
            return redirect('incategory')->with(['error' => $e->getMessage()]);
        }
    }
}
