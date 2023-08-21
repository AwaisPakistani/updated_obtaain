@php
use App\Models\Frontuser;
use App\Models\Paper;
use App\Models\File;
@endphp 
@extends('front.layout.main')

<link href="{{url('assets/front/dist/css/datatable.min.css')}}" rel="stylesheet">

<link href="{{url('assets/front/dist/css/cdn.css')}}" rel="stylesheet">

@section('content')


<div class="container mb-3 mt-3">
   
    <div class="row">

        <div class="col-lg-12 mt-2">

            <h3>Volume:{{$issue->journal_volume->journal_volume_name}}  &nbsp;&nbsp;Issue:{{$issue->journal_issue_name}} </h3>
            <div class="row">
                <div class="col-md-9">
                    <b>ID.</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Articles</b>
                </div>
                <div class="col-md-3">
                    <b>PDF Downloads</b>
                </div>
                
            </div>
                     
                     @foreach($published as $publish)
            <div class="row">
                <div class="col-md-9">
                    
                     <strong class="text-uppercase">
                     @php 
                     $paper = Paper::where([
                     'id'=>$publish->paper_id,
                     'issue_id'=>$issue_id,
                     'status'=>'published'
                     ])->first();
                     @endphp
                     @if(!empty($paper))
                     {{$paper->id}}
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     {{$paper->submission_title}} <br/>
                     
                     @php
                          $author=Frontuser::where('id',$paper->frontuser_id)->first();
                          @endphp &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        {{$author->first_name}} {{$author->last_name}} <br/>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{date('d-m-Y',strtotime($publish->published_at))}}</strong><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                       <strong>

                       
                     <br/>
                     <b>
                    
                   </strong>
                   <div class="flex">
                    <button type="button" class="btn btn-default btn-sm" data-bs-toggle="collapse" data-bs-target="#demo-{{$paper->id}}" style="font-size: 16px;"><b>Show Abstract</b></button>
                      Views:<span class="views_counter{{$paper->id}}">
                          @php
                          $views = DB::table('count_views')->where('paper_id',$paper->id)->value('views');

                          @endphp  
                          
                          @if($views > 0)
                          {{$views}}
                          @else
                          0
                          @endif
                          @php 
                          
                          $downloads = DB::table('count_downloads')->where('paper_id',$paper->id)->value('downloads');
                          @endphp
                          Downloads:
                        <span class="downloads_counter{{$paper->id}}">
                        @if($downloads > 0)
                        {{$downloads}}
                        @else
                        0
                        @endif
                       </span>
                        &nbsp; Citation:4</b><br/>
                      <div id="demo-{{$paper->id}}" class="collapse" style="text-align: justify;">
                        
                       {!!$paper->abstract!!}
                      </div>
                        <hr/>
                        </span>
                        </div> &nbsp;
                      
                    
                @else
                 
                @endif
                </div>
                
                <div class="col-md-3">
                            
                @if(!empty($paper)) 
                    <a href="{{url('storage/'.$publish->file)}}" class="btn btn-primary views" paper_id="{{$paper->id}}">View</a>
                            <a href="{{url('storage/'.$publish->file)}}" download class="btn btn-danger downloads" pap_id="{{$paper->id}}">PDF Download</a>
                @else
                
                @endif
                </div>
            </div>
            
             @endforeach
            

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
       $('.views').click(function(){
         var paper_id = $(this).attr('paper_id');
         $.ajax({

          type:'post',

          url:'/front/add_edit/paper_views',

          data:{paper_id:paper_id},

          success:function(resp){

            $('.views_counter'+resp['paper_id']).text(resp['data']);
            //document.location.reload();



            return false;

          },error:function(){

            alert("Error");

          }

        });
       });

       
       $('.downloads').click(function(){
         var pap_id = $(this).attr('pap_id');
         $.ajax({

          type:'post',

          url:'/front/add_edit/paper_downloads',

          data:{pap_id:pap_id},

          success:function(resp){

            $('.downloads_counter'+resp['pap_id']).text(resp['res']);



            return false;

          },error:function(){

            alert("Error");

          }

        });
       });
    });
</script>
