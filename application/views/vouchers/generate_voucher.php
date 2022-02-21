<div class="page-container itinerary-view">
    <div class="page-content-wrapper">
        <div class="page-content">
            <?php if( isset($error) && !empty( $error ) ){ ?>
            <div class="portlet box blue">
                <div class="portlet-title">
                    <a class="btn btn-success pull-right" href="<?php echo site_url("vouchers"); ?>"
                        title="Back">Back</a>
                </div>
            </div>
            <div class="alert alert-danger"> <?php echo $error; ?></div>
            <?php }else{ ?>
            <!--GET CUSTOMER ACCOUNT-->
            <?php 
            $iti 		= $itinerary[0];
            $pay		= $iti_payment_details[0];
            $voucher 	= $vouchers[0];
            
            $customer_id = $customer[0]->customer_id;
            $customer_account = get_customer_account( $customer_id );
            if( $customer_account && !empty( $customer_account[0]->customer_name ) ){
            	$customer_name 		= $customer_account[0]->customer_name;
            	$customer_email 	= $customer_account[0]->customer_email;
            	$customer_contact 	= $customer_account[0]->customer_contact;
            	$customer_address 	= $customer_account[0]->address;
            	$country		 	= get_country_name($customer_account[0]->country_id);
            	$state 				= get_state_name($customer_account[0]->state_id);
            }else{
            	$customer_name 		= $customer[0]->customer_name;
            	$customer_email 	= $customer[0]->customer_email;
            	$customer_contact 	= $customer[0]->customer_contact;
            	$customer_address 	= $customer[0]->customer_address;
            	$country		 	= get_country_name($customer[0]->country_id);
            	$state 				= get_state_name($customer[0]->state_id);
            }
            ?>
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-users"></i><strong>VOUCHER NUMBER:
                        </strong><?php echo $voucher->voucher_id; ?>
                    </div>
                    <a class="btn btn-success pull-right" href="<?php echo site_url("vouchers"); ?>"
                        title="Back">Back</a>
                </div>
            </div>
            <?php 		
            //GET TERMS iti_type = 2 for accommotion terms
            $terms = $iti->iti_type == 2 ? get_hotel_terms_condition() : get_terms_condition();
            $online_payment_terms	 	= isset($terms[0]) && !empty($terms[0]->bank_payment_terms_content) ? unserialize($terms[0]->bank_payment_terms_content) : "";
            $advance_payment_terms		= isset($terms[0]) && !empty($terms[0]->advance_payment_terms) ? unserialize($terms[0]->advance_payment_terms	) : "";
            $cancel_tour_by_client 		= isset($terms[0]) && !empty($terms[0]->cancel_content) ? unserialize( $terms[0]->cancel_content) : "";
            $terms_condition			= isset($terms[0]) && !empty($terms[0]->terms_content) ? unserialize($terms[0]->terms_content) : "";
            $disclaimer 				= isset($terms[0]) && !empty($terms[0]->disclaimer_content) ? htmlspecialchars_decode($terms[0]->disclaimer_content) : "";
            $greeting 					= isset($terms[0]) && !empty($terms[0]->greeting_message) ? $terms[0]->greeting_message : "";
            $amendment_policy			= isset($terms[0]) && !empty($terms[0]->amendment_policy) ? unserialize( $terms[0]->amendment_policy) : "";
            $book_package_terms			= isset($terms[0]) && !empty($terms[0]->book_package) ? unserialize( $terms[0]->book_package) : "";
            $signature					= isset($terms[0]) && !empty($terms[0]->promotion_signature) ?  htmlspecialchars_decode($terms[0]->promotion_signature) : "";
            $payment_policy				= isset($terms[0]) && !empty($terms[0]->payment_policy) ? unserialize($terms[0]->payment_policy) : "";
            ?>
            <div class="row2">
                <div class="custom_card">
                    <p><strong>Dear : </strong> <?php echo $customer_name . ' / ' . $customer_contact; ?></p>
                    <?php echo $greeting; ?>
                    <div class="well well-sm margin-top-40">
                        <h3>Package Overview</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered ">
                            <tbody>
                                <tr class="thead-inverse">
                                    <td><strong>Name</strong></td>
                                    <td><strong>Contact</strong></td>
                                    <td><strong>Email</strong></td>
                                </tr>
                                <tr>
                                    <td><?php echo $customer_name; ?></td>
                                    <td><?php echo $customer_contact; ?></td>
                                    <td><?php echo $customer_email; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>No of Adults</strong></td>
                                    <td><strong>No of Children</strong></td>
                                    <td><strong>Address</strong></td>
                                </tr>
                                <tr>
                                    <td><?php echo $itinerary[0]->adults; ?></td>
                                    <td><?php echo $itinerary[0]->child;  ?></td>
                                    <td><?php echo $customer_address; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Package Name</strong></td>
                                    <td><strong>Total Rooms</strong></td>
                                    <td><strong>Travel Date</strong></td>
                                </tr>
                                <tr>
                                    <td><?php echo $itinerary[0]->package_name; ?></td>
                                    <td><?php echo isset($hotels[0]->total_rooms) ? $hotels[0]->total_rooms : "";  ?>
                                    </td>
                                    <td><?php echo $itinerary[0]->t_start_date . " - " . $itinerary[0]->t_end_date; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Duration</td>
                                    <td><strong>Vehicle Type</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><?php echo $itinerary[0]->iti_type == 2 ? $itinerary[0]->total_nights . " Nights" : $itinerary[0]->duration; ?>
                                    </td>
                                    <td><?php echo !empty( $itinerary[0]->cab_category ) ? get_car_name( $itinerary[0]->cab_category ) : "--"; ?>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr>
                <!--if holidays iti show daywise data-->
                <div class="custom_card">
                    <?php if( $iti->iti_type == 1 ){ ?>
                    <div class="well well-sm">
                        <h3>Day Wise Programme</h3>
                    </div>
                    <div class="table-responsive2 printable">
                        <table class="table table-bordered">
                            <tbody>
                                <?php
                           //$day_wise = $iti->daywise_meta; 
                           //dump( $iti->daywise_meta ); die;
                           $tourData = unserialize( $iti->daywise_meta );
                           $count_day = count( $tourData );
                           if( $count_day > 0 ){
                           	//print_r( $tourData );
                           	for ( $i = 0; $i < $count_day; $i++ ) {
                           	echo "<tr><td width='10%'>";
                           		$day = $i+1;
                           		echo "<span class=''><strong>Day: ".$tourData[$i]['tour_day']."</strong> </span>";
                           		echo "</td><td width='80%'>";
                           		echo "<!--<div class='some-space'></div>--><strong>" . $tourData[$i]['tour_name'] . "</strong><br>"; 
                           		echo "<strong>Tour Date:</strong><em> " .display_date_month($tourData[$i]['tour_date']) . "</em><br>"; 
                           		echo "<strong>Meal Plan:</strong><em> " .$tourData[$i]['meal_plan'] . "</em><br>"; 
                           		echo "<strong>Tour Description:</strong><em> " .$tourData[$i]['tour_des'] . "</em><br>"; 
                           		echo "<strong>Distance:</strong><em> " .$tourData[$i]['tour_distance'] . " KMS</em><br>";
                           		//hot destination
                           		if( isset($tourData[$i]['hot_des'] ) && !empty( $tourData[$i]['hot_des'] ) ){
                           			$hot_dest = '';
                           			$htd = explode(",", $tourData[$i]['hot_des']);
                           			foreach($htd as $t) {
                           				$t = trim($t);
                           				$hot_dest .= "<span>" . $t . "</span>";
                           			}
                           			echo '<div class="hot_des_view "><strong>Attraction: </strong>' . $hot_dest . '</div>';
                           		}	
                           		echo "</td>";
                           	echo "</tr>";
                           	}
                           }	?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <?php } ?>
                <!--HOTELS DETAILS-->
                <div class="custom_Card">
                    <?php if( $hotels ){ ?>
                    <div class="well well-sm">
                        <h3>Accommodation</h3>
                    </div>
                    <div class="table-responsive2 printable">
                        <table class="table table-bordered">
                            <thead class="thead-default">
                                <th>Sr.</th>
                                <th>City</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Hotel</th>
                                <th>Room Cat</th>
                                <th>Rooms</th>
                                <th>N/t</th>
                            </thead>
                            <tbody>
                                <?php
                           $ch = 1;
                           foreach ( $hotels as $hotel ) {
                           	if( !empty( $hotel->check_in ) && !empty($hotel->check_out) ){
                           		$check_in 	=  $hotel->check_in; 
                           		$check_out 	=  $hotel->check_out;
                           		$date1 		=	 new DateTime($check_in);
                           		$t_date2 	= 	 new DateTime($check_out);
                           		$total_days =  $t_date2->diff($date1)->format("%a"); 
                           		$total_days = $total_days+1;
                           		if( $total_days <= 1 ){
                           			$duration =  "Single Day";
                           		}else{
                           			$nights = $total_days - 1;
                           			$duration =  $nights . " Nights";
                           			
                           		}
                           	}else{
                           		$duration =  "";
                           		$nights ="";
                           	}
                           	
                           	//Get Hotel Information 
                           	$htl_info = get_hotel_details($hotel->hotel_id);;
                           	$hotel_info = $htl_info[0];
                           	$hotel_name = $hotel_info->hotel_name;
                           	$hotel_emails = $hotel_info->hotel_email;
                           	$city = get_city_name( $hotel->city_id );
                           	$check_in_m = display_month_name( $hotel->check_in );
                           	$check_out_m = display_month_name( $hotel->check_out );
                           	$room_cat = get_roomcat_name( $hotel->room_type );
                           	echo "<tr>
                           			<td>{$ch}.</td>
                           			<td>{$city}</td>
                           			<td>{$check_in_m}</td>
                           			<td>{$check_out_m}</td>
                           			<td>{$hotel_name}</td>
                           			<td>{$room_cat}</td>
                           			<td>{$hotel->total_rooms}</td>
                           			<td>{$nights}</td>
                           		</tr>";
                           	$ch++;
                           } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php }?>
                </div>
                <hr>
                <div class="custom_card">
                    <!--VEHICLES DETAILS-->
                    <?php if( $cab_booking ){ ?>
                    <div class="well well-sm">
                        <h3>Vehicle</h3>
                    </div>
                    <div class="table-responsive2 printable">
                        <table class="table table-bordered">
                            <thead class="thead-default">
                                <th>Sr.</th>
                                <th>Vehicle</th>
                                <th>Pick. Date</th>
                                <th>Drop. Date</th>
                                <th>Tarrif</th>
                            </thead>
                            <tbody>
                                <?php
                           $chd = 1;
                           foreach ( $cab_booking as $cab_book ) {
                           	//Get cab_book Information 
                           	$cab_name = get_car_name($cab_book->cab_id);
                           	$picking_date = display_month_name($cab_book->picking_date);
                           	$droping_date = display_month_name($cab_book->droping_date);
                           	echo "<tr>
                           			<td>{$chd}.</td>
                           			<td>{$cab_name}</td>
                           			<td>{$picking_date}</td>
                           			<td>{$droping_date}</td>
                           			<td>{$cab_book->pic_location} - {$cab_book->drop_location}</td>
                           		</tr>";
                           		
                           		//cab meta driver info
                           		$cab_meta = unserialize( $cab_book->cab_meta ); 
                           		$t_cabs = $cab_book->total_cabs;
                           		if( !empty( $cab_meta ) ){
                           			for( $i=0; $i < $t_cabs; $i++ ){
                           				$taxi_number = isset($cab_meta[$i]['taxi_number']) ? $cab_meta[$i]['taxi_number'] : "";
                           				$driver_name = isset($cab_meta[$i]['driver_name']) ? $cab_meta[$i]['driver_name'] : "";
                           				$driver_contact = isset($cab_meta[$i]['driver_contact']) ? $cab_meta[$i]['driver_contact'] : "";
                           				
                           				echo "<tr class='row_dot'>
                           					<td></td>
                           					<td><strong>Taxi Number: </strong> {$taxi_number}</td>
                           					<td><strong>Driver Name: </strong> {$driver_name} </td>
                           					<td colspan=2><strong>Driver Contact: </strong> {$driver_contact}</td>
                           				</tr>";
                           			}	
                           		}
                           
                           	$chd++;	
                           } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                </div>
                <!--if holidays iti show daywise data-->
                <?php if( isset($vtf_booking[0]) ){ ?>
                <div class="well well-sm">
                    <h3>Volvo/Train/Flight Tickets Detail</h3>
                </div>
                <div class="table-responsive2 printable">
                    <table class="table table-bordered">
                        <thead class="thead-default">
                            <th>Sr.</th>
                            <th>Type</th>
                            <th>Docs/Tickets</th>
                        </thead>
                        <tbody>
                            <?php
                        $vd = 1;
                        $doc_path =  base_url() . 'site/assets/client_tickets_docs/';
                        foreach ( $vtf_booking as $v_booking ) {
                        	//Get cab_book Information 
                        	$vtf_booking_docs = $this->global_model->getdata( 'vtf_booking_docs', array("booking_id" => $v_booking->id ) );
                        	echo "<tr>
                        			<td>{$vd}.</td>
                        			<td>{$v_booking->booking_type}</td>";
                        			echo "<td>";
                        			if( $vtf_booking_docs ){
                        				echo "<table class='table table-bordered'>";
                        				$vbd = 1;
                        				foreach( $vtf_booking_docs as $b_docs  ){
                        					$d_link = '<a href="' . $doc_path . $b_docs->file_url .'" title="Click here to view/download" target="_blank" class="btn btn-success" style="position:relative;"><i class="fa fa-download"aria-hidden="true"></i></a>';
                        					
                        					echo "<tr>
                        						<td>{$vbd}.</td>
                        						<td>{$b_docs->description}</td>
                        						<td>{$d_link}</td>
                        					</tr>";	
                        					
                        					$vbd++;
                        				}	
                        				echo "</table>";
                        			}
                        			echo "</td>";
                        		echo "</tr>";
                        	$vd++;	
                        } ?>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
                <hr>
                <div class="custom_card">
                    <div class="well well-sm">
                        <h3>Package / Tour Cost & Advance Received Details</h3>
                    </div>
                    <?php
                  $p_cost		= isset($pay->total_package_cost) ? number_format($pay->total_package_cost) : "";
                  $advance 	= isset($pay->advance_recieved) ? $pay->advance_recieved : ""; 
                  $balance 	= isset($pay->total_balance_amount) ?  $pay->total_balance_amount : "";
                  ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <?php 
                           echo "<tr>
                           	<td>Package Cost: </td>
                           	<td>{$p_cost}</td></tr>
                           	<tr><td>Advance Received (1st Ins.): </td>
                           	<td>{$advance}</td></tr>
                           	<tr><td>Total Balance Pending: </td>
                           	<td>{$balance}</td></tr>"
                           ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="custom_card">
                    <div class="well well-sm">
                        <h3>Notes:</h3>
                    </div>
                    <ul>
                        <?php $hotel_note_meta = unserialize($iti->hotel_note_meta); 
                     $count_hotel_meta = count( $hotel_note_meta );
                     
                     if( $count_hotel_meta > 0 ){
                     	for ( $i = 0; $i < $count_hotel_meta; $i++ ) {
                     		echo "<li>" . $hotel_note_meta[$i]["hotel_note"] . "</li>";
                     	}	
                     } ?>
                    </ul>
                </div>
                <hr>

                <div class="custom_card">
                    <div class="well well-sm">
                        <h3>Inclusion & Exclusion</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-default">
                                <tr class="thead-inverse">
                                    <th width="50%"> Inclusion</th>
                                    <th width="50%"> Exclusion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
							$inclusion = unserialize($iti->inc_meta); 
							$count_inc = count( $inclusion );
							$exclusion = unserialize($iti->exc_meta); 
							$count_exc = count( $exclusion );
							echo "<tr><td><ul>";
							if( $count_inc > 0 ){
								for ( $i = 0; $i < $count_inc; $i++ ) {
									echo "<li>" . $inclusion[$i]["tour_inc"] . "</li>";
								}	
							}
							echo "</ul></td><td><ul>";
							if( $count_exc > 0 ){
								for ( $i = 0; $i < $count_exc; $i++ ) {
									echo "<li>" . $exclusion[$i]["tour_exc"] . "</li>";
								}	
							}
							echo "</ul></td></tr>";
							?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr>

                <div class="custom_card">
                    <div class='well well-sm'>
                        <h3>Contact Numbers Regarding Booking</h3>
                    </div>
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
               $count_bank_payment_terms	= count( $online_payment_terms ); 
               $count_bankTerms			= $count_bank_payment_terms-1; 
               if(isset($online_payment_terms["heading"]) ) { 
               	echo "<div class='well well-sm'><h3>" . $online_payment_terms["heading"] . "</h3></div>"; 
               }
               if( $count_bankTerms > 0 ){
               	echo "<ul class='client_listing'>";
               		for ( $i = 0; $i < $count_bankTerms; $i++ ) { 
               			echo "<li>" . $online_payment_terms[$i]["terms"] . "</li>";
               		}
               	echo "</ul>";
               }
               
               echo "<div class='well well-sm'><h3>Cancellation Of The Tour By Client</h3></div>";
               $count_cancel_content	= count( $cancel_tour_by_client );
               if( $count_cancel_content > 0 ){
               	echo '<div class="table-responsive">
               				<table class="table table-bordered tbl_policy_view">
               					<thead class="thead-default">
               						<tr>
               							<th colspan=3> Cancellation and Refund Policy </th>
               						</tr>
               					</thead>
               					<tbody>';
               		$counter_ra = 1;
               		for ( $i = 0; $i < $count_cancel_content-1; $i++ ) { 
               			$book_title = isset($cancel_tour_by_client[$i]["cancel_terms"]) ? $cancel_tour_by_client[$i]["cancel_terms"] : "";
               			$book_val = isset($cancel_tour_by_client[$i]["cancel_terms_right"]) ? $cancel_tour_by_client[$i]["cancel_terms_right"] : "";
               			echo "<tr>
               				<td>" . $counter_ra . "</td>
               				<td>" . $book_title . "</td>
               				<td>" . $book_val . "</td>
               			</tr>";
               			$counter_ra++;
               		}
               	echo "</tbody></table></div>";
               }
               
               echo "<div class='well well-sm'><h3>Terms & Condition</h3></div>";
               $count_cancel_content	= count( $terms_condition );
               if( $count_cancel_content > 0 ){
               	echo "<ul class='client_listing'>";
               		for ( $i = 0; $i < $count_cancel_content-1; $i++ ) { 
               			echo "<li>" . $terms_condition[$i]["terms"] . "</li>";
               		}
               	echo "</ul>";
               }
               ?>
                    <div class="voucher_sign_sec">
                        <?php
               $agent_id = $iti->agent_id;
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
                    </div>
                </div>

                <div class="custom_card row margin-top-30">
                    <div class="disc_con">
                        <?php echo $disclaimer; ?>
                    </div>
                    <div class="form-group col-md-12 margin_bottom_0">
                        <?php
					$voucher_mail_sent = $voucher->sent_count;
					echo '<div class="text-center margin-bottom-20 margin-top-15"><a title="send voucher to client" href="#" class="btn green uppercase" id="iti_send">Send Voucher</a></div>';
					
					if( $voucher_mail_sent == 0 ){ 
						echo "<div class='clearfix alert alert-danger'>Voucher not send yet.</div>";
					}else{ 
						echo "<div class='clearfix alert alert-success'>Voucher Sent " . $voucher_mail_sent . " Times.</div>";
					}
					?>
                    </div>
                </div>


                <!-- Modal sent itinerary-->
                <div class="modal fade" id="sendItiModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Send Voucher</h4>
                            </div>
                            <div class="modal-body">
                                <form id="sentItiForm">
                                    <div class="form-group">
                                        <label for="email">Customer Email:</label>
                                        <input required type="email" readonly value="<?php echo $customer_email; ?>"
                                            class="form-control" id="email" placeholder="Enter customer email"
                                            name="customer_email">
                                    </div>
                                    <!--CC Email Address-->
                                    <div class="form-group">
                                        <label for="cc_email">CC Email:</label>
                                        <input type="text" value="" class="form-control" id="cc_email"
                                            placeholder="Enter CC Email.eg. admin@trackitinerary.org" name="cc_email">
                                    </div>
                                    <!--BCC Email Address-->
                                    <div class="form-group">
                                        <label for="bcc_email">BCC Email:</label>
                                        <input type="text" value="" class="form-control" id="bcc_email"
                                            placeholder="Enter BCC email eg. manager@trackitinerary.org"
                                            name="bcc_email">
                                    </div>
                                    <div class="form-group">
                                        <label for="sub">Subject:</label>
                                        <input type="text" required class="form-control" id="sub"
                                            placeholder="Final confirmation Mail" name="subject" value="">
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <input type="hidden" name="iti_id" value="<?php echo $voucher->iti_id; ?>">
                                    <input type="hidden" name="id" value="<?php echo $voucher->id; ?>">
                                    <button type="submit" id="sentIti_btn" class="btn btn-success">Send Voucher</button>
                                    <div id="mailSentResponse" class="sam_res"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {

    //open modal 
    $("#iti_send").click(function(e) {
        e.preventDefault();
        $('#sendItiModal').modal('show');
    });

    $("#sentItiForm").validate({
        submitHandler: function(form) {
            $("#sentIti_btn").attr("disabled", "disabled");
            var ajaxReq;
            var resp = $("#mailSentResponse");
            var formData = $("#sentItiForm").serializeArray();
            if (ajaxReq) {
                ajaxReq.abort();
            }

            ajaxReq = $.ajax({
                type: "POST",
                url: "<?php echo base_url('vouchers/sendVoucher'); ?>",
                dataType: 'json',
                data: formData,
                beforeSend: function() {
                    LOADER.show();
                    resp.html(
                        "<div class='alert alert-info'><strong>Please wait</strong> sending mail.....</div>"
                    );
                },
                success: function(res) {
                    LOADER.hide();
                    if (res.status == true) {
                        resp.html(
                            '<div class="alert alert-success"><strong>Success! </strong>' +
                            res.msg + '</div>');
                        //console.log(res.msg);
                        alert(res.msg);
                        location.reload();
                    } else {
                        resp.html(
                            '<div class="alert alert-danger"><strong>Error! </strong>' +
                            res.msg + '</div>');
                        console.log("error");
                    }
                },
                error: function(e) {
                    LOADER.hide();
                    //console.log(e);
                    resp.html(
                        '<div class="alert alert-danger"><strong>Error!</strong> Please Reload Page and Try again later! </div>'
                    );
                }
            });
        }
    });
});
</script>