<?php //before july
foreach( $get_booked_iti as $iti_data ){
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
		$arrangeData['Below Base Price']	= $bbp;
		
		$dataToExports[] 					= $arrangeData;
		$counter++;
	}
	
	// set header
	$filename = "all_agents_incentive_{$ex_mon_name}.xls";
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=\"$filename\"");
	$ex = $this->_exportExcelData($dataToExports);
	$this->session->set_flashdata('success',"Data Export Successfully.");