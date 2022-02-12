<div class="page-container itinerary-view view_call_info">
	<div class="page-content-wrapper">
		<div class="page-content">
			<?php if( !empty($payment ) ){ 
				$pay = $payment[0]; ?>	
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-users"></i>Accommodation ID : <?php echo $pay->acc_id; ?></div>
						<a class="btn btn-success pull-right" href="<?php echo site_url("payments/accommodation"); ?>" title="Back">Back</a>
					</div>
				</div>
				<div class="row">
				<div class="col-md-12">
					<!--Close Lead If All Payment Received-->
					<?php if( empty($pay->total_balance_amount) && $pay->acc_close_status == 0 ){ ?>
						<div class="close_iti text-right">
							<a href="javascript: void(0)" id="update_closeStatus" data-customer_id = "<?php echo $pay->customer_id; ?>" data-iti_id ="<?php echo $pay->acc_id; ?>" class="btn btn-success" title="click to close Accommodation"><i class="fa fa-window-close" aria-hidden="true"></i>Close Accommodation</a>	
						</div>
						<hr>
					<?php }elseif( $pay->acc_close_status == 1 ){
						echo '<p class="text-center"><strong><i class="fa fa-close" aria-hidden="true"></i> Lead Closed</strong></p>';
						echo "<hr>";
					} ?>
					<!--End Close Lead If All Payment Received-->
					</div>
					 
				<div class="col-md-12">
				 <div class="portlet-body">
					<div class="customer-details">	
							<div class=" ">
								<div class="well well-sm"><h3>&nbsp;Payment Details</h3></div>
								<div class="col-md-6 col-lg-6">
									<div class="col-md-4 form_vl"><strong>Accommodation Id:</strong></div>	
									<div class="col-md-8 form_vr"><?php echo $pay->acc_id; ?></div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="col-md-4 form_vl"><strong>Customer Name:</strong></div>	
									<div class="col-md-8 form_vr"><?php echo $pay->customer_name; ?></div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="col-md-4 form_vl"><strong>Customer Contact:</strong></div>	
									<div class="col-md-8 form_vr"><?php echo $pay->customer_contact; ?></div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="col-md-4 form_vl"><strong>Package Cost:</strong></div>	
									<div class="col-md-8 form_vr"><?php echo number_format($pay->total_package_cost) . " /-"; ?></div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="col-md-4 form_vl"><strong>Advance Received (as 1st installment):</strong></div>	
									<div class="col-md-8 form_vr"><?php echo number_format($pay->advance_recieved) . " /-"; ?></div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="col-md-4 form_vl"><strong>Advance Received Date (as 1st installment):</strong></div>	
									<div class="col-md-8 form_vr"><?php echo $pay->booking_date; ?></div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="col-md-4 form_vl"><strong>Next Installment Amount:</strong></div>	
									<div class="col-md-8 form_vr"><?php echo $pay->next_payment; ?></div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="col-md-4 form_vl"><strong>Next Installment Date:</strong></div>	
									<div class="col-md-8 form_vr"><?php echo $pay->next_payment_due_date; ?></div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="col-md-4 form_vl"><strong>Balance Pending:</strong></div>	
									<div class="col-md-8 form_vr"><?php echo number_format( $pay->total_balance_amount ) . " /-"; ?></div>
								</div>
							</div>
						</div>
					</div>
				
				</div>	
					<div class="clearfix">&nbsp;</div>
				<div class="col-md-12">
					<table class="table table-bordered table-striped d-table">
							<thead class="thead-default">
								<tr> <p class="text-center"><strong style="color: red; font-size: 22px;">Payment Transactions</strong></p> </tr>
								<tr>
									<th> Sr.No</th>
									<th> Payment Received</th>
									<th> Received Date</th>
									<th> Bank Name</th>
									<th> Received By</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1.</td>
									<td><?php echo number_format($pay->advance_recieved) . " /-"; ?></td>
									<td><?php echo $pay->booking_date; ?></td>
									<td><?php echo $pay->bank_name; ?></td>
									<td><?php echo get_user_name($pay->agent_id); ?></td>
								</tr>
								
								<?php 
								$pay_received = 0;
								if( !empty( $payment_transaction ) ){ 
									$i = 2;
									foreach( $payment_transaction as $pay_trans ){ ?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo number_format($pay_trans->payment_received) . " /-"; ?></td>
											<td><?php echo $pay_trans->created; ?></td>
											<td><?php echo $pay_trans->bank_name; ?></td>
											<td><?php echo get_user_name($pay_trans->agent_id); ?></td>
										</tr>
										<?php 
										$pay_received += $pay_trans->payment_received;
										$i++;
									} 
								} ?>
							</tbody>
						</table>
					</div>	
				
				<div class="clearfix">&nbsp;</div>
				<?php 
				$advance_rec = $pay->advance_recieved;
				$total_amount_received = $advance_rec + $pay_received; 
				?>
			<div class="col-md-12">
				<div class="portlet-body">
					<div class="customer-details">	
						<div class=" ">
							<div class="col-md-6 col-lg-6">
								<div class="col-md-6 form_vl"><strong>Total Package Cost:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo number_format($pay->total_package_cost) . " /-"; ?></strong></div>
							</div>
							<div class="col-md-6 col-lg-6">
								<div class="col-md-6 form_vl"><strong>Total Payment Received:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo number_format($total_amount_received) . " /-"; ?></div>
							</div>
							
							<?php if( !empty( $pay->second_payment_bal ) ){ ?>
							<div class="col-md-6 col-lg-6">
								<div class="col-md-6 form_vl"><strong>Second Installment Amount: </strong></div>	
								<div class="col-md-6 form_vr"><?php echo number_format($pay->second_payment_bal) . " /-"; ?></div>
							</div>
							<div class="col-md-6 col-lg-6">
								<div class="col-md-6 form_vl"><strong>Second Installment Date:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $pay->second_payment_date; ?></div>
							</div>
							<?php } ?>
							
							<?php if( !empty( $pay->third_payment_bal ) ){ ?>
							 
							<div class="col-md-6 col-lg-6">
								<div class="col-md-6 form_vl"><strong>Third Installment Amount:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo number_format($pay->third_payment_bal) . " /-"; ?></div>
							</div>
							<div class="col-md-6 col-lg-6">
								<div class="col-md-6 form_vl"><strong>Third Installment Date:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $pay->third_payment_date; ?></div>
							</div>
							<?php } ?>
							
							<?php if( !empty( $pay->final_payment_bal ) ){ ?>
							<div class="col-md-6 col-lg-6">
								<div class="col-md-6 form_vl"><strong>Final Installment Amount: </strong></div>	 
								<div class="col-md-6 form_vr"><?php echo number_format($pay->final_payment_bal) . " /-"; ?></div>
							</div>
							<div class="col-md-6 col-lg-6">
								<div class="col-md-6 form_vl"><strong>Final Installment Date: </strong></div>	 
								<div class="col-md-6 form_vr"><?php echo $pay->final_payment_date; ?></div>
							</div>
								 
							<?php } ?>
							<div class="col-md-6 col-lg-6">
								<div class="col-md-6 form_vl"><strong>Balance Pending:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo number_format($pay->total_balance_amount) . " /-"; ?></div>
							</div>
							
							<div class="col-md-6 col-lg-6">
								<div class="col-md-6 form_vl"><strong>Approval Note:</strong></div>	 
								<div class="col-md-6 form_vr"><?php echo $pay->approved_note; ?></div>
							</div>
						 
							</div> <!-- row -->
					</div>		
						</div>
					</div>
				</div>
			
				
					<div class="clearfix">&nbsp;</div>	
						
					<!-- End Payment Details -->
					
					<?php 
					$chkBalance = $pay->total_balance_amount;
					if( empty( $chkBalance ) || $chkBalance <= 0 ){
						echo "<div class='well well-sm text-center red'><strong>No Balance Pending</strong></div>";
					}else{
						$nextPay = $pay->next_payment;
						$nxtPayAmount = !empty( $nextPay ) ? "<strong class='green'> Payment Amount To Receive: " . number_format( $nextPay ) . " /- </strong>" : "";
						echo "<div class='well well-sm text-center'>
							{$nxtPayAmount}
							<strong class='red'> Total Pending Balance: " . number_format( $chkBalance ) . " /- </strong>
							</div>"; ?>
						
						<form id="update_payment">
							<div class="form-group col-md-6">
								<label for="usr">Total Package Cost:</label>
								<input type="text"  readonly class="form-control"  value="<?php echo number_format($pay->total_package_cost) . " /-"; ?>" />
							</div>
							<div class="form-group col-md-6">
								<label for="usr">Total Balance Pending:</label>
								<input type="text"  readonly class="form-control" name="last_balance" id="total_bal" value="<?php echo $pay->total_balance_amount; ?>" />
							</div>
							
							<div class="form-group col-md-4">
								<label class=""><strong>Payment Received:</strong></label>
								<input required type="number" id="payment_recieve" name="payment_recieve" placeholder="Payment Recieved. eg: 5000" class="form-control" value="">
							</div>
							<div class="form-group col-md-4">
								<label class=""><strong>Next Payment Amount:</strong></label>
								<input type="number" id="next_pay_balance" name="next_payment_bal" placeholder="Next Payment Amount" class="form-control" value="">
							</div>
							<div class="form-group col-md-4">
								<label class=""><strong>Next Payment Due Date:</strong></label>
								<input readonly="readonly" data-date-format="yyyy-mm-dd" required class="input-group form-control date_picker" id="next_payment_date" type="text" value="" name="next_payment_date"  />
							</div>
							<div class="form-group col-md-4">
								<div class="form-group2">
									<label class=" "><strong>Bank Name:</strong></label>
									<input class="form-control" id="bank_name" type="text" placeholder="eg: HDFC, ICIC" name="bank_name" value="">
								</div>	 
							</div>
							<div class="form-group col-md-4">
								<div class="form-group2">
									<label class=" "><strong>Payment Type:</strong></label>
									<input required class="form-control" id="pay_type" type="text" placeholder="eg: Cash/cheque" name="pay_type" value="">
								</div>	 
							</div>
							<div class="form-group col-md-4">
								<label class=""><strong>Balance Due:</strong></label>
								<input type="number" readonly id="due_balance" name="new_due_balance" placeholder="Due Balance" class="form-control" value="">
							</div>
							
							<input type="hidden" name="acc_id" value="<?php echo $pay->acc_id; ?>">
							<input type="hidden" name="tra_id" value="<?php echo $pay->id; ?>">
							<div class="margiv-top-10">
								<button type="submit" class="btn green uppercase submit_frm" id="submit_frm">Submit</button>
							</div>
							<div class="clearfix"></div>
							<div class="resPonse"></div>
						</form>
					
					<?php }	?>
				</div>
			<?php }else{
				redirect("payments/accommodation");
			} ?>	
		</div>
	</div>  
	<!-- END CONTENT BODY -->
