<?php //before july
foreach( $get_booked_iti as $iti_data ){
		$incentive_fifth_slab = 0;
		$incentive = 0;
		$incentive_second_slab = 0;
		$incentive_third_slab = 0;
		$temp_key = $iti_data->temp_key;
		$bbp 	= $iti_data->is_below_base_price ? "YES" : "";
		$agent_margin = !empty($iti_data->agent_margin) ? $iti_data->agent_margin : 0;
		$package_cost = $iti_data->package_cost;
		$booking_date = date("d/m/y", strtotime( $iti_data->booking_date ) );
		$travel_date = !empty($travel_date) ? date("d/m/y", strtotime( $iti_data->booking_date ) ) : "";
		
		//calculate base price 
		if( !empty( $agent_margin ) ){
			$reverse_margin = $agent_margin / 100;
			$reverse_margin	 = $reverse_margin + 1 ;
			$base_price = round($package_cost / $reverse_margin );
		}else{
			$base_price = $package_cost;
		}		
		
		$is_below_base_price = $iti_data->is_below_base_price;
		$advance 		= $iti_data->advance_recieved;
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
			//SLAB 3 INCENTIVE
			if( !empty( $is_below_base_price ) && $is_below_base_price == 1 ){
				if( $base_price >= 70000 ){
					$incentive_third_slab = 500;
				}else if( $base_price < 70000 &&  $base_price >= 10000 ){
					$incentive_third_slab = 200;
				}else{
					$incentive_third_slab = 0;
				}
			}else{
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
							else if( $base_price <= 20000 && $base_price >= 15000 )
								$incentive =  1000;
							else
								$incentive =  500;
						break;
					}	
				}
			}
			
			//SLAB 2 INCENTIVE
			if( $package_cost >= 30000 ){
				$check_fifty_per = round( $package_cost * 50 / 100 );
				//if advance recevied more or equal 50% of package cost
				if( $advance >=  $check_fifty_per ){
					$incentive_second_slab = round( $advance * 1 / 100 );
				}
			}
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
		
		$arrangeData['Sr. No'] 				= $counter;
		$arrangeData['Lead ID']				= trim($iti_data->customer_id);
		$arrangeData['Agent'] 				= get_user_name(trim($iti_data->agent_id));
		$arrangeData['Booking Date']		= trim($booking_date);
		$arrangeData['Travel Date']			= trim($travel_date);
		$arrangeData['Base Price']			= $base_price;
		$arrangeData['Agent Margin(%)'] 	= $agent_margin;
		$arrangeData['Package_cost'] 		= trim($package_cost);
		$arrangeData['Advance']		 		= trim($advance);
		$arrangeData['Second Ins. Date']	= trim($second_pay_date);
		$arrangeData['Slab1']				= $incentive;
		$arrangeData['Slab2']				= $incentive_second_slab;
		$arrangeData['Slab3']				= $incentive_third_slab;
		$arrangeData['Slab5']				= $incentive_fifth_slab;
		$arrangeData['Below Base Price']	= $bbp;
		
		$dataToExports[] 					= $arrangeData;
		$counter++;
		
		//total incentive
		$total_incentive += $incentive;
		$total_incentive += $incentive_second_slab;
		$total_incentive += $incentive_third_slab;
		$total_incentive += $incentive_fifth_slab;
	}
	
	//add total incentive
	$addarr = array(
		'Sr. No' 			=> "",
		'Lead ID'			=> "",
		'Agent' 			=> "",
		'Booking Date'		=> "",
		'Travel Date'		=> "",
		'Base Price'		=> "",
		'Agent Margin(%)' 	=> "",
		'Advance'		 	=> "",
		'Next Inst.' 		=> "",
		'Package_cost' 		=> "",
		'Ins. Slab1' 		=> "",					
		'Ins. Slab2'		=> "",
		'Ins. Slab3' 		=> "Total(Slab1+Slab2+Slab3+Slab5)(Approx.): ",
		'Ins. Slab5' 		=> $total_incentive,
	);
	
	$dataToExports[] = $addarr;
	
	// set header
	$filename = "all_agents_incentive_{$ex_mon_name}.xls";
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=\"$filename\"");
	$ex = $this->_exportExcelData($dataToExports);
	$this->session->set_flashdata('success',"Data Export Successfully.");