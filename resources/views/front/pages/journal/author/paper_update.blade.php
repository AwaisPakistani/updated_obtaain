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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>


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

.form-group .form-control label{
  font-weight: bold;
}
input {
    height: 35px;
}


 .wrapperf{

            diplay:flex;

            justify-content:center;

            align-items:center;

            width:100%;

            padding:15px;

            /*min-height:100vh;*/

        }

        .box{

            max-width:100%;

            padding:30px;

            background:white;

            width:100%;

            border-radius:5px;

            -webkit-border-radius:5px;

            -moz-border-radius:5px;

            -ms-border-radius:5px;

            -o-border-radius:5px;

        }

        .upload-area-title{

            text-align:center;

            margin-bottom:20px;

            font-size:20px;

            font-weight:600;

        }

        .uploadlabel{

            width:100%;

            min-height:100px;

            background:white;

            display:flex;

            flex-direction:column;

            justify-content:center;

            align-items:center;

            /* border:3px blue; */

            cursor:pointer;

            border:3px dotted green;

        }

        .uploadlabel span{

            font-size:70px;



        }
             .uploadlabel p{

            font-size:20px;

            font-weight:800px;

            font-family:cursive;

        }

        .uploaded{

            width:100%;

            margin:30px 0;

            font-size:16px;

            font-weight:700;

        }

        .showfilebox{

            display:flex;

            align-items:center;

            justify-content:space-between;

            margin:16px 0;

            padding:10px 15px;

            box-shadow:black 0px 0px 0px 1px;

            #d1d5db3d 0px 0px 0px 1px 1nset;

        }

        .showflex .left{

            display:flex;

            align-items:center;

            flex-wrap:wrap;

            gap:10px;

        }

        .filetype{

            /* background:#62B0DF; */

            background:green;

            color:white;

            padding:5px 15px;

            font-size:20px;

            text-transform:capitalize;

            font-weight:700;

            border-radius:3px;

            -webkit-border-radius:3px;

            -mos-border-radius:3px;

            -ms-border-radius:3px;

            -o-border-radius:3px;



        }
         .left p{

            font-weidht:600;

            font-size:18px;

            color:light;

            margin:0;

        }

        .right span{

            background:lightblue;

            color:white;

            width:25px;

            height:25px;

            font-size:25px;

            line-height:25px;

            display:inline-block;

            text-align:center;

            font-weight:700;

            cursor:pointer;

            border-radius:50%;

            -webkit-border-radius:50%;

            -mos-border-radius:50%;

            -msborder-radius:50%;

            -o-border-radius:50%;

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

            
            <div class="col-md-12 text-center">
                <h4>To upload revised manuscript click here</h4>
                <input type="hidden" name="paper_id" id="paper_id" value="{{$paper->id}}">
                 <div class="wrapperf">

                        <div class="box text-center">

                        <input type="hidden" id="2paper_id">

                        <input type="file" name="files[]" id="upload" multiple="multiple" hidden>

                        <label for="upload" class="uploadlabel">

                            <span>

                            <i class="fa fa-cloud-upload"></i>

                            </span>

                            <p>Click to Upload</p>

                        </label>

                        <span id="docs"><strong>Please Add atleast one file*</strong><br></span>

                        

                          <div class="input-bx">

                              <h2 class="upload-area-title">Upload File</h2>

                          </div>

                          <div id="filewrapper">

                               <h3 class="uploaded">Uploaded Documents</h3>

                               <input type="hidden" name="j_id" id="j_id">

                         </div>

                        </div>
                 </div>
                 <form method="post" action="{{route('author.add_revision',[$journal->id,$paper->id])}}" enctype="multiple/form-data">@csrf
                 <label style="font-size: 15px;"><b>Remarks (If any)</b></label>
                 <textarea name="comment" id="comment" cdeditor="true" ismandatory="false" placeholder="Comments..."></textarea>

                               

                               <script>
                                CKEDITOR.replace( 'comment' );
                               </script>
                <button type="submit" class="btn btn-primary">Submit the revised manuscript to the Chief Editor.</button>
                </form>
                 
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
<script>

    $(document).ready(function(){
            var inputupload= $('#upload').val();
            var filewrapper= $('#filewrapper').val();
            $('#upload').change(function(e){
                var inputname=$(this).val().split('\\').pop();
                var filename = inputname.substr(0, inputname.lastIndexOf('.')) || inputname;
                var extension = inputname.substr( (inputname.lastIndexOf('.') +1) ); // to 

                

                    var paper_id = $('#paper_id').val();

                    var upload = new FormData();

                    var files = $('#upload')[0].files;

                    if(files.length > 0){

                        upload.append('file',files[0]);

                        upload.append('paper_id',paper_id);

                        $.ajax({

                            url:'/front/revisions',

                            type:'post',

                            data:upload,

                            dataType: 'json',

                            contentType: false,

                            processData: false,

                            success:function(resp){

                              if (resp['message']=='') {
                                 $('#filewrapper').append('<div class="showfilebox"><div class="left"><span class="filetype">'+extension+'</span>&nbsp;&nbsp;'+filename+'.'+extension+'&nbsp;&nbsp;</div></div>'); 

                                    $('.right').click(function(){

                                            $(this).closest('.showfilebox').remove();// remove parent of 
                                    });
                              }else{
                                alert(resp['message']);
                              }

                                

                            },error:function(){

                                                    alert("error");
                            }
                        });

                    }else{

                        alert("Please select a file.");

                    }

            });

    });

</script>

