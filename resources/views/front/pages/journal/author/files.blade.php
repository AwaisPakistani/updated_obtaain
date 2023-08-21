@php

use App\Models\Frontuser;

use App\Models\Contributor;

use App\Models\JournalVolume;

use App\Models\JournalIssue;

use App\Models\Paper;

@endphp 

@extends('front.layout.main')

<link href="{{url('assets/front/dist/css/datatable.min.css')}}" rel="stylesheet">

<link href="{{url('assets/front/dist/css/cdn.css')}}" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



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

        <div class="name">

                

                Welcome dear, 

                @php

                $currentuser = Auth::guard('frontuser')->user()->id;

                echo $author=Auth::guard('frontuser')->user()->first_name;

                echo ' ';

                echo Auth::guard('frontuser')->user()->last_name;

                @endphp

            </div><br>

            <div class="col-md-3">

                <!-- Tabs nav -->
                 @include('front.inc.author.author_sidebar')


            </div>





            <div class="col-md-9">

                <!-- Tabs content -->

                <div class="tab-content" id="v-pills-tabContent">

                    <div class="tab-pane fade shadow rounded bg-white show active p-5" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

                        <h2 class="font-italic mb-4">View All Files</h2>
                         <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addfileModal">
                    Add New
                 </button>
                 <!-- The Modal -->
<div class="modal" id="addfileModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <form method="POST" enctype="multipart/form-data" action="{{route('front.add_newfile')}}">@csrf
      <div class="modal-header">
        <h4 class="modal-title">Add new File </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        
            <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                     <input type="hidden" name="paper_id" value="{{$paper->id}}">
                     <input type="file" name="file" class="form-control">
                     <br>
                    

                </div>
            </div>

            </div>
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
      </form>

    </div>
  </div>
</div>
<!-- Model ends here -->
                        <table id='example' class="table table-striped table-bordered">

                <thead>

                  <tr>

                    <th>Sr#</th>

                    <th>Paper</th>

                    <th>Submitted At</th>

                    <th>Download Files</th>

                    <th>Delete</th>

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
                        <td>
                            <a href="{{route('author.delete_file',[$paper_id,$file->id])}}" class="btn btn-danger">Delete</a>
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

                    <th></th>

                </tfoot>

            </table>

                    </div>

                    

                    

                    

                   

                </div>

            </div>

        </div>

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

