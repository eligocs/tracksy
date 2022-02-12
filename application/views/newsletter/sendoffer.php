<link href="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/components-editors.js" type="text/javascript"></script>

<style>
.nl-input-field, .body_edit { 
	margin-left: auto !important;
	float: none;
	margin-right: auto !important;
	padding: 10px;
	line-height: 100%;
}
.form-group.nl-input-field{margin-bottom: 5px;border: 1px solid #eaeaea;}
.mails-db {
    margin-bottom: 20px;
}
div#mails-db {
    border: 1px solid #e6e6e6;
    padding-top: 10px;
}
.heading-label {background: #f1f1f1;    padding: 10px;    border: 1px solid #ececec;     margin-top: 0;}
</style>

<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<div class="portlet box blue">

				<div class="portlet-title">
					<div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Send Offer</div>
					<a class="btn btn-success pull-right" href="<?php echo site_url("newsletters/sendoffers"); ?>" title="Back">Back</a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="profile-content">
						<div class="row">
							<div class="col-md-12">
			<div class="portlet light ">
					<?php $slug	= $offer[0]->offerslug;
							$link 	= base_url() . "promotion/offer/{$slug}"; ?>
			<form role="form" class="form-horizontal form-bordered" method="post" action="<?php echo base_url('newsletters/sendoffers'); ?>" id="sendNewsletter">
			<!--Show success message if Category edit/add -->
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
				
							<!-- h2 class="text-center"><strong>Create Newsletter</strong></h2 -->
										<div class="form-group">
											<label for="subject"><strong>Subject:</strong></label>
											<input required type="text" class="form-control" id="subject" placeholder="Enter subject" name="subject">
										</div>
										<div class="letter ">
										<div class="form-group texttemp  ">								
										<label for="body"><strong>Offer Template Body:</strong></label>
											<textarea id="summernote_3"   name="offertemplate"></textarea>
										</div>
										<!--get marketing users by marketing category -->
										<div class="clearfix cat_wise_filter">
											<!--Get customers added by current agent if sales team-->
											<?php if( isset( $user_role ) && $user_role == 96  ){ ?>
												<div class="col-md-3">	
													<div class="form-group">
														<label class="control-label">Choose Category*</label>
														<select required name="cat" class="form-control" id="mak_cat">
															<option value="">Select Category</option>
															<option value="closed_lead">Closed Leads</option>
															<option value="process_lead">All Leads</option>
														</select>
													</div>
												</div>	
												<!--empty val for city and state -->
												<input type="hidden" value="" name="state" id="state" />
												<input type="hidden" value="" name="city" id="cityID"/>
											<?php }else{ ?>
											<div class="col-md-3">	
												<div class="form-group">
													<label class="control-label">Choose Category*</label>
													<select required name="cat" class="form-control" id="mak_cat">
														<option value="">Select Category</option>
														<option value="closed_lead">Closed Leads</option>
														<option value="process_lead">Process Leads</option>
														<option value="reference">Reference Customers</option>
														<?php if(!empty($marketing_category)) {	?>
															<?php foreach($marketing_category as $cat){?>
																<option value="<?php echo $cat->id;?>"><?php echo $cat->category_name;?></option>
															<?php }	?>
														<?php } ?>
													</select>
												</div>
											</div>	
												
										
											<div class="col-md-3 hideonlead">
												<label class="control-label">State * </label>
												<div class="form-group">
													<select name='state' class='form-control' id='state'>
														<option value="">All States</option>
														<?php $state_list = get_indian_state_list(); 
															if( $state_list ){
																foreach($state_list as $state){
																	echo '<option value="'.$state->id.'">'.$state->name.'</option>';
																}
															} ?>
													</select>	
												</div>
											</div>
											
											<div class="col-md-3 hideonlead">
												<div id ="city_list">
													<div class='form-group'>
													<label>City:</label>
													<select name='city' id="cityID" class='form-control city'>
														<option value="">All Cities</option>
													</select>
													</div>
												</div>
											</div>
											<?php } ?>
											<div class="col-md-3">	
												<div class="margiv-top-10">
													<a href="javascript:void(0);" class="btn green uppercase get_marketing_users">Get Customers</a>
													<a href="javascript:void(0);" class="btn green uppercase reset_filter"><i class="fa fa-refresh"></i> Reset</a>
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="res"></div>
										</div>
									<div class="clearfix"></div>
									
									<!--ajax user listing-->
									<div class="clearfix" id="customer_listing"></div>
									<div id='emails_res'></div>
										<div class="form-actions">
											<div class="row">
												<div class="col-md-10">
													<button type="submit" class="btn green">
													<i class="fa fa-check"></i> Send Newsletter </button>
												</div>
											</div>
										</div>
									<input type="hidden" name="temp_key" value="<?php echo getTokenKey(10); ?>">
									<input type="hidden" name="action_type" value="add">
									</form>
									<div class="clearfix"></div>
									<div id="res"></div>
								</div>
							</div>
						</div>
					</div>
					<!-- END PROFILE CONTENT -->
				</div>
			</div>
		</div>
		<!-- END CONTENT BODY -->
	</div>
	<!-- END CONTENT -->
</div><!--Page Container-->
<script type="text/javascript">
jQuery(document).ready(function($){
	//$("#sendMessage").validate();
	//hide state and city if type = closed_lead || process_lead
	$('#mak_cat').on('change', function (e) {
		var optionSelected = $("option:selected", this);
		var valueSelected = this.value;
		if( valueSelected == "closed_lead" || valueSelected == "process_lead" ){
			$(".hideonlead").hide();
		}else{
			$(".hideonlead").show();
		}
	});

});
</script>
<script>
jQuery(document).ready(function($){
			var tan = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><title>Internal_email-29</title><meta http-equiv='Content-Type' content='text/html; charset=utf-8'/><meta name='viewport' content='width=device-width, initial-scale=1.0'/><style type='text/css'>*{-ms-text-size-adjust:100%;-webkit-text-size-adjust:none;-webkit-text-resize:100%;text-resize:100%;}a{outline:none;color:#40aceb;text-decoration:underline;}a:hover{text-decoration:none !important;}.nav a:hover{text-decoration:underline !important;}.title a:hover{text-decoration:underline !important;}.title-2 a:hover{text-decoration:underline !important;}.btn:hover{opacity:0.8;}.btn a:hover{text-decoration:none !important;}.btn{-webkit-transition:all 0.3s ease;-moz-transition:all 0.3s ease;-ms-transition:all 0.3s ease;transition:all 0.3s ease;}table td{border-collapse: collapse !important;}.ExternalClass, .ExternalClass a, .ExternalClass span, .ExternalClass b, .ExternalClass br, .ExternalClass p, .ExternalClass div{line-height:inherit;}@media only screen and (max-width:500px){table[class='flexible']{width:100% !important;}table[class='center']{float:none !important;margin:0 auto !important;}*[class='hide']{display:none !important;width:0 !important;height:0 !important;padding:0 !important;font-size:0 !important;line-height:0 !important;}td[class='img-flex'] img{width:100% !important;height:auto !important;}td[class='aligncenter']{text-align:center !important;}th[class='flex']{display:block !important;width:100% !important;}td[class='wrapper']{padding:0 !important;}td[class='holder']{padding:30px 15px 20px !important;}td[class='nav']{padding:20px 0 0 !important;text-align:center !important;}td[class='h-auto']{height:auto !important;}td[class='description']{padding:30px 20px !important;}td[class='i-120'] img{width:120px !important;height:auto !important;}td[class='footer']{padding:5px 20px 20px !important;}td[class='footer'] td[class='aligncenter']{line-height:25px !important;padding:20px 0 0 !important;}tr[class='table-holder']{display:table !important;width:100% !important;}th[class='thead']{display:table-header-group !important; width:100% !important;}th[class='tfoot']{display:table-footer-group !important; width:100% !important;}}</style></head><body style='margin:0; padding:0;' bgcolor='#eaeced'><table style='min-width:320px;' width='100%' cellspacing='0' cellpadding='0' bgcolor='#eaeced'><tr><td class='hide'><table width='600' cellpadding='0' cellspacing='0' style='width:600px !important;'><tr><td style='min-width:600px; font-size:0; line-height:0;'>&nbsp;</td></tr></table></td></tr><tr><td class='wrapper' style='padding:0 10px;'><table data-module='module-2' data-thumb='thumbnails/02.png' width='100%' cellpadding='0' cellspacing='0'><tr><td data-bgcolor='bg-module' bgcolor='#eaeced'><table class='flexible' width='600' align='center' style='margin:0 auto;' cellpadding='0' cellspacing='0'><tr><td><table class='logo' style='width: 100%; background: #1c6bc8; padding: 20px 0; text-align: center;background: linear-gradient(#0c5db9, #2272c9);'><tr><td><img src='<?php echo base_url('site/images/trackv2-logo.png')?>' alt='trackitinerary' style='max-width:80%;' ></td></tr></table></td></tr><tr><td class='img-flex'><img src='<?php echo base_url('site/images/top.jpg')?>' style='vertical-align:top;' width='600' height='230' alt=''/></td></tr><tr><td data-bgcolor='bg-block' class='holder' style='padding:20px;' bgcolor='#f9f9f9'><table width='100%' cellpadding='0' cellspacing='0'><tr><td data-color='title' data-size='size title' data-min='25' data-max='45' data-link-color='link title color' data-link-style='text-decoration:none; color:#292c34;' class='title' align='center' style='font: 16px/38px Arial, Helvetica, sans-serif; color: #716d6d; padding: 0;text-align: left; line-height: 150%; padding-bottom: 16px;'>Dear <strong>Client Name </strong><br><em>Greeting of the Day</em></td></tr><tr><td data-color='text' data-size='size text' data-min='10' data-max='26' data-link-color='link text color' data-link-style='font-weight:bold; text-decoration:underline; color:#40aceb;' align='center' style='font:bold 16px/25px Arial, Helvetica, sans-serif; color:#888; padding:0 0 23px;'>Lorem Ipsum is dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard. Buy now standard dummy text ever since</td></tr><tr><td style='padding:0 0 20px;'><table width='134' align='center' style='margin:0 auto;' cellpadding='0' cellspacing='0'><tr><td data-bgcolor='bg-button' data-size='size button' data-min='10' data-max='16' class='btn' align='center' style='font:12px/14px Arial, Helvetica, sans-serif; color:#f8f9fb; text-transform:uppercase; mso-padding-alt:12px 10px 10px; border-radius:2px;' bgcolor='#7bb84f'><a target='_blank' style='text-decoration:none; color:#f8f9fb; display:block; padding:12px 10px 10px;' href='<?= $link; ?>'>View Offer</a></td></tr></table></td></tr></table></td></tr><tr><td height='28'></td></tr></table></td></tr></table><table data-module='module-7' data-thumb='thumbnails/07.png' width='100%' cellpadding='0' cellspacing='0'><tr><td data-bgcolor='bg-module' bgcolor='#eaeced'><table class='flexible' width='600' align='center' style='margin:0 auto;' cellpadding='0' cellspacing='0'><tr><td class='footer' style='padding:0 0 10px;'><table width='100%' cellpadding='0' cellspacing='0'><tr class='table-holder'><th class='tfoot' width='400' align='left' style='vertical-align:top; padding:0;'><table width='100%' cellpadding='0' cellspacing='0'><tr><td data-color='text' data-link-color='link text color' data-link-style='text-decoration:underline; color:#797c82;' class='aligncenter' style='font:12px/16px Arial, Helvetica, sans-serif; color:#797c82; padding:0 0 10px;'>trackitinerary, 2018. &nbsp; All Rights Reserved. <a target='_blank' style='text-decoration:underline; color:#797c82;' href='sr_unsubscribe'>Unsubscribe.</a></td></tr></table></th><th class='thead' width='200' align='left' style='vertical-align:top; padding:0;'><table class='center' align='right' cellpadding='0' cellspacing='0'><tr><td class='btn' valign='top' style='line-height:0; padding:3px 0 0;'><a target='_blank' style='text-decoration:none;' href='https://www.facebook.com/trackitineraryofficial'><img src='<?php echo base_url('site/images/ico-facebook.png'); ?>' border='0' style='font:12px/15px Arial, Helvetica, sans-serif; color:#797c82;' align='left' vspace='0' hspace='0' width='6' height='13' alt='fb'/></a></td><td width='20'></td><td class='btn' valign='top' style='line-height:0; padding:3px 0 0;'><a target='_blank' style='text-decoration:none;' href='https://twitter.com/syatraofficial'><img src='<?php echo base_url('site/images/ico-twitter.png');?>' border='0' style='font:12px/15px Arial, Helvetica, sans-serif; color:#797c82;' align='left' vspace='0' hspace='0' width='13' height='11' alt='tw'/></a></td><td width='19'></td><td class='btn' valign='top' style='line-height:0; padding:3px 0 0;'><a target='_blank' style='text-decoration:none;' href='https://plus.google.com/u/0/108839684823653144097'><img src='<?php echo base_url('site/images/ico-google-plus.png'); ?>' border='0' style='font:12px/15px Arial, Helvetica, sans-serif; color:#797c82;' align='left' vspace='0' hspace='0' width='19' height='15' alt='g+'/></a></td><td width='20'></td><td width='20'></td></tr></table></th></tr></table></td></tr></table></td></tr></table></td></tr><tr><td style='line-height:0;'><div style='display:none; white-space:nowrap; font:15px/1px courier;'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div></td></tr></table></body></html>";
				$('.note-editable').html(tan);
				$('#summernote_3').val(tan);
					
	});
	
</script>
<script>

</script>
<script type="text/javascript">
/* Load More Customer Emails */
$(function(){
	var ajaxReq;
	var page = 1;
	$("#loadMore").click(function(e){
		e.preventDefault();
		var _this = $(this);
	   var res_alert = $("#emails_res");
	   var result = $("#mails-db");
	   if (ajaxReq) {
			ajaxReq.abort();
		}
		ajaxReq = $.ajax({
			type: "GET",
			url: "<?php echo base_url('newsletters/ajax_get_customers_emails'); ?>" ,
			data: {page: page},
			dataType: 'json',
			beforeSend: function(){
				res_alert.html('<div cla="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
			},
			success: function(res){
				console.log(res.status);
				if( res.status == true ){
					res_alert.html("");
					result.append(res.data);
					page++;
				}else if( res.status == "all" ){
					res_alert.html('<div class="alert alert-info">'+res.msg+'</div>');
					_this.hide();
				}else{
					res_alert.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
				}
			},
			error: function(){
				res_alert.html("error");
			}
		});
	return false;
   });
});
</script>
<script type="text/javascript">
// Ajax a Account 
jQuery(document).ready(function($) {
	/* select only three customers emails */
	var limit = 1000;
	$('input.cus_emails').on('change', function (e) {
		if ( $('input.cus_emails:checked').length > limit ) {
			$(this).prop('checked', false);
			$("#checkAll").prop("checked", true);
			alert("allowed only 1000 customer email");
		}else{
			$("#checkAll").removeAttr("checked");
		}	
	});
	/* select first 1000 checkboxs on checkAll click */
	$(document).on("click", "#checkAll", function(){
		if( $(this).prop("checked") ){
			$("input.cus_emails").removeAttr("checked")
			var checkBoxes = $("input.cus_emails:lt(1000)");
			$(checkBoxes).prop("checked", !checkBoxes.prop("checked"));
		}else{
			var checkBoxes = $("input.cus_emails").removeAttr("checked");
		}
	});
	
/* 	var ajaxRstr;
	$("#sendNewsletter").validate({
		submitHandler: function(form) {
			var response = $("#res");
			var formData = $("#sendNewsletter").serializeArray();
			if (ajaxRstr) {
				ajaxRstr.abort();
			}
			ajaxRstr =	jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "newsletters/ajax_send_newsletter",
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					response.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
					console.log(formData);
				},
				success: function(res) {
					console.log(formData);
					if (res.status == true){
						response.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log("done");
						//location.reload();
						window.location.href = "<?php echo site_url("newsletters/edit/"); ?>" + res.insert_id + '/' + res.temp_key; 
					}else{
						response.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(){
					response.html('<div class="alert alert-danger"><strong>Error! </strong>Please Try again later! </div>');
				}
			});
		}
	}); */
	/* Send Mail */
});	
</script>

<script type="text/javascript">
	jQuery(document).ready(function($){
		var resp = $(".res"), ajaxReq, _res_html = $("#customer_listing");
			$(".reset_filter").click(function(){ 
				_res_html.html("");
				$("#mak_cat").val("");	
			});
		
			$(".get_marketing_users").click(function(e){
				if( $("#mak_cat").val() == ""){
					resp.html('<div class="alert alert-danger"><strong>Error! </strong>Please select marketing user category first.</div>');
					return false;
				}
				e.preventDefault();
				//var formData = $("#filter_frm").serializeArray();
				var city_id = $("#cityID").val();
				var state_id = $("#state").val();
				var cat = $("#mak_cat").val();
				console.log(city_id);
					if (ajaxReq) {
						ajaxReq.abort();
					}
					ajaxReq = $.ajax({
					type: "POST",
					url: "<?php echo base_url('newsletters/ajax_marketing_users_email_list'); ?>" ,
					dataType: 'json',
					data: {state: state_id, city: city_id, cat: cat},
					beforeSend: function(){
						console.log("sending...");
						resp.html('<p class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
					},
					success: function(res) {
						if (res.status == true){
							$("#sendMessage").show();
							resp.html("");
							_res_html.html(res.res_html);
							//console.log("done");
						}else{
							$("#sendMessage").hide();
							_res_html.html("");
							resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
							console.log("No data found");
						}
					},
					error: function(e){
						$("#sendMessage").hide();
						_res_html.html("");
						console.log(e);
						//response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
					}
				});
				return false;
			
		});	
		
		/*get cities from state*/
		$(document).on('change', 'select#state', function() {
			var selectState = $("#state option:selected").val();

			var _this = $(this);
			$("#place").val("");
			_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('marketing/cityListByStateId'); ?>",
				data: { state: selectState } 
			}).done(function(data){
				$(".bef_send").hide();
				$(".city").html(data);
				$(".city").removeAttr("disabled");
			}).error(function(){
				$("#city_list").html("Error! Please try again later!");
			});
		});
	});
</script>