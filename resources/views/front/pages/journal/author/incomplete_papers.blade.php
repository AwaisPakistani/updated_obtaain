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
       @include('front.inc.author.buttons')
       </div>
      </div>
    <div class="row">
    
        <div class="col-lg-12 mt-2 text-end py-2 text-start" style="text-decoration:none;">
        @include('front.inc.alerts')
        <div class="author-links text-start px-5 py-2">
            <div class="name">
                
                Welcome dear, 
                @php
                echo $author=Auth::guard('frontuser')->user()->first_name;
                echo ' ';
                echo Auth::guard('frontuser')->user()->last_name;
                @endphp
            </div>
            <br>
            <table id='example' class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>id</th>
                    <th>Author Name</th>
                    <th>Paper Status</th>
                    <th>Process Status</th>
                    <th>Submitted At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($papers as $paper)
                    <tr>
                        <td>{{$paper->id}}</td>
                        <td>@php echo Auth::guard('frontuser')->user()->first_name; @endphp</td>
                        <td>
                            @if($paper->percentagePaper==100)
                            <span class="badge bg-Secondary">Complete</span>
                            @else
                            <span class="badge bg-danger">Incomplete</span>
                            @endif
                        </td>
                        <td>
                            @if($paper->posting_status!='published')
                            <span class="badge bg-primary">Under Process</span>
                            @else
                            <span class="badge bg-success">Published</span>
                            @endif
                        </td>
                        <td>
                        @php
                        echo date("d-m-Y", strtotime($paper->created_at));
                        @endphp    
                        </td>
                        <td>&nbsp;<i class="fa fa-eye" title="View"></i></td>
                    </tr>
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
