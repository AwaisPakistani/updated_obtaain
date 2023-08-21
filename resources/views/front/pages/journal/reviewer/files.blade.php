@php 
use App\Models\Paper;
use App\Models\Frontuser;
use App\Models\Contributor;
use App\Models\PaperReport;
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
                    <th>Paper</th>
                    <th>Submitted At</th>
                    <th>Download Files</th>
                  </tr>
                </thead>
                <tbody>
                    @php 
                    $sr=1;
                    @endphp
                    @foreach($files as $file)
                    <tr>
                            @php 
                            $paper=Paper::where('id',$file->paper_id)->first();
                            @endphp
                        <td>{{$sr}}</td>
                        <td>{{$paper->submission_title}}</td>
                        <td>
                        @php
                        echo date("d-m-Y", strtotime($file->created_at));
                        @endphp 
                        </td>
                        <td>
                          
                          @php
                          $path = explode('.',$file->filepath);
                          @endphp
                          
                          @if($path[1]=='pdf')
                          <a href="{{url('storage/'.$file->filepath)}}" title="Click to read and download files" target="_blank">
                          <i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:48px;color:red"></i>
                          </a>
                          @else 
                          <a href="{{url('storage/'.$file->filepath)}}" title="Click to read and download files" target="_blank">
                          <i class="fa fa-file-word" aria-hidden="true" style="font-size:48px;color:blue"></i>
                        
                          </a>
                          @endif
                        </td>
                    </tr>
                @php $sr++; @endphp
                    @endforeach
                </tbody>
                <tfoot>
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
