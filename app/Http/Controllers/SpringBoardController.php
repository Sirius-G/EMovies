<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cast;
use App\Model\Certificate;
use App\Model\Charges;
use App\Models\Directors;
use App\Models\Feature;
use App\Models\FeatureTypes;
use App\Models\Genre;
use App\Models\Producers;
use App\Models\Tracker;


class SpringBoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function welcome(){
        return view('welcome');
    }

    public function index(){
        //TODO add a join for writers and producers
        $billboard = Feature::where('billboard', 1)
                            ->select('casts.*', 'genres.*', 'certificates.*', 'directors.*', 'feature_types.*', 'features.*', 'features.id as fid')
                            ->leftjoin('casts', 'features.id', 'casts.feature_id')
                            ->leftjoin('feature_types', 'features.feature_type_id', 'feature_types.id')
                            ->leftjoin('genres', 'features.genre_id', 'genres.id')
                            ->leftjoin('certificates', 'features.certificate_id', 'certificates.id')
                            ->leftjoin('directors', 'features.id', 'directors.feature_id')
                            ->orderby('features.id', 'asc')
                            ->get();

        $genres = Genre::get();

        return view('home')->with('billboard', $billboard)->with('genres', $genres);
    }

    public function playView(Request $request, $id){

        //Get the video ID and validate
        //$video_id = $request->input('video_id');

        //check for valid subscription or one off payment

        //if all is well, get the video credentials and parse to front end view
        $current_video = Feature::where('id', $id)->get();

        return view('play')->with('current_video', $current_video);
    }

    public function playtrailer(Request $request, $id){

        $current_video = Feature::where('id', $id)->get();

        return view('playtrailer')->with('current_video', $current_video);
    }

    public function moreInfo(Request $request, $id){

        //$details = Feature::where('id', $id)->get();

        //TODO add a join for writers and producers
        $details = Feature::leftjoin('casts', 'features.id', 'casts.feature_id')
        ->select('casts.*', 'genres.*', 'certificates.*', 'directors.*', 'feature_types.*', 'features.*', 'features.id as fid')
        ->leftjoin('feature_types', 'features.feature_type_id', 'feature_types.id')
        ->leftjoin('genres', 'features.genre_id', 'genres.id')
        ->leftjoin('certificates', 'features.certificate_id', 'certificates.id')
        ->leftjoin('directors', 'features.id', 'directors.feature_id')
        ->where('features.id', $id)
        ->get();

        //return $details;
        //TODO add a join for writers and producers
        $thumbs = Feature::leftjoin('casts', 'features.id', 'casts.feature_id')
        ->select('casts.*', 'genres.*', 'certificates.*', 'directors.*', 'feature_types.*', 'features.*', 'features.id as fid')
        ->leftjoin('feature_types', 'features.feature_type_id', 'feature_types.id')
        ->leftjoin('genres', 'features.genre_id', 'genres.id')
        ->leftjoin('certificates', 'features.certificate_id', 'certificates.id')
        ->leftjoin('directors', 'features.id', 'directors.feature_id')
        ->where('active', 1)
        ->orderby('features.id', 'asc')
        ->get();

        $series_thumbs = Feature::leftjoin('casts', 'features.id', 'casts.feature_id')
        ->select('casts.*', 'genres.*', 'certificates.*', 'directors.*', 'feature_types.*', 'features.*', 'features.id as fid')
        ->leftjoin('feature_types', 'features.feature_type_id', 'feature_types.id')
        ->leftjoin('genres', 'features.genre_id', 'genres.id')
        ->leftjoin('certificates', 'features.certificate_id', 'certificates.id')
        ->leftjoin('directors', 'features.id', 'directors.feature_id')
        ->where('active', 1)
        ->orderby('features.id', 'asc')
        ->get();



        //Get series ID number
        $series_id = Feature::where('id', $id)->pluck('series_id');
        if($series_id[0] > 0){
            $fid = Feature::where('series_id', $series_id[0])->pluck('id');
            $fid = $fid[0];
        } else {
            $fid = 0;
        }

        return view('more_info')->with('details', $details)->with('thumbs', $thumbs)->with('fid', $fid);
    }

    public function watchers(){
        $thumbs = Feature::leftjoin('casts', 'features.id', 'casts.feature_id')
        ->select('casts.*', 'genres.*', 'certificates.*', 'directors.*', 'feature_types.*', 'features.*', 'features.id as fid')
        ->leftjoin('feature_types', 'features.feature_type_id', 'feature_types.id')
        ->leftjoin('genres', 'features.genre_id', 'genres.id')
        ->leftjoin('certificates', 'features.certificate_id', 'certificates.id')
        ->leftjoin('directors', 'features.id', 'directors.feature_id')
        ->where('active', 1)
        ->orderby('features.id', 'asc')
        ->get();

        return view('thumbs_watchers')->with('thumbs', $thumbs);
    }

    public function thumbnails($id){
        $thumbnails = Feature::leftjoin('casts', 'features.id', 'casts.feature_id')
        ->select('casts.*', 'genres.*', 'certificates.*', 'directors.*', 'feature_types.*', 'features.*', 'features.id as fid')
        ->leftjoin('feature_types', 'features.feature_type_id', 'feature_types.id')
        ->leftjoin('genres', 'features.genre_id', 'genres.id')
        ->leftjoin('certificates', 'features.certificate_id', 'certificates.id')
        ->leftjoin('directors', 'features.id', 'directors.feature_id')
        ->where('active', 1)
        ->where('genre_id', $id)
        ->orderby('features.id', 'asc')
        ->groupby('features.title')
        ->get();

        return view('thumbnails')->with('thumbnails', $thumbnails);
    }

    public function thumbnails_series($id){
        //Get series ID number
        $series_id = Feature::where('id', $id)->pluck('series_id');


        $series_thumbs = Feature::leftjoin('casts', 'features.id', 'casts.feature_id')
        ->select('casts.*', 'genres.*', 'certificates.*', 'directors.*', 'feature_types.*', 'features.*', 'features.id as fid')
        ->leftjoin('feature_types', 'features.feature_type_id', 'feature_types.id')
        ->leftjoin('genres', 'features.genre_id', 'genres.id')
        ->leftjoin('certificates', 'features.certificate_id', 'certificates.id')
        ->leftjoin('directors', 'features.id', 'directors.feature_id')
        ->where('active', 1)
        ->where('series_id', $series_id[0])
        ->orderby('features.id', 'asc')
        ->get();

        return view('thumbnails_series')->with('series_thumbs', $series_thumbs);
    }

}
