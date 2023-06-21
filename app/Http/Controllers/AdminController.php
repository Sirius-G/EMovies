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
    public function index()
    {
        $thumbs = Feature::withTrashed()->where('active', 1)->get(); //get all files including soft deleted
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
            'thumb' => 'required',
            'poster' => 'required'
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
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //Upload image
            $img = $request->file('thumb');
            $img->move('assets/thumbnails', $fileNameToStore);	
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
            $fileNameToStore2 = $filename2 . '_' . time() . '.' . $extension2;
            //Upload image
            $img2 = $request->file('poster');
            $img2->move('assets/posters', $fileNameToStore2);	
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
            $capp->certificiate = $cft;
            $capp->certificiate_reason = $cft_rsn;
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
            $w = new Writer;
            $w->feature_id = $id;
            $w->writer_names = $cast;
            $w->save();
          }

          if($producer != ''){
            $pr = new Producer;
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
        return view('admin.edit_feature');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
