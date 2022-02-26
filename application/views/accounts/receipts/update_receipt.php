<script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js' type='text/javascript'></script>
<!-- CSS -->
<link href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css' rel='stylesheet' type='text/css'>

<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<?php if( isset( $invoice ) && !empty( $invoice ) ){ ?>
			
		<?php echo validation_errors('<span class="help-block1 help-block-error">', '</span>'); ?>
		<?php $message = $this->session->flashdata('error'); 
		if($message){ echo '<span class="help-block1 help-block-error">'.$message.'</span>';}
		?>
		<style>
		.dis_block{display: block;}
		.hide_div, .shownewbooking{display: none;}
		</style>
		
		<?php 
		//get customer info
		$get_cus_info 	= get_customer_account( $invoice[0]->lead_id );
		$customer_name 	= isset( $get_cus_info[0]->customer_name ) ? $get_cus_info[0]->customer_name : "";
		$customer_email = isset( $get_cus_info[0]->customer_email ) ? $get_cus_info[0]->customer_email : "";
		$customer_contact = isset( $get_cus_info[0]->customer_contact ) ? $get_cus_info[0]->customer_contact : "";
		
		?>
		
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-plus"></i>Update Receipt
						<span class=''> &nbsp; &nbsp; Lead ID: <strong> <?php echo $invoice[0]->lead_id; ?></strong></span>
					</div>
					
					<?php if( $invoice[0]->receipt_type == "cash" ){ ?>
						<a class="btn btn-success" href="<?php echo site_url("accounts/cash_receipts"); ?>" title="Back">Back</a>
					<?php }else{ ?>
						<a class="btn btn-success" href="<?php echo site_url("accounts/receipts"); ?>" title="Back">Back</a>
					<?php } ?>
				</div>
			</div>
			
			<div class="portlet-body custom_card">
				<div class="row">
				<form id="addAcc_frm">
				<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Customer Name</label>
							<input type="text" readonly value="<?php echo $customer_name; ?>" class="form-control" >
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Customer Email</label>
							<input type="text" readonly value="<?php echo $customer_email; ?>" class="form-control" >
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Customer Contact</label>
							<input type="text" readonly value="<?php echo $customer_contact; ?>" class="form-control" >
						</div>
					</div>
				
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Receipt Type</label>
							<input type="text" readonly value="<?php echo isset( $invoice[0]->receipt_type ) && !empty( $invoice[0]->receipt_type ) ? ucfirst($invoice[0]->receipt_type) : ""; ?>" class="form-control" >
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Account Name</label>
							<input type="text" readonly value="<?php echo isset( $invoice[0]->account_type_id ) && !empty( $invoice[0]->account_type_id ) ? get_cash_bank_account_name($invoice[0]->account_type_id) : ""; ?>" class="form-control" >
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Voucher Number</label>
							<input type="text" readonly value="<?php echo isset( $invoice[0]->voucher_number ) && !empty( $invoice[0]->voucher_number ) ? ucfirst($invoice[0]->voucher_number) : ""; ?>" class="form-control" >
						</div>
					</div>
					
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Voucher Date*</label>
							<input type="text" placeholder="Voucher Date" name="voucher_date" class="form-control datepicker" value="<?php echo isset( $invoice[0]->voucher_date ) && !empty( $invoice[0]->voucher_date ) ? date("d/m/Y", strtotime($invoice[0]->voucher_date) ): ""; ?>" required="required"/> 
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Transfer Type*</label>
							<input type="text" placeholder="eg: Online transfer,TRANSFER CHEQUE,CASH" name="transfer_type" class="form-control" value="<?php echo isset( $invoice[0]->transfer_type ) && !empty( $invoice[0]->transfer_type ) ? $invoice[0]->transfer_type : ""; ?>" required="required"/> 
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Transfer Ref*</label>
							<input type="text" placeholder="Transfer Reference" name="transfer_ref" class="form-control" value="<?php echo isset( $invoice[0]->transfer_ref ) && !empty( $invoice[0]->transfer_ref ) ? $invoice[0]->transfer_ref : ""; ?>" required="required"/> 
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Transfer Date*</label>
							<input type="text" placeholder="Transfer Date" name="transfer_date" class="form-control datepicker" value="<?php echo isset( $invoice[0]->transfer_date ) && !empty( $invoice[0]->transfer_date ) ? date("d/m/Y", strtotime($invoice[0]->transfer_date)) : ""; ?>" required="required"/> 
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Amount Received*</label>
							<input type="number" placeholder="Amount Received" name="amount_received" readonly class="form-control" value="<?php echo isset( $invoice[0]->amount_received ) && !empty( $invoice[0]->amount_received ) ? $invoice[0]->amount_received : ""; ?>" required="required"/> 
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label" >Narration*</label>
							<textarea placeholder="remarks" name="narration" class="form-control" required="required"><?php echo isset( $invoice[0]->narration ) && !empty( $invoice[0]->narration ) ? $invoice[0]->narration : ""; ?></textarea>
						</div>
					</div>
				</div> <!-- row close -->
				<div class="clearfix"></div>
				<div class="margiv-top-10">
					<input type="hidden" id="invoice_id" name="id" value="<?php echo $invoice[0]->id; ?>" >
					<button type="submit" class="btn green uppercase add_Bank margin_left_15">Update Receipt</button>
				</div>
				<div class="clearfix"></div>
				<div id="res"></div>
			</form>
			
		<?php }else{ ?>
			<?php redirect(404); ?>
		<?php } ?>	
		
			</div><!-- portlet body -->
			</div> <!-- portlet -->
		</div>
 <script>
jQuery(document).ready(function($){
	
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
			var invoice_id = $("#invoice_id").val();
			var ajaxReq;
			var formData = $("#addAcc_frm").serializeArray();
			
			//console.log(formData);
			if (ajaxReq) {
				ajaxReq.abort();
			}
			
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('accounts/ajax_update_receipt_details'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						console.log("done");
						//$("#addAcc_frm")[0].reset();
						window.location.href = "<?php echo site_url("accounts/view_receipt/");?>" + invoice_id; 
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