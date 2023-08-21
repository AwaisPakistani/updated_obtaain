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
.reviewer span{
    display: inline-flex;
    
}
.reviewer span b{
    width: 33%;
}
.reviewer span .recommended{
    width: 100%;
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
            <div class="col-md-12">
                <h4>
                @if($rec1->revision_status=='yes' || $rec2->revision_status=='yes')
                <b>Instruction :</b> You are strongly recommended to make changes only in <span style="color:red;font-weight: bold;">red color</span>. This will make it easier to follow up on your revisions, and you should respond to each comment from the reviewers. You must not overlook any comment made by a reviewer.<br>
                Your paper needs <span style="color:red;font-weight: bold;">Revisions</span>. To submit the revised paper, <a href="{{route('author.paper_update',[$journal,$paper_id])}}" style="color:red;font-size: 20;">click here.</a>
                @elseif($rec1->recommendation_remarks=='reject' && $rec2->recommendation_remarks=='reject')
                Your paper is <span style="color:red;font-weight: bold;">Rejected</span>. Please try again
                @elseif($rec1->recommendation_remarks=='accept' && $rec2->recommendation_remarks=='accept')
                <h1 style="color:red;font-weight: bold;">Congratulations,</h1>Your paper is accepted successfully and has sent for publishing.
                @else
                @endif
                </h4>
            </div>
        </div><br>
            @php
            $n=1;
            @endphp
            @foreach($reports as $report)
        <div class="row">
            <div class="col-md-12 reviewer">
                <h3>Report Reviewer#{{$n}}</h3>
                @if(!empty($report->title_remarks))
                <span><b>Submission Title: </b>
                    @if($n==2)
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                	{!!$report->title_remarks!!}</span>
                @endif<br>
                @if(!empty($report->abstract_remarks))
                <span><b>Abstract Remarks : </b>
                    @if($n==2)
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                	{!!$report->abstract_remarks!!}</span>
                @endif<br>
                @if(!empty($report->keyword_remarks))
                <span><b>Keyword Remarks: </b>
                	@if($n==2)
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                {!!$report->keyword_remarks!!}</span>
                @endif<br>
                @if(!empty($report->introduction_remarks))

                <span><b>Introduction Remarks: </b>
                	@if($n==2)
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                {!!$report->introduction_remarks!!}</span>@endif<br>
                @if(!empty($report->originality_remarks))
                <span><b>Originality Remarks: </b>
                	@if($n==2)
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                {!!$report->originality_remarks!!}</span>@endif<br>
                @if(!empty($report->relationship_remarks))
                <span><b>Relationship Remarks: </b>
                	@if($n==2)
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                {!!$report->relationship_remarks!!}</span>@endif<br>
                @if(!empty($report->framework_remarks))
                <span><b>Framework Remarks: </b>
                	@if($n==2)
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                {!!$report->framework_remarks!!}</span>
                @endif<br>
                @if(!empty($report->methodology_remarks))
                <span><b>Methodology Remarks: </b>
                	@if($n==2)
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                {!!$report->methodology_remarks!!}</span>@endif<br>
                @if(!empty($report->population_remarks))
                <span><b>Population Remarks: </b>
                	@if($n==2)
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                {!!$report->population_remarks!!}</span>@endif<br>
                @if(!empty($report->instrument_remarks))
                <span><b>Instrument Remarks: </b>
                	@if($n==2)
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                {!!$report->instrument_remarks!!}</span>@endif<br>
                @if(!empty($report->result_remarks))
                <span><b>Result Remarks: </b>
                	@if($n==2)
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                {!!$report->result_remarks!!}</span>@endif<br>
                @if(!empty($report->implications_remarks))
                <span><b>Implications Remarks: </b>
                	@if($n==2)
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                {!!$report->implications_remarks!!}</span>@endif<br>
                @if(!empty($report->quality_remarks))
                <span><b>Quality Remarks: </b>
                	@if($n==2)
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                {!!$report->quality_remarks!!}</span>@endif<br>
                @if(!empty($report->for_author_comments))
                 <span><b>Comments: </b>
                 	@if($n==2)
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif
                {!!$report->for_author_comments!!}</span>
                @endif<br>
                <span><b class="recommended">Recommendation Remarks: </b>
                @if($report->recommendation_remarks=='minor_revisions')
                Minor Revision
                @elseif($report->recommendation_remarks=='major_revisions')
                Major Revision
                @elseif($report->recommendation_remarks=='reject')
                Reject
                @elseif($report->recommendation_remarks=='accept')
                Accept
                @else
                Reject and Resubmit
                @endif
                </span>
               
            </div>
            
            
        </div>
            @php 
            $n++;
            @endphp
            @endforeach

         

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

