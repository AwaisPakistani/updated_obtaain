@php
use App\Models\Frontuser; 
use App\Models\Paper; 
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

								<li class="breadcrumb-item active" aria-current="page">Chiefeditor Responds</li>

							</ol>

						</nav>

					</div>

					<div class="ms-auto">

						<div class="btn-group">

							

							

						</div>

					</div>

				</div>

				<!--end breadcrumb--> 

				

				

				<h6 class="mb-0 text-uppercase">Chiefeditor's Responses</h6>

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

										<th>Paper ID</th>

										<th>Paper Title</th>

										<th>Chiefeditor's Name</th>

										<th>Message</th>
                    
                    <th>File</th>

										<th>Created At</th>

										<th>Action</th>

									</tr>

								</thead>

								<tbody>
									@php 
                  $sr=1;
									@endphp

                 @foreach($messages as $msg)

								<tr>
									<td>{{$sr}}</td>
									<td>{{$msg->paper_id}}</td>
									<td>
										@php
                    $paper = Paper::where('id',$msg->paper_id)->first();
                    echo $paper->submission_title;
										@endphp

									</td>
									<td>
										@php
                    $chief = Frontuser::where('id',$msg->from_user_id)->first();
                    $paper_id = $msg->paper_id;
                    $to_user = $msg->from_user_id;
                    $from_user = $msg->to_user_id;
                    echo $chief->first_name.' '.$chief->last_name;
										@endphp
									</td>
									<td>{{$msg->message}}</td>

									<td>
										      @if($msg->file_topublish!='')

										      @php
                          $path = explode('.',$msg->file_topublish);
                          @endphp

                           @if($path[1]=='pdf')

                          <a href="{{url('storage/'.$msg->file_topublish)}}" title="Click to read and download files" target="_blank">
                           
                          <i class='bx bxs-file-pdf me-2 font-24 text-danger'></i>
                          </a>

                          @else 

                          <a href="{{url('storage/'.$msg->file_topublish)}}" title="Click to read and download files" target="_blank">

                          <i class="fa fa-file-word" aria-hidden="true" style="font-size:48px;color:blue"></i>
                           word
                        

                          </a>

                          @endif

                          @else

                          @endif

                          
									</td>
									<td>
										{{date('d-m-Y',strtotime($msg->created_at))}}
									</td>
									<td>
										 <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
										  Reply
										</button>
										<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <form method="post" action="{{route('admin.respond_toChief')}}">@csrf
      <div class="modal-header">
        <h4 class="modal-title">Reply to Chiefeditor </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        
        	<div class="row">
            <div class="col-md-12">
            	<div class="form-group">
            		 <input type="hidden" name="paper_id" value="{{$paper_id}}">
            		 <input type="hidden" name="from_user_id" value="{{$from_user}}">
            		 <input type="hidden" name="to_user_id" value="{{$to_user}}">
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
									</td>
								</tr>
                 @php
                 $sr++;
                 @endphp
                 @endforeach

									

									

									

								</tbody>

								<tfoot>

									<tr>

                    <th>ID</th>

										<th>Paper ID</th>

										<th>Paper Title</th>

										<th>Chiefeditor's Name</th>

										<th>Message</th>

										<th>File</th>

										<th>Created At</th>

										<th>Action</th>

									</tr>

								</tfoot>

							</table>

						</div>

					</div>

				</div>

			</main>

       <!--end page main-->
       @php 
       $sr++;
       @endphp

@endsection