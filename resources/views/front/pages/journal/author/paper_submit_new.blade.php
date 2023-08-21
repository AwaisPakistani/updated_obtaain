@php 

use App\Models\Paper;

@endphp

@extends('front.layout.main')

<!-- Editor -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">





<link rel="stylesheet" href=

"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css">

<link href="{{url('assets/front/dist/css/datatable.min.css')}}" rel="stylesheet">

<link href="{{url('assets/plugins/input-tags/css/tagsinput.css')}}" rel="stylesheet" />

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script> -->

<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

<style>

        .wrapperf{

            diplay:flex;

            justify-content:center;

            align-items:center;

            width:100%;

            padding:15px;

            min-height:100vh;

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

    

        .author-links a{

            text-decoration:none;

        }

        .author-links a:hover{

            color:#ff8000;

        }

        



        #heading {

            text-transform: uppercase;

            color: #673AB7;

            font-weight: normal

        }



        #msform {

            /* text-align: center; */

            position: relative;

            margin-top: 20px

        }

        #check7_req,#comment_req,#checks,#docs

        {

            color:red;

            display:none;

        }

        #show_ref_keywords,#show_abstract,#show_submission_title{

            color:red;

            display:none;

        }



        #msform fieldset {

            background: white;

            border: 0 none;

            border-radius: 0.5rem;

            box-sizing: border-box;

            width: 100%;

            margin: 0;

            padding-bottom: 20px;

            position: relative

        }



        .form-card {

            text-align: left

        }



        #msform fieldset:not(:first-of-type) {

            display: none

        }



        #msform input,

        #msform textarea {

            padding: 8px 15px 8px 15px;

            border: 0px solid #ccc;

            border-radius: 0px;

            margin-bottom: 25px;

            margin-top: 2px;

            width: 100%;

            box-sizing: border-box;

            font-family: montserrat;

            color: #2C3E50;

            background-color: #ECEFF1;

            font-size: 16px;

            letter-spacing: 1px

        }

        #msform input[type='checkbox']{

            width:auto;

        }



        #msform input:focus,

        #msform textarea:focus {

            -moz-box-shadow: none !important;

            -webkit-box-shadow: none !important;

            box-shadow: none !important;

            border: 0px solid #673AB7;

            outline-width: 0

        }



        #msform .action-button {

            width: 100px;

            background: green;

            font-weight: bold;

            color: white;

            border: 0 none;

            border-radius: 0px;

            cursor: pointer;

            padding: 10px 5px;

            margin: 10px 0px 10px 5px;

            float: right

        }



        #msform .action-button:hover,

        #msform .action-button:focus {

            background-color: #311B92

        }



        #msform .action-button-previous {

            width: 100px;

            background: #616161;

            font-weight: bold;

            color: white;

            border: 0 none;

            border-radius: 0px;

            cursor: pointer;

            padding: 10px 5px;

            margin: 10px 5px 10px 0px;

            float: right

        }



        #msform .action-button-previous:hover,

        #msform .action-button-previous:focus {

            background-color: #000000

        }



        .card {

            z-index: 0;

            border: none;

            position: relative

        }



        .fs-title {

            font-size: 20px;

            color: black;

            margin-bottom: 15px;

            font-weight: normal;

            text-align: left

        }



        .purple-text {

            /* color: #673AB7; */

            color:green;

            font-weight: normal

        }



        .steps {

            font-size: 25px;

            color: gray;

            margin-bottom: 10px;

            font-weight: normal;

            text-align: right

        }



        .fieldlabels {

            color: gray;

            text-align: left

        }



        #progressbar {

            margin-bottom: 30px;

            overflow: hidden;

            color: lightgrey;

            width:100%;

        }



        #progressbar .active {

            color: green;

        }



        #progressbar li {

            list-style-type: none;

            font-size: 15px;

            width: 20%;

            float: left;

            position: relative;

            font-weight: 400

        }



        #progressbar #article:before {

            font-family: FontAwesome;

            content: "\F378"

        }

        

        #progressbar #attfile:before {

            font-family: FontAwesome;

            content: "\F24A"

        }

        #progressbar #info:before {

            font-family: FontAwesome;

            content: "\f129"

        }

        #progressbar #review:before {

            font-family: FontAwesome;

            content: "\f085"

        }



        #progressbar #comments:before {

            font-family: FontAwesome;

            content: "\f27a"

        }    

        #progressbar #manuscript:before {

            font-family: FontAwesome;

            content: "\274F"

        }



        #progressbar li:before {

            width: 50px;

            height: 50px;

            line-height: 45px;

            display: block;

            font-size: 20px;

            color: #ffffff;

            background: lightgray;

            border-radius: 50%;

            margin: 0 auto 10px auto;

            padding: 2px

        }



        #progressbar li:after {

            content: '';

            width: 100%;

            height: 2px;

            background: lightgray;

            position: absolute;

            left: 0;

            top: 25px;

            z-index: -1

        }



        #progressbar li.active:before,

        #progressbar li.active:after {

            background: green;

        }



        

        /* Drag and drop */

        /* url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap'); */



    /* .form-container {

        width: 100vw;

        height: 100vh;

        background-color: #7b2cbf;

        display: flex;

        justify-content: center;

        align-items: center;

            } */



        /* === Wrapper Styles === */

        url("https://www.transparenttextures.com/patterns/lyonnette.png");

        #FileUpload {

        display: flex;

        justify-content: center;

        }

        .wrapper {

        margin: 30px;

        padding: 10px;

        box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);

        border-radius: 10px;

        background-color: white;

        width: 415px;

        }



        /* === Upload Box === */

        .upload {

        margin: 10px;

        height: 85px;

        border: 8px dashed #e6f5e9;

        display: flex;

        justify-content: center;

        align-items: center;

        border-radius: 5px;

        }

        .upload p {

        margin-top: 12px;

        line-height: 0;

        font-size: 22px;

        color: #0c3214;

        letter-spacing: 1.5px;

        }

        .upload__button {

        background-color: #e6f5e9;

        border-radius: 10px;

        padding: 0px 8px 0px 10px;

        }

        .upload__button:hover {

        cursor: pointer;

        opacity: 0.8;

        }



        /* === Uploaded Files === */

        .uploaded {

        width: 375px;

        margin: 10px;

        background-color: #e6f5e9;

        border-radius: 10px;

        display: flex;

        flex-direction: row;

        justify-content: flex-start;

        align-items: center;

        }

        .file {

        display: flex;

        flex-direction: column;

        }

        .file__name {

        display: flex;

        flex-direction: row;

        justify-content: space-between;

        align-items: baseline;

        width: 300px;

        line-height: 0;

        color: #0c3214;

        font-size: 18px;

        letter-spacing: 1.5px;

        }

        .fa-times:hover {

        cursor: pointer;

        opacity: 0.8;

        }

        .fa-file-pdf {

        padding: 15px;

        font-size: 40px;

        color: #0c3214;

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

           

        <!-- Author Paper Submission -->



        <!-- Multi step form --> 

        <div class="container-fluid">

    <div class="row">

        <div class="col-12 text-center p-0 mt-3 mb-2">

            <div class="px-0 pt-1 pb-1 mt-1 mb-1">

                <h3 id="heading">Front Journal Development</h3>

                

                <form id="msform">@csrf

                    <!-- progressbar -->

                    <ul id="progressbar">

                        <li class="active" id="article"><strong>Start</strong></li>

                        <li id="attfile"><strong>Upload Files</strong></li>

                        <li id="info"><strong>Enter Metadata</strong></strong></li>

                        <li id="review"><strong>Confirmation</strong></li>

                        <li id="comments"><strong>Next Steps</strong></li>

                       

                    </ul>

                   

                    <fieldset class="text-start">

                    <div class="form-card">

                            <div class="row">

                                <div class="col-12">

                                    <h2 class="fs-title text-start"><b>Submission Language:</b></h2>

                                   

                                </div>

                            </div> 

                            <div class="text-start">

                                <!-- <label class="fieldlabels">Choose article type of your submission from the dropdown menu</label> <br> -->

                                <select name="submission_language" id="submission_language" style="width:50%; height:40px;">

                                    

                                    <option value="العربية">العربية</option>

                                    <option value="english">English</option>

                                    

                                </select><br>

                                <span>

                                    We accept submissions in multiple languages. Please select the main language of your submission from the drop-down menu above.*

                                </span>

                            </div>

                        </div>

                        <div class="form-card">

                            <div class="row">

                                <div class="col-12">

                                    <h2 class="fs-title text-start text-bold"><b>Select Article Type:</b></h2>

                                </div>

                            </div> 

                            <div class="text-start">

                                <!-- <label class="fieldlabels">Choose article type of your submission from the dropdown menu</label> <br> -->

                                <select name="article_type" id="article_type"style="width:50%; height:40px;">

                                    @foreach($article_types as $at)

                                    <option value="{{$at->name}}">{{$at->name}}</option>

                                    @endforeach

                                </select><br>

                                <input type="hidden" id="journ_id" value="{{$journal->id}}">

                                <input type="hidden" id="aut_id" value="{{$author->id}}">

                                <input type="hidden" id="aut_id" value="{{$author->id}}">

                                <input type="hidden" id="chiefsahib_id" value="{{$chiefsb->id}}">

                                <span>

                                It is required that articles be submitted to one of the sections of the journal.

                                </span>

                            </div>

                        </div>

                        <div>

                            <div class="row mt-0 mb-0">

                                <div class="col-12">

                                    <h2 class="fs-title text-bold"><b>Submission Requirements:</b></h2><span id="checks"><strong>Please check all checkboxes below*</strong><br></span>

                                <span>

                                Before proceeding, you are required to confirm that you have fulfilled the following requirements:<br><br>

                                <input  type="checkbox" name="check1" id="check1" required>&nbsp;The submission has not been published previously, and it is not currently under consideration by another journal (or if it is, an explanation has been provided in the comments section to the editor).<br>

                                

                                <br>

                                <input  type="checkbox" name="check2" id="check2" required>&nbsp;submission file is in one of the following formats: OpenOffice, Microsoft Word, or RTF document.<br>

                               

                                <input  type="checkbox" name="check3" id="check3" required>&nbsp;References have been provided with URLs, where available.<br>

                               

                                <input  type="checkbox" name="check5" id="check5" required>&nbsp;The text follows specific guidelines such as being single-spaced, using a 12-point font, italicizing rather than underlining (except for URLs), and placing all illustrations, figures, and tables within the text at the appropriate positions.<br>

                                

                                <br>

                                <input  type="checkbox" name="check6" id="check6">&nbsp;

                                The text adheres to the stylistic and bibliographic requirements set out in the Author Guidelines<br>

                                

                               </span>

                               <h2 class="fs-title text-bold"><b>Comments for the Editor:</b></h2>

                               

                               <textarea name="comment" id="comment" cdeditor="true" ismandatory="false" placeholder="Comments..."></textarea>

                               <span id="comment_req">This field is required</span>

                               <script>

                                CKEDITOR.replace( 'comment' );

                                

                               </script>

                                <br>

                               <input  type="checkbox" name="check7" id="check7" required>&nbsp;

                               Consent to the collection and storage of my data in accordance with the privacy statement.<br>

                               <span id="check7_req">This field is required</span>

                                </div>

                            </div> 

                        </div>

                            <input type="button" name="next" class="next action-button" value="Proceed" />

                        

                    </fieldset>

                    <fieldset>

                    <div class="form-card">

                        

                    

                    <div class="wrapperf">

                        <div class="box text-center">

                        <input type="hidden" id="2paper_id">

                        <!-- <input type="file" name="files[]" id="upload" multiple="multiple" accept=".pdf,.doc,.docs" hidden> -->
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

                                <!-- <div class="showfilebox">

                                    <div class="left">

                                    <span class="filetype">pdf&nbsp;</span>

                                    dsaf.pdf

                                    </div>

                                    <div class="right">

                                        <span>

                                            &#215;

                                        </span>

                                    </div>

                                </div> -->

                           

                                

                         </div>

                        </div>



                    </div>

                            

                        </div> <input type="button" name="next" class="next action-button" value="Submit" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />

                    </fieldset>

                    <fieldset>

                        <div class="form-card text-start">

                            <input type="hidden" id="3paper_id">

                            <div class="form-group">

                                <h2 class="fs-title"> <strong>

                                    Submission Title

                                    </strong></h2>

                                <input type="text" id="submission_title" name="title" placeholder="Enter Title" required><br>

                                <span id="show_submission_title">Please fill out this field*</span>

                            </div>

                            <div class="form-group">

                                <h2 class="fs-title">

                                    <strong>

                                    Abstract

                                    </strong></h2>

                                <textarea id="abstract" name="abstract" placeholder="Abstract" required></textarea>

                                <script>

                                CKEDITOR.replace( 'abstract' );

                        //for dkeditor5    //     var abstractEditor;



                            // ClassicEditor

                            //     .create( document.querySelector( '#abstract' ) )

                            //     .then( editor => {

                            //         console.log( 'Editor was initialized', editor );

                            //         myEditor = editor;

                            //     } )

                            //     .catch( err => {

                            //         console.error( err.stack );

                            //     } );

                               </script><br>

                                <span id="show_abstract">Please fill out this field*</span>

                            </div><br><br>

                            <h2 class="fs-title text-start"><strong>List of Contributors</strong>

                             <a href="javascript:void(0)" class="text-center" style="background:white; border-radius:5px; padding:5px; border:1px solid black; color black;" id="contributor">

                                Add Contributor

                                <br>

                            </a><br>

                            <input type="hidden" id="journal_id" value="{{$journal->id}}">

                            <input type="hidden" id="author_id" value="{{$author->id}}">

                            <div id="show_contributor">

                              

                            </div>

                            </h2>

                           

                            <div class="form-group">

                               <span id="conts">



                               </span>

                            </div>

                            <h2 class="fs-title"><strong>Refinements Keywords</strong></h2> <br>

                            

                            <input type="text" id="ref_keywords" name="keywords" data-role="tagsinput"placeholder="Enter Meta Keywords" required><br>

                            <span id="show_ref_keywords">Please fill out this field*</span>

                            <span style="color:green;">Note: Enter Comma(,) to save and switch to enter for more keyword</span>

                            

                            

                           <br><br>

                           

                        </div>

                        <input type="button" name="next" class="next action-button" value="Submit" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />

                    </fieldset>

                    

                    <fieldset>

                        <div class="form-card">

                            <br><br>

                            

                            <!-- <h2 class="purple-text text-center"><strong>SUCCESS !</strong></h2> <br>

                             <br><br> -->

                             <input type="hidden" id="4paper_id">

                            <div class="row justify-content-justify">

                                <div class="col-12 text-justify">

                                    <h5 class="purple-text">This message is informing you that the content you have uploaded has been processed and is now ready to be submitted. Before you submit, you have the opportunity to review and make any necessary changes to the information you entered. Once you are satisfied with the content and all necessary adjustments have been made, you can click on the "Submit" button to submit the content.

                               .</h5>

                                </div>

                            </div>

                        </div>

                        <input type="button" name="next" class="next action-button" value="Submit" onClick="confirm('Are you sure you want to submit this paper in cureent journal')" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous"  />

                    </fieldset>

                    <fieldset>             

                    

                    

                    <div class="form-card">

                            <br><br>

                            <input type="hidden" id="5paper_id">

                            <h2 class="fs-title text-start text-bold"><b>Submission Complete:</b></h2><br>

                            <h5 class="purple-text">Thank you for submitting your work to the Journal of Shukaar. We appreciate your interest in publishing with us. We have received your submission and sent you an email confirming its receipt for your reference.

                               .</h5><br>

                            <h2 class="fs-title text-start text-bold"><b>What to do Next?</b></h2><br>

                            <h5 class="purple-text">Please note that your work will be reviewed by our editor, and we will contact you once the review process is complete. We appreciate your patience during this time, and we will do our best to keep you informed of any updates regarding your submission. Thank you again for considering the Journal of Shukaar as a potential publisher for your work.



                            </h5><br>

                            And for now, you can:

                            <ul>

                                <li>

                                   

                                    <a href="{{route('front.author.dashboard',$journal->id)}}">

                                        Review your Submissions

                                    </a>

                                </li>

                                <li>

                                    <a href="{{route('front.paper_submit_new',$journal->id)}}">

                                        Create a new Manuscript

                                    </a>

                                </li>

                                <li> 

                                <a href="{{route('front.author.dashboard',$journal->id)}}">

                                    Return back to your dashboard

                                </a>    

                            </li>

                            </ul>

                        </div>

                       

                    </fieldset>

                    <fieldset>

                        <div class="form-card">

                             <br><br>

                            <h2 class="purple-text text-center"><strong>SUCCESS !</strong></h2> <br>

                            <div class="row justify-content-center">

                                <div class="col-3"> <img src="https://i.imgur.com/GwStPmg.png" class="fit-image"> </div>

                            </div> <br><br>

                            <div class="row justify-content-center">

                                <div class="col-7 text-center">

                                    <h5 class="purple-text text-center">You Have Successfully Signed Up</h5>

                                </div>

                            </div>

                        </div>

                        <input type="button" name="next" class="next action-button" value="Submit" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />

                    </fieldset>

                </form>

            </div>

        </div>

    </div>

</div>

<!-- End Multi step form -->   

        <!-- End Author Papaer Submission -->

            

        </div>

        

        

         

        </div>

    </div>

</div>



@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js" integrity="sha512-BmM0/BQlqh02wuK5Gz9yrbe7VyIVwOzD1o40yi1IsTjriX/NGF37NyXHfmFzIlMmoSIBXgqDiG1VNU6kB5dBbA==" crossorigin="anonymous"></script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script src="{{url('assets/front/dist/js/jquery.min.js')}}"></script>

<script>

   // const comment = comment.getData();

    $(document).ready(function(){



        var current_fs, next_fs, previous_fs; //fieldsets

        var opacity;

        var current = 1;

        var steps = $("fieldset").length;



        setProgressBar(current);



        $(".next").click(function(){

            if(current==1){

           

                // alert(check1); return false;

                    if($('#check1').is(":not(:checked)") || $('#check2').is(":not(:checked)") || $('#check3').is(":not(:checked)") || $('#check5').is(":not(:checked)") || $('#check6').is(":not(:checked)")){

                        $("#checks").show();

                        return false;

                    }else {

                        $("#checks").hide();

                    }

                    if($('#check7').is(":not(:checked)")){

                        $("#check7_req").show();

                        return false;

                    }else{

                        $("#check7_req").hide();

                    }

                    $('#contributor').click(function(){

                        var journal_id=$('#journal_id').val();

                        var author_id=$('#author_id').val();

                        var ppr_id = $('#3paper_id').val();

                        $.ajax({

                            type:'post',

                            url:'/front/contributor-modal',

                            data:{journal_id:journal_id,author_id:author_id,ppr_id:ppr_id},

                            success:function(resp){

                            //alert(resp);

                                $("#show_contributor").html(resp['data']);

                                $('#author_value').val(resp['author_id']);

                                $('#journal_value').val(resp['journal_id']);

                                $('#show_author').text(resp['author_id']);

                                $('#papr_id').val(resp['ppr_id']);

                            

                            },error:function(){

                            alert("error");

                            }

                        });

                        

                        return false;

                    })

                    

                    $('#add_cont').click(function(){

                        $("#add_contForm").submit();

                        //alert('submission');return false;

                    if($('#first_name').val()==''){

                        $('#show_first_name').show();

                        return false;

                    }

                       

                    });

                    var submission_language = $('#submission_language').val();

                    var article_type = $('#article_type').val();

                   

                    var comment = CKEDITOR.instances['comment'].getData();

                    

                    var journ_id = $('#journ_id').val();

                    var aut_id = $('#aut_id').val();

                    var chiefsahib_id = $('#chiefsahib_id').val();

                    $.ajax({

                                type:'post',

                                url:'/front/paper1',

                                data:{submission_language:submission_language,article_type:article_type,comment:comment,journ_id:journ_id,aut_id:aut_id,chiefsahib_id:chiefsahib_id},

                                cache:false,

                                success:function(resp){

                                //alert(resp);

                                    

                                    $('#2paper_id').val(resp['paper_id']);

                                    $('#contpaper_id').val(resp['paper_id']);

                                    

                                

                                },error:function(){

                                alert("error");

                                }

                            });

            }

            if(current==2){

                if($('#upload').val()==''){

                    $("#docs").show();

                    return false;

                }else{

                    $("#docs").hide();

                }

                

                    // var paper_id = $('#2paper_id').val();

                    

                    // $.ajax({

                    //             type:'post',

                    //             url:'/front/paper2/submit',

                    //             data:{paper_id:paper_id},

                    //             success:function(resp){

                    //             //alert(resp);

                    //             alert(resp['paper_id']);

                                    

                    //                 // $('#3paper_id').val(resp['paper_id']);

                                    

                                

                    //             },error:function(){

                    //             alert("error");

                    //             }

                    // });

                

            }

            if(current==3){

                if($('#submission_title').val()==''){

                    $("#show_submission_title").show();

                    return false;

                }else{

                    $("#show_submission_title").hide();

                }

                // if($('#abstract').val()==''){

                //     $("#show_abstract").show();

                //     return false;

                // }else{

                //     $("#show_abstract").hide();

                // }

                if($('#ref_keywords').val()==''){

                    $("#show_ref_keywords").show();

                    return false;

                }else{

                    $("#show_ref_keywords").hide();

                }

                // submission

                var pap_id = $('#3paper_id').val();

                var submission_title = $('#submission_title').val();

                //alert(submission_title); return false;

                var abstract = CKEDITOR.instances['abstract'].getData();

               // var abstract = $('textarea#abstract').html( abstractEditor.getData() );

                var ref_keywords = $('#ref_keywords').val();

                $.ajax({

                                type:'post',

                                url:'/front/paper3',

                                data:{pap_id:pap_id,submission_title:submission_title,abstract:abstract,ref_keywords:ref_keywords},

                                success:function(resp){

                                //alert(resp);

                                    

                                    $('#4paper_id').val(resp['paper_id']);

                                    

                                    

                                

                                },error:function(){

                                alert("error");

                                }

                    });

            }

            if(current==4){

                var paper_id = $('#4paper_id').val();

                //alert(paper_id); return false;

                    $.ajax({

                                type:'post',

                                url:'/front/paper2/submit',

                                data:{paper_id:paper_id},

                                success:function(resp){

                                //alert(resp);

                                //alert(resp['paper_id']);

                                

                                    

                                     $('#5paper_id').val(resp['paper_id']);



                                    

                                

                                },error:function(){

                                alert("error");

                                }

                    });

            }

        current_fs = $(this).parent();

        next_fs = $(this).parent().next();



        //Add Class Active

        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");



        //show the next fieldset

        next_fs.show();

        //hide the current fieldset with style

        current_fs.animate({opacity: 0}, {

        step: function(now) {

        // for making fielset appear animation

        opacity = 1 - now;



        current_fs.css({

        'display': 'none',

        'position': 'relative'

        });

        next_fs.css({'opacity': opacity});

        },

        duration: 500

        });

        setProgressBar(++current);

        });



        $(".previous").click(function(){



        current_fs = $(this).parent();

        previous_fs = $(this).parent().prev();



        //Remove class active

        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");



        //show the previous fieldset

        previous_fs.show();



        //hide the current fieldset with style

        current_fs.animate({opacity: 0}, {

        step: function(now) {

        // for making fielset appear animation

        opacity = 1 - now;



        current_fs.css({

        'display': 'none',

        'position': 'relative'

        });

        previous_fs.css({'opacity': opacity});

        },

        duration: 500

        });

        setProgressBar(--current);

        });



        function setProgressBar(curStep){

        var percent = parseFloat(100 / steps) * curStep;

        percent = percent.toFixed();

        $(".progress-bbar")

        .css("width",percent+"%")

        }



        $(".submit").click(function(){

        return false;

        })



    });

</script>

<script>

    $(document).ready(function(){

           

            var inputupload= $('#upload').val();

            var filewrapper= $('#filewrapper').val();

            

            $('#upload').change(function(e){

                var inputname=$(this).val().split('\\').pop();

                var filename = inputname.substr(0, inputname.lastIndexOf('.')) || inputname;// to get filename

                //var namefile=inputname.split('.').shift()+filename.split('.').pop();

                

                var extension = inputname.substr( (inputname.lastIndexOf('.') +1) ); // to get file extension

                

                //alert(filename);return false;

                

                // var form_data = new FormData();

                // var allfiles = $('#upload').files.length;

                // for (var i = 0; i < allfiles; i++) {

                // form_data.append("files[]", document.getElementById('files').files[i]);

                // }





                $('#filewrapper').append('<div class="showfilebox"><div class="left"><span class="filetype">'+extension+'</span>&nbsp;&nbsp;'+filename+'.'+extension+'&nbsp;&nbsp;<select style="width:auto; height:40px;"`>@foreach($attach_items as $att)<option>{{$att->name}}</option>@endforeach</select>&nbsp;&nbsp;<select style="width:auto; height:40px;"`>@foreach($attach_items as $att)<option>{{$att->description}}</option>@endforeach</select></div></div>'); 
                

                

                

                $('.right').click(function(){

                        $(this).closest('.showfilebox').remove();// remove parent of selector  

                            

                });



               

                ///     var upload = [];

                    // var file=$('#upload').val();

                    // upload.push(file);

                    //var upload= new FormData();

                    ///var length= $('#upload').length;

                    //var upval=$('#upload').val();



                    // var upval = $('#upload').val().split('\\').pop();

                    

                    // for (var i = 0; i < length; i++) {

                    //     upload.push(upval); 

                    // } 

                 

                    ////

                    

                    var paper_id = $('#2paper_id').val();

                    var upload = new FormData();



                    var files = $('#upload')[0].files;

                    //alert(files);

                    // Check file selected or not

                    if(files.length > 0 ){



                        upload.append('file',files[0]);

                        upload.append('paper_id',paper_id);



                        $.ajax({

                            url:'/front/paper2',

                            type:'post',

                            data:upload,

                            dataType: 'json',

                            contentType: false,

                            processData: false,

                            success:function(resp){

                        

                                $('#3paper_id').val(resp['paper_id']);

                            },error:function(){

                                                    alert("error");

                                                    }

                        });

                    }else{

                        alert("Please select a file.");

                    }



                    ///



                     

            });

    });

</script>

<script>

    <script>

  $(document).ready(function(){

      $('#addcontri').click(function(){

         var first_name = $('#first_name').val();

         var last_name=$('#last_name').val();

         console.log(last_name);

      });

  });

</script>

</script>

<script src="{{url('assets/plugins/input-tags/js/tagsinput.js')}}"></script>

<script>

        function _(element){

            return document.getElementById(element);

        }

    _   ('select_file').onchange = function(event){



        var form_data = new FormData();



        var image_number = 1;



        var error = '';



        for(var count = 0; count < _('select_file').files.length; count++)  {

        if(!['image/jpeg', 'image/png', 'video/mp4'].includes(_('select_file').files[count].type)){

            error += '<div class="alert alert-danger"><b>'+image_number+'</b> Selected File must be .jpg or .png Only.</div>';

        } else {

            form_data.append("images[]", _('select_file').files[count]);

        }

        image_number++;

    }



    if(error != ''){

        _('uploaded_image').innerHTML = error;

        _('select_file').value = '';

    } else {

        _('progress_bar').style.display = 'block';

        var ajax_request = new XMLHttpRequest();

        ajax_request.open("POST", "upload.php");

        ajax_request.upload.addEventListener('progress', function(event){

            var percent_completed = Math.round((event.loaded / event.total) * 100);

            _('progress_bar_process').style.width = percent_completed + '%';

            _('progress_bar_process').innerHTML = percent_completed + '% completed';

        });

        ajax_request.addEventListener('load', function(event){

            _('uploaded_image').innerHTML = '<div class="alert alert-success">Files Uploaded Successfully</div>';

            _('select_file').value = '';

        });

        ajax_request.send(form_data);

    }

 };

</script> 



         





