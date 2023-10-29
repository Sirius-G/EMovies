<?php
use App\Models\Tracker;
use Illuminate\Support\Facades\Storage;

if(isset($_GET['id'])){

    $tid = $_GET['id'];
    $ctm = $_GET['ctm'];
    $dtm = $_GET['dtm'];
    $tp = $_GET['t'];
    $pc = round(($ctm/$dtm)*100, 2);
    if($pc > 99){ $pc = 100; }

    if (Tracker::where('tracker_check', auth()->user()->id.' | ' . $tp . ' | '. $tid)->count() == 0) {
        //New entry into Database
        $nt = new Tracker;
        $nt->user_id = auth()->user()->id;
        $nt->tracer_type = $tp;
        $nt->current_play_time = $ctm;
        $nt->total_play_time = $dtm;
        $nt->tracer_id = $tid;
        $nt->percentage_completed = 0;
        $nt->tracker_check = auth()->user()->id.' | ' . $tp . ' | '. $tid;
        $nt->save();
     } else {
        //Get ID of tracker record
        $track_id = Tracker::where('tracker_check', auth()->user()->id.' | ' . $tp . ' | '. $tid)->limit(1)->pluck('id');
        if(strlen($track_id)>2){ $tr_id = $track_id[0]; } else { $tr_id = ''; }
        $current_time = Tracker::where('id', $track_id[0])->pluck('current_play_time');
        if(strlen($current_time)>2){ $curtm = $current_time[0]; } else { $curtm = 0; }
        
        //Update the database ONLY if the current time stored is less than the current play time of the video
            $id = $tr_id;

            if($curtm < $ctm){
                //Update the database ONLY if the current time stored is less than the current play time of the video
                //Update Database
                $t = Tracker::find($id);
                $t->user_id = auth()->user()->id;
                $t->tracer_type = $tp;
                $t->current_play_time = $ctm;
                $t->total_play_time = $dtm;
                $t->tracer_id = $tid;
                $t->percentage_completed = $pc;
                $t->tracker_check = auth()->user()->id.' | ' . $tp . ' | '. $tid;
                $t->save();
            }
       
     }


        
    

}





?>