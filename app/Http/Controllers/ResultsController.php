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
 		$strip_duplicates = '';

 		foreach ($results as $user) 
 		{

			$username[] = $user->user_name;
			$strip_duplicates = array_unique($username);
		}

		if(!empty($strip_duplicates))
		{
			foreach ($strip_duplicates as $user) 
			{	

				$user_total = DB::table('user_results')
					->where('user_name', $user)
					->sum('score');

				$user_score_object = new \stdClass();
				$user_score_object->name = $user;
				$user_score_object->score = $user_total;

				$score_array[] = $user_score_object;

			}
		}	

 		if($results->isEmpty())
		{
			return view('feedback', [
				'message' => "There's fuckery going on in the ResultsController.",
				'status' => 'error',
			]);
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
