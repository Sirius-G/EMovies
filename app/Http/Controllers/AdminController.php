<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cast;
use App\Models\Certificate;
use App\Models\Charges;
use App\Models\Directors;
use App\Models\Feature;
use App\Models\FeatureTypes;
use App\Models\Genre;
use App\Models\Producers;
use App\Models\Writers;
use Image;

//composer require intervention/image

use Session;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
            $search = $request->input('search');
            if($search !=''){
                $thumbs = Feature::withTrashed()
                                    ->where('active', 1)
                                    ->where('title', 'like', '%' . $search . '%')
                                    ->get(); //get all files including soft deleted
            } else {
                $thumbs = Feature::withTrashed()->where('active', 1)->get(); //get all files including soft deleted
            }

        //$thumbs = Feature::withTrashed()->where('active', 1)->get(); //get all files including soft deleted

        return view('admin.index')->with('thumbs', $thumbs);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //set stage of upload sequence
        if(session::get('stage') == ''){ session::put('stage', 1); }

        $certs = Certificate::orderby('certificate', 'asc')->get();
        $ftypes = FeatureTypes::get();
        $genres = Genre::get();
        return view('admin.add_feature')
                ->with('certs', $certs)
                ->with('ftypes', $ftypes)
                ->with('genres', $genres);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_s1(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'subtitle' => 'required',
            'thumb' => 'required|image|mimes:jpeg,png,jpg,gif',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif'
          ]);

          $title = $request->input('title');
          $subtitle = $request->input('subtitle');

        //Handle File Upload
        if($request->hasFile('thumb')){
            //Get original filename
            $filenameWithExt = $request->file('thumb')->getClientOriginalName();
            //Get just the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get Just filename extension
            $extension = $request->file('thumb')->getClientOriginalExtension();
            //Concatenate filename with date / time to make it unique
            $fileNameToStore = $title . '_210x270_thumb_' . time() . '.' . $extension;
            //Upload image
            $image = $request->file('thumb');
            $destinationPathThumbnail = public_path('/assets/thumbnails/');
            //Resize image to suit requirements
            $img = Image::make($image->path());  
            $img->resize(210, 270)->save($destinationPathThumbnail.$fileNameToStore, 80);
            // $destinationPath = public_path('/assets/thumbnails');
            // $image->move($destinationPath, $fileNameToStore);	
        } else {
            //If no image add default filename to db
            $fileNameToStore = 'assets/thumbnails/noimage.jpg';
        }	

        if($request->hasFile('poster')){
            //Get original filename
            $filenameWithExt2 = $request->file('poster')->getClientOriginalName();
            //Get just the filename
            $filename2 = pathinfo($filenameWithExt2, PATHINFO_FILENAME);
            //Get Just filename extension
            $extension2 = $request->file('poster')->getClientOriginalExtension();
            //Concatenate filename with date / time to make it unique
            $fileNameToStore2 = $title . '_1920x720_poster_' . time() . '.' . $extension2;
            //Upload image
            $image2 = $request->file('poster');
            $destinationPathPoster = public_path('/assets/posters/');
            //Resize image to suit requirements
            $img2 = Image::make($image2->path());
            $img2->resize(1920, 720)->save($destinationPathPoster.$fileNameToStore2, 80);
            // $destinationPath2 = public_path('/assets/posters');
            // $image2->move($destinationPath2, $fileNameToStore2);	
        } else {
            //If no image add default filename to db
            $fileNameToStore2 = '';
        }	
  
        //Create new entry into feature table
        try{
            $app = new Feature;
            $app->title = $title;
            $app->sub_title = $subtitle;
            $app->thumbnail = $fileNameToStore;
            $app->poster = $fileNameToStore2;
            $app->save();
        
        } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return back()->with('error', 'A feature with this title has already been created.');
                }
        }

        session::put('stage', 2);
        session::put('feature_details', $title. ' ' . $subtitle);
        return redirect('/add')->with('success', 'Stage 1 successfully completed.');

    }
    public function store_s2(Request $request)
    {

        $last_feature_id = Feature::orderby('id', 'desc')->limit(1)->pluck('id');
        $id = $last_feature_id[0];

        //Handle File Upload
        if($request->hasFile('file1')){
            //Get original filename
            $filenameWithExt = $request->file('file1')->getClientOriginalName();
            //Get just the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get Just filename extension
            $extension = $request->file('file1')->getClientOriginalExtension();
            //Concatenate filename with date / time to make it unique
            $fileNameToStore = $filename . '_t_' . time() . '.' . $extension;
            //Upload image
            $vid = $request->file('file1');
            $vid->move('assets/videos', $fileNameToStore);	
        } else {
            //If no image add default filename to db
            $fileNameToStore = '';
        }	
  
        //Create new entry into Messages get_html_translation_table
        try{
            $app = Feature::find($id);
            if($fileNameToStore !=''){
                $app->trailer = $fileNameToStore;
            }
            $app->save();
        
        } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return back()->with('error', 'A error occured while uploading the trailer. Please try again.');
                }
        }

        session::put('stage', 3);
        return redirect('/add')->with('success', 'Stage 2 successfully completed.');

    }

    public function store_s2e(Request $request)
    {
        $last_feature_id = Feature::orderby('id', 'desc')->limit(1)->pluck('id');
        $id = $last_feature_id[0];
        $trailer_url = $request->input('file1');
        //Create new entry into Messages get_html_translation_table
        try{
            $app = Feature::find($id);
            if($trailer_url !=''){
                $app->trailer = $trailer_url;
            }
            $app->save();
        } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return back()->with('error', 'A error occured. Please try again.');
                }
        }
        session::put('stage', 3);
        return redirect('/add')->with('success', 'Stage 2 successfully completed.');
    }


    public function store_s3(Request $request)
    {
        $last_feature_id = Feature::orderby('id', 'desc')->limit(1)->pluck('id');
        $id = $last_feature_id[0];

        //Handle File Upload
        if($request->hasFile('feature')){
            //Get original filename
            $filenameWithExt = $request->file('feature')->getClientOriginalName();
            //Get just the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get Just filename extension
            $extension = $request->file('feature')->getClientOriginalExtension();
            //Concatenate filename with date / time to make it unique
            $fileNameToStore = $filename . '_t_' . time() . '.' . $extension;
            //Upload image
            $vid = $request->file('feature');
            $vid->move('assets/videos', $fileNameToStore);	
        } else {
            //If no image add default filename to db
            $fileNameToStore = '';
        }	
  
        //Update feature table
        try{
            $app = Feature::find($id);
            if($fileNameToStore !=''){
                $app->feature = $fileNameToStore;
                $app->series_id = 0;
            }
            $app->save();
        
        } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return back()->with('error', 'A error occured while uploading the feature. Please try again.');
                }
        }

        session::put('stage', 4);
        return redirect('/add')->with('success', 'Stage 3 successfully completed.');

    }

    public function store_s3e(Request $request)
    {
        $last_feature_id = Feature::orderby('id', 'desc')->limit(1)->pluck('id');
        $id = $last_feature_id[0];
        $feature_url = $request->input('feature');
  
        //Update feature table
        try{
            $app = Feature::find($id);
            if($feature_url !=''){
                $app->feature = $feature_url;
                $app->series_id = 0;
            }
            $app->save();
        
        } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return back()->with('error', 'A error occured. Please try again.');
                }
        }

        session::put('stage', 4);
        return redirect('/add')->with('success', 'Stage 3 successfully completed.');

    }








    public function store_s4(Request $request)
    {
        $this->validate($request, [
            'cert' => 'required',
            'ftype' => 'required',
            'genre' => 'required',
            'flen' => 'required'
          ]);

          //set vars
          $cert = $request->input('cert');
          $cert_other = $request->input('cert_other');
          $ftype = $request->input('ftype');
          $ftype_other = $request->input('ftype_other');
          $genre = $request->input('genre');
          $genre_other = $request->input('genre_other');
          $director = $request->input('director');
          $producer = $request->input('producer');
          $writer = $request->input('writer');
          $cast = $request->input('cast');
          $flen = $request->input('flen');
          

          //Make new records if required for certs, feature types or genres
          if($cert_other != ''){
            $c = explode(":", $cert_other);
            $cft = $c[0];
            $cft_rsn = $c[1];
            $capp = new Certificate;
            $capp->certificate = $cft;
            $capp->certificate_reasons = $cft_rsn;
            $capp->save();

            $last_cert_id = Certificate::orderby('id', 'desc')->limit(1)->pluck('id');
            $cert = $last_cert_id[0];
          }
          if($ftype_other != ''){
            $ft = new FeatureTypes;
            $ft->feature_type = $ftype_other;
            $ft->save();

            $last_ftype_id = FeatureTypes::orderby('id', 'desc')->limit(1)->pluck('id');
            $ftype = $last_ftype_id[0];
          }
          if($genre_other != ''){
            $gn = new Genre;
            $gn->genre = $genre_other;
            $gn->save();

            $last_genre_id = Genre::orderby('id', 'desc')->limit(1)->pluck('id');
            $genre = $last_genre_id[0];
          }

          //Get the ID of the feature record to update
          $last_feature_id = Feature::orderby('id', 'desc')->limit(1)->pluck('id');
          $id = $last_feature_id[0];


          //Add details to all associated tables here =============================

          if($cast != ''){
            $cst = new Cast;
            $cst->feature_id = $id;
            $cst->cast_names = $cast;
            $cst->save();
          }

          if($writer != ''){
            $w = new Writers;
            $w->feature_id = $id;
            $w->writer_names = $writer;
            $w->save();
          }

          if($producer != ''){
            $pr = new Producers;
            $pr->feature_id = $id;
            $pr->producer_names = $producer;
            $pr->save();
          }

          if($director != ''){
            $d = new Directors;
            $d->feature_id = $id;
            $d->director_names = $director;
            $d->save();
          }



        //Update feature table
        try{
            $app = Feature::find($id);
            $app->certificate_id = $cert;
            $app->genre_id = $genre;
            $app->feature_type_id = $ftype;
            $app->feature_length = $flen;
            $app->save();
        
        } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return back()->with('error', 'A error occured while adding options. Please try again.');
                }
        }

        session::put('stage', 5);
        return redirect('/add')->with('success', 'Stage 4 successfully completed.');


    }
    public function store_s5(Request $request)
    {
        $this->validate($request, [
            'short_description' => 'required',
            'long_description' => 'required',
            'price' => 'required',
            'subscription' => 'required',
            'active' => 'required',
            'billboard' => 'required'
          ]);

          $s_des = $request->input('short_description');
          $l_des = $request->input('long_description');
          $price = $request->input('price');
          $sub = $request->input('subscription');
          $active = $request->input('active');
          $billboard = $request->input('billboard');

          //Get the ID of the feature record to update
          $last_feature_id = Feature::orderby('id', 'desc')->limit(1)->pluck('id');
          $id = $last_feature_id[0];

          //Add charging and subscription data to charges table
          if($price !=''){
            $charge = new Charges;
            $charge->feature_id = $id;
            $charge->price = $price;
            $charge->subscription = $sub;
            $charge->save();

            $last_charge_id = Charges::orderby('id', 'desc')->limit(1)->pluck('id');
            $cid = $last_charge_id[0];
          }

            //Update feature table
            try{
                $app = Feature::find($id);
                $app->short_description = $s_des;
                $app->long_description = $l_des;
                $app->charges_id = $cid;
                $app->active = $active;
                $app->billboard = $billboard??0;
                $app->save();
            
            } catch (\Illuminate\Database\QueryException $e) {
                    $errorCode = $e->errorInfo[1];
                    if($errorCode == 1062){
                        return back()->with('error', 'A error occured while adding feature details. Please try again.');
                    }
            }


        //Reset session data
        session::put('feature_details', '');
        session::put('stage', '');

        return redirect('/admin')->with('success', 'Stage 5 successfully completed.');
    }














    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.view_feature');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        //set stage of upload sequence
        if(session::get('stage') == ''){ session::put('stage', 1); }
        $certs = Certificate::orderby('certificate', 'asc')->get();
        $ftypes = FeatureTypes::get();
        $genres = Genre::get();

        $all = Feature::withTrashed()
        ->leftjoin('casts', 'features.id', 'casts.feature_id')
        ->select('casts.*', 'genres.*', 'certificates.*', 'directors.*', 'feature_types.*', 'features.*', 'features.id as fid', 'charges.*')
        ->leftjoin('feature_types', 'features.feature_type_id', 'feature_types.id')
        ->leftjoin('genres', 'features.genre_id', 'genres.id')
        ->leftjoin('certificates', 'features.certificate_id', 'certificates.id')
        ->leftjoin('directors', 'features.id', 'directors.feature_id')
        ->leftjoin('charges', 'features.charges_id', 'charges.id')
        ->where('features.id', $id)
        ->get();
		
		//return $all;

        return view('admin.edit_feature')->with('all', $all)                
                                        ->with('certs', $certs)
                                        ->with('ftypes', $ftypes)
                                        ->with('genres', $genres);;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_s1(Request $request, string $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'subtitle' => 'required',
            'thumb' => 'image|mimes:jpeg,png,jpg,gif',
            'poster' => 'image|mimes:jpeg,png,jpg,gif'
          ]);

          $title = $request->input('title');
          $subtitle = $request->input('subtitle');

        //Handle File Upload
        if($request->hasFile('thumb')){
            //Get original filename
            $filenameWithExt = $request->file('thumb')->getClientOriginalName();
            //Get just the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get Just filename extension
            $extension = $request->file('thumb')->getClientOriginalExtension();
            //Concatenate filename with date / time to make it unique
            $fileNameToStore = $title . '_210x270_thumb_' . time() . '.' . $extension;
            //Upload image
            $image = $request->file('thumb');
            $destinationPathThumbnail = public_path('/assets/thumbnails/');
            //Resize image to suit requirements
            $img = Image::make($image->path());  
            $img->resize(210, 270)->save($destinationPathThumbnail.$fileNameToStore, 80);
            // $destinationPath = public_path('/assets/thumbnails');
            // $image->move($destinationPath, $fileNameToStore);	
        } else {
            //If no image add default filename to db
            $fileNameToStore = 'assets/thumbnails/noimage.jpg';
        }	

        if($request->hasFile('poster')){
            //Get original filename
            $filenameWithExt2 = $request->file('poster')->getClientOriginalName();
            //Get just the filename
            $filename2 = pathinfo($filenameWithExt2, PATHINFO_FILENAME);
            //Get Just filename extension
            $extension2 = $request->file('poster')->getClientOriginalExtension();
            //Concatenate filename with date / time to make it unique
            $fileNameToStore2 = $title . '_1920x720_poster_' . time() . '.' . $extension2;
            //Upload image
            $image2 = $request->file('poster');
            $destinationPathPoster = public_path('/assets/posters/');
            //Resize image to suit requirements
            $img2 = Image::make($image2->path());
            $img2->resize(1920, 720)->save($destinationPathPoster.$fileNameToStore2, 80);
            // $destinationPath2 = public_path('/assets/posters');
            // $image2->move($destinationPath2, $fileNameToStore2);	
        } else {
            //If no image add default filename to db
            $fileNameToStore2 = '';
        }	
  
        //Create new entry into feature table
        try{
            $app = Feature::find($id);
            $app->title = $title;
            $app->sub_title = $subtitle;
            if($request->hasFile('thumb')){
                $app->thumbnail = $fileNameToStore;
            }
            if($request->hasFile('poster')){
                $app->poster = $fileNameToStore2;
            }
            $app->save();
        
        } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return back()->with('error', 'A feature with this title has already been created.');
                }
        }

        session::put('stage', 2);
        session::put('feature_details', $title. ' ' . $subtitle);
        return redirect('/edit/'.$id)->with('success', 'Stage 1 successfully updated.');

    }
    public function update_s2(Request $request, string $id)
    {
        //Handle File Upload
        if($request->hasFile('file1')){
            //Get original filename
            $filenameWithExt = $request->file('file1')->getClientOriginalName();
            //Get just the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get Just filename extension
            $extension = $request->file('file1')->getClientOriginalExtension();
            //Concatenate filename with date / time to make it unique
            $fileNameToStore = $filename . '_t_' . time() . '.' . $extension;
            //Upload image
            $vid = $request->file('file1');
            $vid->move('assets/videos', $fileNameToStore);	
        } else {
            //If no image add default filename to db
            $fileNameToStore = '';
        }	
  
        //Create new entry into Messages get_html_translation_table
        try{
            $app = Feature::find($id);
            if($fileNameToStore !=''){
                $app->trailer = $fileNameToStore;
            }
            $app->save();
        
        } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return back()->with('error', 'A error occured while uploading the trailer. Please try again.');
                }
        }

        session::put('stage', 3);
        return redirect('/edit/'.$id)->with('success', 'Stage 2 successfully updated.');

    }
    public function update_s3(Request $request, string $id)
    {
        //Handle File Upload
        if($request->hasFile('feature')){
            //Get original filename
            $filenameWithExt = $request->file('feature')->getClientOriginalName();
            //Get just the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get Just filename extension
            $extension = $request->file('feature')->getClientOriginalExtension();
            //Concatenate filename with date / time to make it unique
            $fileNameToStore = $filename . '_t_' . time() . '.' . $extension;
            //Upload image
            $vid = $request->file('feature');
            $vid->move('assets/videos', $fileNameToStore);	
        } else {
            //If no image add default filename to db
            $fileNameToStore = '';
        }	
  
        //Update feature table
        try{
            $app = Feature::find($id);
            if($fileNameToStore !=''){
                $app->feature = $fileNameToStore;
            }
            $app->save();
        
        } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return back()->with('error', 'A error occured while uploading the feature. Please try again.');
                }
        }

        session::put('stage', 4);
        return redirect('/edit/'.$id)->with('success', 'Stage 3 successfully updated.');
    }
    public function update_s4(Request $request, string $id)
    {
        $this->validate($request, [
            'cert' => 'required',
            'ftype' => 'required',
            'genre' => 'required',
            'flen' => 'required'
          ]);

          //set vars
          $cert = $request->input('cert');
          $cert_other = $request->input('cert_other');
          $ftype = $request->input('ftype');
          $ftype_other = $request->input('ftype_other');
          $genre = $request->input('genre');
          $genre_other = $request->input('genre_other');
          $director = $request->input('director');
          $producer = $request->input('producer');
          $writer = $request->input('writer');
          $cast = $request->input('cast');
          $flen = $request->input('flen');
          

          //Make new records if required for certs, feature types or genres
          if($cert_other != ''){
            $c = explode(":", $cert_other);
            $cft = $c[0];
            $cft_rsn = $c[1];
            $capp = new Certificate;
            $capp->certificate = $cft;
            $capp->certificate_reasons = $cft_rsn;
            $capp->save();
            $cid = Certificate::orderby('id', 'desc')->limit(1)->pluck('id');
            $cert = $cid[0];
          }
          if($ftype_other != ''){
            $ft = new FeatureTypes;
            $ft->feature_type = $ftype_other;
            $ft->save();
            $ftid = FeatureTypes::orderby('id', 'desc')->limit(1)->pluck('id');
            $ftype = $ftid[0];
          }
          if($genre_other != ''){
            $gn = new Genre;
            $gn->genre = $genre_other;
            $gn->save();
            $gid = Genre::orderby('id', 'desc')->limit(1)->pluck('id');
            $genre = $gid[0];
          }

          //Add details to all associated tables here =============================

          if($cast != ''){
            $cid = Cast::where('feature_id', $id)->pluck('id');
			if(strlen($cid)>2){
            $cst = Cast::find($cid[0]);
            $cst->feature_id = $id;
            $cst->cast_names = $cast;
            $cst->save();
            } else {
                $cst = new Cast;
                $cst->feature_id = $id;
                $cst->cast_names = $cast;
                $cst->save();
            }
          }

          if($writer != ''){
            $wid = Writers::where('feature_id', $id)->pluck('id');
			if(strlen($wid)>2){
            $w = Writers::find($wid[0]);
            $w->feature_id = $id;
            $w->writer_names = $writer;
            $w->save();
            } else {
                $w = new Writers;
                $w->feature_id = $id;
                $w->writer_names = $writer;
                $w->save();
            }
          }

          if($producer != ''){
            $pid = Producers::where('feature_id', $id)->pluck('id');
			if(strlen($pid)>2){
				$pr = Producers::find($pid[0]);
				$pr->feature_id = $id;
				$pr->producer_names = $producer;
				$pr->save();
			} else {
                $pr = new Producers;
                $pr->feature_id = $id;
                $pr->producer_names = $producer;
                $pr->save();
            }
          }

          if($director != ''){
            $did = Directors::where('feature_id', $id)->pluck('id');
			if(strlen($did)>2){
            $d = Directors::find($did[0]);
            $d->feature_id = $id;
            $d->director_names = $director;
            $d->save();
            } else {
                $d = new Directors;
                $d->feature_id = $id;
                $d->director_names = $director;
                $d->save();
            }
          }



        //Update feature table
        try{
            $app = Feature::find($id);
            $app->certificate_id = $cert;
            $app->genre_id = $genre;
            $app->feature_type_id = $ftype;
            $app->feature_length = $flen;
            $app->save();
        
        } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return back()->with('error', 'A error occured while adding options. Please try again.');
                }
        }

        session::put('stage', 5);
        return redirect('/edit/'.$id)->with('success', 'Stage 4 successfully updated.');


    }
    public function update_s5(Request $request, string $id)
    {
        $this->validate($request, [
            'short_description' => 'required',
            'long_description' => 'required',
            'price' => 'required',
            'subscription' => 'required',
            'active' => 'required',
            'billboard' => 'required'
          ]);

          $s_des = $request->input('short_description');
          $l_des = $request->input('long_description');
          $price = $request->input('price');
          $sub = $request->input('subscription');
          $active = $request->input('active');
          $billboard = $request->input('billboard');
		
		//$price_check = Charges::where('feature_id', $id)->orderby('id', 'desc')->limit(1)->pluck('price');

          //Add charging and subscription data to charges table
          if($price !=''){
            $charge = new Charges;
            $charge->feature_id = $id;
            $charge->price = $price;
            $charge->subscription = $sub;
            $charge->save();

            $last_charge_id = Charges::orderby('id', 'desc')->limit(1)->pluck('id');
            $cid = $last_charge_id[0];  
		  }

            //Update feature table
            try{
                $app = Feature::find($id);
                $app->short_description = $s_des;
                $app->long_description = $l_des;
                $app->charges_id = $cid;
                $app->active = $active;
                $app->billboard = $billboard??0;
                $app->save();
            
            } catch (\Illuminate\Database\QueryException $e) {
                    $errorCode = $e->errorInfo[1];
                    if($errorCode == 1062){
                        return back()->with('error', 'A error occured while adding feature details. Please try again.');
                    }
            }


        //Reset session data
        session::put('feature_details', '');
        session::put('stage', '');

        return redirect('/admin')->with('success', 'Stage 5 successfully completed.');
    }
    public function skip(Request $request)
    {

        $stage = $request->input('stage');
        $id = $request->input('id');

        if($stage == ''){
            session::put('stage', 1);
        }else if($stage == '5'){
            session::put('stage', 1);
            return redirect('/admin')->with('success', 'All updates completed.');
        } else {
            session::put('stage', $stage+1);
        }

        return redirect('/edit/'.$id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function show_all(){
        $all = Feature::withTrashed()
        ->leftjoin('casts', 'features.id', 'casts.feature_id')
        ->select('casts.*', 'genres.*', 'certificates.*', 'directors.*', 'producers.*', 'writers.*', 'features.*', 'feature_types.*', 'features.id as fid', 'charges.*')
        ->leftjoin('feature_types', 'features.feature_type_id', 'feature_types.id')
        ->leftjoin('genres', 'features.genre_id', 'genres.id')
        ->leftjoin('certificates', 'features.certificate_id', 'certificates.id')
        ->leftjoin('directors', 'features.id', 'directors.feature_id')
		->leftjoin('producers', 'features.id', 'producers.feature_id')
		->leftjoin('writers', 'features.id', 'writers.feature_id')
        ->leftjoin('charges', 'features.charges_id', 'charges.id')
        ->orderby('features.id', 'asc')
        ->get();

        return view('admin.view_all')->with('all', $all);
    }

    public function billboardShow(Request $request){

        $id = $request->input('id');
        $billbo = $request->input('billbox').$request->input('billboy');

        //return $id . ' - ' . $billbo;
        $app = Feature::find($id);
        $app->billboard = $billbo;
        $app->save();

        return back()->with('success', 'The billboard has been updated.');

    }




}
