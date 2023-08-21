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
                    <th>Submission Date</th>
                    <th>Files</th>
                    <th>Action</th>
                    <th>Report</th>
                  </tr>
                </thead>
                <tbody>
                    @php 
                    $sr=1;
                    @endphp
                    @foreach($papers as $paper)
                    @php 
                    $repos = PaperReport::where('paper_id',$paper->id)->get();
                    @endphp
                    @foreach($repos as $report))
                    @php
                    $repopaper = Paper::where('id',$report->paper_id)->first();
                    @endphp
                    <tr>
                        <td>{{$sr}}</td>
                        <td>{{$repopaper->submission_title}}</td>
                        <td>
                        @php
                        echo date("d-m-Y", strtotime($repopaper->submission_title));
                        @endphp
                        </td>
                        <td><a href="{{route('front.reviewwr.files',[$journal->id,$repopaper->id])}}" class="btn btn-success">Files</a></td>
                        <td>
                            <a href="#" class="btn btn-default">Reported</a>
                        </td>
                        <td><a href="{{route('front.reviewwr.paper_view',[$journal->id,$repopaper->id])}}" class="btn btn-primary">View</a></td>
                    </tr>
                    @php $sr++; @endphp
                    @endforeach
                    @endforeach
                </tbody>
                <tfoot>
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
