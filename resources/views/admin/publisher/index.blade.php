@php 
use Illuminate\Support\Facades\DB;
use App\Models\Frontuser;
use App\Models\Paper;
use App\Models\Journal;
$from_user=Auth::guard('web')->user()->id;
//dd($from_user);
@endphp
@extends('admin.layout.master')

@section('content')



    <!--start content-->

    <main class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

					<div class="breadcrumb-title pe-3">Publisher Section</div>

					<div class="ps-3">

						<nav aria-label="breadcrumb">

							<ol class="breadcrumb mb-0 p-0">

								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>

								</li>

								<li class="breadcrumb-item active" aria-current="page">Papers</li>

							</ol>

						</nav>

					</div>

					<div class="ms-auto">

						<div class="btn-group">

							

							

						</div>

					</div>

				</div>

				<!--end breadcrumb--> 

				

				

				<h6 class="mb-0 text-uppercase">Publish Papers</h6>

				 <!--alerts-->

                 @if(Session::has('success_message'))

                <div class="alert border-0 bg-light-success alert-dismissible fade show py-2">

                    <div class="d-flex align-items-center">

                      <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i>

                      </div>

                      <div class="ms-3">

                        <div class="text-success">{{Session::get('success_message')}}</div>

                      </div>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                  </div>

                  @endif

                  @if(Session::has('error_message'))

                  <div class="alert border-0 bg-light-danger alert-dismissible fade show py-2">

                    <div class="d-flex align-items-center">

                      <div class="fs-3 text-danger"><i class="bi bi-x-circle-fill"></i>

                      </div>

                      <div class="ms-3">

                        <div class="text-danger">{{Session::get('error_message')}}</div>

                      </div>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                  </div>

                  @endif

                  <!--alerts-->

				<hr/>

				<div class="card">

					<div class="card-body">

						<div class="table-responsive">

							<table id="example2" class="table table-striped table-bordered">

								<thead>

									<tr>

										<th>ID</th>

										<th>JOurnal Name</th>

										<th>Paper Title</th>

										<th>Created At</th>

										<th>Updated At</th>

										<th>Action</th>

									</tr>

								</thead>

								<tbody>

                 @foreach($papers as $paper)

									<tr>

										<td>{{$paper->id}}</td>

										<td>
											
											@php
                      $journal = Journal::where('id',$paper->journal_id)->first();
                      echo $journal->journal_name;
											@endphp
										</td>

										<td>{{$paper->submission_title}}</td>

										

										<td>

										{{date('d-m-Y',strtotime($paper->created_at))}}	

										</td>

										<td>{{date('d-m-Y',strtotime($paper->updated_at))}}	</td>

										

						   <td>

                             <div class="table-actions d-flex align-items-center gap-3 fs-6">
                               <!-- <a href="{{route('admin.paper_publish_do',$paper->id)}}" class="btn btn-primary" id="sweetalertconfirm" onclick="confirm('Are you sure?You want to publish this paper?')">Hold
                               </a> -->
                               <a href="{{route('admin.publisher_showing_files',$paper->id)}}" class="btn btn-danger">Files</a>
                               <!-- <a href="{{route('admin.paper_publish_do',$paper->id)}}" class="btn btn-warning" id="sweetalertconfirm" onclick="confirm('Are you sure?You want to publish this paper?')">
							   	PUblish 
							   </a> -->
							   
                 <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#publishModal">
                 	Upload to Publish
                 </button>
                 <!-- The Modal -->
<div class="modal" id="publishModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <form method="POST" enctype="multipart/form-data" action="{{route('admin.publish_fileToUpload',$paper->id)}}">@csrf
      <div class="modal-header">
        <h4 class="modal-title">Upload File to Publish </h4>
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
        <button type="submit" class="btn btn-primary">Publish</button>
      </div>
      </form>

    </div>
  </div>
</div>
<!-- Model ends here -->

							   <!-- Remarks Portion ends here -->
							   <!-- Remarks -->

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
  Remarks
</button>
 @php
 $chief = Paper::where('chief_id',$paper->chief_id)->value('chief_id');
 $author = Paper::where('frontuser_id',$paper->frontuser_id)->value('frontuser_id');

 $messagechief = DB::table('messages')->where([
 'paper_id'=>$paper->id,
 'from_user_id'=>$chief
 ])->count();

 $messageauthor = DB::table('messages')->where([
 'paper_id'=>$paper->id,
 'from_user_id'=>$author
 ])->count();

 @endphp
 @if($messagechief > 0 || $messageauthor > 0)
 <a href="{{route('admin.publisher_responses')}}" class="btn btn-success">Responds</a>
 @else
 @endif
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <form method="post" action="{{route('admin.publisher_remarks',$paper->id)}}">@csrf
      <div class="modal-header">
        <h4 class="modal-title">Publisher Remarks </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        
        	<div class="row">
            <div class="col-md-12">
            	<div class="form-group">
            		 <input type="hidden" name="paper_id" value="{{$paper->id}}">
            		 <input type="hidden" name="from_user_id" value="{{$from_user}}">
            		 <input type="hidden" name="to_user_id" value="{{$paper->chief_id}}">
            		 <br>
            		 <select name="receiver" class="form-control">
            		 	 <option>Send To</option>
            		 	 <option value="{{$paper->frontuser_id}}">Paper's Author</option>
            		 	 <option value="{{$paper->chief_id}}">Paper's Chiefeditor</option>
            		 </select><br>
            		 <textarea name="remarks" class="form-control" placeholder="Enter Remarks..."></textarea>

            	</div>
            </div>

        	</div>
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Send</button>
      </div>
      </form>

    </div>
  </div>
</div>

							   <!-- Remarks Portion ends here -->


                             </div>

                           </td>

										

									</tr>

                                    @endforeach

									

									

									

								</tbody>

								<tfoot>

									<tr>

                    <th>ID</th>

                    <th>JOurnal Name</th>

										<th>Paper Title</th>

										<th>Created At</th>

										<th>Updated At</th>

										<th>Action</th>

									</tr>

								</tfoot>

							</table>

						</div>

					</div>

				</div>

			</main>

       <!--end page main-->

@endsection