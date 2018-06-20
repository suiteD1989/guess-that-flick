<?php

namespace App\Http\Controllers;
 
use App\Item;
use App\ItemDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;
use Auth;
use Illuminate\Support\Facades\DB;

 
class ImageController extends Controller
 
	{
 
		public function uploadForm()
 
		{
		 
			return view('admin');
		 
		}
 
		public function uploadSubmit(Request $request)
		{
		 
			$this->validate($request, [
			 
				'name' => 'required', 
				'photos'=>'required',

			]);
			 
			if ($request->hasFile('photos'))
			{
			 
				$allowedfileExtension=['pdf','jpg','png','jpeg']; 
				$files = $request->file('photos');
				$film_title = $request->input('name');
				 
				foreach($files as $file)
				{
				 
					$filename = $file->getClientOriginalName(); 
					$extension = $file->getClientOriginalExtension(); 
					$check=in_array($extension,$allowedfileExtension);
				 
					if($check)
					{
						$items = Item::create($request->all());
					 
							foreach ($request->photos as $photo) {

								$filename = $photo->store('public');
					 
								ItemDetails::create([
					 
									'item_id' => $items->id,
									'film_title' => $film_title,
									'filename' => $filename
									 
									]);
					 
							}
						return view('uploaded');
					}
					else
					{
						return view('upload-failed');	 
					}
				} 
			}
		}

		public function fetchImage() 
		{	
		 	$film_image = DB::table('item_details')
		 		->where('solved', false)
		 		->get();

	 		if ($film_image)
	 		{
	 			return view('admin-image', [

					'query' => $film_image
		
				]);
	 		}
	 		else 
	 		{
	 			return view('admin-image');
	 		}
		}

		public function markSolved(Request $request)
		{	
			$this->validate($request, [
			 
				'id' => 'required'

			]);

			$id = $request->id;

			if ($id) 
			{
				$item_update = DB::table('item_details')
		 		->where('item_id', $id)
		 		->update(['solved' => 1]);
		 	
				echo "Record with ID:".$id." marked as solved";
			}
			else 
			{
				echo "Missing ID. Cannot update record without ID.";	
			}
		}

		public function displayImageMain()
		{
			$film_image = DB::table('item_details')
		 		->where('solved', false)
		 		->get();

	 		if ($film_image)
	 		{
	 			return view('main-image', [

					'query' => $film_image
		
				]);
	 		}
	 		else 
	 		{
	 			return view('main-image');
	 		}
		}

		public function guessFlick(Request $request)
		{
			$this->validate($request, [
			 
				'film_title' => 'required', 

			]);	

			$user_guess = $request->film_title;
			$user_id = Auth::id();
			$user_name = Auth::user()->name;

			$film_details = DB::table('item_details')
		 		->where('film_title', 'LIKE', '%'.$user_guess.'%')
		 		->get();

	 		if($film_details->isEmpty())
	 		{
	 			return 'uncool';
	 		}
	 		else
	 		{
	 			DB::table('user_results')->insert([
	 				'user_id' => $user_id,
	 				'user_name' => $user_name,
	 				'film_title' => $user_guess,
	 				'score' => 1
	 			]);

	 			return 'query posted';
	 		}
		}
	}