@extends('admin.layout.master')

@section('content')

<style type="text/css">
  .journalname{
    display: none;
  }
</style>               

<!--start content-->

<main class="page-content">

        <!--breadcrumb-->

				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

					<div class="breadcrumb-title pe-3">Front</div>

					<div class="ps-3">

						<nav aria-label="breadcrumb">

							<ol class="breadcrumb mb-0 p-0">

								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>

								</li>

								<li class="breadcrumb-item active" aria-current="page">Registration</li>

							</ol>

						</nav>

					</div>

					<div class="ms-auto">

						<div class="btn-group">

              @can('view')

							<a href="{{route('front.view_chiefeditors')}}" class="btn btn-primary">View Registered Users</a>

              @endcan

						</div>

					</div>

				</div>

				<!--end breadcrumb--> 

				

				

				<h6 class="mb-0 text-uppercase">{{$title}}</h6>

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





                <div class="col-12 col-xl-12 order-xl-3">

                  <div class="card-body p-4 p-sm-5">

                   

                     <form method="post"

                     action="{{route('front.add_chiefeditor')}}" enctype="multipart/form-data" class="form-body">@csrf 

                        <div class="row g-3">

                          <div class="col-6 ">

                            <label for="inputName" class="form- 

                            label">First Name</label>

                            <div class="ms-auto position-relative">

                              <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-person-circle"></i></div>

                              <input type="text" class="form-control radius-30 ps-5" id="inputName" name="first_name" 

                              placeholder="Enter First Name" required>

                            </div>

                          </div>

                          <div class="col-6 ">

                            <label for="inputName" class="form- 

                            label">Last Name</label>

                            <div class="ms-auto position-relative">

                              <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-person-circle"></i></div>

                              <input type="text" class="form-control radius-30 ps-5" id="inputName" name="last_name" 

                              placeholder="Enter Last Name" required>

                            </div>

                          </div>

                        </div><br>

                        <div class="row g-3">

                          <div class="col-6 ">

                            <label for="inputName" class="form- 

                            label">Role</label>

                            <div class="ms-auto position-relative">

                              <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-person-circle"></i></div>

                              <!-- <input type="text" class="form-control radius-30 ps-5" id="inputName" 

                              value="chiefeditor"

                              disabled> -->

                              <select class="form-control radius-30 ps-5" id="selectRole"  name="role">

                                <option value="chiefeditor">Chiefeditor</option>

                                <option value="reviewer">Reviewer</option>

                                <option value="publisher">Publisher</option>

                              </select>

                              <!-- <input type="hidden" name="role" value="chiefeditor"> -->

                            </div>

                          </div>

                          <div class="col-6 ">

                            <label for="inputName" class="form- 

                            label">Email</label>

                            <div class="ms-auto position-relative">

                              <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-envelope-fill"></i></div>

                              <input type="text" class="form-control radius-30 ps-5" id="inputName" name="email" 

                              placeholder="Enter Email" required>

                            </div>

                          </div>

                        </div><br>

                        <div class="row g-3">

                          <div class="col-6 ">

                            <label for="inputName" class="form- 

                            label">Password</label>

                            <div class="ms-auto position-relative">

                              <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-lock-fill"></i></div>

                              <input type="password" class="form-control radius-30 ps-5" id="inputName" name="password" 

                              placeholder="Enter Password" required>

                            </div>

                          </div>

                          <div class="col-6 ">

                            <label for="inputName" class="form- 

                            label">Confirm Password</label>

                            <div class="ms-auto position-relative">

                              <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-lock-fill"></i></div>

                              <input type="password" class="form-control radius-30 ps-5" id="inputName" name="retype_password" 

                              placeholder="Enter Re-type Password" required>

                            </div>

                          </div>

                        </div><br>

                        <div class="row g-3">

                          <div class="col-6 ">

                            <label for="inputName" class="form- 

                            label">Profile</label>

                            <div class="ms-auto position-relative">

                              <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-lock-fill"></i></div>

                              <input type="file" class="form-control radius-30 ps-5" id="inputName" name="profile" 

                               required>

                            </div>

                          </div><br><br><br>
                          <div class="col-6 journalname">
                             <label for="inputName" class="form- 

                            label">Select Journal for this Reviewer</label>
                             <select class="form-control radius-30 ps-5" id="selectRole"  name="journal_id">

                                <option value="chiefeditor">Select Journal</option>
                                @foreach($journals as $journal)      
                                <option value="{{$journal->id}}">{{$journal->journal_name}}</option>
                                @endforeach

                              </select>
                          </div>

                          

                        </div><br>

                        <div class="row g-3">

                        <div class="col-12">

                            <div class="d-grid">

                              <button type="submit" class="btn btn-primary radius-30">{{$title}}</button>

                            </div>

                          </div>

                        </div>

                    </form>

                 </div>

                </div>

</main>

        

       <!--end page main-->
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('#selectRole').change(function(){
    var role = $('#selectRole').val();
    if(role=='reviewer'){
      $('.journalname').show();
    }else{
      $('.journalname').hide();
    }
  });
});
</script>