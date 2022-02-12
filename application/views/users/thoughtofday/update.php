<?php 
//check status
$id 	= isset( $thought_of_day[0]->id ) && !empty( $thought_of_day[0]->id ) ? $thought_of_day[0]->id : 0;
$type 	= isset( $thought_of_day[0]->type ) && !empty( $thought_of_day[0]->type ) ? $thought_of_day[0]->type : 0;
$status = isset( $thought_of_day[0]->status ) && !empty( $thought_of_day[0]->status ) ? 1 : 0;
$ckstatus = empty( $status) ? "checked" : "";
$content = isset( $thought_of_day[0]->content ) && !empty( $thought_of_day[0]->content ) ? $thought_of_day[0]->content : "";
$doc_path =  base_url() .'site/assets/thoughts/';

	//show selected 
	$checked_radio3 = $checked_radio2 = $checked_radio1 = "";
	$content1 = $content2 = $content3 = "";
	$show_div1 = "style='display: none'";
	$show_div3 = "style='display: none'";
	$show_div2 = "style='display: none'";
	if( $type == 2  ){
		//radio
		$checked_radio3 = "checked";
		//div
		$show_div3 = "style='display: block'";
		$content3 = $content;
	}else if( $type == 1 ){
		$checked_radio2 = "checked";
		//div
		$show_div2 = "style='display: block'";
		$content2 = $content;
	}else{
		$checked_radio1 = "checked";
		$show_div1 = "style='display: block'";
		$content1 = $content;
	}
?>

<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-plus"></i> Latest Update
					</div>
				</div>
			</div>
				<div class="clearfix"></div>
					<?php if( $id ){ ?>
						<div class="update_thstatus text-center second_custom_card margin-bottom-25">
							<label class="shs">Show/Hide Status</label>
							<div class="clearfix"></div>
							<label class="switch_custom">
								<input type="checkbox" <?php echo $ckstatus; ?> id="inSlider" data-id="<?php echo $id; ?>" >
								<span class="custom_slide_btn round"></span>
							</label>
						</div>	
					<?php } ?>	
				<div class="clearfix"></div>

			<div class="portlet-body custom_card">
			<form role="form" id="addSlide" enctype="multipart/form-data">
				<div class="row1">
					<div class="call_type_seciton">
						<label class="radio-inline">
							<input id="picked_call" <?php echo $checked_radio1; ?> class="radio_toggle" type="radio"  data-id="txtstatus" name="type" value="0">Text
						</label>
						<label class="radio-inline"><input class="radio_toggle" <?php echo $checked_radio2; ?> data-id="imgstatus" type="radio" name="type" value="1">Image</label>
						<label class="radio-inline"><input class="radio_toggle" <?php echo $checked_radio3; ?> data-id="vidstatus" required id="close_lead" type="radio" name="type" value="2">Youtube</label>
					</div>	
					<br>
					<div class="col-md-6 ssection" id="txtstatus" <?php echo $show_div1; ?> >
						<div class="form-group">
							<label class="control-label"><strong>Status </strong>(Max 1000 characters)*</label>
							 <textarea maxlength="500" required class="form-control" rows="10" name="text_status" ><?php echo $content1; ?></textarea>
						</div>
					</div>
					<div class="col-md-6 ssection" id="imgstatus" <?php echo $show_div2; ?> >
						<label class="control-label">Status Image*</label>
						<div class="form-group">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100%; height: 150px;">
									<img alt="" class="img-responsive" src="" />
									<?php $poster_path = $doc_path . $content; ?>
									<img alt="" class="img-responsive editvid-image" src="<?php echo $poster_path; ?>" />
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
								<div>
									<span class="btn default btn-file">
										<span class="fileinput-newa"> Click here to update status image </span>
										<span class="fileinput-existss"> </span>
										<input id="image_url" type="file" name="image_url"> </span>
									<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
								</div>
							</div>
							<div class="clearfix margin-top-10">
								<span class="label label-danger">NOTE! </span>&nbsp;
								<span class='red'> Image size not bigger then 2 MB and dimensions(1250px X 600px).</span>
							</div>
						</div>
					</div>
					<div class="col-md-6 ssection" id="vidstatus" <?php echo $show_div3; ?> >
						<div class="form-group">
							<label class="control-label">Youtube Video Link*</label>
							<input type="url" required placeholder="eg: https://www.youtube.com/watch?v=YE7VzlLtp-4" name="youtube_vid_link" class="form-control" value="<?php echo $content3; ?>"/> 
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<hr>
				<div class="col-md-10">
				<div class="margiv-top-10">
					<input type="hidden" name="id" value="<?php echo $id; ?>"/> 
					<button type="submit" class="btn green uppercase">Update Status</button>
				</div>
			</div>
			</form>
			<div class="clearfix"></div>
			<div id="addresEd"></div>		
			</div><!-- portlet body -->
			</div> <!-- portlet -->
		</div>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>
<script type="text/javascript">
jQuery(document).ready(function($){
	
	//radio button calltype on change function
	$(document).on("change", ".radio_toggle", function(e){
		e.preventDefault();
		var _this = $(this);
		var section_id = _this.attr("data-id");
		$(".ssection").hide();
		$("#"+section_id).slideDown();
	});
	
	var resp = $("#addresEd"),ajaxReq;
	$("#addSlide").validate();
	$(document).on("submit",'#addSlide', function(e){
			//console.log(formData);
			if (ajaxReq) {
				ajaxReq.abort();
			}
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('agents/ajax_update_thoughtofday_status'); ?>" ,
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success:function(data){
					if( data == "success" ){
						resp.html('<div class="alert alert-success"><strong>Success: </strong> Status Updated successfully!</div>');
					}else{
						resp.html(data);
					}
					location.reload();
				},
				error: function(e){
					//console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		
	});	
}); 
</script>

<!-- Show review in slider section on/off button -->
<script>
	jQuery(document).ready(function($){
		$(document).on("click", '#inSlider', function() {
			var ajaxReq;
			//get review status
			if (!$(this).is(':checked')) {
				var chkVal = 1;
			}else{
				var chkVal = 0;
			}
			//get review id
			var id = $(this).attr("data-id");
			console.log( id );
			console.log( chkVal );
			if (ajaxReq) {
				ajaxReq.abort();
			}
			//ajax request to update status	
			ajaxReq = $.ajax({
				url: "<?php echo base_url(); ?>" + "agents/ajax_tod_updateStatus",
				type:"POST",
				data:{ "id":  id, "is_slider": chkVal },
				dataType: 'json',
				cache: false,
				success: function(r){
					if(r.status = true){
						//location.reload();
						console.log("ok " + r.msg);
						//console.log(r.msg);
					}else{
						alert("Error! Please try again.");
					}
				}
			});
		});
	});	
</script>
