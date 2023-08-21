<!DOCTYPE html>
<html>
<head>
	<title>Obtaain-Paper Report </title>
    <style>
        .report span{
            display: inline-flex;
        }
        .report span b{
          width: 30%;
        }
        .report span .recommend{
          width: 100%;
        }
    </style>
</head>
<body>
<p>
  Dear {{$name}},<br>
  {!!$msg!!}<br>
</p>
<span stype="font-size:20px;"><b>Report from Reviewer#1 </b></span>
<div class="report">  
       @if(!empty($report1->title_remarks)) 
       <span><b>Title Remarks :</b> {!!$report1->title_remarks!!}</span>
       @endif<br>
       @if(!empty($report1->abstract_remarks)) 
       <span><b>Abstract Remarks:</b> {!!$report1->abstract_remarks!!}</span>
       @endif<br>
       @if(!empty($report1->keyword_remarks))
       <span><b>Keywords Remarks:</b> {!!$report1->keyword_remarks!!}</span>
       @endif<br>
       @if(!empty($report1->introduction_remarks))
       <span><b>Introduction Remarks:</b> {!!$report1->introduction_remarks!!}</span>
       @endif<br>
       @if(!empty($report1->originality_remarks))
       <span><b>Originality Remarks:</b> {!!$report1->originality_remarks!!}</span>
       @endif<br>
       @if(!empty($report1->relationship_remarks))
       <span><b>Relationship Remarks:</b> {!!$report1->relationship_remarks!!}</span>
       @endif<br>
       @if(!empty($report1->framework_remarks))
       <span><b>Framework Remarks:</b> {!!$report1->framework_remarks!!}</span><br>
       @endif
       @if(!empty($report1->methodology_remarks))
       <span><b>Methodology Remarks:</b> {!!$report1->methodology_remarks!!}</span><br>
       @endif
       @if(!empty($report1->population_remarks))
       <span><b>Population Remarks:</b> {!!$report1->population_remarks!!}</span><br>
       @endif
       @if(!empty($report1->instrument_remarks))
       <span><b>Instrument Remarks:</b> {!!$report1->instrument_remarks!!}</span><br>
       @endif
       @if(!empty($report1->result_remarks))
       <span><b>Result Remarks:</b> {!!$report1->result_remarks!!}</span><br>
       @endif
       @if(!empty($report1->implications_remarks))
       <span><b>Implications Remarks:</b> {!!$report1->implications_remarks!!}</span><br>
       @endif
       @if(!empty($report1->quality_remarks))
       <span><b>Quality Remarks:</b> {!!$report1->quality_remarks!!}</span><br>
       @endif
       @if(!empty($report1->for_author_comments))
       <span><b>Comments:</b> {!!$report1->for_author_comments!!}</span><br>
       @endif

       <span><b class="recommend">Recommendation Remarks:</b></span><br>
       <span>
                @if($report2->recommendation_remarks=='minor_revisions')
                Minor Revision
                @elseif($report2->recommendation_remarks=='major_revisions')
                Major Revision
                @elseif($report2->recommendation_remarks=='reject')
                Reject
                @elseif($report2->recommendation_remarks=='accept')
                Accept
                @else
                Reject and Resubmit
                @endif
       </span>
</div><br>
<span stype="font-size:20px;"><b>Report from Reviewer#2 </b></span>
<div class="report">
      @if(!empty($report2->title_remarks)) 
       <span><b>Title Remarks :</b> {!!$report1->title_remarks!!}</span>
       @endif<br>
       @if(!empty($report2->abstract_remarks)) 
       <span><b>Abstract Remarks:</b> {!!$report1->abstract_remarks!!}</span>
       @endif<br>
       @if(!empty($report2->keyword_remarks))
       <span><b>Keywords Remarks:</b> {!!$report1->keyword_remarks!!}</span>
       @endif<br>
       @if(!empty($report2->introduction_remarks))
       <span><b>Introduction Remarks:</b> {!!$report1->introduction_remarks!!}</span>
       @endif<br>
       @if(!empty($report2->originality_remarks))
       <span><b>Originality Remarks:</b> {!!$report1->originality_remarks!!}</span>
       @endif<br>
       @if(!empty($report2->relationship_remarks))
       <span><b>Relationship Remarks:</b> {!!$report1->relationship_remarks!!}</span>
       @endif<br>
       @if(!empty($report2->framework_remarks))
       <span><b>Framework Remarks:</b> {!!$report1->framework_remarks!!}</span><br>
       @endif
       @if(!empty($report2->methodology_remarks))
       <span><b>Methodology Remarks:</b> {!!$report2->methodology_remarks!!}</span><br>
       @endif
       @if(!empty($report2->population_remarks))
       <span><b>Population Remarks:</b> {!!$report1->population_remarks!!}</span><br>
       @endif
       @if(!empty($report2->instrument_remarks))
       <span><b>Instrument Remarks:</b> {!!$report1->instrument_remarks!!}</span><br>
       @endif
       @if(!empty($report2->result_remarks))
       <span><b>Result Remarks:</b> {!!$report1->result_remarks!!}</span><br>
       @endif
       @if(!empty($report2->implications_remarks))
       <span><b>Implications Remarks:</b> {!!$report1->implications_remarks!!}</span><br>
       @endif
       @if(!empty($report2->quality_remarks))
       <span><b>Quality Remarks:</b> {!!$report1->quality_remarks!!}</span><br>
       @endif
       @if(!empty($report2->for_author_comments))
       <span><b>Comments:</b> {!!$report1->for_author_comments!!}</span><br>
       @endif
       <span><b  class="recommend">Recommendation Remarks:</b>
       
                @if($report2->recommendation_remarks=='minor_revisions')
                Minor Revision
                @elseif($report2->recommendation_remarks=='major_revisions')
                Major Revision
                @elseif($report2->recommendation_remarks=='reject')
                Reject
                @elseif($report2->recommendation_remarks=='accept')
                Accept
                @else
                Reject and Resubmit
                @endif
        
      </span>
</div>
<!-- Contact via Email : <a href="mailto:{{$email}}">Reviewer</a> -->
</body>
</html>
