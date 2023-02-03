<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use Illuminate\Http\Request;

class BadanUsahaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $badan_usahas = BadanUsaha::all();

        return view('settings.bu.index', [
            'badan_usahas' => $badan_usahas,
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
            BadanUsaha::create($request->all());

            return redirect('bu')->with('success', 'Data berhasil diinput !');
        } catch (Exception $e) {
            return redirect('bu')->with(['error' => $e->getMessage()]);
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
        $badan_usaha = BadanUsaha::find($id);

        return view('settings.bu.edit', [
            'badan_usaha' => $badan_usaha,
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
            $badan_usaha = BadanUsaha::find($id);

            $badan_usaha->update($request->all());

            return redirect('bu')->with('success', 'Data berhasil diupdate !');
        } catch (Exception $e) {
            return redirect('bu')->with(['error' => $e->getMessage()]);
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
            $badan_usaha = BadanUsaha::find($id);

            $badan_usaha->delete($badan_usaha);

            return redirect('bu')->with('success', 'Data berhasil dihapus !');
        } catch (Exception $e) {
            return redirect('bu')->with(['error' => $e->getMessage()]);
        }
    }
}
