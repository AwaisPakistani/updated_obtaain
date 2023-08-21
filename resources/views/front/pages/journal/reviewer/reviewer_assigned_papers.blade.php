@php 

use App\Models\Paper;

use App\Models\Frontuser;

use App\Models\Contributor;

use App\Models\PaperReport;

@endphp

@extends('front.layout.main')

<link href="{{url('assets/front/dist/css/datatable.min.css')}}" rel="stylesheet">

<link href="{{url('assets/front/dist/css/cdn.css')}}" rel="stylesheet">

<style>

 .author-links a{

    text-decoration:none;

 }

 .author-links a:hover{

    color:#ff8000;

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

        <div class="author-links text-start px-5 py-2">

           

            <br>

            <table id='example' class="table table-striped table-bordered">

                <thead>

                  <tr>

                    <th>Sr#</th>

                    <th>Submission Title</th>

                    <th>Author Name</th>

                    <th>Submission Date</th>

                    <th>Paper Type</th>

                    <th>Contributors</th>

                    <th>Revision</th>

                    <th>Files</th>

                    <th>Action</th>

                    <th>Report</th>

                  </tr>

                </thead>

                <tbody>

                    @php 

                    $sr=1;

                    @endphp

                    @foreach($assigned as $pap)

                    <tr>

                        @php 

                        $paper=Paper::where('id',$pap->paper_id)->first();



                        $author=Frontuser::where('id',$paper->frontuser_id)->first();

                        @endphp

                        <td>{{$sr}}</td>

                        <td>{{$paper->submission_title}}</td>

                        <td>{{$author->first_name}} {{$author->last_name}}<br></td>

                        <td>

                        @php

                        echo date("d-m-Y", strtotime($paper->updated_at));

                        @endphp 

                        </td>

                        <td>

                          {{$paper->article_type}}

                        </td> 

                        <td>

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

                        </td>

                        <td>{{$paper->revision}}</td>
                        
                        <td><a href="{{route('front.reviewwr.files',[$journal->id,$paper->id])}}" class="btn btn-success">Files</a></td>

                        

                        @php 

                        $reportexist = PaperReport::where('paper_id',$paper->id)->count();

                        @endphp

                         

                        <td>

                        @if($reportexist > 1)

                        <a href="#" class="btn btn-default">Reported</a>

                        @else

                            <a href="{{route('front.reviewwr.paper_report',[$journal->id,$paper->id])}}" class="btn btn-warning">Report</a>

                        @endif

                        </td>

                        <td style="display: flex;">
                            @if(!empty($paper->comments))
                            <button  type="button" class="text-primary" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$paper->id}}" title="View Author Comment" style="border: 0px;"><i class="fa fa-message">(1)</i></button>
                            @endif
                            <a href="{{route('front.reviewwr.paper_view',[$journal->id,$paper->id])}}" class="btn btn-primary">View</a>

                        </td>

                    </tr>

                @php $sr++; @endphp



@if(!empty($paper->comments))                <!-- Modal -->
<div class="modal fade" id="exampleModal-{{$paper->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Author Comments ({{$paper->submission_title}})</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <b>Comments:</b>{!!$paper->comments!!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endif
                    @endforeach

                </tbody>

                <tfoot>

                    <th></th>

                    <th></th>

                    <th></th>

                    <th></th>

                    <th></th>

                    <th></th>

                    <th></th>

                    <th></th>

                    <th></th>

                    <th></th>

                </tfoot>

            </table>

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

