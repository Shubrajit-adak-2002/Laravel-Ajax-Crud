<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    function search(Request $req){
        if ($req->ajax()) {
            $datas = Product::where('name','LIKE',$req->name."%")->get();
            $output = '';
            if (count($datas) > 0) {
                $output = '<ul style="list-style: none;">';
                foreach ($datas as $data) {
                    $output .= '<li>'.$data->name.'</li>';
                }
                $output .= "</ul>";
            }else{
                $output .= "<li>No data found</li>";
            }

            return $output;
        }
        return view('search');
    }
}
