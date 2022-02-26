<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<?php echo validation_errors('<span class="help-block1 help-block-error">', '</span>'); ?>
		<?php $message = $this->session->flashdata('error'); 
		if($message){ echo '<span class="help-block1 help-block-error">'.$message.'</span>';}
		?>
		<?php echo form_open(' ',array('id'=> 'branch_form')); ?>
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-plus"></i>Add Office Branch Details
				</div>
				<a class="btn btn-success" href="<?php echo site_url("terms/office_branches");?>" title="Back">Back</a>
			</div>
		</div>	
			<div class="portlet-body custom_card">
			
				<div class="row">
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Branch Name*</label>
					<input type="text" placeholder="Branch Name" name="inp[branch_name]" class="form-control" value="<?php if(isset($branch_name)){ echo $branch_name; }else{ echo set_value('inp[branch_name]'); } ?>" required="required"/> 
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Branch Address*</label>
					<textarea placeholder="Branch Address" name="inp[branch_address]" class="form-control" required="required"><?php if(isset($branch_address)){ echo $branch_address; }else{ echo set_value('inp[branch_address]'); } ?></textarea> 
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label" >Contact Number*</label>
					<input type="text" placeholder="Contact Number" name="inp[branch_contact]" class="form-control" value="<?php if(isset($branch_contact)){ echo $branch_contact; }else{ echo set_value('inp[branch_contact]'); } ?>" required="required"/> 
				</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-6">
				<div class="form-group">
					<label class="control-label" >Email Address*</label>
					<input type="text" placeholder="Email Address eg. email1@trackitinerary.com,email2@trackitinerary.com" name="inp[email_address]" class="form-control" value="<?php if(isset($email_address)){ echo $email_address; }else{ echo set_value('inp[email_address]'); } ?>" required="required"/> 
				</div>
				</div>
			
				
				<div class="col-md-3">
					<label for="" class="d_block">&nbsp;</label>
					<button type="submit" class="btn green uppercase add_Bank">Add Branch</button>
				</div>
				
				</div> <!-- row close -->
				<div class="clearfix"></div>
					<div id="res"></div>		
			</form>
			</div><!-- portlet body -->
			</div> <!-- portlet -->
		</div>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>
<script type="text/javascript">
jQuery(document).ready(function($){
	var form = $("#branch_form");
	var ajaxReq;
	$("#branch_form").validate({
		submitHandler: function(form) {
			var resp = $("#res");
			var formData = $("#branch_form").serializeArray();
			//console.log(formData);
			if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('terms/ajax_add_office_branches'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						console.log("done");
						 $("#branch_form")[0].reset();
						window.location.href = "<?php echo site_url("terms/office_branches");?>"; 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						console.log("error");
					}
				},
				error: function(e){
						console.log(e);
					//response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});	
}); 
</script>