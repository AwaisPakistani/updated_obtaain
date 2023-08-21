@php 
use App\Models\Frontuser;
use App\Models\Paper;
@endphp
@extends('front.layout.main')
<link href="{{url('assets/front/dist/css/datatable.min.css')}}" rel="stylesheet">
<link href="{{url('assets/front/dist/css/cdn.css')}}" rel="stylesheet">
@section('content')
@include('front.inc.journal_content_hero')
<div class="container mb-3 mt-3">
    <div class="row">
    <div class="col-lg-12 text-center">
    @include('front.inc.pages_journal_buttons')
    </div>
    </div>
    <div class="row">
    @include('front.inc.alerts')
      
        <div class="col-lg-12 mt-2 text-end py-2" style="text-decoration:none;">
       

        <div class="content">
            <div class="collapse multi-collapse" id="multiCollapseExample2">
              <div class="card card-body">
              
              </div>
            </div>
        <div>
              <div class="card card-body">
                  <div class="row">
                      <div class="col-lg-12">
                        <span>
                          <h3 class="text-start">Assigned Papers</h3>
                           <a href="{{route('front.chief.papers_assign',$paper->id)}}" class="btn btn-success text-end mb-4">Assign New</a>
                        </span>
            <table @if($assigned->count() > 10) id="example" @endif class="table table-striped" style="width:100%">
                 <thead>
                   
                    <tr>
                        <th>S.No</th>
                        <th>Paper</th>
                        <th>Assigned To</th>
                        <th>Role</th>
                        
                    </tr>
                    
                    </thead>
                    <tbody>
                    @php 
                    $sr=1;
                    @endphp
                    @foreach($assigned as $assign)
                    <tr>
                        <td>{{$sr}}</td>
                        <td>
                        @php
                        echo $title=Paper::where('id',$assign->paper_id)->value('submission_title');
                        @endphp
                        </td>
                        <td>
                        @php
                        $user=Frontuser::where('id',$assign->assign_to)->first();
                        @endphp 
                        {{$user->first_name}} {{$user->last_name}}
                        </td>
                        <td class="text-capitalize">
                            @if($user->roles)
                            @foreach($user->roles as $role)
                            {{$role->name}}
                            @endforeach
                            @endif
                        </td>
                        
                    </tr>
                    @php 
                    $sr++;
                    @endphp
                    @endforeach   
                    
                    </tbody>
                <tfoot>
                
                    <tr>
                        <th>S.No</th>
                        <th>Paper</th>
                        <th>Assigned To</th>
                        <th>Role</th
                       
                    </tr>
                
                </tfoot>
            </table>
                      
                      </div>
                     
                  </div>
              </div>
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
