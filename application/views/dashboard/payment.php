<!-- Payment Testing -->
<div class="page-content-wrapper sales_team_dashboard">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->
		<h3>Calculate Payment</h3>
		<!-- END PAGE BAR -->
		<form class="form-horizontal" role="form" id="addPayment">
			<div class="col-md-4">
				<div class="form-group2">
					<label class=" "><strong>Total Package Cost:</strong></label>
					<input class="form-control" id="total_pack_cost" type="number" placeholder="eg: 10000" name="total_pack_cost" value="">
				</div>	 
			</div>
			<div class="col-md-4">
				<label class=""><strong>Booking Date:</strong></label>
				<input required readonly="readonly" class="input-group form-control booking_date" id="booking_date" type="text" value="" name="booking_date"  />
			</div>
			
			<div class="clearfix"></div>
			
			<div class="col-md-3">
				<label class=""><strong>Advance Recieved:</strong></label>
				<input type="text" id="pack_advance_recieve" name="advance_recieve" placeholder="Advance Recieved. eg: 5000" class="form-control" value="">
			</div>
			<div class="col-md-3">
				<label class=""><strong>Balance:</strong></label>
				<input type="text" readonly id="balance_pay" name="advance_recieve" placeholder="" class="form-control" value="">
			</div>
			<div class="col-md-3">
				<div class="form-group2">
					<label class=" "><strong>Bank Name:</strong></label>
					<input class="form-control" id="bank_name" type="text" placeholder="eg: HDFC, ICIC" name="bank_name" value="">
				</div>	 
			</div>
			<div class="col-md-3">
				<label class=""><strong>Transaction Date:</strong></label>
				<input required readonly="readonly" class="input-group form-control transaction_date" id="transaction_date" type="text" value="" name="transaction_date"  />
			</div>
			
			<div class="clearfix"></div>	
			
			<div class="margiv-top-10 col-md-12 text-right">
				<button type="submit" class="btn green uppercase add_hotel">Add Payment</button>
			</div>
			<div class="clearfix"></div>
			<div id="addresEd"></div>
		</form>
	
	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->

<script type="text/javascript">
jQuery(document).ready(function($){
	$('#transaction_date, #booking_date').datepicker({
		startDate: '-1d'
	});  
});
</script>
