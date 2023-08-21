@php 
use Illuminate\Support\Facades\DB;
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

								<li class="breadcrumb-item active" aria-current="page">Files</li>

							</ol>

						</nav>

					</div>

					<div class="ms-auto">

						<div class="btn-group">

							

							

						</div>

					</div>

				</div>

				<!--end breadcrumb--> 

				

				

				<h6 class="mb-0 text-uppercase">Files</h6>

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

										<th>Sr#</th>

										<th>Paper Title</th>

										<th>Files</th>

										<th>Created At</th>

										<th>Updated At</th>

										<th>Action</th>

									</tr>

								</thead>

								<tbody>
                 @php
                 $sr=1;
                 @endphp
                 @foreach($files as $file)
                 <tr>
                 	 <td>
                 	 	{{$sr}}
                 	 </td>
                 	 <td>
                 	 	@php 
                 	 	$paper = Paper::where('id',$file->paper_id)->first();
                 	 	echo $paper->submission_title;
                 	 	@endphp
                 	 </td>
                 	 <td>
                 	 	   @php

                          $path = explode('.',$file->filepath);

                          @endphp

                          

                          @if($path[1]=='pdf')

                          <a href="{{url('storage/'.$file->filepath)}}" title="Click to read and download files" target="_blank">
                           
                          <i class='bx bxs-file-pdf me-2 font-24 text-danger'></i>

														

                          </a>

                          @else 

                          <a href="{{url('storage/'.$file->filepath)}}" title="Click to read and download files" target="_blank">

                          <i class="fa fa-file-word" aria-hidden="true" style="font-size:48px;color:blue"></i>
                           word
                        

                          </a>

                          @endif
                 	 </td>
                 	 <td>{{date('d-m-Y',strtotime($file->created_at))}}</td>
                 	 <td>{{date('d-m-Y',strtotime($file->updated_at))}}</td>

                 </tr>
                 @php
                 $sr++;
                 @endphp
                 @endforeach

									

									

									

								</tbody>

								<tfoot>

									<tr>

                    <th>ID</th>

										<th>Paper Title</th>

										<th>Files</th>

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