</div>
<!-- Booking Payment Script -->
<!-- Booking Payment Script -->
<script type="text/javascript">
jQuery(document).ready(function($){
	//Close Itinerary Status
	$(document).on("click", "#update_closeStatus", function(e){
		e.preventDefault();
		var _this = $(this);
		var acc_id = _this.attr("data-iti_id");
		var cus_id = _this.attr("data-customer_id");
		console.log(acc_id);
		if (confirm("Are you sure?")) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('payments/updateAccommodationCloseStatus'); ?>" ,
				dataType: 'json',
				data: {acc_id: acc_id, cus_id: cus_id},
				beforeSend: function(){
					//resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						console.log("done");
						location.reload(); 
					}else{
						alert("Error! Please try again later.");
						console.log("error");
					}
				},
				error: function(e){
					console.log(e);
				}
			});
		}	
	});
	
	//datepicker
	$(".date_picker").datepicker({startDate: "now"});
	$(".transaction_date").datepicker({startDate: "-10d"});
	
	/* On Advance Received blur */
	$(document).on("blur", "#payment_recieve", function(){
		$("#next_pay_balance").val("");
		var amount_received = parseFloat($(this).val());
		
		if( amount_received < 0 || $.isNumeric( $(this).val() ) == false ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Please enter positive Amount value</div>');
			$(this).val("");
			return false;
		}else{
			$(".resPonse").html("");
		}	
		
		//check if payment received is more than balance
		var total_balace = $("#total_bal").val();
		if( amount_received > total_balace ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Payment should be less than Balance amount</div>');
			$("#payment_recieve").val("");
			$("#due_balance").val("");
		}else{
			//calculate Total Balace
			var due_balance = total_balace - amount_received;
			$("#due_balance").val(due_balance);
		}
		
		
		//remove required attribute if Balance is null
		if( $("#due_balance").val() < 1 ){
			$("#next_payment_date").removeAttr("required");
			$("#next_payment_date").removeClass("date_picker");
			$("#next_payment_date").val("");
			$("#next_pay_balance").val("");
			$("#next_pay_balance").attr("disabled", "disabled");
		}else{
			$("#next_payment_date").attr("required", "required");
			$("#next_payment_date").addClass("date_picker");
			$("#next_pay_balance").removeAttr("disabled");
		}
	});
	
	/* On Next payment blur */
	$(document).on("blur", "#next_pay_balance", function(){
		var _this = $(this);
		var _this_val = parseFloat($(this).val());
		//if not valid input
		if( _this_val == '' || !$.isNumeric(_this_val) || _this_val < 0 ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Please enter positive value</div>');
			_this.val("");
			return false;
		}else{
			$(".resPonse").html('');
		}
		
		//check if Next Payment is more than balance
		var total_due_balace = $("#due_balance").val();
		if( _this_val > total_due_balace ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Next Payment should be less than Balance amount</div>');
			$("#next_pay_balance").val("");
		}
	});
});
</script>
<!-- End Booking Payment Script -->
<script type="text/javascript">
jQuery(document).ready(function($){
	//validate form
	var ajaxReq;
	var resp = $(".resPonse");
	$("#update_payment").validate({
		submitHandler: function(form, event) {
			event.preventDefault();
			$("#submit_frm").attr("disabled", "disabled");
			var formData = $("#update_payment").serializeArray();
			console.log(formData);
			//Get call type value
			var callType = $('input[name=callType]:checked').val();
			console.log(callType);
				if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('payments/updateAccommodationPaymentDetails'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					$("#update_payment")[0].reset();
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						console.log("done");
						location.reload(); 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						console.log("error");
						alert( "Error: " + res.msg );
						location.reload();
					}
				},
				error: function(e){
					resp.html('<div class="alert alert-danger"><strong>Error! </strong>Try again later.</div>');
					console.log(e);
				}
			});
			return false;
		} 
	});	
	
});
</script>