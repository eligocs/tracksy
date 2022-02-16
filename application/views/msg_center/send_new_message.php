<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		 <!-- BEGIN SAMPLE TABLE PORTLET-->
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-cogs"></i>Msg Center Create New Message
					</div>
				</div>
			</div>
			<!--Show success message if hotel edit/add -->
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<?php $eerr = $this->session->flashdata('error'); 
				if($eerr){ echo '<span class="help-block help-block-success"><span class="red">'.$eerr.'</span></span>'; }
			?>
			<!--Filter-->
			<div class="cat_wise_filter custom_card margin-bottom-25">
				<form id="filter_frm" >
					<!--Get customers added by current agent if sales team-->
					<?php if( isset( $user_role ) && $user_role == 96  ){ ?>
						<div class="col-md-3">	
							<div class="form-group">
								<label class="control-label">Choose Category*</label>
								<select required name="cat" class="form-control" id="mak_cat">
									<option value="">Select Category</option>
									<option value="all_leads">All Leads</option>
									<option value="working_lead">Working Leads</option>
									<option value="booked_lead">Booked Leads</option>
									<option value="declined_lead">Declined Leads</option>
									<option value="closed_lead">Closed Leads</option>
								</select>
							</div>
						</div>	
						<div class="col-md-3">	
							<div class="form-group">
								<label class="control-label">Leads Date Range</label>
								<input type="text" class="form-control" id="daterange" name="dateRange" value="" />
							</div>
						</div>
						<!--empty val for city and state -->
						<input type="hidden" value="" name="date_from" id="date_from" />
						<input type="hidden" value="" name="date_to" id="date_to" />
						<input type="hidden" value="" name="state" />
						<input type="hidden" value="" name="city" />
					<?php }else{ ?>
						<div class="col-md-3">	
							<div class="form-group">
								<label class="control-label">Choose Category*</label>
								<select required name="cat" class="form-control" id="mak_cat">
									<option value="">Select Category</option>
									<option value="booked_lead">Booked Leads</option>
									<option value="declined_lead">Declined Leads</option>
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
					<?php }	?>
					<div class="col-md-3">	
						<div class="margiv-top-10">
							<label class="d_block" for="">&nbsp;</label>
							<button type="submit" class="btn green uppercase add_user">Get Customers</button>
							<a href="javascript:void(0);" class="btn green uppercase reset_filter"><i class="fa fa-refresh"></i> Reset</a>
						</div>
					</div>
				</form>	
				<div class="clearfix"></div>
				<div class="res"></div>
			</div>
			<div class="clearfix"></div>
			<!--Sent Message Form -->
			<div class="row custom_card">
				<form role='form' class='' method="post" style="display: none;" id='sendMessage'>
					<div class="clearfix" id="customer_listing"></div>
					<hr>
					<div class="col-md-6">
						<label>Type a text message* <span style='color: red; font-size: 12px;'>Note: Max 160 character</span></label>
						<textarea required maxlength="160" name="text_message" class="form-control"></textarea>
					</div>
					<div class="clearfix"></div>
					<hr class="clreafix" />
					<div class="col-md-3">	
						<div class="margiv-top-10">
							<button type="submit" class="btn green uppercase add_user">Send Message</button>
						</div>
					</div>
					<input type="hidden" name="action_type" value="add">
				</form>
			</div>
			<div class="clearfix" id="res"></div>
		</div>	
			
		</div>
		</div>
	</div>
	<!-- END CONTENT BODY -->
<style>
.city_filter .btn:hover {
  background-color: #32c5d2 !important;
}
.city_filter .btn.active {
  background-color: #32c5d2 !important;
}
</style>
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
<script type="text/javascript">
	jQuery(document).ready(function($){
		$("#filter_frm").validate({
			submitHandler: function(form) {
				var resp = $(".res"), ajaxReq, _res_html = $("#customer_listing");
				$(".reset_filter").click(function(){ 
					_res_html.html("");
					$("#mak_cat").val("");	
				});
				var formData = $("#filter_frm").serializeArray();
				//console.log(formData);
					if (ajaxReq) {
						ajaxReq.abort();
					}
					ajaxReq = $.ajax({
					type: "POST",
					url: "<?php echo base_url('msg_center/ajax_get_marketing_ref_cus_list'); ?>" ,
					dataType: 'json',
					data: formData,
					beforeSend: function(){
						console.log("sending...");
						resp.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
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
			}
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
		
		
		//Send message
		var ajaxRstr;
		$("#sendMessage").validate({
			submitHandler: function(form) {
				var response = $("#res");
				var formData = $("#sendMessage").serializeArray();
				if (ajaxRstr) {
					ajaxRstr.abort();
				}
				ajaxRstr =	jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "msg_center/send_flash_text_sms",
					dataType: 'json',
					data: formData,
					beforeSend: function(){
						response.html('<div class="alert alert-success"><strong></strong><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
					},
					success: function(res) {
						if (res.status == true){
							response.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
							//console.log("done");
							//location.reload();
							window.location.href = "<?php echo site_url("msg_center/resend_message/"); ?>" + res.insert_id; 
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
		
		
		//Date range
		$("#daterange").daterangepicker({
			locale: {
			  format: 'YYYY-MM-DD'
			},
			autoUpdateInput: false,
			showDropdowns: true,
			minDate: new Date(2016, 10 - 1, 25),
			//singleDatePicker: true,
			ranges: {
			   'Today': [moment(), moment()],
			   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			   'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
			   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			   'This Month': [moment().startOf('month'), moment().endOf('month')],
			   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
		},
		function(start, end, label) {
			$('#daterange').val( start.format('D MMMM, YYYY') + ' to ' +  end.format('D MMMM, YYYY'));
			$("#date_from").val( start.format('YYYY-MM-DD') );
			$("#date_to").val(end.format('YYYY-MM-DD') );
			console.log("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
		});
	});
</script>
<script type="text/javascript">
/* select only three customers emails */
	var limit = 1000;
	$(document).on('change', 'input.cus_emails', function (e) {
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
</script>
