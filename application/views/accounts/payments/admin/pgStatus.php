<?php
   $ORDER_ID = "";
   $requestParamList = array();
   $responseParamList = array();
   if ( isset($_POST["ORDER_ID"]) && $_POST["ORDER_ID"] != "" ) {
   	// In Test Page, we are taking parameters from POST request. In actual implementation these can be collected from session or DB. 
   	$ORDER_ID = $_POST["ORDER_ID"];
   	// Create an array having all required parameters for status query.
   	$requestParamList = array("MID" => PAYTM_MERCHANT_MID , "ORDERID" => $ORDER_ID); 
   	$StatusCheckSum = getChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY);
   	
   	$requestParamList['CHECKSUMHASH'] = $StatusCheckSum;
   	// Call the PG's getTxnStatusNew() function for verifying the transaction status.
   	$responseParamList = getTxnStatusNew($requestParamList);
   }
   
   ?>
<div class="page-container">
   <div class="page-content-wrapper">
      <div class="page-content">
         <div class="portlet box blue">
            <div class="portlet-title">
               <div class="caption">
                  <h2 class="check_order_status">Check Order Status</h2>
               </div>
            </div>
         </div>
         <form method="post" action="">
   			<div class="second_custom_card">
			   <table class='table margin-top-20'>
					<tbody>
						<tr>
							<td class="border_top_zero"><label> <strong>Enter ORDER_ID ::* </strong></label></td>
							<td class="border_top_zero"><input id="ORDER_ID" tabindex="1" class='form-control' maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="<?php echo $ORDER_ID ?>">
							</td>
							<td class="border_top_zero"><input value="Status Query"  class='btn btn-success' type="submit"	onclick=""></td>
						</tr>
					</tbody>
            	</table>
			   </div>
            <br/></br/>
            <div class="custom_card">
				<?php
				if (isset($responseParamList) && count($responseParamList)>0 )
				{ 
				?>
				
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							<h2 class="status_query_response">Response of status query:</h2>
						</div>
					</div>
				</div>
				<table  class='table table_payments_status table-striped' style="border: 1px solid nopadding" border="0">
				<tbody>
					<?php
						foreach($responseParamList as $paramName => $paramValue) {
						?>
					<tr >
						<td><label><?php echo $paramName?></label></td>
						<td><?php echo $paramValue?></td>
					</tr>
					<?php
						}
						?>
				</tbody>
				</table>
				<?php
				}
				?>
			</div>
         </form>
      </div>
   </div>
</div>