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
       
       </div>
      </div>
    <div class="row">
    
        <div class="col-lg-12 mt-2 text-end py-2 text-start" style="text-decoration:none;">
        @include('front.inc.alerts')
       
        </div>
    </div>
    <!-- Paper View -->
    <div class="row">
        <div class="col-lg-6">
           <form method="post" action="{{route('user.rolechange.request',[$journal->id,$user->id])}}">@csrf
              <div class="form-group">
                    <h3 class="h3">Role Change Request</h3><hr/>
                    <select class="form-control" name="role_name" id="role_name">
                        <option value="">Select Roles </option>
                        @foreach($roles as $role_name)
                        @if($role_name->name=='paper_editor' || $role_name->name=='publisher' || $role_name->name==$role)
                        @else
                        <option value="{{$role_name->id}}">{{$role_name->name}} </option>
                        @endif
                        @endforeach
                    </select>
                
              </div><br>
              <div class="form-group">

                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="{{ url()->previous() }}" class="btn btn-warning">Back</a>
              </div>

           </form>
         </div>
         <div class="col-lg-6">

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
