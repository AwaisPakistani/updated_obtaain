@php 

use App\Models\JournalVolume;

@endphp

@extends('front.layout.main')

<link href="{{url('assets/front/dist/css/datatable.min.css')}}" rel="stylesheet">

<link href="{{url('assets/front/dist/css/cdn.css')}}" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
#more {display: none;}

</style>

@section('content')

@include('front.inc.journal_hero')

<div class="container mb-3 mt-3">

    <div class="row">

        <div class="col-lg-8 mt-2">

        <h3>Volume List</h3>

        <ul>

            @foreach($journal->Journal_volumes as $vol)

            <li>{{$vol->journal_volume_name}}

                <ul>

                    @php

                    $issues=JournalVolume::with('journal_volume_issues')->where('id',$vol->id)->first();

                    @endphp

                    @foreach($issues->journal_volume_issues as $issue)

                   <li><a href="{{route('front.papers_journal_issues',$issue->id)}}" class="text-decoration-none">{{$issue->journal_issue_name}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{date('d-m-Y',strtotime($issue->created_at))}}</a></li>

                   @endforeach

                   

                </ul>

            </li>

            @endforeach

        </ul>
        <a href="{{$journal->journal_slug}}" title="Join Group for this JOurnal" class="btn btn-success"><i class="fab fa-whatsapp"></i>&nbsp;Join Group</a>
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

            </a><br>

            <span><b>Category:</b>&nbsp;&nbsp;

            {{$journal->category->category_name}}</span><br>

            <span><b>ISSN:</b>&nbsp;&nbsp;{{$journal->issn}}</span><br>

            <span><b>More Information About Journal:</b>&nbsp;&nbsp;<a href="{{url('storage/'.$journal->more_info)}}" target="__blank" class="text-decoration-none">Click here</a></span><br>

            <span><b>Author Guideline:</b>&nbsp;&nbsp;<a href="{{url('storage/'.$journal->author_guideline)}}" class="text-decoration-none" target="__blank">Click here</a></span><br>

            <span id="dots" style="text-align: justify;"><b>Scope & Aim:</b>
            {{ strip_tags(Str::limit($journal->scope_and_aim, 50))  }}
            </span>
            
            <span id="more" style="text-align: justify;">{!!$journal->scope_and_aim!!}</span>
            <button onclick="myFunction()" id="myBtn">Read more</button><br>

            <span><b>Indexing & Metrics:</b>{!!$journal->Indexing_or_abstracting!!}</span>

            <span >

                <a href="#" class="text-decoration-none">Current Issue</a> | <a href="#" class="text-decoration-none">Available Issues</a>

            </span><br><br>

            

         

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
<script>
function myFunction() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("myBtn");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less"; 
    moreText.style.display = "inline";
  }
}
</script>

