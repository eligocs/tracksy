<div class="page-container customer_content">
	<div class="page-content-wrapper">
		<div class="page-content">
		<?php echo validation_errors('<span class="help-block help-block-error1">', '</span>'); ?>
		<?php $message = $this->session->flashdata('error'); 
		if($message){ echo '<span class="help-block help-block-error1 red">'.$message.'</span>';}
		?>
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-users"></i>Add Leads</div>
					<a class="btn btn-success" href="<?php echo site_url("purchaseleads"); ?>" title="Back">Back</a>
				</div>
			</div>

			   <form id="lead_form" action="<?php echo base_url().'purchaseleads/update_lead/'.$id; ?>" method="post" >
			   <input type="hidden" name="inp[temp_key]" value="<?php echo getTokenKey(15); ?>">
				<?php if($user){ 	$user = $user[0];		?>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Customer Name*</label>
					<input required type="text" placeholder="eg. Mr. Rajesh Thakur" name="c_name"  value="<?php echo  $user->c_name; ?> " class="form-control textfield" value=""/> 
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Email*</label>
					<input required type="email" placeholder="Email" name="c_email" class="form-control" value="<?php echo  $user->c_email; ?> "/> 
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Contact Number*</label>
					<input required type="text" placeholder="Customer Phone Number" name="c_number" class="form-control " value="<?php echo $user->c_contact; ?> "/> 
				</div>
				</div>
		<?php }  ?>
				<div class="clearfix"></div>
		
	
				
				<div class="clearfix"></div>
				<hr>
				<div class="col-md-12 text-left">
				<div class="margiv-top-10">
					<button type="submit" class="btn green uppercase add_Customer">Update Lead</button>
				</div>
				</div>
					<div class="clearfix"></div>
			</form>
			<div id="res"></div>		
		</div>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>

<script type="text/javascript">
jQuery(document).ready(function($){
	$("#lead_form").validate();
	/* jQuery.validator.addMethod("lettersonly", function(value, element) {
	  return this.optional(element) || /^[a-z]+$/i.test(value);
	}, "Letters only please"); 
	//validate textfield
	jQuery.validator.addClassRules('textfield', {
        required: true ,
		lettersonly: true
    }); */
	
	//Show reference_section
	var ref_section = $("#reference_section");
	$("#cus_type").change(function(){
		var _this_val = $(this).val();
		if( _this_val == 2 ){
			ref_section.show();
		}else{
			ref_section.hide();
			$("#reference_section input").val('');
		}
	});
	
}); 
</script>

<script type="text/javascript">
  var wasSubmitted = false;    
    function checkBeforeSubmit(){
      if(!wasSubmitted) {
        wasSubmitted = true;
        return wasSubmitted;
      }
      return false;
    }    
</script>