<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet"> -->
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <!--[if !mso]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <!--<![endif]-->
    <style type="text/css">
    body {
        margin: 0;
        padding: 0;
    }

    table,
    td,
    tr {
        vertical-align: top;
        border-collapse: collapse;
    }

    * {
        line-height: inherit;
    }

    a[x-apple-data-detectors=true] {
        color: inherit !important;
        text-decoration: none !important;
    }
    </style>
    <style type="text/css" id="media-query">
    @media (max-width: 620px) {

        .block-grid,
        .col {
            min-width: 320px !important;
            max-width: 100% !important;
            display: block !important;
        }

        .block-grid {
            width: 100% !important;
        }

        .col {
            width: 100% !important;
        }

        .col_cont {
            margin: 0 auto;
        }

        img.fullwidth,
        img.fullwidthOnMobile {
            width: 100% !important;
        }

        .no-stack .col {
            min-width: 0 !important;
            display: table-cell !important;
        }

        .no-stack.two-up .col {
            width: 50% !important;
        }

        .no-stack .col.num2 {
            width: 16.6% !important;
        }

        .no-stack .col.num3 {
            width: 25% !important;
        }

        .no-stack .col.num4 {
            width: 33% !important;
        }

        .no-stack .col.num5 {
            width: 41.6% !important;
        }

        .no-stack .col.num6 {
            width: 50% !important;
        }

        .no-stack .col.num7 {
            width: 58.3% !important;
        }

        .no-stack .col.num8 {
            width: 66.6% !important;
        }

        .no-stack .col.num9 {
            width: 75% !important;
        }

        .no-stack .col.num10 {
            width: 83.3% !important;
        }

        .video-block {
            max-width: none !important;
        }

        .mobile_hide {
            min-height: 0px;
            max-height: 0px;
            max-width: 0px;
            display: none;
            overflow: hidden;
            font-size: 0px;
        }

        .desktop_hide {
            display: block !important;
            max-height: none !important;
        }

        .img-container.big img {
            width: auto !important;
        }
    }

    @media (max-width: 400px) {
        .package_details td {
            display: block;
        }
    }
    </style>
</head>

<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #e1e4e9;">
    <!--[if IE]>
      <div class="ie-browser">
         <![endif]-->
    <?php 	
    // $logo_url = base_url() . "site/images/trackv2-logo.png";
    $logo_url = site_url()  . 'site/images/' . getLogo();


