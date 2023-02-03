<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = Divisi::all();

        return view('settings.division.index', [
            'divisions' => $divisions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            Divisi::create($request->all());

            return redirect('division')->with('success', 'Data berhasil diinput !');
        } catch (Exception $e) {
            return redirect('division')->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        $division = Divisi::find($id);

        return view('settings.division.edit', [
            'division' => $division,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $division = Divisi::find($id);

            $division->update($request->all());

            return redirect('division')->with('success', 'Data berhasil diupdate !');
        } catch (Exception $e) {
            return redirect('division')->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $division = Divisi::find($id);

            $division->delete($division);

            return redirect('division')->with('success', 'Data berhasil dihapus !');
        } catch (Exception $e) {
            return redirect('division')->with(['error' => $e->getMessage()]);
        }
    }
}
