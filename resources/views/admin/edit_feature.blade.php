@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-sm-12 col-md-2">
        <!-- Sidebar --> 
        @include('inc.sidebar')
    </div>


    <div class="col-sm-12 col-md-10">
        <!-- Main Page --> 
        @if(count($all)>0)
        @foreach($all as $a)
        <div class="row" style="margin-top: 100px">
        
        @if(session::get('stage') == 1)
            <!-- STEP 1 - Make a new record and add assets -->
            <div class="col-12 col-sm-12 mt-4">
                <div class="card p-4" style="background: #eee;">
                    <h1 class="p-4">Edit an existing feature</h1>
                    <h3 class="px-4">* : Compulsory fields</h3>
                    <h3 class="px-4">Step 1 - update record or change image assets</h3>
                    <form action="{{route('skip')}}" method="post" class="p-4">
                        @csrf 
                        <input type="hidden" name="stage" value="1">
                        <input type="hidden" name="id" value="{{$a->fid}}">
                        <button type="submit" class="btn btn-secondary p-4">
                            <i class="fa fa-arrow-right fa-lg"></i> <b>Skip this step</b>
                        </button>
                    </form>
                    <form action="{{route('update.s1', $a->fid)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row px-4">
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label fw-bold">Title *</label><br>
                                <input type="text" name="title" class="form-control" placeholder="Enter title" value="{{$a->title}}" required />
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label fw-bold">Subtitle *</label><br>
                                <input type="text" name="subtitle" class="form-control" placeholder="Enter subtitle" value="{{$a->sub_title}}" required />
                            </div>
                            <div class="col-12"><hr></div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label fw-bold">Thumbnail</label><br>
                                <input type="file" name="thumb" class="form-control" placeholder="Thumbnail Image" />
                                <br>
                                <img src="{{asset('assets/thumbnails/'.$a->thumbnail)}}" height="150px" />
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label fw-bold">Billboard Poster</label><br>
                                <input type="file" name="poster" class="form-control" placeholder="Poster Image" />
                                <br>
                                <img src="{{asset('assets/posters/'.$a->poster)}}" height="150px" />
                            </div>
                            <div class="col-sm-12 p-4">
                                <button type="submit" class="btn btn-primary p-4">
                                    <i class="fa fa-retweet fa-lg"></i> <b>Update feature - Step 1</b>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

     
        @elseif(session::get('stage') == 2)
            
            <!-- STEP 2 - Add a trailer (non-compulsory) -->
            <div class="col-12 col-sm-12 mt-4">
                <div class="card p-4" style="background: #eee;">
                    <h3 class="p-4">Step 2 - update trailer</h3>
                    <form action="{{route('skip')}}" method="post" class="p-4">
                        @csrf 
                        <input type="hidden" name="stage" value="2">
                        <input type="hidden" name="id" value="{{$a->fid}}">
                        <button type="submit" class="btn btn-secondary p-4">
                            <i class="fa fa-arrow-right fa-lg"></i> <b>Skip this step</b>
                        </button>
                    </form>
                    <form action="{{route('update.s2', $a->fid)}}" method="post" id="trailer_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row p-4">
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label fw-bold">Trailer</label><br>
                                <input type="file" name="file1" id="file1" class="form-control" placeholder="Add a trailer" />
                                <br>
                                <label><b>Current trailer:</b></label><br>
                                <video  src="{{asset('assets/videos/'.$a->trailer)}}" height="200px" controls></video>
                            </div>
                            <div class="col-sm-12 p-4">
                                <button type="submit" onclick="uploadFile()" class="btn btn-primary p-4">
                                    <i class="fa fa-retweet fa-lg"></i> <b>Update trailer - Step 2</b>
                                </button>
                                <br>Progress:<br>
                                <progress id="progressBar" value="0" max="100" style="width:100%;"></progress>
                                <h3 id="status"></h3>
                                <p id="loaded_n_total"></p>
                            </div>
                        </div>
                    </form>
        <script>
            function uploadFile() {
            var file = document.getElementById("file1").files[0];
            var formdata = new FormData();
            formdata.append("file1", file);
            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.open("POST", "{{route('store.s2')}}");
            ajax.send(formdata);
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            }

            function progressHandler(event) {
                document.getElementById("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            document.getElementById("progressBar").value = Math.round(percent);
            document.getElementById("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
                // if(Math.round(percent) == 100){
                //     document.getElementById("trailer_form").submit();
                // }
            }
        </script>
                </div>
            </div>

        @elseif(session::get('stage') == 3)

            <!-- STEP 3 - Add the main feature (compulsory) -->
            <div class="col-12 col-sm-12 mt-4">
                <div class="card p-4" style="background: #eee;">
                    <h3 class="p-4">Step 3 - Update the main feature video or audio file</h3>
                    <form action="{{route('skip')}}" method="post" class="p-4">
                        @csrf 
                        <input type="hidden" name="stage" value="3">
                        <input type="hidden" name="id" value="{{$a->fid}}">
                        <button type="submit" class="btn btn-secondary p-4">
                            <i class="fa fa-arrow-right fa-lg"></i> <b>Skip this step</b>
                        </button>
                    </form>
                    <form action="{{route('update.s3', $a->fid)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row p-4">
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label fw-bold">Feature *</label><br>
                                <input type="file" name="feature" id="feature" class="form-control" placeholder="Add the main feature" required />
                                <br>
                                <label><b>Current feature:</b></label><br>
                                <video  src="{{asset('assets/videos/'.$a->feature)}}" height="200px" controls></video>
                            </div>
                            <div class="col-sm-12 p-4">
                            <button type="submit" onclick="uploadFileMain()" class="btn btn-primary p-4">
                                    <i class="fa fa-plus fa-lg"></i> <b>Add the main feature - Step 3</b>
                                </button>
                                <br>Progress:<br>
                                <progress id="progressBarMain" value="0" max="100" style="width:100%;"></progress>
                                <h3 id="statusMain"></h3>
                                <p id="loaded_n_totalMain"></p>
                            </div>
                        </div>
                        <script>
                            function uploadFileMain() {
                            var file2 = document.getElementById("feature").files[0];
                            var formdata2 = new FormData();
                            formdata2.append("feature", file2);
                            var ajax = new XMLHttpRequest();
                            ajax.upload.addEventListener("progress", progressHandlerMain, false);
                            ajax.open("POST", "{{route('store.s3')}}");
                            ajax.send(formdata2);
                                $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            }

                            function progressHandlerMain(evt) {
                                document.getElementById("loaded_n_totalMain").innerHTML = "Uploaded " + evt.loaded + " bytes of " + evt.total;
                            var perc = (evt.loaded / evt.total) * 100;
                            document.getElementById("progressBarMain").value = Math.round(perc);
                            document.getElementById("statusMain").innerHTML = Math.round(perc) + "% uploaded... please wait";
                            }
                        </script>
                    </form>
                </div>
            </div>

        @elseif(session::get('stage') == 4)

            <!-- STEP 4 choose options - genre, directors, feature type, director, producer, writer, cast--> 
            <div class="col-12 col-sm-12 mt-4">
                <div class="card p-4" style="background: #eee;">
                    <h3 class="p-4">Step 4 - Choose/update feature options</h3>
                    <form action="{{route('skip')}}" method="post" class="p-4">
                        @csrf 
                        <input type="hidden" name="stage" value="4">
                        <input type="hidden" name="id" value="{{$a->fid}}">
                        <button type="submit" class="btn btn-secondary p-4">
                            <i class="fa fa-arrow-right fa-lg"></i> <b>Skip this step</b>
                        </button>
                    </form>
                    <form action="{{route('update.s4', $a->fid)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row p-4">

                            <div class="col-sm-12 col-md-6">
                                <label class="form-label fw-bold">Certificate *</label><br>
                                <select name="cert" id="cert" class="form-select" onchange="cert_response()" required>
                                    <option value="{{$a->certificate_id}}" selected> Current Setting  {{$a->certificate_id}} </option>
                                    @foreach($certs as $c)
                                        <option value="{{$c->id}}">{{$c->certificate}} : {{$c->certificate_reasons}}</option>
                                    @endforeach
                                    <option value="other">Add a new certification</option>
                                </select>
                                <input type="text" name="cert_other" id="cert_other" class="form-control my-4" placeholder="Enter certification and reason separated by a colon. E.g. PG-13 : Adult humour" style="display: none;">
                                <script>
                                    function cert_response(){
                                        let crt = cert.options[cert.selectedIndex].value;
                                        if (crt === 'other'){   
                                            document.getElementById('cert_other').style.display = 'block';
                                        } else {
                                            document.getElementById('cert_other').style.display = 'none';
                                        }
                                    }
                                </script>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label fw-bold">Feature type *</label><br>
                                <select name="ftype" id="ftype" class="form-select" onchange="ftype_response()" required>
                                    <option value="{{$a->feature_type_id}}" selected> Current setting {{$a->feature_type_id}} </option>
                                    @foreach($ftypes as $f)
                                        <option value="{{$f->id}}">{{$f->feature_type}}</option>
                                    @endforeach
                                    <option value="other">Add new feature type</option>
                                </select>
                                <input type="text" name="ftype_other" id="ftype_other" class="form-control my-4" placeholder="Enter a new feature type" style="display: none;">
                                <script>
                                    function ftype_response(){
                                        let ft = ftype.options[ftype.selectedIndex].value;
                                        if (ft === 'other'){   
                                            document.getElementById('ftype_other').style.display = 'block';
                                        } else {
                                            document.getElementById('ftype_other').style.display = 'none';
                                        }
                                    }
                                </script>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label fw-bold">Genre *</label><br>
                                <select name="genre" id="genre" class="form-select" onchange="genre_response()" required>
                                    <option value="{{$a->genre_id}}" selected> Current setting {{$a->genre_id}} </option>
                                    @foreach($genres as $g)
                                        <option value="{{$g->id}}">{{$g->genre}}</option>
                                    @endforeach
                                    <option value="other">Add a new genre</option>
                                </select>
                                <input type="text" name="genre_other" id="genre_other" class="form-control my-4" placeholder="Enter a new genre" style="display: none;">
                                <script>
                                    function genre_response(){
                                        let gen = genre.options[genre.selectedIndex].value;
                                        if (gen === 'other'){   
                                            document.getElementById('genre_other').style.display = 'block';
                                        } else {
                                            document.getElementById('genre_other').style.display = 'none';
                                        }
                                    }
                                </script>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label fw-bold">Director(s) (comma separate)</label><br>
                                <input type="text" name="director" class="form-control" value="{{$a->director_names}}" placeholder="Enter director(s)" />
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label fw-bold">Producer(s) (comma separate)</label><br>
                                <input type="text" name="producer" class="form-control" value="{{$a->producer_names}}" placeholder="Enter producer(s)" />
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label fw-bold">Writer(s) (comma separate)</label><br>
                                <input type="text" name="writer" class="form-control" value="{{$a->writer_names}}" placeholder="Enter writer(s)" />
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label fw-bold">Cast list (comma separate)</label><br>
                                <input type="text" name="cast" class="form-control" value="{{$a->cast_names}}" placeholder="Enter cast list" />
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label fw-bold">Feature Length * </label><br>
                                <input type="text" name="flen" class="form-control" value="{{$a->feature_length}}" placeholder="Enter the feature length (mins only for videos - e.g. 95, mins and secs for audio files - e.g. 3.29)" required />
                            </div>

                            <div class="col-sm-12 p-4">
                                <button type="submit" class="btn btn-primary p-4">
                                    <i class="fa fa-retweet fa-lg"></i> <b>Update feature options - Step 4</b>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        @elseif(session::get('stage') == 5)

            <!-- STEP 5 - Add the other details -->
            <div class="col-12 col-sm-12 mt-4">
                <div class="card p-4" style="background: #eee;">
                    <h3 class="p-4">Step 5 - Update remaining details</h3>
                    <form action="{{route('skip')}}" method="post" class="p-4">
                        @csrf 
                        <input type="hidden" name="stage" value="5">
                        <input type="hidden" name="id" value="{{$a->fid}}">
                        <button type="submit" class="btn btn-secondary p-4">
                            <i class="fa fa-arrow-right fa-lg"></i> <b>Skip this step</b>
                        </button>
                    </form>
                    <form action="{{route('update.s5', $a->fid)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row p-4">
                            <div class="col-sm-12">
                                <label class="form-label fw-bold">Short description *</label><br>
                                <input type="text" name="short_description" class="form-control" value="{{$a->short_description}}" placeholder="Enter a short description - Max 250 characters" required />
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label fw-bold">Long description *</label><br>
                                <textarea name="long_description" class="form-control" rows="10" placeholder="Enter a long description - Up to 5000 characters" required />{{$a->long_description}}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="form-label fw-bold">Price (in $)</label><br>
                                <input type="text" name="price" class="form-control" value="{{$a->price}}" placeholder="Enter price e.g. 2.99" required />
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="form-label fw-bold">Available on subscription *</label><br>
                                <select name="subscription" class="form-select" required>
                                    <option value="{{$a->subscription}}" selected> {{$a->subscription}} </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="form-label fw-bold">Active (Show to users) *</label><br>
                                <select name="active" class="form-select" required>
                                    <option value="{{$a->active}}" selected> {{$a->active}} </option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label class="form-label fw-bold">Show on billboard *</label><br>
                                <select name="billboard" class="form-select" required>
                                    <option value="{{$a->billboard}}" selected> {{$a->billboard}} </option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <div class="col-sm-12 p-4">
                                <button type="submit" class="btn btn-primary p-4">
                                    <i class="fa fa-retweet fa-lg"></i> <b>Update details - Step 5</b>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        @else
            <p class="card p-4">Error - no upload stage found. Please refresh the page.</p>
        @endif

    @endforeach
    @endif 


        </div>
    </div>
</div>
@endsection