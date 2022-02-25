<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.10/clipboard.min.js"></script>

<?php if($payment_link){ 	$pay_link = $payment_link[0]; ?>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-inr"></i> Payment Link
					</div>
					<a class="btn btn-success" href="<?php echo site_url("accounts/payment_links"); ?>" title="Back">Back</a>
				</div>
			</div>
			
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<style> 
				#t_countdown{
					text-align: center; 
					font-size: 20px; 
					color: red;
				}
			</style> 
			<div class="portlet-body custom_card">
				<?php
					$pay_status = $pay_link->paid_status == 1 ? "<strong class='green'>PAID</strong>" : "<strong class='red'>UNPAID</strong>";
					$link_token	= base64_url_encode( $pay_link->link_token );
					$enc_key 	= base64_url_encode(md5( $this->config->item("encryption_key") ));
					$client_link = base_url("checkout/payinstallment?i={$link_token}");
				?>
				
				<h3>Customer Details</h3>
				<p id="t_countdown"></p>
				<div class="table-responsive">	
				<!-- Target -->
				<table class="table table-condensed table-hover table-bordered table-striped">
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Link ID: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $pay_link->link_token; ?> ( <?php echo $pay_status; ?> )</div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>ORDER ID: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $pay_link->order_id; ?> ( <?php echo $pay_status; ?> )</div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Customer ID: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $pay_link->customer_id; ?></div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Iti ID: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><a href="<?php echo iti_view_single_link( $pay_link->iti_id ); ?>" title='check quotation' target='_blank'><?php echo $pay_link->iti_id; ?></a></div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Amount: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $pay_link->trans_amount; ?></div></td>
					</tr>
					<?php if(  $pay_link->paid_status == 0  ){ ?>
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Payment Link: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr" id='copyme'><?php echo $client_link; ?>
							</div>
							<button class="btn btn_blue_outline copy-letter-button margin-top-15" data-clipboard-action="copy" data-clipboard-target="#copyme">Click To Copy Payment Link</button>
							
							</td>
						</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Link Expire On: </strong></div></td>
						<?php
						$exp = "";
						if( !empty($pay_link->link_expire_date)  ){
							$disabled_btn = "";
							$link_expire_date = strtotime($pay_link->link_expire_date); //gives value in Unix Timestamp (seconds since 1970)
							$current_d = strtotime( date("Y-m-d H:i:s") );
							
							if ( $link_expire_date < $current_d ){
								$exp = "( Link Expire ) ";
							}else{ 
							
							?>
								<script> 
									var deadline = new Date(<?php echo $link_expire_date*1000 ?>).getTime();
									//console.log( date );
									//var deadline = new Date("Jan 5, 2020 15:37:25").getTime(); 
									var x = setInterval(function() { 
										var now = new Date().getTime(); 
										var t = deadline - now; 
										var days = Math.floor(t / (1000 * 60 * 60 * 24)); 
										var hours = Math.floor((t%(1000 * 60 * 60 * 24))/(1000 * 60 * 60)); 
										var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60)); 
										var seconds = Math.floor((t % (1000 * 60)) / 1000); 
										document.getElementById("t_countdown").innerHTML = "Link Expire in: " + days + "d " 
										+ hours + "h " + minutes + "m " + seconds + "s ";
										
										//console.log( now );
										
										if ( t < 0 ) {
											clearInterval(x); 
											document.getElementById("t_countdown").innerHTML = "LINK EXPIRED";
											document.getElementById("checkout_btn").disabled = true;
										}else{
											if( days == 0 && hours == 0 && minutes == 0 && seconds == 0 ){
												alert("LINK HAS BEEN EXPIRED.");
											}
										} 
									}, 1000); 
								</script>
							<?php } 
							
						}
						?>
						<td><div class="col-mdd-10 form_vr"><strong class='red'> <?php echo $pay_link->link_expire_date . $exp; ?> </strong> </div></td>
					</tr>
					<?php } ?>
					
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Updated By:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo get_user_name($pay_link->agent_id); ?></strong></div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Created:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo $pay_link->created; ?></strong></div></td>
					</tr>
				</table>
			</div>	
			
			<div class="text-center">
				<a title='Edit User' href="<?php echo site_url("accounts/create_payment_link/{$pay_link->id}"); ?>" class="btn_pencil" ><i class="fa fa-pencil"></i> Edit</a>
			</div>	
		</div>	
	</div>
</div>
	<div class="loader"></div>
<?php }else{
	redirect(404);
} ?>	

<script>
jQuery( document ).ready(function($){
	
	$('[data-toggle="tooltip"]').tooltip();
	var clipboard = new Clipboard('.copy-letter-button');
	clipboard.on('success', function(e) {
		alert('Link Copied Successfully');
		console.log(e);
	});

	clipboard.on('error', function(e) {
	  console.log(e);
	});
});
</script>
