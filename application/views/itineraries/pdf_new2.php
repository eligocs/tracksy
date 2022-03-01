<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (!empty($itinerary)) {
    $iti = $itinerary[0];
    $terms = get_terms_condition();
    $online_payment_terms         = isset($terms[0]) && !empty($terms[0]->bank_payment_terms_content) ? unserialize($terms[0]->bank_payment_terms_content) : "";
    $advance_payment_terms        = isset($terms[0]) && !empty($terms[0]->advance_payment_terms) ? unserialize($terms[0]->advance_payment_terms) : "";
    $cancel_tour_by_client         = isset($terms[0]) && !empty($terms[0]->cancel_content) ? unserialize($terms[0]->cancel_content) : "";
    $terms_condition            = isset($terms[0]) && !empty($terms[0]->terms_content) ? unserialize($terms[0]->terms_content) : "";
    $disclaimer                 = isset($terms[0]) && !empty($terms[0]->disclaimer_content) ? htmlspecialchars_decode($terms[0]->disclaimer_content) : "";
    $greeting                     = isset($terms[0]) && !empty($terms[0]->greeting_message) ? $terms[0]->greeting_message : "";
    $amendment_policy            = isset($terms[0]) && !empty($terms[0]->amendment_policy) ? unserialize($terms[0]->amendment_policy) : "";
    $book_package_terms            = isset($terms[0]) && !empty($terms[0]->book_package) ? unserialize($terms[0]->book_package) : "";
    $signature                    = isset($terms[0]) && !empty($terms[0]->promotion_signature) ?  htmlspecialchars_decode($terms[0]->promotion_signature) : "";
    $payment_policy                = isset($terms[0]) && !empty($terms[0]->payment_policy) ? unserialize($terms[0]->payment_policy) : "";

    //Get customer info
    $get_customer_info = get_customer($iti->customer_id);
    $cust = $get_customer_info[0];

    $customer_name         = !empty($get_customer_info) ? $cust->customer_name  : "";;
    $customer_contact     = !empty($get_customer_info) ? $cust->customer_contact : "";
    $customer_email        = !empty($get_customer_info) ? $cust->customer_email : "";

    $pdf_name = 'itinerary_' . $iti->iti_id . '_' . str_replace(' ', '_', $customer_name);
?>
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
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url()  . 'site/images/' . favicon() ?>" />
        <title>PDF</title>

        <style type="text/css" media="all">
            * {
                font-family: 'Montserrat', sans-serif;
            }

            body {
                font-family: 'Montserrat', sans-serif;
                background-color: #fff;
                color: #000;
                outline: 2px solid #5e72e4;
            }


            .page_break {
                page-break-after: always;
            }

            .text_muted {
                color: #d8d2d2 !important;
            }
        </style>

    </head>

    <body>
        <?php
        $logoImgPath =  base_url() . 'site/assets/logo_email.png';
        $logotype = pathinfo($logoImgPath, PATHINFO_EXTENSION);
        $logodata = file_get_contents($logoImgPath);
        $logobase64 = 'data:image/' . $logotype . ';base64,' . base64_encode($logodata);


        $path = base_url() . 'site/assets/bg_banner.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        ?>
        <div style="max-width: 8.11in; width: 100%; margin: 0 auto; padding: 0.04in;">
            <div class="page_content">
                <div style="position: relative;">
                    <div style="padding: 10px 18px; position: absolute; top: -1px !important; left: -1px; width: 170px; text-align:center; background: #fff; border-bottom-right-radius: 10px;">
                        <div>
                            <img style="width: 150px" src="<?= $logobase64 ?>" />
                        </div>
                    </div>
                    <img style="max-width: 778px; width: 100%; max-height: 700px;" src="<?= $base64 ?>" alt="Background Image">
                    <div style="background:#000; position: absolute; bottom: 31%; left: 0; color: #fff; line-height: 30px; width: 100%; padding: 20px; box-sizing: border-box;">
                        <h1 style="font-size: 22px; margin: 0;"><?= $iti->package_name ?></h1>
                        <div>
                            <div>
                                <p style="font-size: 16px; margin: 0;"><?= $iti->duration ?></p>
                                <p style="font-size: 16px; margin: 0;">INR <?= $iti->final_amount ?>/- Total Package Cost</p>
                                <p style="font-size: 16px; margin: 0;">
                                    <?php
                                    if (!empty($iti->child)) {
                                        echo  $iti->adults + $iti->child;
                                    } else {
                                        echo $iti->adults;
                                    } ?> People</p>
                                <p style="font-size: 16px; margin: 0;"><?php if ($iti->quatation_date) {
                                                                            $newDate = date("d-m-Y", strtotime($iti->quatation_date));
                                                                            echo $newDate;
                                                                        } ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="padding:16px; margin-top: 10px; line-height: 27px;">
                    <h1 style="font-size: 22px; margin: 0;">Hi <?= $customer_name ?></h1>
                    <p style="font-size: 16px; margin: 0;">Greetings from Track Itinerary ! </p>
                    <p style="font-size: 16px; margin: 0;"><?= $greeting ?>
                    </p>
                </div>

                <div class="page_break"></div>

                <div>
                    <h3 class="page_heading" class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px;">
                        Detailed Itinerary</h3>
                    <?php
                    $day_wise = $iti->daywise_meta;
                    if (!empty($day_wise)) {
                        $tourData = unserialize($day_wise);
                        $count_day = count($tourData);
                        if ($count_day > 0) {

                            for ($i = 0; $i < $count_day; $i++) {
                    ?>
                                <div class="day_wise_itinerary"  style="margin-bottom: 22px; margin-top: 30px; padding: 0 16px;">
                                    <div class="day" style="margin: 0 !important;">
                                        <p style="font-size:16px; margin: 0 !important;"> <strong>Day <?= $tourData[$i]['tour_day'] ?></strong> <span style="font-size: 14px;"><?= $tourData[$i]['tour_date']; ?>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="tour_tittle" style="margin: 10px 0;">
                                        <h4 style="font-size: 16px; margin: 7px 0;"><?= $tourData[$i]['tour_name']; ?>
                                            <i class="fa fa-car"></i>
                                            <i class="fa fa-hotel"></i>
                                            <i class="fa fa-plane text_muted"></i>
                                        </h4>
                                        <span style="font-size: 14px;"> <strong>Meal Plan:</strong> <?= $tourData[$i]['meal_plan']; ?> <i class="fa fa-cutlery"></i></span>
                                    </div>
                                    <div class="tour_details">
                                        <p style="font-size: 16px; margin: 0; line-height: 30px;"><?= $tourData[$i]['tour_des']; ?>
                                        </p>
                                        <?php
                                        $hot_destination = "";
                                        if (isset($tourData[$i]['hot_des']) && !empty($tourData[$i]['hot_des'])) {
                                            $hot_dest = '';
                                            $htd = explode(",", $tourData[$i]['hot_des']);
                                        ?>
                                            <div class="margin_top_10">
                                                <p class="attractions" style="display: inline-block; background: #5e72e4; color: #fff; padding: 0 8px; border-radius: 5px; margin-top: 7px; font-size: 14px;">Attractions :</p>
                                                <?php
                                                foreach ($htd as $t) {
                                                    $hot_dest = trim($t);
                                                ?>
                                                    <span style="font-size: 14px;"><?= $hot_dest ?>,</span>
                                                <?php

                                                } ?>
                                            </div>
                                        <?php

                                        }
                                        ?>
                                        <!-- <div class="margin_top_10">
                            <p class="attractions " style="display: inline-block; background: #5e72e4; color: #fff; padding: 0 8px; border-radius: 5px; margin-top: 7px; font-size: 14px;">Activites</p>
                            <span style="font-size: 14px;">Activity one,</span>
                            <span style="font-size: 14px;">Activity two,</span>
                            <span style="font-size: 14px;">Activity three</span>
                        </div> -->
                                    </div>
                                </div>
                                <?php if($i > 2){
                                    // dump($i);die;
                                    ?>
                                <div class="page_break"></div>
                                <?php
                                }

                                ?>
                                <?php
                            }
                        }
                    } ?>
                </div>

                <div class="inclusions page">
                    <h3 class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px;">
                        Inclusions</h3>
                    <ul style="padding: 0 16px; line-height: 30px;">
                        <?php
                        $inclusion = unserialize($iti->inc_meta);
                        $count_inc = count($inclusion);
                        if ($count_inc > 0) {
                            for ($i = 0; $i < $count_inc; $i++) {
                        ?>
                                <li style="font-size: 15px; list-style-position: inside !important; list-style: disc;"><?= $inclusion[$i]["tour_inc"] ?></li>
                        <?php }
                        }
                        ?>
                    </ul>
                </div>
                <div class="page_break"></div>
                <div class="inclusions page">
                    <h3 class="page_heading" class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px;">
                        Exclusions</h3>
                    <ul style="padding: 0 16px; line-height: 30px;">
                        <?php
                        $exclusion = unserialize($iti->exc_meta);
                        $count_exc = count($exclusion);
                        if ($count_exc > 0) {
                            for ($i = 0; $i < $count_exc; $i++) {
                        ?>
                                <li style="font-size: 15px; list-style-position: inside !important; list-style: disc;"><?= $exclusion[$i]["tour_exc"] ?></li>
                        <?php }
                        }
                        ?>
                    </ul>
                </div>

                <div class="inclusions page">
                    <h3 class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px;">
                        Spacial Inclusions</h3>
                    <ul style="padding: 0 16px; line-height: 30px;">
                        <?php
                        $sp_inc = unserialize($iti->special_inc_meta);
                        $count_sp_inc = count($sp_inc);
                        if ($count_sp_inc > 0) {
                            for ($ii = 0; $ii < $count_sp_inc; $ii++) {
                        ?>
                                <li style="font-size: 15px; list-style-position: inside !important; list-style: disc;"><?= isset($sp_inc[$ii]['tour_special_inc']) ? $sp_inc[$ii]['tour_special_inc'] : ""; ?></li>
                        <?php }
                        }
                        ?>
                    </ul>
                </div>
                <div class="page_break"></div>

                <div class="page">
                    <h3 class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px;">
                        Benefits of Booking With Us</h3>
                    <p style="font-size: 16px; padding: 0 16px;"><strong>Why Book a Package Only with Track
                            Itinerary?</strong>
                    </p>
                    <ul style="padding: 0 16px; line-height: 30px;">
                        <?php
                        $benefits_m = unserialize($iti->booking_benefits_meta);
                        $count_bn_inc = count($benefits_m);
                        if (!empty($benefits_m)) {
                            for ($ii = 0; $ii < $count_bn_inc; $ii++) {
                        ?>
                                <li style="font-size: 15px; list-style-position: inside !important; list-style: disc;"><?= isset($benefits_m[$ii]['benefit_inc']) ? $benefits_m[$ii]['benefit_inc'] : ""; ?></li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <div class="page">
                <h3 class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px;">
                    Hotel Details</h3>
                <div style="padding: 0 16px;">
                    <?php
                    $hotel_meta = unserialize($iti->hotel_meta);
                    if (!empty($hotel_meta)) {
                        $count_hotel = count($hotel_meta);
                    ?>
                        <table style="border-collapse: collapse; width: 100%; font-size: 15px; box-sizing: border-box;">
                            <thead>
                                <tr>
                                    <th style="padding:5px; border: 1px solid; text-align: left;">City</th>
                                    <th style="padding:5px; border: 1px solid; text-align: left;">Standard</th>
                                    <th style="padding:5px; border: 1px solid; text-align: left;">Deluxe</th>
                                    <th style="padding:5px; border: 1px solid; text-align: left;">Super Deluxe</th>
                                    <th style="padding:5px; border: 1px solid; text-align: left;">Luxury</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($count_hotel > 0) {
                                    $hotel_st = "";
                                    $hotel_d = "";
                                    $hotel_sd = "";
                                    $hotel_lux = "";
                                    for ($i = 0; $i < $count_hotel; $i++) {
                                        $city_name = $hotel_meta[$i]["hotel_location"];
                                        $hotel_standard =  isset($hotel_meta[$i]["hotel_standard"]) ? $hotel_meta[$i]["hotel_standard"] : '';
                                        $hotel_deluxe =  isset($hotel_meta[$i]["hotel_deluxe"]) ? $hotel_meta[$i]["hotel_deluxe"] : '';
                                        $hotel_super_deluxe =  isset($hotel_meta[$i]["hotel_super_deluxe"]) ? $hotel_meta[$i]["hotel_super_deluxe"] : '';
                                        $hotel_luxury =  isset($hotel_meta[$i]["hotel_luxury"]) ? $hotel_meta[$i]["hotel_luxury"] : '';
                                ?>
                                        <tr>
                                            <td style="padding: 5px; border: 1px solid; text-align: left;"><?= $city_name ?></td>
                                            <td style="padding: 5px; border: 1px solid; text-align: left;"><?= $hotel_standard ?></td>
                                            <td style="padding: 5px; border: 1px solid; text-align: left;"><?= $hotel_deluxe ?></td>
                                            <td style="padding: 5px; border: 1px solid; text-align: left;"><?= $hotel_super_deluxe ?></td>
                                            <td style="padding: 5px; border: 1px solid; text-align: left;"><?= $hotel_luxury ?></td>
                                        </tr>
                                <?php
                                    }
                                }
                            }
                            $rate_meta = unserialize($iti->rates_meta);
                            if (!empty($rate_meta)) {
                                $agent_price_percentage = !empty($iti->agent_price) ? $iti->agent_price : 0;
                                //get per person price
                                $per_person_ratemeta     = unserialize($iti->per_person_ratemeta);
                                //$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
                                $inc_gst = "";

                                $s_pp = isset($per_person_ratemeta["standard_rates"]) && !empty($per_person_ratemeta["standard_rates"]) ? " Rs." . $per_person_ratemeta["standard_rates"] +  $per_person_ratemeta["standard_rates"] * $agent_price_percentage / 100 . " Per/Person" : "";
                                $d_pp = isset($per_person_ratemeta["deluxe_rates"]) && !empty($per_person_ratemeta["deluxe_rates"]) ? " Rs." . $per_person_ratemeta["deluxe_rates"] +  $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage / 100 . " Per/Person" : "";
                                $sd_pp = isset($per_person_ratemeta["super_deluxe_rates"]) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? " Rs." . $per_person_ratemeta["super_deluxe_rates"] +  $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage / 100 . " Per/Person" : "";
                                $l_pp = isset($per_person_ratemeta["luxury_rates"]) && !empty($per_person_ratemeta["luxury_rates"]) ? " Rs." . $per_person_ratemeta["luxury_rates"] +  $per_person_ratemeta["luxury_rates"] * $agent_price_percentage / 100  . " Per/Person" : "";

                                //child rates
                                $child_s_pp = isset($per_person_ratemeta["child_standard_rates"]) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " .  number_format($per_person_ratemeta["child_standard_rates"]  + $per_person_ratemeta["child_standard_rates"] * $agent_price_percentage / 100) . "/- Per Child" : "";

                                $child_d_pp = isset($per_person_ratemeta["child_deluxe_rates"]) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_deluxe_rates"] +  $per_person_ratemeta["child_deluxe_rates"] * $agent_price_percentage / 100) . "/- Per Child" : "";

                                $child_sd_pp = isset($per_person_ratemeta["child_super_deluxe_rates"]) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_super_deluxe_rates"] +  $per_person_ratemeta["child_super_deluxe_rates"] * $agent_price_percentage / 100) . "/- Per Child" : "";

                                $child_l_pp = isset($per_person_ratemeta["child_luxury_rates"]) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " .   number_format($per_person_ratemeta["child_luxury_rates"] +  $per_person_ratemeta["child_luxury_rates"] * $agent_price_percentage / 100) . "/- Per Child" : "";

                                $standard_rates = !empty($rate_meta["standard_rates"]) ? number_format($rate_meta["standard_rates"] + $rate_meta["standard_rates"] * $agent_price_percentage / 100) . "/-" : "<strong class='red'>On Request</strong>";

                                $deluxe_rates = !empty($rate_meta["deluxe_rates"]) ? number_format($rate_meta["deluxe_rates"] + $rate_meta["deluxe_rates"] * $agent_price_percentage / 100) . "/-" : "<strong class='red'>On Request</strong>";

                                $super_deluxe_rates = !empty($rate_meta["super_deluxe_rates"]) ? number_format($rate_meta["super_deluxe_rates"] + $rate_meta["super_deluxe_rates"] * $agent_price_percentage / 100) . "/-" : "<strong class='red'>On Request</strong>";
                                $rate_luxry = !empty($rate_meta["luxury_rates"]) ? number_format($rate_meta["luxury_rates"] + $rate_meta["luxury_rates"] * $agent_price_percentage / 100) . "/-" : "<strong class='red'>On Request</strong>";
                                ?>
                                <tr>
                                    <td style="padding: 5px; border: 1px solid; text-align: left; font-size: 12px;">Price</td>
                                    <td style="padding: 5px; border: 1px solid; text-align: left;"><?= $standard_rates ?></td>
                                    <td style="padding: 5px; border: 1px solid; text-align: left;"><?= $deluxe_rates ?></td>
                                    <td style="padding: 5px; border: 1px solid; text-align: left;"><?= $super_deluxe_rates ?></td>
                                    <td style="padding: 5px; border: 1px solid; text-align: left;"><?= $rate_luxry ?></td>
                                </tr>
                                <?php
                            }
                            if (!empty($discountPriceData)) {
                                foreach ($discountPriceData as $price) {
                                    $agent_price_percentage = !empty($price->agent_price) ? $price->agent_price : 0;
                                    $sent_status = $price->sent_status;
                                    if ($sent_status) {
                                        //get per person price
                                        $per_person_ratemeta     = unserialize($price->per_person_ratemeta);
                                        //$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
                                        $inc_gst = "";
                                        $s_pp = isset($per_person_ratemeta["standard_rates"]) && !empty($per_person_ratemeta["standard_rates"]) ? "RS. " . number_format($per_person_ratemeta["standard_rates"] +  $per_person_ratemeta["standard_rates"] * $agent_price_percentage / 100) . "/- Per Person" : "";
                                        $d_pp = isset($per_person_ratemeta["deluxe_rates"]) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"] +  $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage / 100) . "/- Per Person" : "";
                                        $sd_pp = isset($per_person_ratemeta["super_deluxe_rates"]) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"] +  $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage / 100) . "/- Per Person" : "";
                                        $l_pp = isset($per_person_ratemeta["luxury_rates"]) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"] +  $per_person_ratemeta["luxury_rates"] * $agent_price_percentage / 100) . "/- Per Person" : "";

                                        //child rates
                                        $child_s_pp = isset($per_person_ratemeta["child_standard_rates"]) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_standard_rates"] +  $per_person_ratemeta["child_standard_rates"] * $agent_price_percentage / 100) . "/- Per Child" : "";
                                        $child_d_pp = isset($per_person_ratemeta["child_deluxe_rates"]) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_deluxe_rates"] +  $per_person_ratemeta["child_deluxe_rates"] * $agent_price_percentage / 100) . "/- Per Child" : "";
                                        $child_sd_pp = isset($per_person_ratemeta["child_super_deluxe_rates"]) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_super_deluxe_rates"] +  $per_person_ratemeta["child_super_deluxe_rates"] * $agent_price_percentage / 100) . "/- Per Child" : "";
                                        $child_l_pp = isset($per_person_ratemeta["child_luxury_rates"]) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_luxury_rates"] +  $per_person_ratemeta["child_luxury_rates"] * $agent_price_percentage / 100) . "/- Per Child" : "";

                                        //get rates
                                        $s_price = !empty($price->standard_rates) ? number_format($price->standard_rates + $price->standard_rates * $agent_price_percentage / 100) . "/- {$inc_gst} <br> {$s_pp} <br> {$child_s_pp}" : "<strong class='red'>On Request</strong>";

                                        $d_price = !empty($price->deluxe_rates) ? number_format($price->deluxe_rates + $price->deluxe_rates * $agent_price_percentage / 100) . "/- {$inc_gst} <br> {$d_pp} <br> {$child_d_pp}" : "<strong class='red'>On Request</strong>";

                                        $sd_price = !empty($price->super_deluxe_rates) ? number_format($price->super_deluxe_rates + $price->super_deluxe_rates * $agent_price_percentage / 100) . "/- {$inc_gst} <br> {$sd_pp} <br> {$child_sd_pp}"  : "<strong class='red'>On Request</strong>";

                                        $l_price = !empty($price->luxury_rates) ? number_format($price->luxury_rates + $price->luxury_rates * $agent_price_percentage / 100) . "/- {$inc_gst} <br> {$l_pp} <br> {$child_l_pp}"  : "<strong class='red'>On Request</strong>";

                                        $count_price = count($discountPriceData);
                                        $strike_class = ($price !== end($discountPriceData) && $count_price > 1) ? "strikeLine" : "";

                                ?>
                                        <tr>
                                            <td style="padding: 5px; border: 1px solid; text-align: left; font-size: 12px;">Price</td>
                                            <td style="padding: 5px; border: 1px solid; text-align: left;" class='<?= $strike_class?>'><?= $s_price ?></td>
                                            <td style="padding: 5px; border: 1px solid; text-align: left;" class='<?= $strike_class?>'><?= $d_price ?></td>
                                            <td style="padding: 5px; border: 1px solid; text-align: left;" class='<?= $strike_class?>'><?= $sd_price ?></td>
                                            <td style="padding: 5px; border: 1px solid; text-align: left;" class='<?= $strike_class?>'><?= $l_price ?></td>
                                        </tr>
                            <?php
                                    }
                                }
                            }
                            ?>

                            </tbody>
                        </table>
                </div>
            </div>
            <div class="page_break"></div>

            <div class="hotel_notes page">
                <h3 class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px;">
                    Hotel Notes:</h3>
                <ul style="padding: 0 16px; line-height: 30px;">
                    <?php
                    $hotel_note_meta = unserialize($iti->hotel_note_meta);
                    $count_hotel_meta = count($hotel_note_meta);
                    if ($count_hotel_meta > 0) {
                        for ($i = 0; $i < $count_hotel_meta; $i++) {
                    ?>
                            <li style="font-size: 15px; list-style-position: inside !important; list-style: disc;"><?= $hotel_note_meta[$i]["hotel_note"] ?></li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="page_break"></div>

            <div class="how_to_book page">
                <h3 class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px;">
                    How To Book Package</h3>
                <p style="padding: 0 16px; font-size: 16px;"><strong>For booking confirmation, Please follow the instructions mentioned below:</strong></p>
                <div style="padding: 0 16px;">
                    <table style="border-collapse: collapse; width: 100%; font-size: 15px; line-height: 30px;">
                        <?php
                        $count_book_package    = count($book_package_terms);
                        if ($count_book_package > 0) {
                            for ($i = 0; $i < $count_book_package - 2; $i++) {
                        ?>
                                <tr>
                                    <th style="padding: 5px; border: 1px solid; text-align: left;"><?= isset($book_package_terms[$i]["hotel_book_terms"]) ? $book_package_terms[$i]["hotel_book_terms"] : ""; ?></th>
                                    <td style="padding: 5px; border: 1px solid; text-align: left;"><?= isset($book_package_terms[$i]["hotel_book_terms_right"]) ? $book_package_terms[$i]["hotel_book_terms_right"] : ""; ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>

            <div class="process_ad_pay page">
                <h3 class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px;">
                    PROCESS OF MAKING ADVANCE PAYMENT</h3>
                <ul style="padding: 0 16px; line-height: 30px;">
                    <?php
                    $count_ad_pay    = count($advance_payment_terms);
                    if ($count_ad_pay > 0) {
                        for ($i = 0; $i < $count_ad_pay - 1; $i++) {
                    ?>
                            <li style="font-size: 15px; list-style-position: inside !important; list-style: disc;"><?= $advance_payment_terms[$i]["terms"] ?>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>

            <div class="bank_details page">
                <h3 class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px;">
                    Bank Details: Cash/Cheque at Bank or Net Transfer</h3>
                <div style="padding: 0 16px;">
                    <div class="bank">
                        <?php
                        $banks = get_all_banks();
                        $countbanks = count($banks);

                        if ($banks) {
                            foreach ($banks as $key => $bank) {
                                if ($key == 2) {


                        ?>
                                <?php }

                                ?>
                                <div>
                                    <span class="bank_num"> <?= $key + 1 . ' ' ?>. </span>
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
                    <!-- <table style="border-collapse: collapse; width: 100%; font-size: 15px; box-sizing: border-box; line-height: 30px;">
                        <tr>
                            <th style="padding: 5px; border: 1px solid; text-align: left;">Bank Name</th>
                            <td style="padding: 5px; border: 1px solid; text-align: left;">HDFC</td>
                        </tr>
                        <tr>
                            <th style="padding: 5px; border: 1px solid; text-align: left;">Payee Name</th>
                            <td style="padding: 5px; border: 1px solid; text-align: left;">Track Itinerary PVT. LTD</td>
                        </tr>
                        <tr>
                            <th style="padding: 5px; border: 1px solid; text-align: left;">Account Type</th>
                            <td style="padding: 5px; border: 1px solid; text-align: left;">Current Account</td>
                        </tr>
                        <tr>
                            <th style="padding: 5px; border: 1px solid; text-align: left;">Account Number</th>
                            <td style="padding: 5px; border: 1px solid; text-align: left;">000045481214</td>
                        </tr>
                        <tr>
                            <th style="padding: 5px; border: 1px solid; text-align: left;">Branch Address</th>
                            <td style="padding: 5px; border: 1px solid; text-align: left;">Demo Address</td>
                        </tr>
                        <tr>
                            <th style="padding: 5px; border: 1px solid; text-align: left;">IFSC Code</th>
                            <td style="padding: 5px; border: 1px solid; text-align: left;">HDFC0014545</td>
                        </tr>
                    </table> -->
                </div>
            </div>
            <div class="page_break"></div>

            <div class="bank_pay_terms page">
                <h3 class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px;">
                    Bank Payment Terms</h3>
                <ul style="padding: 0 16px; line-height: 30px;">
                    <?php
                    $count_bank_payment_terms    = count($online_payment_terms);
                    $count_bankTerms            = $count_bank_payment_terms - 1;
                    if ($count_bankTerms > 0) {
                        for ($i = 0; $i < $count_bankTerms; $i++) {
                    ?>
                            <li style="font-size: 15px; list-style-position: inside !important; list-style: disc;"><?= $online_payment_terms[$i]["terms"] ?></li>

                    <?php

                        }
                    }
                    ?>
                </ul>
            </div>

            <div class="page_break"></div>

            <div class="page">
                <h3 class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px;">
                    AMENDMENT POLICY (PREPONE & POSTPONE)</h3>
                <div style="padding: 0 16px;">
                    <table style="border-collapse: collapse; width: 100%; font-size: 15px; box-sizing: border-box; line-height: 30px;">
                        <?php
                        $count_amendment_policy    = count($amendment_policy);
                        if ($count_amendment_policy > 0) {
                            for ($i = 0; $i < $count_amendment_policy - 1; $i++) {
                                ?>
                                <tr>
                                    <td style="padding: 5px; border: 1px solid; text-align: left;"><?= isset($amendment_policy[$i]["amend_policy"]) ? $amendment_policy[$i]["amend_policy"] : ""; ?> </td>
                                    <td style="padding: 5px; border: 1px solid; text-align: left;"><?= isset($amendment_policy[$i]["amend_policy_right"]) ? $amendment_policy[$i]["amend_policy_right"] : ""; ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>

            <div class="page">
                <h3 class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px; line-height: 30px;">
                    Payment Policy (After receiving Booking cost)</h3>
                <div style="padding: 0 16px;">
                    <table style="border-collapse: collapse; width: 100%; font-size: 15px; box-sizing: border-box;">
                        <?php
                        $count_payPolicy    = count($payment_policy);
                        if ($count_payPolicy > 0) {
                            for ($i = 0; $i < $count_payPolicy - 1; $i++) {
                                ?>
                                <tr>
                                    <td style="padding: 5px; border: 1px solid; text-align: left;"><?= isset($payment_policy[$i]["pay_policy"]) ? $payment_policy[$i]["pay_policy"] : ""; ?></td>
                                    <td style="padding: 5px; border: 1px solid; text-align: left;"><?= isset($payment_policy[$i]["pay_policy_right"]) ? $payment_policy[$i]["pay_policy_right"] : ""; ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>

            <div class="page">
                <h3 class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px;">
                    CANCELLATION & REFUND POLICY</h3>
                <div style="padding: 0 16px;">
                    <table style="border-collapse:collapse; width: 100%; font-size: 15px; box-sizing: border-box; line-height: 30px;">
                        <?php
                            $count_cancel_content	= count( $cancel_tour_by_client );
                            if( $count_cancel_content > 0 ){
                                for ( $i = 0; $i < $count_cancel_content-1; $i++ ) {      

                                    ?>
                                    <tr>
                                        <td style="padding: 5px; border: 1px solid; text-align: left;"><?= isset($cancel_tour_by_client[$i]["cancel_terms"]) ? $cancel_tour_by_client[$i]["cancel_terms"] : "";?></td>
                                        <td style="padding: 5px; border: 1px solid; text-align: left;"><?= isset($cancel_tour_by_client[$i]["cancel_terms_right"]) ? $cancel_tour_by_client[$i]["cancel_terms_right"] : "";?></td>
                                    </tr>                        
                            <?php }
                            }
                        ?>
                    </table>
                </div>
            </div>

            <div class="page_break"></div>

            <div class="terms_Con page">
                <h3 class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px;">
                    Terms & conditions</h3>
                <ul style="padding: 0 16px; line-height: 30px;">
                    <?php
                $count_cancel_content	= count( $terms_condition );
                if( $count_cancel_content > 0 ){
                    for ( $i = 0; $i < $count_cancel_content-1; $i++ ) { 
                        ?>
                        <li style="font-size: 13px !important; line-height: 18px !important; list-style-position: inside !important; list-style: disc;">
                        <?= $terms_condition[$i]["terms"] ?>
                        </li>
                <?php
                    }
                }
                ?>
                </ul>
            </div>

            <div class="page_break"></div>

            <div class="page">
                <h3 class="page_heading" style="margin-bottom: 15px; background: #f1f4f6; color: #000; padding: 16px !important; margin-top: 15px; font-size: 18px;">
                    BRANCHES</h3>
                <div style="padding: 0 16px;">
                    <table style="border-collapse: collapse; width: 100%; font-size: 15px; box-sizing: border-box; line-height: 30px;">
                        <?php
                        $head_off = get_head_office();
                        $head_office = $head_off[0];
                        if( !empty(  $head_office ) ){ 
                        ?>
                        <tr>
                            <th style="padding: 5px; border: 1px solid; text-align: left;">Head Office</th>
                            <td style="padding: 5px; border: 1px solid; text-align: left;">
                            <?= $head_office->branch_name . ',' . $head_office->branch_address. ',' . $head_office->branch_contact . ',' .  $head_office->email_address  ?>
                            </td>
                        </tr>
                        <?php } 
                        $office_branches = get_office_branches();
                        if( !empty( $office_branches ) ){
                        ?>
                        <tr>
                            <th style="padding: 5px; border: 1px solid; text-align: left;">Second Branch</th>
                            <?php
                                foreach( $office_branches as $branch ){
                                ?>
                            <td style="padding: 5px; border: 1px solid; text-align: left;">
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
            </div>
    <?php
    $agent_id = $iti->agent_id;
	$user_info = get_user_info($agent_id);
	if($user_info){
		$agent = $user_info[0];
        ?>
            <div class="signature page" style="margin-top: 260px; line-height: 15px;">
                <p style="padding: 0 16px; font-size: 16px;"><strong>Regards</strong></p>
                <p style="padding: 0 16px; font-size: 16px;"><strong><?= $agent->first_name . " " . $agent->last_name ?></strong></p>
                <p style="padding: 0 16px; font-size: 16px;"><strong>Call Us :</strong> <span><?= $agent->mobile ?></span></p>
                <p style="padding: 0 16px; font-size: 16px;"><strong>Email </strong> <span><?= $agent->email ?></span></p>
                <p style="padding: 0 16px; font-size: 16px;"><strong>Timing :</strong> <span><?= $agent->in_time ?>   to  <?= $agent->out_time ?></span></p>
                <p style="padding: 0 16px; font-size: 16px;"><strong>Website :</strong>
                    <span><?= $agent->website ?></span>
                </p>
            </div>
<?php

    }?>
            <div class="page_footer page" style="margin-top: 30px; line-height: 30px;">
                <p style="padding: 0 16px; font-size: 16px;">
                        <?= isset($signature) ? $signature :''; ?>
                </p>

            </div>
        </div>
    </body>

    </html>

<?php
}
?>