<link href="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/components-editors.js" type="text/javascript"></script>
<?php if($newsletter){ 	$news = $newsletter[0]; ?>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Send Newsletter</div>
					<a class="btn btn-success pull-right" href="<?php echo site_url("newsletters"); ?>" title="Back">Back</a>
				</div>
			</div>
			
			<!--Show success message if Category edit/add -->
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			
			<!-- Newsletter Share Section -->
			<?php /*
			<div class="socicons text-center">
			 <h2>Share Newsletter</h2>
				<?php 
				//$url	= 'http://belogical.biz/yatra/';
				$slug = $news->slug;
				$url = base_url() . "promotion/article/{$slug}";
				$text	= $news->subject;
				$fb_description	= $news->subject;
				?>
				<br><br><br>
				<a class="sm_share twitter" target="_blank" title="Share to Twitter" href="<?php echo share_url('twitter',	array('url'=>$url, 'text'=>$text, 'via'=>'mpak666'))?>">
					<i class="fa fa-twitter fa-3x" aria-hidden="true"></i>
				
				<a class="sm_share facebook" target="_blank" title="share on facebook" href="<?php echo share_url('facebook',	array('url'=>$url, 'text'=>$text, 'description' => $fb_description))?>">
					<i class="fa fa-facebook-square fa-3x" aria-hidden="true"></i>
				</a>
				<a class="sm_share goole_plus" target="_blank" href="<?php echo share_url('google',		array('url'=>$url))?>" title="Share to Google Plus">
					<i class="fa fa-google-plus-square fa-3x" aria-hidden="true"></i>
				</a>
				
			</div>  <!-- End Newsletter Share Section -->    */ ?>     
<style>
.nl-input-field, .body_edit {/*width: 92%;*/
	margin-left: auto !important;
	float: none;
	margin-right: auto !important;
	padding: 10px;
	line-height: 100%;
}
.form-group.nl-input-field{margin-bottom: 5px;border: 1px solid #eaeaea;}
.label-success { background-color: #5cb85c;}
.progress-bar{text-align:left; font-size:inherit;}	
.email_sent_list span {
	display: inline-block;
	width: 30%;
	display: inline-block;
	height: 28px;
	border-bottom: 1px solid #cecece;
	margin: 5px 1%;
}
.mails-db { margin-bottom: 20px;}
.email_sent_list {height: 250px;}	
.mails-db-outer .well {
	padding: 10px;
	border: 1px solid #e4e4e4;
	margin-top: 5px;
}	
div#mails-db {
    border: 1px solid #e6e6e6;
    padding-top: 10px;
}	
.heading-label {background: #f1f1f1;    padding: 10px;    border: 1px solid #ececec;     margin-top: 0;}					
</style>

				
				
				<form role="form" class="form-horizontal form-bordered" id="editNewsletter">
					<div class="form-group nl-input-field">
						<label for="subject"><strong>Subject:</strong></label>
						<?php echo $news->subject; ?>
					</div>
					<div class="form-group nl-input-field">
						<label for="body"><strong>Newsletter Body:</strong><span id="copy_news"><a title='edit'  href="#" class=' '>  &nbsp; <i class='fa fa-pencil'></i></a></span></label>
					</div>	
					<div class="form-group nl-input-field">	
						<div class="body_view"><?php echo htmlspecialchars_decode($news->body); ?></div>
						<div class="body_edit"><textarea id="template"><?php echo htmlspecialchars_decode($news->body); ?></textarea></div>
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
				<div class="nl-input-field">			
					<ul class="nav nav-tabs nav nav-pills">
						<li class="active"><a data-toggle="tab" href="#pending-mails">Pending Emails</a></li>
					</ul>
				</div>
				
				<div class="tab-content">
					<div id="pending-mails" class="tab-pane fade in active">
				   <div class="form-group nl-input-field">
					<div class="mails-db-outer">
						<h5 class="heading-label" for="emails"><strong>Pending Customer Emails:</strong></h5>
						<?php $sent_emails = explode(",", $news->emails); 
							if( $sent_emails ){
								$sent_emails_list = $sent_emails;
							}else{
								$sent_emails_list = array();
							}
						?>
						<?php 
						$checkbox_list = "";
						if( $customers  ){ ?>
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
							echo '<div class="mails-db " id="mails-db">';
								$list_id = 1;
								foreach( $customers as $customer ){
									$email = $customer->customer_email;
									echo "<div class='all_mails'><input id='emaillist_{$list_id}' required class='form-control cus_emails' name='customer_email[]' type='checkbox' value='{$email}' /><label for='emaillist_{$list_id}'>{$email}</label></div>";
									$list_id++;
								} 
							echo "</div>";
							echo "<div class='clearfix'></div><div id='emails_res'></div>";
						}else{
							echo "<div class='msg'>This newsletter send to all customers</div>";
						} ?>
					</div>
					</div>
					
				</div>
			
			
				
			  </div> <!-- tab-content -->
				*/ ?>
					
					<?php //if( !empty($customers) ){ ?>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12 nl-input-field">
									<button type="submit" class="btn green">
									<i class="fa fa-check"></i> Send Newsletter </button>
								</div>
							</div>
						</div>
						<input type="hidden" class="form-control" value="<?php echo htmlspecialchars_decode($news->subject); ?>" name="subject"/>
						<textarea  style="display: none !important;" name="template"><?php echo htmlspecialchars_decode($news->body); ?></textarea>
						<input type="hidden" name="temp_key" value="<?php echo $news->temp_key; ?>">
						<input type="hidden" name="id" id="news_id" value="<?php echo $news->id; ?>">
						<input type="hidden" name="action_type" value="edit">
					<?php// } ?>
				</form>
				<div class="clearfix"></div>
				<div id="res"></div>
				
				
				<div class="clearfix"></div>
				<?php if( !empty( $news->emails ) ){ ?>
					<div id="send-mails" class="">
						<h3>Sending History</h3>
						<div class="form-group nl-input-field  ">
								<h5 class="heading-label"> <strong>Sent:</strong></h5>
								<?php $sent_e = explode(",", $news->emails);
									$len = count($sent_e);
									$i = 0;
									echo '<div class="email_sent_list">';
										if( !empty( $sent_e ) ){
											foreach( $sent_e as $e ){
												if(++$i === $len) {
													echo "<span>{$e}</span>";
												}else{
													echo "<span>{$e}</span> ";
												}	
											}
										}else{
											echo "<strong>Email Not sent yet.</strong>";
										}
									echo "</div>";
								?>
								
							</div>

					</div>
				<?php } ?>
			</div>
			
		</div>
	</div>
</div>
<?php } ?>	
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
				var news_id = $("#news_id").val();
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
					data: {state: state_id, city: city_id, cat: cat, news_id: news_id},
					beforeSend: function(){
						console.log("sending...");
						resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
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

<script type="text/javascript">
jQuery(document).ready(function(){
	//Show newsletter body in editor
	var body_view = $(".body_view");
	var body_edit = $(".body_edit");
	$(document).on("click", "#copy_news a", function(e){
		e.preventDefault();
		body_view.hide();
		body_edit.show();
		$(this).parent().addClass("showView");
		
	});
	$(document).on("click", "#copy_news.showView a", function(e){
		e.preventDefault();
		body_view.show();
		body_edit.hide();
		$(this).parent().removeClass("showView");
		
	});
	
	
});
/* Load More Customer Emails */
$(function(){
	var ajaxReq;
	var page = 1;
	var id = $("#news_id").val();
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
			url: "<?php echo base_url('newsletters/ajax_get_customers_emails_pending'); ?>" ,
			data: {page: page, id: id},
			dataType: 'json',
			beforeSend: function(){
				res_alert.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
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
	$("#editNewsletter").validate({
		submitHandler: function(form) {
			var response = $("#res");
			var formData = $("#editNewsletter").serializeArray();
			if (ajaxRstr) {
				ajaxRstr.abort();
			}
			ajaxRstr =	jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "newsletters/ajax_send_newsletter",
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					response.html('<div class="alert alert-success"><strong></strong><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
				},
				success: function(res) {
					if (res.status == true){
						response.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log("done");
						location.reload();
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
<script>
/* Popu Up window */
jQuery(document).ready(function(){
  $.fn.customerPopup = function (e, intWidth, intHeight, blnResize) {
    // Prevent default anchor event
    e.preventDefault();
    
    // Set values for window
    intWidth = intWidth || '500';
    intHeight = intHeight || '400';
    strResize = (blnResize ? 'yes' : 'no');

    // Set title and open popup with focus on it
    var strTitle = ((typeof this.attr('title') !== 'undefined') ? this.attr('title') : 'Social Share'),
        strParam = 'width=' + intWidth + ',height=' + intHeight + ',resizable=' + strResize,            
        objWindow = window.open(this.attr('href'), strTitle, strParam).focus();
  }
  
  /* ================================================== */
     $('.sm_share').on("click", function(e) {
      $(this).customerPopup(e);
    });
  });
</script>