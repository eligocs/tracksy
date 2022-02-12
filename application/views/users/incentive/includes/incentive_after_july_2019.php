<?php
	/*
	Incentive Policy July 2019 onwards
	Docket Slab
		1. 1 to 10 	250
		2. 11 to 20 	300
		3. 21 and above 	500
	
	Turnover Slab
		1. 0 to 2,99,999 	0
		2. 3 Lakh and Above 	1% of total turnover
	*/
	$turnover_slab = 0;
	////// Docket Slab //////
	foreach( $get_booked_iti as $iti_data ){
		$incentive 	= 0;
		$incentive_second_slab = 0;
		$incentive_third_slab = 0;
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
		
		$total_pacages_cost += $package_cost; //add package costs
	}
	
	////// Docket Slab  //////
	$incentive = 0;
	if( !empty( $total_booking ) ){
		//calculate incentive
		switch( $total_booking ){
			case ( $total_booking <= 10 ):
				$incentive = $total_booking * 250; //250 per package
				break;
			case ($total_booking > 10 && $total_booking <= 20 ):
				$incentive = $total_booking * 300; //300 per package;
				break;
			case ($total_booking > 20):
				$incentive = $total_booking * 500; //500 per package;
				break;
			default:
				$incentive =  0;
			break;
		}	
	}
	//END Docket Slab//
	
	//TURN OVER SLAB//
	if( $total_pacages_cost > 300000 ){
		$turnover_slab = ( $total_pacages_cost * 1 ) / 100;
	}else{
		$remain = 300000 - $total_pacages_cost;
		$terms_html .= "<div class='alert alert-info'><strong> Target: </strong> 3,00,000/- <br><strong>Booked Packages Cost: </strong> {$total_pacages_cost}/- <br><strong>Remaining For Turnover Incentive: </strong> {$remain}/-</div>";
	}
	//END TURN OVER SLAB//
	
	$total_inc = $turnover_slab + $incentive;
	
	$return_html .= "<tr><td colspan=4><strong class='red'>Docket Slab Inc. = </strong> {$incentive} /- </td><td colspan=4><strong class='red'>Turnover Slab Inc. = </strong> {$turnover_slab} /-</td><td colspan=5><strong class='red'>Total (Docket Slab + Turnover Slab) = </strong> <span> {$total_inc}/- (Approx.) </span></td>}</tr>";