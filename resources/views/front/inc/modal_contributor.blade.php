<style>
  #show_first_name,#show_last_name,#show_email,#show_degree,#show_position,#show_institution,#show_department,#show_country{
    color:red;
    display:none;
  }
</style>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
Click to Add Contributor(#<span ></span>)
</button>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl text-start">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Contributor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="add_contForm">
      <div class="form-group">
      <div class="row">
            <div class="col-12">
                  <label><b id="already_exist"></b></label>
                
            </div>
          </div>
        <div class="row">
         
        
             <div class="col-6">
                <label><b>First Name </b></label>
                <input type="text" name="first_name" id="first_name" required><br>
                <span id="show_first_name">Please fill this field*</span>
             </div>
             <div class="col-6">
    
              <label><b>Last Name </b></label>
               <input type="text" name="last_name" id="last_name" required><br>
               <span id="show_last_name">Please fill this field*</span>
             </div>
        </div>
     
      </div>
      <div class="form-group">
        <div class="row">
             <div class="col-6">
                <label><b>Email </b></label>
                <input type="text" name="email" id="email" required><br>
                <span id="show_email">Please fill this field*</span>
             </div>
             <div class="col-6">
    
              <label><b>Degree </b></label>
               <input type="text" name="degree" id="degree" required><br>
               <span id="show_degree">Please fill this field*</span>
             </div>
        </div>
     
      </div>
      <div class="form-group">
        <div class="row">
             <div class="col-6">
                <label><b>Position </b></label>
                <input type="text" name="position" id="position" required><br>
                <span id="show_position">Please fill this field*</span>
             </div>
             <div class="col-6">
    
              <label><b>Institution </b></label>
               <input type="text" name="institution" id="institution" required><br>
               <span id="show_institution">Please fill this field*</span>
             </div>
        </div>
     
      </div>
      <div class="form-group">
        <div class="row">
             <div class="col-6">
                <label><b>Department </b></label>
                <input type="text" name="department" id="department"required><br>
                <span id="show_department">Please fill this field*</span>
             </div>
             <div class="col-6">
    
                <label><b>Country </b></label>
                <input type="text" name="country" id="country" required><br>
                <input type="hidden" id="author_value" name="author_value">
                <input type="hidden" id="journal_value" name="journal_value">
                <input type="hidden" id="papr_id">
                <span id="show_country">Please fill this field*</span>
             </div>
             
        </div>
       </form>
      </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="addcontribute" class="btn btn-primary">Save changes</button>
     
      </div>
    </div>
  </div>
</div>
<script src="{{url('assets/front/dist/js/jquery.min.js')}}"></script>

<script>
   $(document).on('click','#addcontribute',function(){
     var first_name= $('#first_name').val();
     var last_name= $('#last_name').val();
     var email= $('#email').val();
     var degree=$('#degree').val();
     var position= $('#position').val();
     var institution=$('#institution').val();
     var department=$('#department').val();
     var country=$('#country').val();
     var author_value= $('#author_value').val();
     var journal_value= $('#journal_value').val();
     var papr_id=$('#papr_id').val();
     if(first_name==''){
      $('#show_first_name').show();
      return false;
     }else{
      $('#show_first_name').hide();
     }
     if(last_name==''){
      $('#show_last_name').show();
      return false;
     }else{
      $('#show_last_name').hide();
     }
     if(email==''){
      $('#show_email').show();
      return false;
     }else{
      $('#show_email').hide();
     }
     if(degree==''){
      $('#show_degree').show();
      return false;
     }else{
      $('#show_degree').hide();
     }
     if(position==''){
      $('#show_position').show();
      return false;
     }else{
      $('#show_position').hide();
     }
     if(institution==''){
      $('#show_institution').show();
      return false;
     }else{
      $('#show_institution').hide();
     }
     if(department==''){
      $('#show_department').show();
      return false;
     }else{
      $('#show_department').hide();
     }
     if(country==''){
      $('#show_country').show();
      return false;
     }else{
      $('#show_country').hide();
     }
    
     
     $.ajax({
      type:'post',
      url:'/front/add-contributor',
      data:{first_name:first_name,last_name:last_name,email:email,degree:degree,position:position,institution:institution,department:department,country:country,author_value:author_value,journal_value:journal_value,papr_id:papr_id},
      success:function(resp){
        if(resp['status']==0){
          alert("This contributor already exists in this paper.");
        }else{
          alert("The contributor has been added successfully.");
        }
        $('#conts').html(resp['view']);
        return false;
      //alert(resp);  
      },error:function(){
      alert("error");
      }
      });
   });
</script>
