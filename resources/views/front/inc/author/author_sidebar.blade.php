<link href="{{url('assets/front/dist/css/datatable.min.css')}}" rel="stylesheet">

<link href="{{url('assets/front/dist/css/cdn.css')}}" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
<style>

 .author-links a{

    text-decoration:none;

 }

 .author-links a:hover{

    color:#ff8000;

 }

.name{

    font-size:20px;

}









 .nav-pills-custom .nav-link {

    color: black;

    background: #fff;

    position: relative;

}

                  

.nav-pills-custom .nav-link.active {

    color: #45b649;

    background: #fff;

    

}





/* Add indicator arrow for the active tab */

@media (min-width: 992px) {

    .nav-pills-custom .nav-link::before {

        content: '';

        display: block;

        border-top: 8px solid transparent;

        border-left: 10px solid #fff;

        border-bottom: 8px solid transparent;

        position: absolute;

        top: 50%;

        right: -10px;

        transform: translateY(-50%);

        opacity: 0;

    }

}



.nav-pills-custom .nav-link.active::before {

    opacity: 1;

}


.btn-toggle-nav li a{
    text-decoration: none;
}

/*Dropdown*/

.dropdown-btn {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 15px;
  color: #818181;
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}
/* Main content */


/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
  background-color: white;
  color:black;
  padding-left: 8px;
}
.dropdown-container a{
    text-decoration: none;
    background: white;
}

/* Optional: Style the caret down icon */
.fa-caret-down {
  float: right;
  padding-right: 8px;
}

 

</style>
                <!-- Tabs nav -->

                <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                    <a href="{{route('front.author.dashboard',$journal->id)}}" class="nav-link mb-3 p-3 shadow" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">

                        <span class="font-weight-bold small text-uppercase" style="font-size:1.3em;"><b>



                        Author Dashboard

                        </b></span></a>

                        <a href="{{route('front.paper_submit_new',$journal->id)}}" class="nav-link mb-3 p-3 shadow" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">

                        <span class="font-weight-bold small text-uppercase"><b>Start New Submission</b></span></a>



                    <a href="{{route('front.author.dashboard',$journal->id)}}" class="nav-link mb-3 p-3 shadow" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">

                        <span class="font-weight-bold small text-uppercase"><b>Submitted Manuscripts ({{$papers->count()}})</b></span></a>

                       <a class="nav-link mb-3 p-3 shadow dropdown-btn font-weight-bold small text-uppercase"><b>Revisions & Completed</b> 
						    <i class="fa fa-caret-down"></i>
						  </a>
						  <div class="dropdown-container font-weight-bold small text-uppercase">
						  	<a href="#" class="nav-link mb-3 p-3 shadow" style="font-size:1em;"><b>Revisions</b></a>
						    <a href="{{route('front.author.submissions_needing_revisions',$journal->id)}}" class="nav-link mb-3 p-3 shadow">Submissions Needing Revision ({{$paper_need->count()}})</a>
						    <a href="{{route('front.author.papers_backToAuthor',$journal->id)}}" class="nav-link mb-3 p-3 shadow">Revisions Sent Back to Author ({{$revision_backToAuthor->count()}})</a>
						    <a href="{{route('front.author.revisions_being_processed',$journal->id)}}" class="nav-link mb-3 p-3 shadow">Revisions Being Processed ({{$revisions_being_processed->count()}})</a>
						    <a href="{{route('front.author.papers_declined',$journal->id)}}" class="nav-link mb-3 p-3 shadow">Declined Revisions ({{$declined->count()}})</a>
						    <a href="#" class="nav-link mb-3 p-3 shadow" style="font-size:1em;"><b>Completed</b></a>
						    <a href="{{route('front.author.papers_decisioned',$journal->id)}}" class="nav-link mb-3 p-3 shadow">Submissions with a Decision ({{$paper_decisioned->count()}})</a>
						    <a href="{{route('front.author.papers_production_completed',$journal->id)}}" class="nav-link mb-3 p-3 shadow">Submissions with Production Completed ({{$production->count()}})</a>
						    
						  </div>
      



                    <a class="nav-link mb-3 p-3 shadow" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">

                        <span class="font-weight-bold small text-uppercase"><b>Manuscripts with Decisions</b></span></a>



                    



                        <a href="{{route('user.rolechange.request',[$journal->id,$currentuser])}}" class="nav-link mb-3 p-3 shadow" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">

                        <span class="font-weight-bold small text-uppercase"><b>Request a Role</b></span></a>

                        <a href="{{route('publisher.texts',[$journal->id,$currentuser])}}" class="nav-link mb-3 p-3 shadow" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                        <span class="font-weight-bold small text-uppercase"><b>PUblisher's Remarks</b></span></a>


                    </div>

<script src="{{url('assets/front/dist/js/jquery.min.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
$(document).ready(function(){
   var dropdown = document.getElementsByClassName("dropdown-btn");
   var i;

  for (i = 0; i < dropdown.length; i++) {
  $(dropdown[i]).click(function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
});

</script>