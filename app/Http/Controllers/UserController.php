<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;

class UserController extends Controller
{
    public function profile($id)
    {
        $user = User::find($id);

        return view('master.user.profile', [
            'user' => $user,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $divisions = Divisi::all();

        return view('master.user.index')->with([
            'users' => $users,
            'division' => $divisions,
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
            $request['password'] = bcrypt($request->password);
            
            $user = User::create($request->all());

            $user->remember_token = Str::random(60);
            $user->save();

            if ($request->hasFile('profile_picture')) {
                $request->file('profile_picture')->move('images/', $request->file('profile_picture')->getClientOriginalName());
                $user->profile_picture = $request->file('profile_picture')->getClientOriginalName();
                $user->save();
            }

            return redirect('user')->with('success', 'Data berhasil diinput !');
        } catch (Exception $e) {
            return redirect('user')->with(['error' => $e->getMessage()]);
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
        $users = User::find($id);
        $divisions = Divisi::all();

        return view('master.user.edit')->with([
            'user' => $users,
            'division' => $divisions,
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
            //dd($request->all());
            $user = User::find($id);

            $user->update($request->all());

            if ($request->hasFile('profile_picture')) {
                $request->file('profile_picture')->move('images/', $request->file('profile_picture')->getClientOriginalName());
                $user->profile_picture = $request->file('profile_picture')->getClientOriginalName();
                $user->save();
            }

            return redirect('user')->with('success', 'Data berhasil diupdate !');
        } catch (Exception $e) {
            //throw $th;
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
            $user = User::find($id);

            $user->delete($user);

            return redirect('user')->with('success', 'Data berhasil dihapus !');
        } catch (Exception $e) {
            //throw $th;
        }
    }
}
