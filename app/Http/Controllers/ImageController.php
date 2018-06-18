<?php

namespace App\Http\Controllers;
 
use App\Item;
use App\ItemDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;
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
			 
			if($request->hasFile('photos'))
			 
			{
			 
			$allowedfileExtension=['pdf','jpg','png','docx']; 
			$files = $request->file('photos');
			$film_title = $request->input('name');
			 
			foreach($files as $file){
			 
				$filename = $file->getClientOriginalName(); 
				$extension = $file->getClientOriginalExtension(); 

				$check=in_array($extension,$allowedfileExtension);
			 
				if($check)
			 
				{
				 
					$items= Item::create($request->all());
				 
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
		 	$film_image = DB::table('item_details')->where('solved', false)->get();

			$image = Storage::url('public/test.png');

			return view('image', [
				'image' => $image,
				'query' => $film_image
			]);

		}
	}