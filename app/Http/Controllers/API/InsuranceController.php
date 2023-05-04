<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    public function deleteColumn()
    {
        $query = Insurance::with('insurance_update')
        ->doesntHave('insurance_update')
        ->get();

        //dd($query);

        foreach ($query as $key) {
            $key->forceDelete();
        }
    }

}
