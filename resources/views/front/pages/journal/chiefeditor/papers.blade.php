@php 
use App\Models\Frontuser;
use App\Models\Contributor;
use App\Models\PaperReport;
use App\Models\AssignPaper;
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
                          <h3 class="text-start">Papers</h3>
                          
                        </span>
                        <table @if($papers->count() > 10) id="example" @endif class="table table-striped" style="width:100%">
                <thead>
                   
                    <tr>
                        <th>S.No</th>
                        <th>Author Name</th>
                        <th>Title</th>
                        <th>Article Type</th>
                        <th>Contributors</th>
                        <th>Revision</th>
                        <th>Submitted At</th>
                        <th>Action</th>
                    </tr>
                    
                </thead>
                <tbody>
                @php
                $sr=1;
                @endphp
                @foreach($papers as $paper)
                    <tr>
                        <td>{{$sr}}</td>
                        <td>
                          @php
                          $author=Frontuser::where('id',$paper->frontuser_id)->first();
                          @endphp  
                        {{$author->first_name}} {{$author->last_name}}</td>
                        <td>
                            {{$paper->submission_title}}
                        </td>
                        <td>
                            {{$paper->article_type}}
                        </td>
                        <td>
                        {{$author->first_name}} {{$author->last_name}}<br>
                        @php
                        $conts=Contributor::where([
                            'author_id'=>$paper->frontuser_id,
                            'journal_id'=>$journal->id,
                            'paper_id'=>$paper->id
                            ])->get();

                        @endphp
                        @foreach($conts as $contributor)
                        {{$contributor->first_name}} {{$contributor->last_name}}
                        @endforeach
                        </td>
                        <td>{{$paper->revision}}</td>
                        <td>
                        @php
                        echo date('d-m-Y', strtotime($paper->created_at));  
                        @endphp</td>
                        <td>
                        <div class="btn-group me-2" role="group" aria-label="Second group">
                        
                        @php 
                        $report = PaperReport::where('paper_id',$paper->id)->count();
                        $assign = AssignPaper::where('paper_id',$paper->id)->count();
                        @endphp
                        @if($report > 1)
                        <a href="{{route('front.chief.paper_report',[$journal->id,$paper->id])}}" class="btn btn-primary">Report</a>
                        @else 

                        @if($assign > 0)
                        @else 
                        @if(!empty($paper->comments))
                        <button  type="button" class="text-primary" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$paper->id}}" title="View Author Comment" style="border: 0px;"><i class="fa fa-message">(1)</i></button>
                        @endif
                        <a href="{{route('front.chief.papers_assigning',$paper->id)}}" class="btn btn-warning">Assign Paper</a>
                        @endif
                        @endif
                      </div>
                        </td>
                        <td></td>
                    </tr>
                    @php
                    $sr++;
                    @endphp

                    @if(!empty($paper->comments))                <!-- Modal -->
                    <div class="modal fade" id="exampleModal-{{$paper->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Author Comments ({{$paper->submission_title}})</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body text-start">
                             <b>Comments:</b>{!!$paper->comments!!}
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endif
                @endforeach
                </tbody>
                <tfoot>
                
                    <tr>
                    <th>S.No</th>
                        <th>Author Name</th>
                        <th>Title</th>
                        <th>Article Type</th>
                        <th>Contributors</th>
                        <th>Revision</th>
                        <th>Submitted At</th>
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
