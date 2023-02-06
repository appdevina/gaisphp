<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RequestType;
use Illuminate\Http\Request;

class RequestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request_types = RequestType::all();
        $approvals = User::all();

        return view('master.request_type.index', [
            'request_types' => $request_types,
            'approvals' => $approvals,
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
            RequestType::create($request->all());

            return redirect('requesttype')->with('success', 'Data berhasil diinput !');
        } catch (Exception $e) {
            return redirect('requesttype')->with(['error' => $e->getMessage()]);
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
        $request_type = RequestType::find($id);
        $approvals = User::all();

        return view('master.request_type.edit', [
            'request_type' => $request_type,
            'approvals' => $approvals,
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
            $request_type = RequestType::find($id);

            $request_type->update($request->all());

            return redirect('requesttype')->with('success', 'Data berhasil diupdate !');
        } catch (Exception $e) {
            return redirect('requesttype')->with(['error' => $e->getMessage()]);
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
            $request_type = RequestType::find($id);

            $request_type->delete($request_type);

            return redirect('requesttype')->with('success', 'Data berhasil dihapus !');
        } catch (Exception $e) {
            return redirect('requesttype')->with(['error' => $e->getMessage()]);
        }
    }
}
