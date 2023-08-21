@php

use App\Models\Frontuser;

use App\Models\Contributor;

use App\Models\JournalVolume;

use App\Models\JournalIssue;

@endphp 

@extends('front.layout.main')

<link href="{{url('assets/front/dist/css/datatable.min.css')}}" rel="stylesheet">

<link href="{{url('assets/front/dist/css/cdn.css')}}" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">



<style>

 .author-links a{

    text-decoration:none;

 }

 .author-links a:hover{

    color:#ff8000;

 }

.name{

    font-size:20px;

}









 .nav-pills-custom .nav-link {

    color: black;

    background: #fff;

    position: relative;

}

                  

.nav-pills-custom .nav-link.active {

    color: #45b649;

    background: #fff;

}





/* Add indicator arrow for the active tab */

@media (min-width: 992px) {

    .nav-pills-custom .nav-link::before {

        content: '';

        display: block;

        border-top: 8px solid transparent;

        border-left: 10px solid #fff;

        border-bottom: 8px solid transparent;

        position: absolute;

        top: 50%;

        right: -10px;

        transform: translateY(-50%);

        opacity: 0;

    }

}



.nav-pills-custom .nav-link.active::before {

    opacity: 1;

}





 

</style>

@section('content')

@include('front.inc.journal_content_hero')

<div class="container mb-3 mt-3">

    <div class="row">

       <div class="col-lg-12 text-center">

       @include('front.inc.author.buttons')

       </div>

      </div>







<section class="py-5 header">

    <div class="container py-4">

        <div class="row">

            <div class="col-mb-12">

            @include('front.inc.alerts')

            </div>

        </div>

        <div class="row">

        <div class="name">

                

                Welcome dear, 

                @php

                $currentuser = Auth::guard('frontuser')->user()->id;

                echo $author=Auth::guard('frontuser')->user()->first_name;

                echo ' ';

                echo Auth::guard('frontuser')->user()->last_name;

                @endphp

            </div><br>

            <div class="col-md-3">

                <!-- Tabs nav -->

               @include('front.inc.author.author_sidebar')

            </div>





            <div class="col-md-9">

                <!-- Tabs content -->

                <div class="tab-content" id="v-pills-tabContent">

                    <div class="tab-pane fade shadow rounded bg-white show active p-5" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

                        <h2 class="font-italic mb-4">View Manuscript</h2>

                        <div class="row paperdetail">

            <div class="col-lg-4">

              <b>Submission Title</b>

            </div>

            <div class="col-lg-8">

             {{$paper->submission_title}}

            </div>

        </div>

        <div class="row paperdetail">

            <div class="col-lg-4">

              <b>Author Name</b>

            </div>

            <div class="col-lg-8">

                @php

                $author= Frontuser::where('id',$paper->frontuser_id)->first();

                @endphp

             {{$author->first_name}} {{$author->last_name}}

            </div>

        </div>

        @php

        $volume= JournalVolume::with('current_issue')->where('id',$paper->volume_id)->first();

        @endphp

        @if(!empty($volume->journal_volume_name))

        <div class="row paperdetail">

            <div class="col-lg-4">

              <b>Volume Name</b>

            </div>

            <div class="col-lg-8">

                

             {{$volume->journal_volume_name}} 

            </div>

        </div>

        @else 

        @endif

        @if(!empty($volume->current_issue))

        <div class="row paperdetail">

            <div class="col-lg-4">

              <b>Issue Name</b>

            </div>

            <div class="col-lg-8"> 

             @php 

             echo $issue_name = JournalIssue::where('id',$volume->current_issue->issue_id)->value('journal_issue_name');

             @endphp

            </div>

        </div>

        @else 

        @endif

        <div class="row paperdetail">

            <div class="col-lg-4">

              <b>Contributors</b>

            </div>

            <div class="col-lg-8">

                       1.{{$author->first_name}} {{$author->last_name}}<br>

                        @php

                        $conts=Contributor::where([

                            'author_id'=>$paper->frontuser_id,

                            'journal_id'=>$journal->id,

                            'paper_id'=>$paper->id

                            ])->get();



                        $cn=2;

                        @endphp

                        @foreach($conts as $contributor)

                        {{$cn}}.

                        {{$contributor->first_name}} {{$contributor->last_name}}

                        @php $cn++; @endphp

                        @endforeach 

            </div>

        </div>

        <div class="row paperdetail">

            <div class="col-lg-4">

              <b>Abstract</b>

            </div>

            <div class="col-lg-8">

             {!!$paper->abstract!!}

            </div>

        </div>

        <div class="row paperdetail">

            <div class="col-lg-4">

              <b>Keywords</b>

            </div>

            <div class="col-lg-8">

             {{$paper->keywords}}

            </div>

        </div>

        <div class="row paperdetail">

            <div class="col-lg-4">

              <b>Article Type</b>

            </div>

            <div class="col-lg-8">

             {{$paper->article_type}}

            </div>

        </div>

        <div class="row paperdetail">

            <div class="col-lg-4">

              <b>Additional Comments</b>

            </div>

            <div class="col-lg-8">

            {!!$paper->comments!!}

            </div>

        </div>

        <div class="row paperdetail">

            <div class="col-lg-4">

              <b>Files</b>

            </div>

            <div class="col-lg-8">

            <a href="{{route('front.author.files',[$journal->id,$paper->id])}}" class="btn btn-success" title="Download and review files">See Files</a>

            </div>

        </div>

                    </div>

                    

                    

                    

                   

                </div>

            </div>

        </div>

    </div>

</section>







    <div class="row">

    

        <div class="col-lg-12 mt-2 text-end py-2 text-start" style="text-decoration:none;">

        

        <div class="author-links text-start px-5 py-2">

            

            <br>

            

           

        </div>

        

        

         

        </div>

    </div>

</div>



@endsection

<script src="{{url('assets/front/dist/js/jquery.min.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="{{url('assets/front/dist/js/datatable_net.min.js')}}"></script>

<script src="{{url('assets/front/dist/js/datatable.min.js')}}"></script>

<script>

    $(document).ready(function () {

    $('#example').DataTable();

    });

</script>

