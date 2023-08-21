@php 
use App\Models\Frontuser;
use Spatie\Permission\Models\Role;
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
                          <h3 class="text-start">Role Change Requests</h3>
                          
                        </span>
            <table @if($rolechangerequests->count() > 10) id="example" @endif class="table table-striped" style="width:100%">
                 <thead>
                   
                    <tr>
                        <th>S.No</th>
                        <th>User</th>
                        <th>Current Role</th>
                        <th>Role Request</th>
                        <th>Action</th>
                        
                    </tr>
                    
                    </thead>
                    <tbody>
                    @php 
                    $sr=1;
                    @endphp
                    @foreach($rolechangerequests as $requestrole)
                    @php
                    $user=Frontuser::where('id',$requestrole->user_id)->first();

                    $currentrole = Role::where('id',$requestrole->old_role_id)->first();

                    $requestrol = Role::where('id',$requestrole->request_role_id)->first();
                    @endphp
                    <tr>
                        <td>{{$sr}}</td>
                        <td>{{$user->first_name}} {{$user->last_name}}</td>
                        <td>{{$currentrole->name}}</td>
                        <td class="text-capitalize">
                        {{$requestrol->name}}
                        </td>
                        <td>
                            <button class="btn btn-success" id="approve">Approve</button>
                            <button class="btn btn-danger" id="reject">Reject</button>
                            <input type="hidden" id="user_id" value="{{$user->id}}">
                            <input type="hidden" id="old_role_id" value="{{$currentrole->id}}">
                            <input type="hidden" id="request_role_id" value="{{$requestrol->id}}">
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
                        <th>User</th>
                        <th>Current Role</th>
                        <th>Role Request</th>
                        <th>Action</th>
                       
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
<script>
    $(document).ready(function(){
        $("#reject").click(function(){
            var user_id = $('#user_id').val();
            var old_role_id = $('#old_role_id').val();
            var request_role_id = $('#request_role_id').val();
           // alert(request_role_id); return false;
                    //alert(paper_id); return false;
                        $.ajax({
                                    type:'post',
                                    url:'/front/requestrolechange/reject',
                                    data:{user_id:user_id,old_role_id:old_role_id,request_role_id:request_role_id},
                                    success:function(resp){
                                    if(resp['status']=='true'){

                                        alert('Successfully rejected');
                                    }
                                    location.reload();
                                    //alert(resp['paper_id']);
                                    
                                        
                                         
    
                                        
                                    
                                    },error:function(){
                                    alert("error");
                                    }
                        });
        })

        $("#approve").click(function(){
            var user_id = $('#user_id').val();
            var old_role_id = $('#old_role_id').val();
            var request_role_id = $('#request_role_id').val();
           // alert(request_role_id); return false;
                    //alert(paper_id); return false;
                        $.ajax({
                                    type:'post',
                                    url:'/front/requestrolechange/approve',
                                    data:{user_id:user_id,old_role_id:old_role_id,request_role_id:request_role_id},
                                    success:function(resp){
                                        if(resp['status']=='true'){

                                        alert('Successfully approved');
                                        }
                                        location.reload();
                                    
                                        
                                         
    
                                        
                                    
                                    },error:function(){
                                    alert("error");
                                    }
                        });
        })
    });
</script>