if( !empty($itinerary )){
	$acc = $itinerary[0];
		$acc_id = $acc->iti_id;

		$get_customer_info = get_customer( $acc->customer_id ); 
		$cust = $get_customer_info[0];
		$customer_name = $cust->customer_name;

		$total_tra = "<strong> Adults: </strong> " . $acc->adults; 
		if( !empty( $acc->child ) ){
			$total_tra .= "  <strong> No. of Child: </strong> " . $acc->child; 
			$total_tra .= " (" . $acc->child_age .")"; 
		}

	}
		
		?>
    <table class="nl-container"
        style="table-layout: fixed; vertical-align: top; min-width: 320px; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #e1e4e9; width: 100%;"
        cellpadding="0" cellspacing="0" role="presentation" width="100%" bgcolor="#e1e4e9" valign="top">
        <tbody>
            <tr style="vertical-align: top;" valign="top">
                <td style="word-break: break-word; vertical-align: top;" valign="top">
                    <!--[if (mso)|(IE)]>
                     <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                           <td align="center" style="background-color:#e1e4e9">
                              <![endif]-->
                    <div style="background-color:transparent;">
                        <div class="block-grid mixed-two-up no-stack"
                            style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #ffffff;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;">
                                <div class="col num4"
                                    style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 200px; width: 200px;">
                                    <div class="col_cont" style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div
                                            style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 20px; padding-left: 20px;">
                                            <!--<![endif]-->
                                            <div class="img-container left autowidth" align="left"
                                                style="padding-right: 0px;padding-left: 0px;">
                                                <div style="font-size:1px;line-height:10px">&nbsp;</div>
                                                <img class="left autowidth" border="0"
                                                    src="<?= !empty($logo_url) ? $logo_url : base_url() . "site/images/trackv2-logo.png" ?>"
                                                    alt="Your Logo Here Image" title="Your Logo Here Image"
                                                    style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 150px; max-width: 100%; display: block;"
                                                    width="70">
                                                <div style="font-size:1px;line-height:10px">&nbsp;</div>
                                            </div>
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                                <div class="col num8"
                                    style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 400px; width: 400px;">
                                    <div class="col_cont" style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div
                                            style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 20px; padding-left: 20px;">
                                            <div
                                                style="color:#66787f;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                                <div class="txtTinyMce-wrapper"
                                                    style="font-size: 14px; line-height: 1.2; color: #66787f; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 17px;">
                                                    <p
                                                        style="margin: 0; font-size: 12px; line-height: 1.2; word-break: break-word; text-align: right; mso-line-height-alt: 14px; margin-top: 0; margin-bottom: 0;">
                                                        <span style="font-size: 12px;"><?= $agentData->first_name . ' ' .$agentData->last_name?></span>
                                                    </p>
                                                    <p
                                                        style="margin: 0; font-size: 12px; line-height: 1.2; word-break: break-word; text-align: right; mso-line-height-alt: 14px; margin-top: 0; margin-bottom: 0;">
                                                        <span style="font-size: 12px;">Email ID. <strong><span
                                                                    style="color: #0377ea;"><?= $agentData->email ?></span>
                                                            </strong>|
                                                            Designation <strong><span style="color: #0377ea;"><?php
                                                           $userType = $agentData->user_type;
                                                            if($userType == 96){
                                                                echo "Sales Executive";
                                                            }elseif($userType == 98){
                                                                echo "Manager";

                                                            }  ?>
                                                            </span></strong></span>
                                                    </p>
                                                    <p
                                                        style="margin: 0; font-size: 12px; line-height: 1.2; word-break: break-word; text-align: right; mso-line-height-alt: 14px; margin-top: 0; margin-bottom: 0;">
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid "
                            style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #ffffff;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;">
                                <div class="col num12"
                                    style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
                                    <div class="col_cont" style="width:100% !important;">
                                        <div
                                            style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:10px; padding-bottom:10px; padding-right: 0px; padding-left: 0px;">
                                            <div
                                                style="color:#0377ea;font-family:'Merriwheater', 'Georgia', serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                                <div class="txtTinyMce-wrapper"
                                                    style="font-size: 14px; line-height: 1.2; font-family: 'Merriwheater', 'Georgia', serif; color: #0377ea; mso-line-height-alt: 17px;">
                                                    <p
                                                        style="margin: 0; font-size: 30px; line-height: 1.2; text-align: center; word-break: break-word; mso-line-height-alt: 36px; margin-top: 0; margin-bottom: 0;">
                                                        <span style="font-size: 30px;">Greetings for the
                                                            Day&nbsp;</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid three-up no-stack"
                            style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #ffffff;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;">
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid "
                            style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #ffffff;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;">
                                <div class="col num12"
                                    style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
                                    <div class="col_cont" style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div
                                            style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <div class="img-container center autowidth big" align="center"
                                                style="padding-right: 0px;padding-left: 0px;">
                                                <img class="center autowidth" align="center" border="0"
                                                    src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/4456/Airplane_fIRST_Image_.png"
                                                    alt="Flying Airplane Image " title="Flying Airplane Image "
                                                    style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 600px; max-width: 100%; display: block;"
                                                    width="600">
                                            </div>
                                            <!--[if (!mso)&(!IE)]><!-->
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid "
                            style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #ffffff;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;">
                                <div class="col num12"
                                    style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
                                    <div class="col_cont" style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div
                                            style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:20px; padding-bottom:5px; padding-right: 15px; padding-left: 15px;">
                                            <div
                                                style="color:#0685cf;font-family:'Merriwheater', 'Georgia', serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                                <div class="txtTinyMce-wrapper"
                                                    style="font-size: 14px; line-height: 1.2; font-family: 'Merriwheater', 'Georgia', serif; color: #0685cf; mso-line-height-alt: 17px;">
                                                    <p
                                                        style="margin: 0; font-size: 30px; line-height: 1.2; text-align: center; word-break: break-word; mso-line-height-alt: 36px; margin-top: 0; margin-bottom: 0;">
                                                        <span style="font-size: 22px;">Dear
                                                            [<?= $cust->customer_name ?>] greetings in holiday
                                                            terms</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div
                                                style="color:#0685cf;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                                <div class="txtTinyMce-wrapper"
                                                    style="font-size: 14px; line-height: 1.2; color: #0685cf; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 17px;">
                                                    <p
                                                        style="margin: 0; font-size: 16px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">
                                                        Here is your [<?= $acc->package_name ?>] tour detais as per your
                                                        requirements. Please find the details below :- &nbsp;
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid three-up no-stack"
                            style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #ffffff;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;">
                            </div>
                        </div>
                    </div>

                    <div style="background-color:transparent;">
                        <div class="block-grid three-up no-stack"
                            style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #ffffff;">
                            <table class="html_block package_details" width="100%" border="0" cellpadding="0"
                                cellspacing="0" role="presentation"
                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                <tr>
                                    <td style="padding-top:30px;">
                                        <div style="font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;text-align:center;"
                                            align="center">
                                            <table
                                                style="width:95%; border-collapse:collapse;border-spacing:0; margin: 0 auto;">
                                                <tr>
                                                    <td
                                                        style="padding:10px;vertical-align:top;color:rgb(0, 0, 0); border:1px solid">
                                                        <strong> Name of Package</strong>
                                                    </td>
                                                    <td
                                                        style="padding:10px;vertical-align:top;color:rgb(0, 0, 0); border:1px solid">
                                                        <?= $acc->package_name ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding:10px;vertical-align:top;color:rgb(0, 0, 0); border:1px solid">
                                                        <strong> Routing</strong>
                                                    </td>
                                                    <td
                                                        style="padding:10px;vertical-align:top;color:rgb(0, 0, 0); border:1px solid">
                                                        <?= $acc->package_routing?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding:10px;vertical-align:top;color:rgb(0, 0, 0); border:1px solid">
                                                        <strong> No. of Travelers</strong>
                                                    </td>
                                                    <td
                                                        style="padding:10px;vertical-align:top;color:rgb(0, 0, 0); border:1px solid">
                                                        <strong> <?= 
															$total_tra
														?></strong> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding:10px;vertical-align:top;color:rgb(0, 0, 0); border:1px solid">
                                                        <strong> Tour Start Date</strong>
                                                    </td>
                                                    <td
                                                        style="padding:10px;vertical-align:top;color:rgb(0, 0, 0); border:1px solid">
                                                        <?= $acc->t_start_date ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding:10px;vertical-align:top;color:rgb(0, 0, 0); border:1px solid">
                                                        <strong> Tour End Date</strong>
                                                    </td>
                                                    <td
                                                        style="padding:10px;vertical-align:top;color:rgb(0, 0, 0); border:1px solid">
                                                        <?= $acc->t_end_date ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding:10px;vertical-align:top;color:rgb(0, 0, 0); border:1px solid">
                                                        <strong>Total Nights</strong>
                                                    </td>
                                                    <td
                                                        style="padding:10px;vertical-align:top;color:rgb(0, 0, 0); border:1px solid">
                                                        <?= $acc->total_nights ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid "
                            style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #0377ea;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#0377ea;">
                                <div class="col num12"
                                    style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
                                    <div class="col_cont" style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div
                                            style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid "
                            style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #ffffff;">
                            <div
                                style="border-collapse: collapse;display: table;width: 100%;background-color:#ffffff; background-position:center top;background-repeat:no-repeat">
                                <div class="col num12"
                                    style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
                                    <div class="col_cont" style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div
                                            style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:35px; padding-bottom:10px; padding-right: 15px; padding-left: 15px;">
                                            <!--<![endif]-->
                                            <div class="button-container" align="center"
                                                style="padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                                <a href="<?= site_url("promotion/pdf/{$acc->iti_id}/{$acc->temp_key}") ?>"
                                                    target="_blank"
                                                    style="-webkit-text-size-adjust: none; text-decoration: none; display: inline-block; color: #fff; background-color: #0377ea; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; width: auto; width: auto; border-top: 1px solid #0377ea; border-right: 1px solid #0377ea; border-bottom: 1px solid #0377ea; border-left: 1px solid #0377ea; padding-top: 05px; padding-bottom: 05px; font-family: 'Merriwheater', 'Georgia', serif; text-align: center; mso-border-alt: none; word-break: keep-all;"><span
                                                        style="padding-left:34px;padding-right:34px;font-size:16px;display:inline-block;letter-spacing:undefined;"><span
                                                            style="font-size: 12px; line-height: 2; word-break: break-word; mso-line-height-alt: 24px;"><span
                                                                style="font-size: 16px; line-height: 32px;"
                                                                data-mce-style="font-size: 16px; line-height: 32px;">Click here to view Accommodation Quotation</span></span></span></a>
                                            </div>
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="background-color:transparent;">
                        <div class="block-grid "
                            style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #ffffff;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;">
                                <div class="col num12"
                                    style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
                                    <div class="col_cont" style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div
                                            style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:20px; padding-bottom:30px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <!-- <div class="img-container center autowidth big" align="center"
                              style="padding-right: 0px;padding-left: 0px;">
                              <img class="center autowidth" align="center" border="0"
                                 src="./images/road_img.jpg"
                                 alt="Flying Airplane Illustration"
                                 title="Flying Airplane Illustration"
                                 style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 600px; max-width: 100%; display: block;"
                                 width="600">
                           </div> -->
                                            <div
                                                style="color:#00255b;font-family:'Merriwheater', 'Georgia', serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                                <div class="txtTinyMce-wrapper"
                                                    style="font-size: 14px; line-height: 1.2; font-family: 'Merriwheater', 'Georgia', serif; color: #00255b; mso-line-height-alt: 17px;">
                                                    <p
                                                        style="margin: 0; font-size: 20px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 24px; margin-top: 0; margin-bottom: 0;">
                                                        <span style="font-size: 20px;">Have a Safe Journey!</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <table class="divider" border="0" cellpadding="0" cellspacing="0"
                                                width="100%"
                                                style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;"
                                                role="presentation" valign="top">
                                                <tbody>
                                                    <tr style="vertical-align: top;" valign="top">
                                                        <td class="divider_inner"
                                                            style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 0px; padding-right: 10px; padding-bottom: 0px; padding-left: 10px;"
                                                            valign="top">
                                                            <table class="divider_content" border="0" cellpadding="0"
                                                                cellspacing="0" width="30%"
                                                                style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 4px solid #0377ea; width: 30%;"
                                                                align="center" role="presentation" valign="top">
                                                                <tbody>
                                                                    <tr style="vertical-align: top;" valign="top">
                                                                        <td style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;"
                                                                            valign="top"><span></span></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div
                                                style="color:#66787f;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:30px;padding-bottom:10px;padding-left:30px;">
                                                <div class="txtTinyMce-wrapper"
                                                    style="font-size: 14px; line-height: 1.2; color: #66787f; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 17px;">
                                                    <p
                                                        style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">
                                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                                                        do
                                                        eiusmod tempor incididunt ut labore et dolore magna
                                                        aliqua.&nbsp;
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<![endif]-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;">
                        <div class="block-grid "
                            style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #fafafa;">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#fafafa;">
                                <div class="col num12"
                                    style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
                                    <div class="col_cont" style="width:100% !important;">
                                        <!--[if (!mso)&(!IE)]><!-->
                                        <div
                                            style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:30px; padding-bottom:20px; padding-right: 0px; padding-left: 0px;">
                                            <!--<![endif]-->
                                            <div class="img-container center autowidth" align="center"
                                                style="padding-right: 0px;padding-left: 0px;">
                                                <img class="center autowidth" align="center" border="0"
                                                    src="<?= !empty($logo_url) ? $logo_url : base_url() . "site/images/trackv2-logo.png" ?>" alt="Your Logo Here image"
                                                    title="Your Logo Here image"
                                                    style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 150px; max-width: 100%; display: block;"
                                                    width="70">
                                            </div>
                                            <table class="divider" border="0" cellpadding="0" cellspacing="0"
                                                width="100%"
                                                style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;"
                                                role="presentation" valign="top">
                                                <tbody>
                                                    <tr style="vertical-align: top;" valign="top">
                                                        <td class="divider_inner"
                                                            style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 20px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;"
                                                            valign="top">
                                                            <table class="divider_content" border="0" cellpadding="0"
                                                                cellspacing="0" width="90%"
                                                                style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px solid #CDCDCD; width: 90%;"
                                                                align="center" role="presentation" valign="top">
                                                                <tbody>
                                                                    <tr style="vertical-align: top;" valign="top">
                                                                        <td style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;"
                                                                            valign="top"><span></span></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div
                                                style="color:#667;font-family:'Merriwheater', 'Georgia', serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
                                                <div class="txtTinyMce-wrapper"
                                                    style="font-size: 12px; line-height: 1.2; font-family: 'Merriwheater', 'Georgia', serif; color: #667; mso-line-height-alt: 14px;">
                                                    <p
                                                        style="margin: 0; font-size: 14px; text-align: center; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">
                                                        <span style="font-size: 14px;">Show us some support</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <table class="social_icons" cellpadding="0" cellspacing="0" width="100%"
                                                role="presentation"
                                                style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                valign="top">
                                                <tbody>
                                                    <tr style="vertical-align: top;" valign="top">
                                                        <td style="word-break: break-word; vertical-align: top; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;"
                                                            valign="top">
                                                            <table class="social_table" align="center" cellpadding="0"
                                                                cellspacing="0" role="presentation"
                                                                style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-tspace: 0; mso-table-rspace: 0; mso-table-bspace: 0; mso-table-lspace: 0;"
                                                                valign="top">
                                                                <tbody>
                                                                    <tr style="vertical-align: top; display: inline-block; text-align: center;"
                                                                        align="center" valign="top">
                                                                        <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 2.5px; padding-left: 2.5px;"
                                                                            valign="top"><a
                                                                                href="https://www.facebook.com/"
                                                                                target="_blank"><img width="32"
                                                                                    height="32"
                                                                                    src="https://d2fi4ri5dhpqd1.cloudfront.net/public/resources/social-networks-icon-sets/t-only-logo-dark-gray/facebook@2x.png"
                                                                                    alt="Facebook" title="Facebook"
                                                                                    style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;"></a>
                                                                        </td>
                                                                        <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 2.5px; padding-left: 2.5px;"
                                                                            valign="top"><a href="https://twitter.com/"
                                                                                target="_blank"><img width="32"
                                                                                    height="32"
                                                                                    src="https://d2fi4ri5dhpqd1.cloudfront.net/public/resources/social-networks-icon-sets/t-only-logo-dark-gray/twitter@2x.png"
                                                                                    alt="Twitter" title="Twitter"
                                                                                    style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;"></a>
                                                                        </td>
                                                                        <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 2.5px; padding-left: 2.5px;"
                                                                            valign="top"><a
                                                                                href="https://instagram.com/"
                                                                                target="_blank"><img width="32"
                                                                                    height="32"
                                                                                    src="https://d2fi4ri5dhpqd1.cloudfront.net/public/resources/social-networks-icon-sets/t-only-logo-dark-gray/instagram@2x.png"
                                                                                    alt="Instagram" title="Instagram"
                                                                                    style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;"></a>
                                                                        </td>
                                                                        <td style="word-break: break-word; vertical-align: top; padding-bottom: 0; padding-right: 2.5px; padding-left: 2.5px;"
                                                                            valign="top"><a
                                                                                href="https://www.linkedin.com/"
                                                                                target="_blank"><img width="32"
                                                                                    height="32"
                                                                                    src="https://d2fi4ri5dhpqd1.cloudfront.net/public/resources/social-networks-icon-sets/t-only-logo-dark-gray/linkedin@2x.png"
                                                                                    alt="LinkedIn" title="LinkedIn"
                                                                                    style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; display: block;"></a>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>