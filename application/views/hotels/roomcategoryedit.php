<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-pencil"></i>Edit Room Category
				</div>
				<a class="btn btn-success" href="<?php echo site_url("hotels/viewroomcategory"); ?>" title="Back">Back</a>
			</div>
		</div>
		<?php if($categories){ 	$category = $categories[0]; ?>
			<form role="form" id="editRoomCat">
				
				<div class="form-group">
					<label class="control-label">Room Category</label>
					<input id="mulit_email" type="text" placeholder="Room Category" name="room_cat_name" class="form-control" value="<?php echo $category->room_cat_name; ?>"/> 
				</div>
				
				<div class="margiv-top-10">
					<input type="hidden" name="id" value="<?php echo $category->room_cat_id;?>"/>
					<button type="submit" class="btn green uppercase edit_roomcat">Save Changes</button>
				</div>
			</form>
			<div id="editRoomCatRes"></div>		
		<?php }else{
			echo "Invalid Hotel id";
		}?>
		</div>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>


<script type="text/javascript">

jQuery(document).ready(function($){
	var form = $("#editRoomCat");
	var resp = $("#editRoomCatRes");
	form.validate({
		rules: {
			room_cat_name: {required: true},
			
		},
		submitHandler: function(form) {
			var formData = $("#editRoomCat").serializeArray();
			//console.log(formData);
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('AjaxRequest/editRoomCategory'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						console.log("done");
						 $("#editRoomCat")[0].reset();
						window.location.href = "<?php echo site_url("hotels/viewroomcategory");?>"; 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						console.log("error");
					}
				},
				error: function(e){
						//console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});	
}); 
</script>
