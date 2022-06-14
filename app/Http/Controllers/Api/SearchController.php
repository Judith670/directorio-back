<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // $query  = Company::all();
        $data = $request->input('search');
        if($data){
            // $query->where('company_name', 'LIKE', "%{$search}%")
            // ->orWhere('category', 'LIKE', "%{$search}%")
            // $query->whereRaw("company_name LIKE '%" . $data . "%'")
            //     ->orWhere("category LIKE '%" . $data . "%'")
            //     ->get();

                $query = Company::query()
                ->where('company_name', 'LIKE', "%{$data}%")
                ->orWhere('category', 'LIKE', "%{$data}%")
                ->get();

        return $query;

        }
    }

    // public function show($search)
    // {
    //     // Company::where('company_name', 'LIKE', '%'. $search. '%')->get();
    //     $posts = Company::query()
    //         ->where('company_name', 'LIKE', "%{$search}%")
    //         ->orWhere('category', 'LIKE', "%{$search}%")
    //         ->get();
    //     return $posts;
    // }
}
