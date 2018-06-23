<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultsController extends Controller
{
    public function getResults()
    {
    	$results = DB::table('user_results')
		 		->get();

 		if($results->isEmpty())
		{
			return view('results');
		}
		else
		{
			return view('results', [

					'results' => $results
		
				]);
		}
    }

    private function filmTitle()
    {
    	$film_title = DB::table('item_details')
		 		->where('solved', true)
		 		->get();


    }
}
