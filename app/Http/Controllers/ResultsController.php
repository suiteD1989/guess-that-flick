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
 	
 		foreach ($results as $user) 
 		{

			$username[] = $user->user_name;
			$stip_duplicates = array_unique($username);
		}

		foreach ($stip_duplicates as $user) 
		{	

			$user_total = DB::table('user_results')
				->where('user_name', $user)
				->sum('score');

			$user_score_object = new \stdClass();
			$user_score_object->name = $user;
			$user_score_object->score = $user_total;

			$score_array[] = $user_score_object;

		}	

 		if($results->isEmpty())
		{
			return view('test');
		}
		else
		{
			return view('results', [

					'results' => $score_array
		
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
