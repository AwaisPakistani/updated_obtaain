@php 
use App\Models\AssignPaper;
use App\Models\Frontuser;
use App\Models\Contributor;
use App\Models\JournalVolume;
use App\Models\JournalIssue;
@endphp
@extends('front.layout.main')
<link href="{{url('assets/front/dist/css/datatable.min.css')}}" rel="stylesheet">
<link href="{{url('assets/front/dist/css/cdn.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
 .author-links a{
    text-decoration:none;
 }
 .author-links a:hover{
    color:#ff8000;
 }
 .paperdetail{
    padding:10px 0px;
 }
</style>
@section('content')
@include('front.inc.journal_content_hero')
<div class="container mb-3 mt-3">
    <div class="row">
       <div class="col-lg-12 text-center">
       @include('front.inc.reviewer.buttons')
       </div>
      </div>
    <div class="row">
    
        <div class="col-lg-12 mt-2 text-end py-2 text-start" style="text-decoration:none;">
        @include('front.inc.alerts')
       
        </div>
    </div>
    <!-- Paper View -->
    <div class="row">
        <div class="col-lg-12">
        <div class="row">
        <div class="col-lg-8 mt-2">
        <h3>Paper Detail</h3><hr/>
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
            <a href="{{route('front.reviewwr.files',[$journal->id,$paper->id])}}" class="btn btn-success" title="Download and review files">See Files</a>
            </div>
        </div>
        
        

               
           
        
        </div>
        <div class="col-lg-4 mt-2 text-start text-decoration-none py-2" style="text-decoration:none;">
            <h4 style="background-color:green; padding:15px; color:white; border-radius:10px;">Journal Information</h4>
         
            <span>{!!$journal->information!!}</span>
            <a href="{{route('front.chiefeditor.login',$journal->id)}}" style="color:red; font-size:1.5em" class="text-decoration-none ">
            <strong>
                <b>
                    Submit New Manuscript
                </b>
            </strong>
            </a>
            
            <span><b>Category:</b>&nbsp;&nbsp;
            {{$journal->category->category_name}}</span><br>
            <span><b>ISSN:</b>&nbsp;&nbsp;{{$journal->issn}}</span><br>
            <span><b>More Information About Journal:</b>&nbsp;&nbsp;<a href="{{url('storage/'.$journal->more_info)}}" target="__blank" class="text-decoration-none">Click here</a></span><br>
            <span><b>Author Guideline:</b>&nbsp;&nbsp;<a href="{{url('storage/'.$journal->author_guideline)}}" class="text-decoration-none" target="__blank">Click here</a></span><br>
            <span><b>Indexing & Metrics:</b>{!!$journal->Indexing_or_abstracting!!}</span>
            <span >
                <a href="#" class="text-decoration-none">Current Issue</a> | <a href="#" class="text-decoration-none">Available Issues</a>
            </span><br><br>
            
         
        </div>
    </div>
        </div>
    </div>

    
</div>

@endsection
<script src="{{url('assets/front/dist/js/jquery.min.js')}}"></script>
    <script src="{{url('assets/front/dist/js/datatable_net.min.js')}}"></script>
    <script src="{{url('assets/front/dist/js/datatable.min.js')}}"></script>
    <script>
    $(document).ready(function () {
    $('#example').DataTable();
    });
</script>
