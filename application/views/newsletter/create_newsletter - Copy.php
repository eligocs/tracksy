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
					<div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Create Newsletter</div>
					<a class="btn btn-success pull-right" href="<?php echo site_url("newsletters"); ?>" title="Back">Back</a>
				</div>
			</div>
			<form role="form" class="form-horizontal form-bordered" id="sendNewsletter">
			<div class="row">
				<div class="col-md-12">
					<div class="profile-content">
						<div class="row">
							<div class="col-md-12">
															<div class="portlet light ">

			<!--Show success message if Category edit/add -->
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="form-group">
				<label for="youtube_link"><strong>Select Template Type:</strong></label> <br>
				<input type="radio" class="form temp" value="1"  id='default' name="type">Default
				<input type="radio" class="form temp" value="2"  id='text' 	   name="type">Text	
				<input type="radio" class="form temp" value="3"  id='image'    name="type">Image
			</div>
			<div class="form-group imagetemp hide ">
				<?php if($imageTemplate >0 ){
					foreach($imageTemplate as $img){
						 ?>
						<input type='radio' class='form imagelist' value='<?php echo base_url('site/images/imageTemplate/'.$img->img_name);  ?>' id='text'  name='image'>
						<img  width='10%' src="<?php echo base_url('site/images/imageTemplate/'.$img->img_name);  ?>" > <br>
						
				<?php 	}
				}?>
			</div>
			<div class="form-group  texttemp hide">
				<?php if($textTemplate >0 ){
					foreach($textTemplate as $text){
							$slug	= $text->slug;
							$link 	= base_url() . "promotion/templateText/{$slug}";
						echo "<input type='radio' class='form textlist' value='{$link}' id='text'  name='image'>$text->greeting<br>";
					}
				}?>			
			</div>
			
			
							<!-- h2 class="text-center"><strong>Create Newsletter</strong></h2 -->
										<div class="form-group">
											<label for="subject"><strong>Subject:</strong></label>
											<input required type="text" class="form-control" id="subject" placeholder="Enter subject" name="subject">
										</div>
										<div class="letter hide">
										<div class="form-group">
											<label for="youtube_link"><strong>Youtube Link:</strong></label>
											<input type="url" class="form-control" id="youtube" placeholder="Enter youtube video link" name="youtube_link">
										</div>
										
										<div class="form-group ">
											<label for="body"><strong>Newsletter Body:</strong></label>
											<textarea  name="template" id="template"><?php if($templates!= NULL){ echo htmlspecialchars_decode($templates[0]->template); }?></textarea>
										</div>
										
										</div>
											<div class="form-group imagetemp hide ">								
										<label for="body"><strong>Image Body:</strong></label>
											<textarea id="summernote_1"   name="imagetemplate"></textarea>
										</div>
										<div class="form-group texttemp hide ">								
										<label for="body"><strong>Text Template Body:</strong></label>
											<textarea id="summernote_3"   name="texttemplate"></textarea>
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
									
										<?php /*
										<div class="form-group nl-input-field">
											<h5 class="heading-label" for="emails"><strong>Select Customer Emails:</strong></h5>
											<?php if( $customers ){  ?>
												<div class="well">
													<label class="strong">
														<input type="checkbox" id="checkAll"/> Select all
													</label>
													<div class="">
														<span class="red small">Note:</span>
															<span class="small"><em> By click on select all you can select only first 1000 checkbox.</em></span>
													</div>
												</div>
												<?php 
												echo '<div class="mails-db" id="mails-db">';
													$list_id = 1;
													foreach( $customers as $customer ){
														$email = $customer->customer_email;
														echo "<div class='all_mails'><input id='emaillist_{$list_id}' required class='form-control cus_emails' name='customer_email[]' type='checkbox' value='{$email}' /><label for='emaillist_{$list_id}'>{$email}</label></div>";
														$list_id++;
													} 
													echo "</div>";	
													echo "<div class='clearfix'></div><a href='#' class='btn btn-success pull-right' id='loadMore'>LoadMore</a>";
												}else{
													echo "<div class='clearfix'></div><div id='emails_res'></div>";
													echo "<input required class='form-control' name='customer_email[]' type='email' value='' />";
												} ?>
										</div> */ ?>
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
	$('.temp').on('change', function (e) {
		var type=$(this).val();
		console.log(type);
		if(type == 1){
			$( ".letter" ).removeClass( "hide" );
			$( ".imagetemp" ).addClass( "hide" );
			$( ".texttemp" ).addClass( "hide" );
		}
		else if( type == 2){
			//console.log('text');
			$( ".letter" ).addClass( "hide" );
			$( ".imagetemp" ).addClass( "hide" );
			$( ".texttemp" ).removeClass( "hide" );
		}
		else if( type == 3){
			$( ".letter" ).addClass( "hide" );
			$( ".imagetemp" ).removeClass( "hide" );
			$( ".texttemp" ).addClass( "hide" );
		}
		else{			
			$( ".letter" ).addClass( "hide" );
			$( ".imagetemp" ).addClass( "hide" );
			$( ".texttemp" ).addClass( "hide" );
		}
			
	});
	$('.imagelist').on('change', function (e) {	
		var imgName = $(this).val();		
		console.log(imgName);
		var  image = "<div class='page-content' style='width: 800px; padding: 20px;	border: 1px dashed #b7b7b7;margin: 20px auto 0; box-shadow: 0 8px 107px 0 rgba(0,0,0,.2), 0 6px 155px 0 rgba(0, 0, 0, 0);'><div class='logo' style='margin: -20px -20px 0 -20px;    background: #00307b;'><a href='https://www.trackitinerary.com/'><img src='<?php echo base_url().'site/images/trackv2-logo.png ' ?>' alt='Track Itinerary Software'></a></div><div class='newsletter_section image'><div class=' text-center'><img width='100%' src="+imgName+" alt='image'></div></div></div>";
		$('.note-editable').html(image);
		$('#newImg').val(imgName);
				
	});
	$('.textlist').on('change', function (e) {	
		var textName = $(this).val();		
		console.log(textName);
		/* var  image = "<div class='page-content' style='width: 800px; padding: 20px;	border: 1px dashed #b7b7b7;margin: 20px auto 0; box-shadow: 0 8px 107px 0 rgba(0,0,0,.2), 0 6px 155px 0 rgba(0, 0, 0, 0);'><div class='logo' style='margin: -20px -20px 0 -20px;    background: #00307b;'><a href='https://www.trackitinerary.com/'><img src='<?php echo base_url('site/images/trackv2-logo.png')?>' alt='Track Itinerary Software'></a></div><div class='newsletter_section image'><div class=' text-center'><img width='100%' src="+imgName+" alt='image'></div></div></div>";
		*/
		$('.note-editable').html(textName);
		$('#summernote_3').val(textName);
				
	});
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
	
	var ajaxRstr;
	$("#sendNewsletter").validate({
		submitHandler: function(form) {
			var response = $("#res");
			var formData = $("#sendNewsletter").serializeArray();
			if (ajaxRstr) {
				ajaxRstr.abort();
			}
			ajaxRstr =	jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "newsletters/send_newsletter",
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
	});
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