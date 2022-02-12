<?php if( isset($view_transactions) && $view_transactions ){
	$trans = $view_transactions[0];
	?>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN SAMPLE TABLE PORTLET-->
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';}
			?>
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-inr"></i>View Transaction Details
					</div>
					<a class="btn btn-success" href="<?php echo site_url("accounts/all_online_transactions"); ?>" title="All transactions">Back</a>
				</div>
				
			</div>
			<?php $tra_s = $trans->trans_status == "TXN_SUCCESS" ? "<strong class='green'>SUCCESS</strong>" : "<strong class='red'>FAIL</strong>"; ?>
			<div class="portlet-body">
				<h3>Transaction Details</h3>
				<p id="t_countdown"></p>
				<div class="table-responsive">	
					<!-- Target -->
					<table class="table table-condensed table-hover">
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Order ID: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $trans->order_id; ?></div></td>
						</tr>
						
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Iti ID: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><a href="<?php echo iti_view_single_link( $trans->iti_id ); ?>" title='check quotation' target='_blank'><?php echo $trans->iti_id; ?></a></div></td>
						</tr>
						
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Transaction ID: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $trans->trans_id; ?></div></td>
						</tr>
						
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Customer ID: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $trans->customer_id; ?></div></td>
						</tr>
						
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Customer Name: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $trans->customer_name; ?></div></td>
						</tr>
						
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Customer Contact: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $trans->customer_contact; ?></div></td>
						</tr>
						
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Customer Email: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $trans->customer_email; ?></div></td>
						</tr>
						
						
						
						
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Amount Received: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $trans->trans_amount; ?></div></td>
						</tr>
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Payment Mode: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $trans->payment_mode; ?></div></td>
						</tr>
						
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Transaction Date: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $trans->trans_date; ?></div></td>
						</tr>
						
						
							<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Transaction Status: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $tra_s; ?></div></td>
						</tr>
						
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Bank Name: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $trans->bank_name; ?></div></td>
						</tr>
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Bank Transaction ID: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $trans->bank_trans_id; ?></div></td>
						</tr>
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Getway Name: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $trans->gatwayname; ?></div></td>
						</tr>
						
						
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Description: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $trans->description; ?></div></td>
						</tr>
						
						
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Client IP: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $trans->client_ip; ?></div></td>
						</tr>
						
						
						
						
					</table>
				</div>	
			</div>			</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- Modal -->
<script type="text/javascript">
jQuery(document).ready(function($){	$(".table").DataTable();
});
</script>
<?php }else{
	redirect(404);
}?>