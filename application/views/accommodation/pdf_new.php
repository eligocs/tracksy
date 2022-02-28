<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>PDF</title>

    <style type="text/css" media="all">
        * {
            font-family: 'Montserrat', sans-serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            line-height: 30px;
            background-color: #fff;
            color: #000;
            font-size: 18px;
        }
        
        h1,
        p {
            margin: 0;
        }
        
        h1 {
            font-size: 22px;
        }
        
        h4 {
            font-size: 16px;
        }
        
        h3 {
            font-size: 18px;
        }
        
        p {
            font-size: 16px;
        }
        
        span {
            font-size: 14px;
        }
        
        ul li {
            font-size: 15px;
            list-style-position: inside !important;
            list-style: circle;
            margin-bottom: 10px;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 15px;
        }
        
        table tr th,
        table tr td {
            padding: 5px;
            border: 1px solid;
            text-align: left;
        }
        
        .page_container {
            max-width: 8.11in;
            width: 100%;
            margin: 0 auto;
            outline: 2px solid rgb(26, 144, 255);
            padding: 0.04in;
        }
        
        .d_flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page_header {
            padding: 6px 8px;
            line-height: 22px;
            position: absolute;
            background: #fff;
            border-bottom-right-radius: 10px;
        }
        
        .page_break {
            page-break-after: always;
        }
        

        .banner_area {
            position: relative;
        }
        
        .package_overview {
            position: absolute;
            bottom: 7px;
            color: white;
            line-height: 30px;
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }
        
        .greeings_area {
            padding: 16px;
            margin-top: 20px;
            line-height: 30px;
        }
        
        .page_heading {
            margin-bottom: 15px;
            background: #03a9f4;
            color: #fff;
            padding: 16px;
        }
        
        .day_wise_itinerary {
            margin-bottom: 22px;
        }
        
        .tour_tittle {
            margin: 10px 0;
        }
        
        .attractions {
            display: inline-block;
            background: #5e72e4;
            color: #fff;
            padding: 0 8px;
            border-radius: 5px;
            margin-top: 7px;
            font-size: 14px;
        }
        
        .terms_Con ul li {
            font-size: 12px !important;
            line-height: 16px !important;
        }
        .bank {
            font-size: 14px;
            margin-top: 15px;
        }

        span.bank_num {
            display: inline-block;
            float: left;
            height: 50px;
            margin-right: 20px;
        }
    </style>

</head>

