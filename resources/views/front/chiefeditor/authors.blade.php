@extends('admin.layout.master')

@section('content')



    <!--start content-->

    <main class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

					<div class="breadcrumb-title pe-3">Registration</div>

					<div class="ps-3">

						<nav aria-label="breadcrumb">

							<ol class="breadcrumb mb-0 p-0">

								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>

								</li>

								<li class="breadcrumb-item active" aria-current="page">View Front Authors</li>

							</ol>

						</nav>

					</div>

					<div class="ms-auto">

						<div class="btn-group">

                            

							

						</div>

					</div>

				</div>

				<!--end breadcrumb--> 

				

				

				<h6 class="mb-0 text-uppercase">Authors</h6>

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

										<th>ID</th>

										<th>Name</th>

										<th>Email</th>

                                        <th>Role</th>

                                        <th>Phone</th>

										<th>Created At</th>

										<th>Updated At</th>

										<th>Action</th>

									</tr>

								</thead>

								<tbody>

                                    @foreach($authors as $author)

									@if($author->hasRole('author'))

									<tr>

										<td>{{$author->id}}</td>

										<td>{{$author->first_name}} {{$author->last_name}}</td>

<td>{{$author->email}}</td>                                  



<td>

    @if($author->roles)

	  

      @foreach($author->roles as $role)

	    @if($role->name=='paper_editor')

		Editor 

      @else 

       <p style="text-transform:capitalize;">

	   {{$role->name}}

	   </p> 

	  @endif

      @endforeach

	  

    @endif

</td>
<td>{{$author->author->phone}}</td>

<td>
@php
echo $Date = date("d-m-Y", strtotime($author->created_at));
@endphp
</td>

<td>
@php
echo $newDate = date("d-m-Y", strtotime($author->updated_at));
@endphp
</td>

										<td>

                             <div class="table-actions d-flex align-items-center gap-3 fs-6">
                               <button  type="button" class="text-primary" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$author->id}}" title="View Author Detail" style="border: 0px;"><i class="bi bi-eye-fill"></i></button>

                               <a href="{{route('front.change_chief_password',$author->id)}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Change Password"><i class="bi bi-key-fill"></i></a>

                               <a href="{{route('front.edit_chiefeditor',$author->id)}}" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill"></i></a>

							  

                               <a href="{{route('front.delete_author',$author->id)}}" class="text-danger"

							   onClick="return confirm('Are you sure?YOu want to delete this?')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" id="delteSweetConfirm"><i class="bi bi-trash-fill"></i></a>
                             </div>

                           </td>



<!-- Author Detail -->
                <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal-{{$author->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Author Detail ({{$author->first_name}})</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <b>Qualification:</b>{{$author->author->highest_qualification}}&nbsp;&nbsp;<b>Phone:</b>{{$author->author->phone}}<br>

         <b>Prefered Name:</b>{{$author->author->prefered_name}}&nbsp;&nbsp;<b>Position:</b>{{$author->author->position}}<br>

         <b>Institution:</b>{{$author->author->institution}}&nbsp;&nbsp;<b>Department:</b>{{$author->author->department}}<br>

         <b>Address:</b>{{$author->author->address}}&nbsp;&nbsp;<b>country:</b>{{$author->author->country}}<br>

         <b>State Province:</b>{{$author->author->state_province}}&nbsp;&nbsp;<b>Zip Code:</b>{{$author->author->zip}}<br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
				<!-- Author Detail End -->

										

									</tr>

									@endif

                                    @endforeach

									

									

									

								</tbody>

								<tfoot>

									<tr>

                                        <th>ID</th>

										<th>Name</th>

										<th>Email</th>

                                        <th>Role</th>

                                        <th>Phone</th>

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