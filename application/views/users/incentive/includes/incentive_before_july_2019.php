<?php 
////// SLAB 4 //////
	//Incentive Slab 4 - Over achievement
	if( $incentive_session == "2018-2019" ){
		if( $total_booking >= 21 ){
			$incentive_fourth_slab = 10000;
		}else if( $total_booking < 21 && $total_booking >= 17 ){
			$incentive_fourth_slab = 5000;
		}else if( $total_booking < 17 && $total_booking >= 13 ){
			$incentive_fourth_slab = 3000;
		}else{
			$incentive_fourth_slab = 0;
		} 
	}else{
		//only for May 2019 Month
		if( $month == "2019-05" ){
			if( $total_booking >= 22 ){
				$incentive_fourth_slab = 10000;
			}else if( $total_booking < 22 && $total_booking >= 18 ){
				$incentive_fourth_slab = 5000;
			}else if( $total_booking < 18 && $total_booking >= 13 ){
				$incentive_fourth_slab = 3000;
			}else{
				$incentive_fourth_slab = 0;
			} 
		}else{
			if( $total_booking >= 24 ){
				$incentive_fourth_slab = 10000;
			}else if( $total_booking < 24 && $total_booking >= 20 ){
				$incentive_fourth_slab = 5000;
			}else if( $total_booking < 20 && $total_booking >= 15 ){
				$incentive_fourth_slab = 3000;
			}else{
				$incentive_fourth_slab = 0;
			} 
		}
		
	}
	////// END SLAB 4 //////	
	foreach( $get_booked_iti as $iti_data ){
		$incentive 	= 0;
		$incentive_second_slab = 0;
		$incentive_third_slab = 0;
		$incentive_fifth_slab = 0;
		$temp_key = $iti_data->temp_key;
		$pid 	= $iti_data->pid;
		$iti_url = base_url( "itineraries/view_iti/{$iti_data->iti_id}/{$temp_key}" );
		$agent_margin = !empty($iti_data->agent_margin) ? $iti_data->agent_margin : 0;
		$package_cost = $iti_data->package_cost;
		$booking_date = date("d/m/y", strtotime( $iti_data->booking_date ) );
		$travel_date = !empty($travel_date) ? date("d/m/y", strtotime( $iti_data->booking_date ) ) : "";
		$is_below_base_price = $iti_data->is_below_base_price;
		$bbp 	= $iti_data->is_below_base_price ? "BBP" : "";
		$bbptr 	= $iti_data->is_below_base_price ? "bbptr" : "";
		
		$below_price_btn = "";
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$below_price_btn = 	$is_below_base_price == 1 ? "<label class='mt-checkbox'> <input type='checkbox' title='Checked if Cost is below base price' value='1' data-id ={$pid} class='form-control is_below_base_price' checked ><span></span></label>" : "<label class='mt-checkbox'> <input title='Checked if Cost is below base price' type='checkbox' value='0' data-id ={$pid} class='form-control is_below_base_price'> <span></span></label>";	
		}
		
		//calculate base price 
		if( !empty( $agent_margin ) ){
			$reverse_margin = $agent_margin / 100;
			$reverse_margin	 = $reverse_margin + 1 ;
			$base_price = round($package_cost / $reverse_margin );
		}else{
			$base_price = $package_cost;
		}		
		
		$advance 	= $iti_data->advance_recieved;
		$second_pay_status = $iti_data->second_pay_status;
		$second_pay_date = $second_pay_status == "unpaid" ? $iti_data->second_payment_date : "";
		
		/////SLAB 5 (FD Packages) ///
		//CHECK PACKAGE TYPE Fixed Departure
		if( isset($iti_data->package_type) && strtolower($iti_data->package_type) == "fixed departure" ){
			$adults = !empty($iti_data->adults) ? (int) $iti_data->adults : 0;
			$incentive_fifth_slab = $adults*100;
		}
		//End Slab 5//
		
		
		//if session 2018-2019
		if( $incentive_session == "2018-2019" ){
			////// SLAB 3  //////
			//Incentive Slab 3 - Loss or below MU packages
			if( !empty( $is_below_base_price ) && $is_below_base_price == 1 ){
				if( $base_price >= 70000 ){
					$incentive_third_slab = 500;
				}else if( $base_price < 70000 &&  $base_price >= 10000 ){
					$incentive_third_slab = 200;
				}else{
					$incentive_third_slab = 0;
				}
				////// END SLAB 3  //////
				
			}else{
				
				////// SLAB 1  //////
				//SLAB 1 INCENTIVE
				$incentive = 200;
				//check if margin exists
				if( !empty( $agent_margin ) ){
					//calculate incentive
					switch( $agent_margin ){
						case ( $agent_margin <= 5 ):
							$incentive = 200;
							break;
						case ($agent_margin > 5 && $agent_margin <= 10 ):
							$incentive = 300;
							break;
						case ($agent_margin > 10 && $agent_margin <= 15 ):
							$incentive = 500;
							break;
						case ($agent_margin > 15 && $agent_margin <= 20 ):
							$incentive = $base_price > 10000 ? 1000 : 500;
							break;
						default:
							if( $base_price > 20000 )
								$incentive =  2000;
							else if( $base_price <= 20000 && $base_price >= 10000 )
								$incentive =  1000;
							else
								$incentive =  500;
						break;
					}	
				}
				////// END SLAB 1  //////
			}	
			
			////// SLAB 2  //////
			//Incentive Slab 2 - 1% flat payout
			if( $package_cost >= 30000 ){
				$check_fifty_per = round( $package_cost * 50 / 100 );
				//if advance recevied more or equal 50% of package cost
				if( $advance >=  $check_fifty_per ){
					$incentive_second_slab = round( $advance * 1 / 100 );
				}
			}
			////// END SLAB 2  //////
		
		}else{
			
			////// SLAB 3  //////
			//Incentive Slab 3 - Loss or below MU packages
			if( !empty( $is_below_base_price ) && $is_below_base_price == 1 ){
				if( $base_price >= 30000 ){
					$incentive_third_slab = 200;
				}else{
					$incentive_third_slab = 0;
				}
				////// END SLAB 3  //////
			}else{
				
				////// SLAB 1  //////
				//Incentive Slab 1 - MU Percentage							
				$incentive = $base_price >= 30000 ? 200 : 0;
				//check if margin exists
				if( !empty( $agent_margin ) ){
					//calculate incentive
					switch( $agent_margin ){
						case ( $agent_margin <= 4 ):
							$incentive = $base_price >= 30000 ? 200 : 0;
							break;
						case ($agent_margin >= 5 && $agent_margin <= 10 ):
							$incentive = 300;
							break;
						case ($agent_margin > 10 && $agent_margin <= 15 ):
							$incentive = $base_price > 20000 ? 500 : 300;
							break;
						case ($agent_margin > 15 && $agent_margin <= 20 ):
							$incentive = $base_price > 20000 ? 1000 : 300;
							break;
						default:
							if( $base_price > 20000 )
								$incentive =  2000;
							else if( $base_price <= 20000 && $base_price >= 10000 )
								$incentive =  1000;
							else
								$incentive =  300;
						break;
					}	
				}
				////// END SLAB 1  //////
			}	
			
			////// SLAB 2  //////
			//Incentive Slab 2 - 1% flat payout
			if( $package_cost >= 30000 ){
				$check_fifty_per = round( $package_cost * 50 / 100 );
				//if advance recevied more or equal 50% of package cost
				if( $advance >=  $check_fifty_per ){
					$incentive_second_slab = round( $advance * 1 / 100 );
				}
			}
			////// SLAB 2  //////
		}
		
		
		//generate iti link
		$iti_link = "<a target='_blank' href='{$iti_url}' title='Click to view package'>{$iti_data->customer_id}</a>";
		$return_html .= "<tr class='{$bbptr}'>";
		$return_html .= "<td>{$counter}. {$bbp} {$below_price_btn}</td>
						<td>{$iti_link}</td>
						<td>{$booking_date}</td>
						<td>{$travel_date}</td>
						<td>{$base_price}</td>
						<td>{$agent_margin}</td>
						<td>{$package_cost}</td>
						<td>{$advance}</td>
						<td>{$second_pay_date}</td>
						<td>{$incentive}</td>
						<td>{$incentive_second_slab}</td>
						<td>{$incentive_third_slab}</td>
						<td>{$incentive_fifth_slab}</td>";
		$return_html .= "</tr>";
		
		//total incentive
		$total_incentive += $incentive;
		$total_incentive += $incentive_second_slab;
		$total_incentive += $incentive_third_slab;
		$total_incentive += $incentive_fifth_slab;
		$counter++;
	}
	
	//Get Total Incentive
	$total_incentive += $incentive_fourth_slab;
	$total_inc = number_format($total_incentive);
	
	//slab4
	$slab_4_html = !empty( $incentive_fourth_slab ) ? "Slab 4 Incentive = {$incentive_fourth_slab}" : "";
	$return_html .= "<tr><td colspan=9>{$slab_4_html}</td><td colspan=4>Total (Slab1+Slab2+Slab3+slab4+slab5) = <strong> {$total_inc}/- (Approx.) </strong></td>}</tr>";
	