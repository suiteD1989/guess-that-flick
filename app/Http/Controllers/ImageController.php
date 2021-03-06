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
		 
			return view('home');
		 
		}
 
		public function uploadSubmit(Request $request)
		{
		 
			$this->validate($request, [
			 
				'name' => 'required', 
				'photos'=>'required',

			]);
		 	
			$check_title_exists = DB::table('item_details')
		 		->where('film_title', '=', $request->name)
		 		->get();

			if ($request->hasFile('photos'))
				if($check_title_exists->isEmpty()) 
				{
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

										$filename = $photo->storeAs('public', $film_title);
							 
										ItemDetails::create([
							 
											'item_id' => $items->id,
											'film_title' => $film_title,
											'filename' => $filename
											 
											]);
							 
									}
								return view('feedback', [
									'message' => 'Upload finished, let the games begin!',
									'status' => 'success',
								]);
							}
							else
							{
								return view('feedback', [
									'message' => 'Upload failed.',
									'status' => 'error',
								]);	 
							}
						} 
					}
				}
				else
				{
					return view('feedback', [
						'message' => 'That film has already been entered!',
						'status' => 'error',
					]);
				}
		}

		public function fetchImage() 
		{	
		 	$film_image = DB::table('item_details')
		 		->where('solved', false)
		 		->get();

	 		if ($film_image)
	 		{
	 			return view('film-config', [

					'query' => $film_image
		
				]);
	 		}
	 		else 
	 		{
	 			return view('edit-image');
	 		}
		}

		public function markSolved(Request $request)
		{	
			$this->validate($request, [
			 
				'id' => 'required',
				'title' => 'required'

			]);

			$id = $request->id;
			$film_title = $request->title;

			if ($id) 
			{
				$item_update = DB::table('item_details')
		 		->where('item_id', $id)
		 		->update(['solved' => 1]);
		 		
		 		Storage::delete('public/'.$film_title);

				return view('feedback', [

						'message' => 'This film has been solved.',
						'status' => 'success',

					]);
			}
			else 
			{
				return view('feedback', [

						'message' => 'Missing ID.',
						'status' => 'error',

					]);
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
	 			return view('/');
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

			$guess_exist = DB::table('user_results')
		 		->where('user_id', '=', $user_id)
		 		->Where('film_title', '=', $user_guess)
		 		->get();

			$film_details = DB::table('item_details')
		 		->where('film_title', 'LIKE', '%'.$user_guess.'%')
		 		->where('solved', false)
		 		->get();

	 		if($guess_exist->isEmpty())
	 		{
	 			if($film_details->isEmpty())
		 		{
		 			return view('feedback', [

						'message' => 'Nope, guess again!',
						'status' => 'error',

					]);
		 		}
		 		else
		 		{
		 			DB::table('user_results')->insert([
		 				'user_id' => $user_id,
		 				'user_name' => $user_name,
		 				'film_title' => $user_guess,
		 				'score' => 1
		 			]);

		 			return view('feedback', [

						'message' => 'Nice one, well done!',
						'status' => 'success',

					]);
		 		}
	 		}
	 		else
	 		{
	 			return view('feedback', [

						'message' => 'You already had a go at that one!',
						'status' => 'error',

					]);
	 		}
		}
	}