<body>
<?php
if( !empty($itinerary )){
$iti = $itinerary[0];
$terms = get_terms_condition();
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

//Get customer info
$get_customer_info = get_customer( $iti->customer_id ); 
$cust = $get_customer_info[0];

$customer_name 		= !empty($get_customer_info) ? $cust->customer_name  : "";
$customer_contact 	= !empty($get_customer_info) ? $cust->customer_contact : "";
$customer_email		= !empty($get_customer_info) ? $cust->customer_email : "";
$image_file = site_url()  . 'site/images/' . getLogo();
?>
    <div class="page_container">
        <div class="page_content">
            <div class="banner_area">
                <div class="page_header">
                    <div>
                    <img src="<?= $image_file ?>" alt="Track Itinerary Software">
                    </div>

                </div>
                <img class="background_image" src="<?php echo base_url();?>site/assets/bg_banner.jpg" alt="Background Image" style="max-height: 7.7in; max-width: 8.10in; width: 100%;">
                <div class="package_overview" style="background:#000;">
                    <h1><?= $iti->package_name ?></h1>
                    <div class="short_info">
                        <div>
                            <p><?=  $iti->duration ?></p>
                            <p>INR <?= $iti->final_amount ?>/- Total Package Cost</p>
                            <p><?php 
                            if(!empty($iti->child)){
                              echo  $iti->adults + $iti->child;
                            }else{
                               echo $iti->adults;
                            }?> People</p>
                            
                            <p><?php if($iti->quatation_date){
                                $newDate = date("d-m-Y", strtotime($iti->quatation_date));  
                                                            echo $newDate ;
                             } ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="greeings_area">
                <h1>Hi <?= $customer_name ?></h1>
                <p>Greetings from Track Itinerary ! </p>
                <p><?= $greeting ?></p>
            </div>
            <div class="page_break"></div>
            <div class="page ">
                <div class="itinerary_section" style="padding: 16px;">
                    <h3 class="page_heading">Detaild Itinerary</h3>
                    <?php
                        $day_wise = $iti->daywise_meta; 
                        if(!empty($day_wise)){
                        $tourData = unserialize($day_wise);
                        $count_day = count( $tourData );
                        if( $count_day > 0 ){
                            
                            for ( $i = 0; $i < $count_day; $i++ ) {
                        ?>
                    <div class="day_wise_itinerary">
                        <div class="day">
                            <p> <strong>Day  <?= $tourData[$i]['tour_day'] ?></strong> <span><?= $tourData[$i]['tour_date']; ?></span></p>
                        </div>
                        <div class="tour_tittle">
                            <h4><?= $tourData[$i]['tour_name'];?>
                                <i class="fa fa-car"></i>
                                <i class="fa fa-plane"></i>
                            </h4>
                            <span><?= $tourData[$i]['meal_plan'];?> <i class="fa fa-cutlery"></i></span>
                        </div>
                        <div class="tour_details">
                            <p><?= $tourData[$i]['tour_des']; ?>
                            </p>
                        </div>
                    </div>
                    <?php
                            }
                       }	              
                       }?>
                    <div class="page_break"></div>
                </div>

            </div>

            <div class="inclusions" style="padding: 16px;">
                <h3 class="page_heading">Inclusions</h3>
                <ul>
                    <?php 
                    $inclusion = unserialize($iti->inc_meta); 
                    $count_inc = count( $inclusion );
                    if( $count_inc > 0  ){
                        for ( $i = 0; $i < $count_inc; $i++ ) {
                    ?>
                    <li><?= $inclusion[$i]["tour_inc"] ?></li>

                    <?php }
                    }
                    ?>
                    
                </ul>
            </div>
            <div class="page_break"></div>
            <div class="inclusions" style="padding: 16px;">
                <h3 class="page_heading">Exclusions</h3>
                <ul>
                <?php 
                	$exclusion = unserialize($iti->exc_meta); 
                    $count_exc = count( $exclusion );
                    if( $count_exc > 0  ){
                        for ( $i = 0; $i < $count_exc; $i++ ) {
                    ?>
                    <li><?= $exclusion[$i]["tour_exc"] ?></li>
                    <?php }
                    }
                    ?>
                </ul>
            </div>

            <div class="inclusions" style="padding: 16px;">
                <h3 class="page_heading">Spacial Inclusions</h3>
                <ul>
                <?php 
                	$sp_inc = unserialize($iti->special_inc_meta); 
                    $count_sp_inc = count( $sp_inc );
                    if( $count_sp_inc > 0  ){
                        for ( $ii = 0; $ii < $count_sp_inc; $ii++ ) {
                    ?>
                    <li><?= isset($sp_inc[$ii]['tour_special_inc']) ? $sp_inc[$ii]['tour_special_inc']: ""; ?></li>
                    <?php }
                    }
                    ?>
                </ul>
            </div>
            <div class="page_break"></div>

            <div style="padding: 16px;">
                <h3 class="page_heading">Benefits of Booking With Us</h3>
                <ul>
                    <?php 
                    		$benefits_m = unserialize($iti->booking_benefits_meta); 
                            $count_bn_inc = count( $benefits_m );
                            if( !empty( $benefits_m ) ){
                                for ( $ii = 0; $ii < $count_bn_inc; $ii++ ) {
                            ?>
                    <li><?= isset($benefits_m[$ii]['benefit_inc']) ? $benefits_m[$ii]['benefit_inc']: ""; ?></li>


                    <?php }
                            }
                    ?>
                </ul>
            </div>
        </div>

        <div style="padding: 16px;">
            <h3 class="page_heading">Hotel Details</h3>
            <?php		
        $hotel_meta = unserialize($iti->hotel_meta); 
		if( !empty( $hotel_meta ) ){
		$count_hotel = count( $hotel_meta );
        ?>
            <table>
                <thead>
                    <tr>
                        <th>Hotel Category</th>
                        <th>Standard</th>
                        <th>Deluxe</th>
                        <th>Super Deluxe</th>
                        <th>Luxury</th>
                        <!-- <th>Super Luxury</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if( $count_hotel > 0 ){
                        $hotel_st = "";
                        $hotel_d = "";
                        $hotel_sd = "";
                        $hotel_lux = "";
                        for ( $i = 0; $i < $count_hotel; $i++ ) {
                            $city_name = $hotel_meta[$i]["hotel_location"]; 
                            $hotel_standard =  isset($hotel_meta[$i]["hotel_standard"]) ? $hotel_meta[$i]["hotel_standard"] : '';
                            $hotel_deluxe =  isset($hotel_meta[$i]["hotel_deluxe"]) ? $hotel_meta[$i]["hotel_deluxe"] : '';
                            $hotel_super_deluxe =  isset($hotel_meta[$i]["hotel_super_deluxe"]) ? $hotel_meta[$i]["hotel_super_deluxe"] : '';
                            $hotel_luxury =  isset($hotel_meta[$i]["hotel_luxury"]) ? $hotel_meta[$i]["hotel_luxury"] : '';
                            ?>
                    <tr>
                        <td><?= $city_name ?></td>
                        <td><?=  $hotel_standard ?></td>
                        <td><?=  $hotel_deluxe ?></td>
                        <td><?=  $hotel_super_deluxe ?></td>
                        <td><?=  $hotel_luxury ?></td>
                    </tr>

                    <?php 
                        }
                    }
                    }
                    $rate_meta = unserialize($iti->rates_meta);
                    if( !empty( $rate_meta ) ){
                        $agent_price_percentage = !empty($iti->agent_price) ? $iti->agent_price : 0;
                        //get per person price
                        $per_person_ratemeta 	= unserialize($iti->per_person_ratemeta);
                        //$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
                        $inc_gst = "";
                        
                        $s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"]) ? " Rs." . $per_person_ratemeta["standard_rates"] +  $per_person_ratemeta["standard_rates"] * $agent_price_percentage/100 . " Per/Person" : "";
                        $d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? " Rs." . $per_person_ratemeta["deluxe_rates"] +  $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage/100 . " Per/Person" : "";
                        $sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? " Rs." . $per_person_ratemeta["super_deluxe_rates"] +  $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage/100 . " Per/Person" : "";
                        $l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? " Rs." . $per_person_ratemeta["luxury_rates"] +  $per_person_ratemeta["luxury_rates"] * $agent_price_percentage/100  . " Per/Person" : "";
        
                        //child rates
                        $child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " .  number_format( $per_person_ratemeta["child_standard_rates"]  + $per_person_ratemeta["child_standard_rates"] * $agent_price_percentage/100  ) . "/- Per Child" : "";
                        
                        $child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . number_format( $per_person_ratemeta["child_deluxe_rates"] +  $per_person_ratemeta["child_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
                        
                        $child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . number_format( $per_person_ratemeta["child_super_deluxe_rates"] +  $per_person_ratemeta["child_super_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
                        
                        $child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " .   number_format( $per_person_ratemeta["child_luxury_rates"] +  $per_person_ratemeta["child_luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";													
                        
                        $standard_rates = !empty( $rate_meta["standard_rates"]) ? number_format($rate_meta["standard_rates"] + $rate_meta["standard_rates"] * $agent_price_percentage / 100 ) . "/-" : "<strong class='red'>On Request</strong>";
                        
                        $deluxe_rates = !empty( $rate_meta["deluxe_rates"]) ? number_format($rate_meta["deluxe_rates"] + $rate_meta["deluxe_rates"] * $agent_price_percentage / 100 ) . "/-" : "<strong class='red'>On Request</strong>";
                        
                        $super_deluxe_rates = !empty( $rate_meta["super_deluxe_rates"]) ? number_format($rate_meta["super_deluxe_rates"] + $rate_meta["super_deluxe_rates"] * $agent_price_percentage / 100  ) . "/-" : "<strong class='red'>On Request</strong>";
                        $rate_luxry = !empty( $rate_meta["luxury_rates"]) ? number_format($rate_meta["luxury_rates"] + $rate_meta["luxury_rates"] * $agent_price_percentage / 100 ) . "/-" : "<strong class='red'>On Request</strong>";
                        ?>
                    <tr>
				<td style="font-size: 12px;">Price</td>
				<td><?= $standard_rates?></td>
				<td><?=$deluxe_rates?></td>
				<td><?=$super_deluxe_rates ?></td>
				<td><?=$rate_luxry ?></td>
			</tr>
                <?php
                    }
                    if( !empty( $discountPriceData ) ){
                        foreach( $discountPriceData as $price ){
                            $agent_price_percentage = !empty($price->agent_price) ? $price->agent_price : 0;
                            $sent_status = $price->sent_status;
                            if( $sent_status ){
                                //get per person price
                                $per_person_ratemeta 	= unserialize($price->per_person_ratemeta);
                                //$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
                                $inc_gst = "";
                                $s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"] ) ? "RS. " . number_format( $per_person_ratemeta["standard_rates"] +  $per_person_ratemeta["standard_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
                                $d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"] +  $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
                                $sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"] +  $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage/100) . "/- Per Person" : "";
                                $l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"] +  $per_person_ratemeta["luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
                                
                                //child rates
                                $child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_standard_rates"] +  $per_person_ratemeta["child_standard_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
                                $child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_deluxe_rates"] +  $per_person_ratemeta["child_deluxe_rates"] * $agent_price_percentage/100) . "/- Per Child" : "";
                                $child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_super_deluxe_rates"] +  $per_person_ratemeta["child_super_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
                                $child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_luxury_rates"] +  $per_person_ratemeta["child_luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";			
                                
                                //get rates
                                $s_price = !empty( $price->standard_rates) ? number_format($price->standard_rates + $price->standard_rates * $agent_price_percentage/100 ) . "/- {$inc_gst} <br> {$s_pp} <br> {$child_s_pp}" : "<strong class='red'>On Request</strong>";
                                
                                $d_price = !empty( $price->deluxe_rates) ? number_format($price->deluxe_rates + $price->deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$d_pp} <br> {$child_d_pp}" : "<strong class='red'>On Request</strong>";
                                
                                $sd_price = !empty( $price->super_deluxe_rates) ? number_format($price->super_deluxe_rates + $price->super_deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$sd_pp} <br> {$child_sd_pp}"  : "<strong class='red'>On Request</strong>";
                                
                                $l_price = !empty( $price->luxury_rates) ? number_format($price->luxury_rates + $price->luxury_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$l_pp} <br> {$child_l_pp}"  : "<strong class='red'>On Request</strong>";
                                
                                $count_price = count( $discountPriceData );
                                $strike_class = ($price !== end($discountPriceData) && $count_price > 1 ) ? "strikeLine" : "";
                    
                    ?>
                    <tr>
                        <td style="font-size: 12px;">Price</td>
                        <td class='<?= $strike_class?>'><?= $d_price?></td>
                        <td class='<?= $strike_class?>'><?= $sd_price?></td>
                        <td class='<?= $strike_class?>'><?= $s_price?></td>
                        <td class='<?= $strike_class?>'><?= $l_price?></td>
			        </tr>
            <?php
            }
            }  
            }
            ?>
                    </tbody>
            </table>
        </div>
        <div class="page_break"></div>
        <div class="hotel_notes" style="padding: 16px;">
            <h3 class="page_heading">Hotel Notes:</h3>
            <ul>
                <?php
                $hotel_note_meta = unserialize($iti->hotel_note_meta); 
                $count_hotel_meta = count( $hotel_note_meta );
                if( $count_hotel_meta > 0 ){
                    for ( $i = 0; $i < $count_hotel_meta; $i++ ) {
                ?>
                <li><?= $hotel_note_meta[$i]["hotel_note"] ?></li>
      <?php
    }
    }
    ?>
            </ul>
        </div>
        <div class="page_break"></div>

        <div class="how_to_book" style="padding: 16px">
            <h3 class="page_heading">How To Book Package</h3>
            <p><strong>For booking confirmation, Please follow the instructions mentioned below:</strong></p>
            <table>
                <?php
                	$count_book_package	= count( $book_package_terms );
                    if( $count_book_package > 0 ){
                        for ( $i = 0; $i < $count_book_package-2; $i++ ) {
                        ?>
                <tr>
                    <th><?= isset($book_package_terms[$i]["hotel_book_terms"]) ? $book_package_terms[$i]["hotel_book_terms"] : ""; ?></th>
                    <td><?= isset($book_package_terms[$i]["hotel_book_terms_right"]) ? $book_package_terms[$i]["hotel_book_terms_right"] : ""; ?></td>
                </tr>
               <?php
                        }
                    }
               ?>
            </table>
        </div>

        <div class="process_ad_pay" style="padding: 16px;">
            <h3 class="page_heading">PROCESS OF MAKING ADVANCE PAYMENT</h3>
            <ul>
                <?php
                $count_ad_pay	= count( $advance_payment_terms );
                if( $count_ad_pay > 0 ){
                    for ( $i = 0; $i < $count_ad_pay-1; $i++ ) { 
                ?>
                <li><?= $advance_payment_terms[$i]["terms"] ?></li>
                <?php
                    }
                }
                    ?>


            </ul>
        </div>
        <div class="page_break"></div>
        <div class="bank_details" style="padding: 16px;">
            <h3 class="page_heading">Bank Details: Cash/Cheque at Bank or Net Transfer</h3>
            <div class="bank">
            <?php
                	$banks = get_all_banks(); 
                    $countbanks = count($banks);
                 
                    if( $banks ){
                        foreach( $banks as $key => $bank ){ 
                            if($key == 2){


                                ?>
                           <?php }
                       
                    ?>
                <div>
                    <span class="bank_num"> <?= $key+1 . ' ' ?>.  </span>
                    <strong>Bank Name : </strong> <?= $bank->bank_name ?>
                   <strong> Account Number:</strong> <?= $bank->account_number ?><br>
                   <strong> Branch Address:</strong> <?= $bank->branch_address ?>
                   <strong> IFSC Code:</strong> <?= $bank->ifsc_code ?>
                </div>
                <?php
                }
			}
            ?>
            </div>
        </div>
        <div class="page_break"></div>
        <div class="bank_pay_terms" style="padding: 16px;">
            <h3 class="page_heading">Bank Payment Terms</h3>
            <ul>
                <?php
                $count_bank_payment_terms	= count( $online_payment_terms ); 
                $count_bankTerms			= $count_bank_payment_terms-1;
                if( $count_bankTerms > 0 ){
                    for ( $i = 0; $i < $count_bankTerms; $i++ ) { 
                     ?>
                <li><?= $online_payment_terms[$i]["terms"] ?></li>

                <?php 

                    }
                }
                ?>

            </ul>
        </div>
        <div class="page_break"></div>
        <div style="padding: 16px;">
            <h3 class="page_heading">AMENDMENT POLICY (PREPONE & POSTPONE)</h3>
            <table>
                <?php
                	$count_amendment_policy	= count( $amendment_policy );
                    if( $count_amendment_policy > 0 ){
                        for ( $i = 0; $i < $count_amendment_policy-1; $i++ ) {
                        ?>
                <tr>
                    <td><?= isset($amendment_policy[$i]["amend_policy"]) ? $amendment_policy[$i]["amend_policy"] : ""; ?> </td>
                    <td><?= isset($amendment_policy[$i]["amend_policy_right"]) ? $amendment_policy[$i]["amend_policy_right"] : ""; ?></td>
                </tr>
                <?php
                    }}
                    ?>
               
            </table>
        </div>

        <div style="padding: 16px;">
            <h3 class="page_heading">Payment Policy (After receiving Booking cost)</h3>
            <table>
                <?php
                	$count_payPolicy	= count( $payment_policy );
                    if( $count_payPolicy > 0 ){
                        for ( $i = 0; $i < $count_payPolicy-1; $i++ ) {
                        ?>
                <tr>
                    <td><?= isset($payment_policy[$i]["pay_policy"]) ? $payment_policy[$i]["pay_policy"] : ""; ?></td>
                    <td><?= isset($payment_policy[$i]["pay_policy_right"]) ? $payment_policy[$i]["pay_policy_right"] : ""; ?></td>
                </tr>
                    <?php 
                        }
                    }
                    ?>
            </table>
        </div>

        <div style="padding: 16px;">
            <h3 class="page_heading">CANCELLATION & REFUND POLICY</h3>
            <table>
                <?php
                $count_cancel_content	= count( $cancel_tour_by_client );
                if( $count_cancel_content > 0 ){
                    for ( $i = 0; $i < $count_cancel_content-1; $i++ ) {

                ?>
                <tr>
                    <td><?= isset($cancel_tour_by_client[$i]["cancel_terms"]) ? $cancel_tour_by_client[$i]["cancel_terms"] : "";?></td>
                    <td><?php isset($cancel_tour_by_client[$i]["cancel_terms_right"]) ? $cancel_tour_by_client[$i]["cancel_terms_right"] : ""; ?></td>
                </tr>
            
                <?php }
                }
                ?>
            </table>
        </div>
        <div class="page_break"></div>
        <div class="terms_Con" style="padding: 16px;">
            <h3 class="page_heading">Terms & conditions</h3>
            <ul>
                <?php
                $count_cancel_content	= count( $terms_condition );
                if( $count_cancel_content > 0 ){
                    for ( $i = 0; $i < $count_cancel_content-1; $i++ ) { 
                    ?>
                <li><?= $terms_condition[$i]["terms"] ?>
                </li>

                <?php
                    }
                }
                ?>
            </ul>
        </div>
        <div class="page_break"></div>
        <div style="padding: 16px;">
            <h3 class="page_heading">BRANCHES</h3>
            <table>
                <tr>
                    <th>Head Office</th>
                    <?php
                    $head_off = get_head_office();
                    $head_office = $head_off[0];
                    if( !empty(  $head_office ) ){ 
                    ?>
                    <td>
                   <?= $head_office->branch_name . ',' . $head_office->branch_address. ',' . $head_office->branch_contact . ',' .  $head_office->email_address  ?>
                    </td>
                </tr>
            <?php } 
            $office_branches = get_office_branches();
            if( !empty( $office_branches ) ){
                ?>
                <tr>
                    <th>Second Branch</th>
                    <?php
                        foreach( $office_branches as $branch ){
                        ?>
                    <td>
                    <?= $branch->branch_name . ',' . $branch->branch_address. ',' . $branch->branch_contact . ',' .  $branch->email_address  ?>
                    </td>
                    <?php 
                }?>
                </tr>
                <?php
            }
            ?>
            </table>
        </div>

        <div class="page_footer" style="padding: 16px;">
            <p>
                <?= isset($signature) ? $signature :''; ?>
            </p>

        </div>
    </div>
    <?php }?>
</body>

</html>