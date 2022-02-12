<?php if($vouchers){ ?>
<div class="page-container itinerary-view">
	<div class="page-content-wrapper">
		<div class="page-content">
			<?php 			
				$voucher = $vouchers[0];
				$terms = get_terms_condition();
				if( $terms ){
					$terms = $terms[0];
					$online_payment_terms	 	= htmlspecialchars_decode($terms->bank_payment_terms_content);
					$cancel_tour_by_client 		= htmlspecialchars_decode($terms->cancel_content);
					$terms_condition			= htmlspecialchars_decode($terms->terms_content);
					$disclaimer = htmlspecialchars_decode($terms->disclaimer_content);
					$greeting = $terms->greeting_message;
				}else{
					$greeting = "";
					$online_payment_terms = "";
					$cancel_tour_by_client = "";
					$terms_condition = "";
					$disclaimer = "";
				}	?>
				
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-users"></i><strong>Customer Name: </strong><?php echo $voucher->customer_name; ?></div>
						<a class="btn btn-success pull-right" href="<?php echo site_url("vouchers"); ?>" title="Back">Back</a>
					</div>
				</div>
				
				<div class="row2">
					<p><strong>Dear : </strong> <?php echo $voucher->customer_name . ' / ' . $voucher->customer_contact; ?></p>
					<?php echo $greeting; ?>
					<div class="well well-sm"><h3>Package Overview</h3></div>
					
					<div class="table-responsive">
						<table class="table table-bordered ">
							<tbody>
								<tr class="thead-inverse">
									<td><strong>Name</strong></td>
									<td><strong>Contact</strong></td>
									<td><strong>Email</strong></td>
								</tr>
								<tr>
									<td><?php echo $voucher->customer_name; ?></td>
									<td><?php echo $voucher->customer_contact; ?></td>
									<td><?php echo $voucher->customer_email; ?></td>
								</tr>
								
								<tr>
									<td><strong>No of Adults</strong></td>
									<td><strong>No of Children</strong></td>
									<td><strong>Address</strong></td>
								</tr>
								<tr>
									<td><?php echo $voucher->adults; ?></td>
									<td><?php echo $voucher->children;  ?></td>
									<td><?php echo $voucher->customer_address; ?></td>
								</tr>
								<tr>
									<td><strong>Package Name</strong></td>
									<td><strong>Total Rooms</strong></td>
									<td><strong>Travel Date</strong></td>
								</tr>
								<tr>
									<td><?php echo $voucher->package_name; ?></td>
									<td><?php echo $voucher->total_rooms;  ?></td>
									<td><?php echo $voucher->travel_date . " - " . $voucher->travel_end_date; ?></td>
								</tr>
								<tr>
									<td><strong>Vehicle Type</strong></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td><?php echo $voucher->vehicle_type; ?></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="clearfix"></div>
					<hr>
					<div class="well well-sm"><h3>Day Wise Programme</h3></div>
					<div class="table-responsive">
						<table class="table table-bordered hidden-md">
							<th>Date</th>
							<th>Programme</th>
							<th>Hotel Details</th>
							<th>Meal Plan</th>
							<th>Transportation Type</th>
							<tbody>
								
								<?php $day_wise = $voucher->daywiseplan; 
								$tourData = unserialize($day_wise);
								$count_day = count( $tourData );
								if( $count_day > 0 ){
									//print_r( $tourData );
									for ( $i = 0; $i < $count_day; $i++ ) {
										$cab_details = "";
										if( isset( $tourData[$i]['cab_details'] ) ){
											$cab_meta = unserialize($tourData[$i]['cab_details']);
											$count_cab_meta = count( $cab_meta );
											if( $count_cab_meta > 0 ){
												for ( $ii = 0; $ii < $count_cab_meta; $ii++ ) {
													$cab_num	= $cab_meta[$ii]["taxi_number"];
													$dr_name 	= $cab_meta[$ii]["driver_name"];
													$dr_contact = $cab_meta[$ii]["driver_contact"];
													if( !empty($cab_num)){ $cab_details .= "<strong>Cab Number: </strong>$cab_num";  }
													if( !empty($dr_name)){ $cab_details .= "<strong>Driver Name:</strong> $dr_name";  }
													if( !empty($dr_contact)){ $cab_details .= "Driver Contact: </strong>$dr_contact";  }
													$cab_details .= "<br>";
												}
											}  
										}	
									echo "<tr><td>";
										$tour_date = $tourData[$i]['tour_date'];
										echo $tour_date;
										echo "</td><td>";
										echo $tourData[$i]['tour_name'] . "</td><td>"; 
										echo $tourData[$i]['hotel_details'] . "</td><td>";
										echo $tourData[$i]['meal_plan'] . "</td><td>";
										echo $tourData[$i]['transport_type'] . " <br>" . $cab_details . " </td>";
									echo "</tr>";
									}
								}	?>
							</tbody>
						</table>
					</div>	
					<hr>	
					<div class="well well-sm"><h3>Package / Tour Cost & Advance Received Details</h3></div>
					<?php
					$p_cost		 		= number_format($voucher->package_cost); 
					$tax		 		= $voucher->tax; 
					$grand_total 		= $voucher->grand_total; 
					$advance 			= $voucher->advance_payment; 
					$balance 			= $voucher->balance_payment; 
					$last_installment	= $voucher->last_installment; 
					
					?>
					<div class="table-responsive">
						<table class="table table-bordered">
							<tbody>
								<?php 
								echo "<tr>
									<td>Package Cost: </td>
									<td>{$p_cost}</td></tr>
									<tr><td>Tax: </td>
									<td>{$tax}</td></tr>
									<tr><td>Grand Total: </td>
									<td>{$grand_total}</td></tr>
									<tr><td>Advance Received: </td>
									<td>{$advance}</td></tr>
									<tr><td>Balance Payment: </td>
									<td>{$balance}</td></tr>
									<tr><td>Last Installment: </td>
									<td>{$last_installment}</td>
								</tr>"
								?>
							</tbody>
						</table>
					</div>	
					<hr>
						
						<div class="well well-sm"><h3>Notes:</h3></div>
					<ul>
					<?php $hotel_note_meta = unserialize($voucher->hotel_notes_meta); 
					$count_hotel_meta = count( $hotel_note_meta );
					
					if( $count_hotel_meta > 0 ){
						for ( $i = 0; $i < $count_hotel_meta; $i++ ) {
							echo "<li>" . $hotel_note_meta[$i]["hotel_note"] . "</li>";
						}	
					} ?>
					</ul>
					<div class="well well-sm"><h3>Inclusion & Exclusion</h3></div>
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead class="thead-default">
								<tr>
									<th> Inclusion</th>
									<th> Exclusion</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$inclusion = unserialize($voucher->vc_inc); 
								$count_inc = count( $inclusion );
								$exclusion = unserialize($voucher->vc_exc); 
								
								$count_exc = count( $exclusion );
								echo "<tr><td><ul>";
								if( $count_inc > 0 ){
									for ( $i = 0; $i < $count_inc; $i++ ) {
										echo "<li>" . $inclusion[$i]["inc"] . "</li>";
									}	
								}
								echo "</ul></td><td><ul>";
								if( $count_exc > 0 ){
									for ( $i = 0; $i < $count_exc; $i++ ) {
										echo "<li>" . $exclusion[$i]["exc"] . "</li>";
									}	
								}
								echo "</ul></td></tr>";
								?>
							</tbody>
						</table>
					</div>	
					<hr>
					<div class='well well-sm'><h3>Contact Numbers Regarding Booking</h3></div>
					<p><strong> Please Contact Regarding booking & payment Detail Given Below:- <strong></p>
					<?php $get_sales_team_details = get_settings(); ?>
						<div class="table-responsive">
						<table class="table table-bordered">
							<thead class="thead-default">
								<tr>
									<th> Sr. No.</th>
									<th> Contact For</th>
									<th> Contact Person</th>
									<th> Mobile Number</th>
									<th> Email Id</th>
								</tr>
							</thead>
							<tbody>
							<tr> 
								<td>1.</td>
								<td>Volvo</td>
								<td><?php echo $get_sales_team_details->vehicle_team_name; ?></td>
								<td><?php echo $get_sales_team_details->vehicle_team_contact; ?></td>
								<td><?php echo $get_sales_team_details->vehicle_email; ?></td>
							</tr>
							<tr> 
								<td>2.</td>
								<td>Hotel</td>
								<td><?php echo $get_sales_team_details->hotel_team_name; ?></td>
								<td><?php echo $get_sales_team_details->hotel_team_contact; ?></td>
								<td><?php echo $get_sales_team_details->hotel_email; ?></td>
							</tr>
							<tr> 
								<td>3.</td>
								<td>Payment</td>
								<td><?php echo $get_sales_team_details->sales_team_name; ?></td>
								<td><?php echo $get_sales_team_details->sales_team_contact; ?></td>
								<td><?php echo $get_sales_team_details->sales_email; ?></td>
							</tr>
							</tbody>
						</table>
					</div>		
					<?php
						echo "<div class='well well-sm'><h3>Online Payment Terms</h3></div>";
						echo $online_payment_terms;
						echo "<div class='well well-sm'><h3>Cancellation Of The Tour By Client</h3></div>";
						echo $cancel_tour_by_client;
						echo "<div class='well well-sm'><h3>Terms & Condition</h3></div>";
						echo $terms_condition;
					?>
					<?php
					$agent_id = $voucher->agent_id;
					$user_info = get_user_info($agent_id);
					if($user_info){
						$agent = $user_info[0];
						echo "<strong>Regards</strong><br>";
						echo "<strong> " . $agent->first_name . " " . $agent->last_name . "</strong><br>";
						echo "<strong>Call Us : </strong> " . $agent->mobile . "<br>";
						echo "<strong>Email : </strong> " . $agent->email . "<br>";
						echo "<strong>Timing : </strong> " . $agent->in_time . " To " . $agent->out_time . "<br>";
						echo "<strong>Website : </strong> " . $agent->website;
					}	
					?>
					<div class="disc_con"> 
					<?php echo $disclaimer; ?></div>
					
					<div class="form-group col-md-12">
						<input type="hidden" name="voucher_id" value="<?php echo $voucher->voucher_id; ?>" id="voc_send_id">
						<input type="hidden" name="temp_key" value="<?php echo $voucher->temp_key; ?>" id="voc_send_key">
						<?php $voucher_mail_sent = $voucher->email_count; 
						if( $voucher_mail_sent == 0 ){ 
							echo "<div class=' btn btn-info pull-right'>Voucher not send yet.</div>";
							echo '<a href="#" class="btn green uppercase pull-left" id="iti_send">Send</a>';
						}elseif( $voucher_mail_sent > 0 && is_admin() ){ 
							echo "<div class=' btn btn-info pull-right'>Voucher Sent " . $voucher_mail_sent . " Times.</div>";
							echo '<a href="#" class="btn green uppercase pull-left" id="iti_send">Resend</a>';
						}else{
							echo "<div class=' btn btn-info pull-left'>Voucher Sent " . $voucher_mail_sent . " Times.</div>";
							echo "<div class=' btn btn-danger pull-right'>Voucher already send. To resend please contact your administrator.</div>";
						}
						?>
					</div>
					<div class="clearfix"></div>				
					<div id="mailSentResponse"></div>

				</div>
			
		
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
	var ajaxReq;
	$("#iti_send").click(function(e){
		e.preventDefault();
		var vocher_id = $("#voc_send_id").val();
		var temp_key = $("#voc_send_key").val();
		var resp = $("#mailSentResponse");
		if (ajaxReq) {
            ajaxReq.abort();
		}
		ajaxReq = $.ajax({
			type: "POST",
			url: "<?php echo base_url('sendemail/sendvoucher'); ?>" ,
			dataType: 'json',
			data: {id: vocher_id, key: temp_key},
			beforeSend: function(){
				resp.html("<div class='alert alert-info'><strong>Please wait</strong> gernating pdf sending mail.....</div>");
			},
			success: function(res) {
				if (res.status == true){
					resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
					//console.log(res.msg);
					alert(res.msg);
					location.reload();
				}else{
					resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
					console.log("error");
				}
			},
			error: function(e){
					//console.log(e);
				resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
			}
		});
	}); 
});
</script>
<?php }else{
		redirect("vouchers");
	} ?>	