@php 
use App\Models\AssignPaper;
use App\Models\Frontuser;
use App\Models\Contributor;
use App\Models\JournalVolume;
use App\Models\JournalIssue;

$author=Frontuser::where('id',$paper->frontuser_id)->first();                     
                        
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
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<!-- <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script> -->
@section('content')
@include('front.inc.journal_content_hero')
<div class="container mb-3 mt-3">
    <div class="row">
       <div class="col-lg-12 text-center">
       @include('front.inc.reviewer.buttons')
       </div>
      </div>
    <div class="row">
    
        <div class="col-lg-12 mt-2 text-end py-2 text-start" style="text-decoration:none;">
        @include('front.inc.alerts')
       
        </div>
    </div>
    <!-- Paper View -->
    <form method="post" action="{{route('front.reviewwr.paper_report_submit',[$journal->id,$paper->id])}}">@csrf
    <div class="row">
        <div class="col-lg-12">
        <div class="row">
        <div class="col-lg-6 mt-2">
        <h3>Paper Report</h3><hr/>
        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Title:</b>Please check keywords are written in the title and whether title accurately reflects the actual research issues addressed in this study, suggest suitable title if requires. 
              <textarea name="submit_title" id="title" cdeditor="true" ismandatory="false" placeholder="Title..."></textarea>
                               <!-- <script>
                                CKEDITOR.replace( 'title' );
                                
                               </script> -->
                               <script>
                                ClassicEditor
                                    .create( document.querySelector( '#title' ) )
                                    .catch( error => {
                                        console.error( error );
                                    } );
                               </script>
            </div>
            
        </div>
        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Abstract:</b>Is there objective, methodology, finding and implication or significance present?
              <textarea name="Abstract" id="abstract" cdeditor="true" ismandatory="false" placeholder="Abstract..."></textarea>
                               <script>
                                ClassicEditor
                                    .create( document.querySelector( '#abstract' ) )
                                    .catch( error => {
                                        console.error( error );
                                    } );
                               </script>
            </div>
            
        </div>
        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Keywords:</b>Does the keywords reflect the framework/model and overall study?
              <textarea name="keywords" id="keywords" cdeditor="true" ismandatory="false" placeholder="Keywords..."></textarea>
                               <script>
                                ClassicEditor
                                    .create( document.querySelector( '#keywords' ) )
                                    .catch( error => {
                                        console.error( error );
                                    } );
                               </script>
            </div>
            
        </div>
        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Introduction:</b>Does the introduction include clarity, flow and research gaps,significance and worthless?
              <textarea name="introduction" id="introduction" cdeditor="true" ismandatory="false" placeholder="Introduction..."></textarea>
                               <script>
                                ClassicEditor
                                    .create( document.querySelector( '#introduction' ) )
                                    .catch( error => {
                                        console.error( error );
                                    } );
                               </script>
            </div>
            
        </div>
        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Originality:</b>Does the paper contain new and significant information adequate to justify publication?
              <textarea name="originality" id="originality" cdeditor="true" ismandatory="false" placeholder="Originality..."></textarea>
                               <script>
                                ClassicEditor
                                    .create( document.querySelector( '#originality' ) )
                                    .catch( error => {
                                        console.error( error );
                                    } );
                               </script>
            </div>
            
        </div>
        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Relationship and Literature:</b>Does the exhaustiveness of literature shows the idea from contemporary support/justify the research being conducted.Does the paper cite an appropriate range of literature sources, critical anaylysis? Is any significant work ignored?
              <textarea name="relationship_and_literature" id="relationship_and_literature" cdeditor="true" ismandatory="false" placeholder="Relationship and Literature..."></textarea>
                               <script>
                                ClassicEditor
                                    .create( document.querySelector( '#relationship_and_literature' ) )
                                    .catch( error => {
                                        console.error( error );
                                    } );
                               </script>
            </div>
            
        </div>

        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Methodology:</b>Does the paper determince whether the choice of preposed method is suitable with the research objective? Does it determine clarity of explanation on method[step and procedure involved in data collection, sampling, method and choosing the respondents in data anaylysis].
              <textarea name="methodology" id="methodology" cdeditor="true" ismandatory="false" placeholder="Methodology..."></textarea>
                               <script>
                                ClassicEditor
                                    .create( document.querySelector( '#methodology' ) )
                                    .catch( error => {
                                        console.error( error );
                                    } );
                               </script>
            </div>
            
        </div>

        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Population and sample:</b>Determine whether the population, sampling, method, sampling frame, sample size, eligibilty criteria of study, participants and characteristics of study sample are suitable and appropriate to address the objective of the study.
              <textarea name="population_and_sample" id="population_and_sample" cdeditor="true" ismandatory="false" placeholder="Population and sample..."></textarea>
                               <script>
                                ClassicEditor
                                    .create( document.querySelector( '#population_and_sample' ) )
                                    .catch( error => {
                                        console.error( error );
                                    } );
                               </script>
            </div>
            
        </div>

        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Instrument:</b>Does instrument reflect objective and measured the stated variable? Does this determine the description on how instrument was developed/adopted and steps taken to insure validity and reliability?
              <textarea name="instrument" id="instrument" cdeditor="true" ismandatory="false" placeholder="Instrument..."></textarea>
                               <script>
                                ClassicEditor
                                    .create( document.querySelector( '#instrument' ) )
                                    .catch( error => {
                                        console.error( error );
                                    } );
                               </script>
            </div>
            
        </div>

        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Results:</b>Are results presented and analyzed appropriately? Do the conclusions adequately tie together the elements of the paper?
              <textarea name="results" id="results" cdeditor="true" ismandatory="false" placeholder="Results..."></textarea>
                               <script>
                                ClassicEditor
                                    .create( document.querySelector( '#results' ) )
                                    .catch( error => {
                                        console.error( error );
                                    } );
                               </script>
            </div>
            
        </div>
        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Implications for research practice and/or society:</b>Does the paper identify, clarify any Implications for research, practice and/or society?Does the paper bridge the gap between the theory and practices? What is the impact upon society[inflencing public attitudes affecting quality of life]? Are these implications consistent with the findings and conclusions of the paper?
              <textarea name="implications" id="implications" cdeditor="true" ismandatory="false" placeholder="Implications..."></textarea>
                               <script>
                                ClassicEditor
                                    .create( document.querySelector( '#implications' ) )
                                    .catch( error => {
                                        console.error( error );
                                     } );
                               </script>
            </div>
            
        </div>

        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Quality of communication:</b>Does the paper clearly express the case, measured against the technical language of the field and the expected knowledge of the journal's relationship? Has attention been paid to the clarity of expression and readability, such as influence structure, jargon use , acronyms etc.
              <textarea name="quality_of_commmunication" id="quality_of_commmunication" cdeditor="true" ismandatory="false" placeholder="Quality of Commmunication..."></textarea>
                               <script>
                                ClassicEditor
                                    .create( document.querySelector( '#quality_of_commmunication' ) )
                                    .catch( error => {
                                        console.error( error );
                                     } );
                               </script>
            </div>
            
        </div>

        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Recommendations:</b>
             <select name="recommendations" class="form-control">
              <option>Please Select</option>
              <option value="accept">Accept</option>
              <option value="minor_revisions">Minor Revisions</option>
              <option value="major_revisions">Major Revisions</option>
              <option value="reject_and_resubmit">Reject and Resubmit</option>
              <option value="reject">Reject</option>
             </select>
            </div>
            
        </div>

        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Would you like to review a revision of this manuscript?</b>
             <select name="review_revision" class="form-control">
              <option>Please Select</option>
              <option value="yes">Yes</option>
              <option value="no">No</option>
              
             </select>
            </div>
            
        </div>

        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Confidential comments to the editor:</b>
              <textarea name="editor_comments" id="editor_comments" cdeditor="true" ismandatory="false" placeholder="Confidential comments to the editor..."></textarea>
                               <script>
                                ClassicEditor
                                    .create( document.querySelector( '#editor_comments' ) )
                                    .catch( error => {
                                        console.error( error );
                                     } );
                               </script>
            </div>
            
        </div>

        <div class="row paperdetail">
            <div class="col-lg-12">
              <b>Comments to the author:</b>
              <textarea name="author_comments" id="author_comments" cdeditor="true" ismandatory="false" placeholder="Confidential Comments to the author..."></textarea>
                               <script>
                                ClassicEditor
                                    .create( document.querySelector( '#author_comments' ) )
                                    .catch( error => {
                                        console.error( error );
                                     } );
                               </script>
            </div>
            
        </div>
      
        
       
        
      
       
       
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        

               
           
        
        </div>
        <div class="col-lg-6 mt-2 text-start text-decoration-none py-2" style="text-decoration:none;">
        <h3>Paper Detail</h3>
        <hr/>
        <h4>Submission Title</h4>
        {{$paper->submission_title}}
        <h4>Abstract</h4>
        {!!$paper->abstract!!}
        @if(!empty($volume->journal_volume_name))
        <h4>Volume Name</h4>
        @php
        $volume= JournalVolume::with('current_issue')->where('id',$paper->volume_id)->first();
        @endphp
        
        {{$volume->journal_volume_name}}
        @else 
        @endif
        @if(!empty($volume->current_issue))
        <h4>Issue Name</h4>
        @php 
        echo $issue_name = JournalIssue::where('id',$volume->current_issue->issue_id)->value('journal_issue_name');
        @endphp
        @else 
        @endif
        <h4>Keywords</h4>
        {{$paper->keywords}}
       
        
        <h4>Additional Comments</h4>
        {!!$paper->comments!!}
        <h4>Contributors</h4>
                       1.{{$author->first_name}} {{$author->last_name}}<br>
                        @php
                        $conts=Contributor::where([
                            'author_id'=>$paper->frontuser_id,
                            'journal_id'=>$journal->id,
                            'paper_id'=>$paper->id
                            ])->get();

                        $cn=2;
                        @endphp
                        @foreach($conts as $contributor)
                        {{$cn}}.
                        {{$contributor->first_name}} {{$contributor->last_name}}
                        @php $cn++; @endphp
                        @endforeach 
        <h4>Files</h4>
        <a href="{{route('front.reviewwr.files',[$journal->id,$paper->id])}}" class="btn btn-success" title="Download and review files">See Files</a>
        
            
         
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
<script src="{{url('assets/plugins/input-tags/js/tagsinput.js')}}"></script>
