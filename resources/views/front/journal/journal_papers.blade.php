@extends('admin.layout.master')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--start content-->

    <main class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

					<div class="breadcrumb-title pe-3">Journals</div>

					<div class="ps-3">

						<nav aria-label="breadcrumb">

							<ol class="breadcrumb mb-0 p-0">

								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>

								</li>

								<li class="breadcrumb-item active" aria-current="page">Journals</li>

							</ol>

						</nav>

					</div>

					<div class="ms-auto">

						<div class="btn-group">

                
						</div>

					</div>

				</div>

				<!--end breadcrumb--> 

				

				

				<h6 class="mb-0 text-uppercase">View JOurnal related Papers</h6>

				<hr/>

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

				<div class="card">

					<div class="card-body">

						<div class="table-responsive">

							<table id="example2" class="table table-striped table-bordered">

								<thead>

									<tr>

										<th>Sr#</th>

										<th>ID</th>

										<th>Paper Title</th>

										<th>Created At</th>

										<th>Open Files</th>

									</tr>

								</thead>

								<tbody>

                 @php $sr=1; @endphp        
                 @foreach($papers as $paper)
								<tr>
									<td>{{$sr}}</td>
									<td>{{$paper->id}}</td>
									<td>{{$paper->submission_title}}</td>
									<td>
										@php 
                     echo date('d-m-Y', strtotime($paper->created_at));
										@endphp
									</td>
									<td>
										<a href="{{route('admin.delete_journalpaper_files',$paper->id)}}" class="btn btn-danger btn-sm" title="Open files you want to delete">Open Files</a>
									</td>
								</tr>	
								@php $sr++; @endphp
                 @endforeach

									

									

									

								</tbody>

								<tfoot>

									<tr>

                    <th>Sr#</th>

										<th>ID</th>

										<th>Paper Title</th>

										<th>Created At</th>

										<th>Open Files</th>

									</tr>

								</tfoot>

							</table>

						</div>

					</div>

				</div>

			</main>

       <!--end page main-->

@endsection