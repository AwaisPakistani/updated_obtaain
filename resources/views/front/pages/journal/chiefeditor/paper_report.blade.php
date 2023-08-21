@php 

use App\Models\Frontuser;

use App\Models\Paper;

@endphp

@extends('front.layout.main')

<link href="{{url('assets/front/dist/css/datatable.min.css')}}" rel="stylesheet">

<link href="{{url('assets/front/dist/css/cdn.css')}}" rel="stylesheet">

<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

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

       

        <form method="post" action="{{route('front.chief.reportSendAuthor',[$journal,$paper_report,$paper_report_reviewer2])}}" enctype="multipart/form-data">@csrf
            
            <div class="content text-start">

               <div class="row">

                 <div class="col-md-12">

                     <h2>Paper Report Reviewer 1</h2>

                 </div>

               </div>

               <div class="row">

                <div class="col-md-6">

                  <b>Title Remarks</b>

                 

                  <textarea name="title_remarks" id="title" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report->title_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#title' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                <div class="col-md-6">

                  <b>Abstract Remarks</b>

                  <textarea name="abstract_remarks" id="abstract_remarks" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report->abstract_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#abstract_remarks' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

               </div>

    

               <div class="row">

                <div class="col-md-6">

                  <b>Keywords Remarks</b>

                  <textarea name="keyword_remarks" id="keyword_remarks" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report->keyword_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#keyword_remarks' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                <div class="col-md-6">

                  <b>Introduction Remarks</b>

                  <textarea name="introduction_remarks" id="introduction_remarks" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report->introduction_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#introduction_remarks' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

               </div>

    

               <div class="row">

                <div class="col-md-6">

                  <b>Originality Remarks</b>

                  <textarea name="originality_remarks" id="originality_remarks" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report->originality_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#originality_remarks' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                <div class="col-md-6">

                  <b>Relationship Remarks</b>

                  <textarea name="relationship_remarks" id="relationship_remarks" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report->relationship_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#relationship_remarks' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

               </div>

    

               <div class="row">

                <div class="col-md-6">

                  <b>Framework Remarks</b>

                  

                  <textarea name="framework_remarks" id="framework_remarks" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report->framework_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#framework_remarks' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                <div class="col-md-6">

                  <b>Methodology Remarks</b>

                  

                  <textarea name="methodology_remarks" id="methodology_remarks" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report->methodology_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#methodology_remarks' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

               </div>

    

               <div class="row">

                <div class="col-md-6">

                  <b>Population Remarks</b>

                 

                  <textarea name="population_remarks" id="population_remarks" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report->population_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#population_remarks' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                <div class="col-md-6">

                  <b>Instrument Remarks</b>

                  

                  <textarea name="instrument_remarks" id="instrument_remarks" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report->instrument_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#instrument_remarks' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

               </div>

    

               <div class="row">

                <div class="col-md-6">

                  <b>Result Remarks</b>

                  

                  <textarea name="result_remarks" id="result_remarks" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report->result_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#result_remarks' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                <div class="col-md-6">

                  <b>Implications Remarks</b>

                 

                  <textarea name="implications_remarks" id="implications_remarks" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report->implications_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#implications_remarks' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

               </div>

    

               <div class="row">

                <div class="col-md-6">

                  <b>Quality Remarks</b>

                  

                  <textarea name="quality_remarks" id="quality_remarks" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report->quality_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#quality_remarks' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                <div class="col-md-6">

                 <!--  <b>Recommendation Remarks</b>

                     <select name="recommendations" class="form-control">

                        <option>Please Select</option>

                        

                        <option value="accept" @if($paper_report->recommendation_remarks== 'accept') selected @endif>Accept</option>

                        <option value="minor_revisions" @if($paper_report->recommendation_remarks== 'minor_revisions') selected @endif>Minor Revisions</option>

                        <option value="major_revisions" @if($paper_report->recommendation_remarks== 'major_revisions') selected @endif>Major Revisions</option>

                        <option value="reject_and_resubmit" @if($paper_report->recommendation_remarks== 'reject_and_resubmit') selected @endif>Reject and Resubmit</option>

                        <option value="reject"@if($paper_report->recommendation_remarks== 'reject') selected @endif>Reject</option>

                     </select> -->
                     <b>For Author Comments</b>

                  <textarea name="for_author_comments" id="for_author_comments" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report->for_author_comments}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#for_author_comments' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

            </div>

                </div>

               </div>

    

               <div class="row">

                <div class="col-md-6  text-start">

                  <!-- <b>Revision Status</b>

                  

                  <select name="review_revision" class="form-control">

                    <option>Please Select</option>

                    <option value="yes" @if($paper_report->revision_status== 'yes') selected @endif>Yes</option>

                    <option value="no" @if($paper_report->revision_status== 'no') selected @endif>No</option>

                    

                  </select> -->


                  <b>For Chiefeditor Comments</b> 

                  <textarea name="for_chiefeditor_comments" id="for_chiefeditor_comments" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report->for_chiefeditor_comments}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#for_chiefeditor_comments' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                
                </div>

                <div class="col-md-6  text-start">
                  <br><br>

                  <b>Submitted At</b>

                  @php  

                  echo date("d-m-Y", strtotime($paper_report->created_at));

                  @endphp

                </div>

               </div>
            </div><br><br>
        <!-- ///////////////////////
            For Reviewer 2
        /////////////////////// -->
         <div class="content text-start">

               <div class="row">

                 <div class="col-md-12">

                     <h2>Paper Report Reviewer 2</h2>

                 </div>

               </div>

               <div class="row">

                <div class="col-md-6">

                  <b>Title Remarks</b>

                 

                  <textarea name="title_remarks_rev2" id="title_rev2" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report_reviewer2->title_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#title_rev2' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                <div class="col-md-6">

                  <b>Abstract Remarks</b>

                  <textarea name="abstract_remarks_rev2" id="abstract_remarks_rev2" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report_reviewer2->abstract_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#abstract_remarks_rev2' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

               </div>

    

               <div class="row">

                <div class="col-md-6">

                  <b>Keywords Remarks</b>

                  <textarea name="keyword_remarks_rev2" id="keyword_remarks_rev2" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report_reviewer2->keyword_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#keyword_remarks_rev2' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                <div class="col-md-6">

                  <b>Introduction Remarks</b>

                  <textarea name="introduction_remarks_rev2" id="introduction_remarks_rev2" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report_reviewer2->introduction_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#introduction_remarks_rev2' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

               </div>

    

               <div class="row">

                <div class="col-md-6">

                  <b>Originality Remarks</b>

                  <textarea name="originality_remarks_rev2" id="originality_remarks_rev2" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report_reviewer2->originality_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#originality_remarks_rev2' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                <div class="col-md-6">

                  <b>Relationship Remarks</b>

                  <textarea name="relationship_remarks_rev2" id="relationship_remarks_rev2" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report_reviewer2->relationship_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#relationship_remarks_rev2' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

               </div>

    

               <div class="row">

                <div class="col-md-6">

                  <b>Framework Remarks</b>

                  

                  <textarea name="framework_remarks_rev2" id="framework_remarks_rev2" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report_reviewer2->framework_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#framework_remarks_rev2' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                <div class="col-md-6">

                  <b>Methodology Remarks</b>

                  

                  <textarea name="methodology_remarks_rev2" id="methodology_remarks_rev2" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report_reviewer2->methodology_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#methodology_remarks_rev2' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

               </div>

    

               <div class="row">

                <div class="col-md-6">

                  <b>Population Remarks</b>

                 

                  <textarea name="population_remarks_rev2" id="population_remarks_rev2" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report_reviewer2->population_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#population_remarks_rev2' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                <div class="col-md-6">

                  <b>Instrument Remarks</b>

                  

                  <textarea name="instrument_remarks_rev2" id="instrument_remarks_rev2" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report_reviewer2->instrument_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#instrument_remarks_rev2' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

               </div>

    

               <div class="row">

                <div class="col-md-6">

                  <b>Result Remarks</b>

                  

                  <textarea name="result_remarks_rev2" id="result_remarks_rev2" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report_reviewer2->result_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#result_remarks_rev2' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                <div class="col-md-6">

                  <b>Implications Remarks</b>

                 

                  <textarea name="implications_remarks_rev2" id="implications_remarks_rev2" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report_reviewer2->implications_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#implications_remarks_rev2' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

               </div>

    

               <div class="row">

                <div class="col-md-6">

                  <b>Quality Remarks</b>

                  

                  <textarea name="quality_remarks_rev2" id="quality_remarks_rev2" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report_reviewer2->quality_remarks}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#quality_remarks_rev2' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                <div class="col-md-6">

                 <!--  <b>Recommendation Remarks</b>

                     <select name="recommendations_rev2" class="form-control">

                        <option>Please Select</option>

                        

                        <option value="accept" @if($paper_report_reviewer2->recommendation_remarks== 'accept') selected @endif>Accept</option>

                        <option value="minor_revisions" @if($paper_report_reviewer2->recommendation_remarks== 'minor_revisions') selected @endif>Minor Revisions</option>

                        <option value="major_revisions" @if($paper_report_reviewer2->recommendation_remarks== 'major_revisions') selected @endif>Major Revisions</option>

                        <option value="reject_and_resubmit" @if($paper_report_reviewer2->recommendation_remarks== 'reject_and_resubmit') selected @endif>Reject and Resubmit</option>

                        <option value="reject"@if($paper_report_reviewer2->recommendation_remarks== 'reject') selected @endif>Reject</option>

                     </select> -->
                      <b>For Author Comments</b>

                  <textarea name="for_author_comments_rev2" id="for_author_comments_rev2" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report_reviewer2->for_author_comments}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#for_author_comments_rev2' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                </div>

               </div>

    

               <div class="row">

                <div class="col-md-6  text-start">

                 <!--  <b>Revision Status</b>

                  

                  <select name="review_revision_rev2" class="form-control">

                    <option>Please Select</option>

                    <option value="yes" @if($paper_report_reviewer2->revision_status== 'yes') selected @endif>Yes</option>

                    <option value="no" @if($paper_report_reviewer2->revision_status== 'no') selected @endif>No</option>

                    

                  </select> -->
                  <b>For Chiefeditor Comments</b> 

                  <textarea name="for_chiefeditor_comments_rev2" id="for_chiefeditor_comments_rev2" cdeditor="true" ismandatory="false" placeholder="Title...">{{$paper_report_reviewer2->for_chiefeditor_comments}}</textarea>

                  <script>

                                ClassicEditor

                                    .create( document.querySelector( '#for_chiefeditor_comments_rev2' ) )

                                    .catch( error => {

                                        console.error( error );

                                    } );

                               </script>

                </div>

                <div class="col-md-6  text-start">
                 <br><br>
                 <b>Submitted At</b>

                  @php  

                  echo date("d-m-Y", strtotime($paper_report_reviewer2->created_at));

                  @endphp

                </div>

               </div>

    

              <br>
               <div class="row">
                 <div class="col-md-12">
                   <button type="submit" class="btn btn-primary w-100" >Send Reports to Author</button><br><br>
                   <a class="btn btn-primary w-100" href="{{route('chiefeditor.send_paperreport_toPublisher',$paper_id)}}">Send to Publisher</a>
                 </div>
               </div>

    

              

    

            </div>
        </form>

        

        

         

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

