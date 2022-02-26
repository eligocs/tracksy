<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<?php if( $branch_data ){ 
			
		$branch = $branch_data[0];		?>
		 
			<?php //echo validation_errors('<span class="help-block help-block-error">', '</span>'); ?>
				<?php $attributes = array('id' => 'editBranch'); ?>
				<?php echo form_open('', $attributes); ?>
				
				<div class="portlet box blue">
				
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-users"></i>Edit Branch Details
						</div>
						<a class="btn btn-success" href="<?php echo site_url("terms/office_branches");?>" title="Back">Back</a>
					</div>
		</div>
			 
				<div class="portlet-body custom_card">
				<div class="row">
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Bank Name*</label>
					<input required type="text" placeholder="Branch Name" name="inp[branch_name]" class="form-control" value="<?php if(isset($branch->branch_name)){ echo $branch->branch_name; }else{ echo set_value('inp[branch_name]'); } ?>"/> 
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label" >Branch Address*</label>
					<textarea required placeholder="Branch Address" name="inp[branch_address]" class="form-control"><?php if(isset($branch->branch_address)){ echo $branch->branch_address; }else{ echo set_value('inp[branch_address]'); } ?></textarea> 
				</div>
				</div>
				
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label" >Contact Number*</label>
						<input required placeholder="Contact Number" type="text" class="form-control" name="inp[branch_contact]" value="<?php if(isset($branch->branch_contact)){ echo $branch->branch_contact; }else{ echo set_value('inp[branch_contact]'); } ?>">
				</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-6">
				<div class="form-group">
					<label class="control-label" >Email Address*</label>
					<input type="text" placeholder="Email Address eg. email1@trackitinerary.com,email2@trackitinerary.com" name="inp[email_address]" class="form-control" value="<?php if(isset($branch->email_address)){ echo $branch->email_address; }else{ echo set_value('inp[email_address]'); } ?>" required="required"/> 
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label" >Assign As Headoffice</label>
						<select name="inp[head_office]" class="form-control">
							<option value="">Select Option</option>
							<option value="0" <?php if ( $branch->head_office == "0" ) { ?> selected="selected" <?php } ?> >Branch</option>
							<option value="1" <?php if ( $branch->head_office == "1" ) { ?> selected="selected" <?php } ?> >Head Office</option>
						</select>	
				</div>
				</div>
				
				
				</div> <!-- row -->
				
				<div class="clearfix"></div>
				<div class="margiv-top-10">
					<input type="hidden" name="branch_id" value="<?php echo $branch->branch_id; ?>"/>
					<button type="submit" class="btn green uppercase edit_Customer margin_left_15">Update Branch Details</button>
				</div>
				<div class="clearfix"></div>
			<div id="res"></div>		
			</form>
				</div>
				</div>
		</div>
		<?php }else{
			redirect(404);
		} ?>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>
<script type="text/javascript">
jQuery(document).ready(function($){
	var form = $("#editBranch");
	var ajaxReq;
	$("#editBranch").validate({
		submitHandler: function(form) {
			var resp = $("#res");
			var formData = $("#editBranch").serializeArray();
			//console.log(formData);
			if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('terms/ajax_edit_office_branches'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						console.log("done" + res.msg);
						 $("#editBranch")[0].reset();
						window.location.href = "<?php echo site_url("terms/office_branches");?>"; 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						console.log("error" + res.msg);
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
