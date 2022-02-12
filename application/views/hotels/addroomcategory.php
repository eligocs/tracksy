<div class="page-container customer_content">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-plus"></i>Add New Room Category
					</div>
					<a class="btn btn-success" href="<?php echo site_url("hotels/viewroomcategory"); ?>" title="Back">Back</a>
				</div>
			</div>
			<form role="form" id="addRoomCategory">
			
			
			<div class="portlet-body">
			<div class="row">
				<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Room Category</label>
					<input type="text" placeholder="Room Category" name="room_cat_name" class="form-control" value=""/> 
				</div>
				</div>
			</div> <!-- row -->
				<div class="clearfix"></div>
				<div class="margiv-top-10">
					<button type="submit" class="btn green uppercase add_roomcategory">Add Room Category</button>
				</div>
			</form>
			<div class="clearfix"></div>
			<div id="addresEd" class="sam_res"></div>		
			</div><!-- portlet body -->
			</div> <!-- portlet -->
			
			
		</div>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>


<script type="text/javascript">
jQuery(document).ready(function($){
	var form = $("#addRoomCategory");
	var resp = $("#addresEd");
	form.validate({
		rules: {
			room_cat_name: {required: true},
		},
		submitHandler: function(form) {
			var formData = $("#addRoomCategory").serializeArray();
			//console.log(formData);
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('AjaxRequest/addRoomCategory'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log("done");
						$("#addRoomCategory")[0].reset();
						window.location.href = "<?php echo site_url("hotels/viewroomcategory");?>"; 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(e){
				//	console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
				}
			});
			return false;
		}
	});	
}); 
</script>
