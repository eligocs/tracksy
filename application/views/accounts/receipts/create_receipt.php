<script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js' type='text/javascript'></script>
<!-- CSS -->
<link href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css' rel='stylesheet' type='text/css'>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<?php if( isset( $customer_accounts ) && !empty( $customer_accounts ) ){ ?>
			
		<?php echo validation_errors('<span class="help-block1 help-block-error">', '</span>'); ?>
		<?php $message = $this->session->flashdata('error'); 
		if($message){ echo '<span class="help-block1 help-block-error">'.$message.'</span>';}
		?>
		<style>
		.dis_block{display: block;}
		.hide_div, .shownewbooking{display: none;}
		</style>
		
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-plus"></i>Create New Receipt
					</div>
					<a class="btn btn-success" href="<?php echo site_url("accounts/receipts");?>" title="Back">Back</a>
				</div>
			</div>
		
			<div class="portlet-body custom_card">
				<div class="row">
				<form id="addAcc_frm">
					<!--IF NEW CUSTOMER ACCOUNT DROPDOWN BOOKED ITI ID -->
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label" data-toggle="tooltip" data-placement="top" title="Note: If you not find customer in list create new account in customer account section.">Select Customer Account* &nbsp; &nbsp; <i class='fa fa-info'></i><!--span style="color: red; font-size: 10px;">Note: if you not find customer in list create new account in customer account section.</span--></label>
							<select name="customer_acc_id" class="form-control" required id="select_lead_id" >
								<option value="">Select</option>
								<?php 
								foreach( $customer_accounts as $account ){
									$selected = isset( $get_customer_account[0]->id ) && !empty( $get_customer_account[0]->id ) && $get_customer_account[0]->id == $account->id && $get_customer_account[0]->lead_id == $account->lead_id ? "selected='selected'" : "";
									
									echo "<option {$selected} data-customer_id ='{$account->lead_id}' data-customer_name ='{$account->customer_name}'  data-customer_email ='{$account->customer_email}' data-customer_contact ='{$account->customer_contact}' value='{$account->id}'>{$account->lead_id} ( {$account->customer_name} ) ( {$account->customer_contact
									} )</option>";
								}	
								?>
							</select>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Receipt Type*</label>
							<select name="receipt_type" class="form-control" required id="receipt_type" >
								<option value="">Select</option>
								<option value="bank">Bank</option>
								<option value="cash">Cash</option>
							</select>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Account Name*</label>
							<select name="account_type_id" class="form-control" required id="account_name" >
								<option value="">Select</option>
								
							</select>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Voucher Date*</label>
							<input type="text" placeholder="Voucher Date" name="voucher_date" class="form-control datepicker" value="" required="required"/> 
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Transfer Type*</label>
							<input type="text" data-toggle="tooltip" title="Online transfer,TRANSFER CHEQUE,CASH ETC." placeholder="eg: Online transfer,TRANSFER CHEQUE,CASH" name="transfer_type" class="form-control" value="" required="required"/> 
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Transfer Ref</label>
							<input type="text" placeholder="Transfer Reference" name="transfer_ref" class="form-control" value="" /> 
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Transfer Date*</label>
							<input type="text" placeholder="Transfer Date" name="transfer_date" class="form-control datepicker" value="" required="required"/> 
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Amount Received*</label>
							<input type="number" placeholder="Amount Received" name="amount_received" class="form-control" value="" required="required"/> 
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label" >Narration</label>
							<textarea placeholder="Remarks" name="narration" class="form-control"></textarea>
						</div>
					</div>
				</div> <!-- row close -->
				<div class="clearfix"></div>
				<div class="margiv-top-10">
					<input type="hidden" name="customer_id" value="<?php echo isset( $get_customer_account[0]->lead_id ) && !empty( $get_customer_account[0]->lead_id ) ? $get_customer_account[0]->lead_id : "";?>" >
					<button type="submit" class="btn green uppercase add_Bank margin_left_15">Generate Receipt</button>
				</div>
				<div class="clearfix"></div>
				<div id="res"></div>
				
			</form>
			
		<?php }else{ ?>
			<div class="alert alert-info">You need to create customer account before generate invoice. Click below link to create customer account. </div>
			<hr>
			<div class="text-center"> 
				<a class="btn btn-success" href="<?php echo site_url("accounts/add_cus_account"); ?>" title="Add New Account">Add account</a>
			</div>
		<?php } ?>	
		
			</div><!-- portlet body -->
			</div> <!-- portlet -->
		</div>
 <script>
jQuery(document).ready(function($){
		$('[data-toggle="tooltip"]').tooltip();
	//date picker
	$(".datepicker").datepicker({ 
		endDate: '0d', 
		format: 'd/m/yyyy', 
	});
	
	$("#select_lead_id").select2();

	//select_lead_id change
	$("#select_lead_id").change( function(){
		var selected = $(this).val();
		if( selected ){
			var _this_opt = $('option:selected', this);
			var customer_id = _this_opt.attr("data-customer_id");
			$("input[name='customer_id']").val(customer_id);
		}else{
			$("input[name='customer_id']").val("");
		}
		
	});
	
	//check voucher type
	$("#receipt_type").change( function(){
		var selected = $(this).val();
		if( selected ){
			$.ajax({
				url: "<?php echo base_url(); ?>" + "accounts/get_cash_bank_accounts",
				type:"POST",
				data:{receipt_type: selected},
				dataType: "html",
				cache: false,
				success: function(r){
					console.log(r);
					$("#account_name").html(r);
				}
			});	
		}else{
			$("#account_name").html("<option>Select Receipt type first.</option>");
		}
	});

	
	//select iti change function
	
	
	//submit form
	$('#addAcc_frm').validate({
		submitHandler: function(form) {
			var resp = $("#res");
			var ajaxReq;
			var formData = $("#addAcc_frm").serializeArray();
			
			//console.log(formData);
			if (ajaxReq) {
				ajaxReq.abort();
			}
			
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('accounts/ajax_add_receipt_details'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						console.log("done");
						$("#addAcc_frm")[0].reset();
						window.location.href = "<?php echo site_url("accounts/view_receipt/");?>" + res.id; 
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