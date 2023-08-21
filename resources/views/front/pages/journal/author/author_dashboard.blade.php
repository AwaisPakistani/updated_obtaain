@php 
use App\Models\Frontuser;
@endphp
@extends('front.layout.main')

<link href="{{url('assets/front/dist/css/datatable.min.css')}}" rel="stylesheet">

<link href="{{url('assets/front/dist/css/cdn.css')}}" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
   <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
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
.modal-body input,textarea{
    width: 100%;
    border: 0px;
    border-bottom: 1px solid black;
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


.btn-toggle-nav li a{
	text-decoration: none;
}

/*Dropdown*/

.dropdown-btn {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 15px;
  color: #818181;
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}
/* Main content */


/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
  background-color: white;
  color:black;
  padding-left: 8px;
}
.dropdown-container a{
	text-decoration: none;
	background: white;
}

/* Optional: Style the caret down icon */
.fa-caret-down {
  float: right;
  padding-right: 8px;
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

                        <h2 class="font-italic mb-4">Submitted Manuscripts</h2>

                        <table  class="table table-striped table-bordered">

                <thead>

                  <tr>

                    <th>ID</th>

                    <th>Author Name</th>

                    <th>Title</th>

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

                        <td>{{$paper->submission_title}}</td>

                        <td>

                            @if($paper->percentagePaper==100)

                            <span class="badge bg-Secondary">Complete</span>

                            @else

                            <span class="badge bg-danger">Complete</span>

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

                        <td>&nbsp;

                            <!-- <i class="fa fa-eye" title="View"></i> -->

                            <a href="{{route('front.author.review_submission_stage1',[$journal->id,$paper->id])}}" class="btn btn-primary">View</a>

                        </td>

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

                    <th></th>

                </tfoot>

            </table>
            @php
            $author_id = Auth::guard('frontuser')->user()->id;
            $author_mail = Frontuser::where('id',$author_id)->value('email');
            $chief = Frontuser::where('id',$journal->assign_chiefeditor)->value('email');
            @endphp
            <button  style="text-decoration: none;" type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-envelope" style="color: blue;"></i> &nbsp;Contact Journal</button>
                    </div>
                    <!-- Button trigger modal -->


<!-- Modal --><form method="post" action="{{route('author.mailto.journal')}}" enctype="multipart/form-data">@csrf
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{$journal->journal_name}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <strong>From :</strong> <input type="text" name="from_mail" value="{{$author_mail}}"><br>
        <strong>To :</strong> <input type="text" name="to_mail" value="{{$chief}}"><br>
        <strong>Subject :</strong> <input type="text" name="subject"><br>
        <strong>Body :</strong> <textarea name="body" id="message_body"></textarea><br>
       <script>
                                ClassicEditor
                                    .create( document.querySelector( '#message_body' ) )
                                    .catch( error => {
                                        console.error( error );
                                     } );
                               </script>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>
</form>
                    

                   

                    

                  

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


