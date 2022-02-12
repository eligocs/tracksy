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
			<h2>Check Order Status</h2>
			<form method="post" action="">
				<table class='table'>
					<tbody>
						<tr>
							<td><label> <strong>Enter ORDER_ID ::* </strong></label></td>
							<td><input id="ORDER_ID" tabindex="1" class='form-control' maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="<?php echo $ORDER_ID ?>">
							</td>
							<td><input value="Status Query"  class='btn btn-success' type="submit"	onclick=""></td>
						</tr>
					</tbody>
				</table>
				<br/></br/>
				<?php
				if (isset($responseParamList) && count($responseParamList)>0 )
				{ 
				?>
				<hr>
				<h2>Response of status query:</h2>
				<table  class='table' style="border: 1px solid nopadding" border="0">
					<tbody>
						<?php
							foreach($responseParamList as $paramName => $paramValue) {
						?>
						<tr >
							<td style="border: 1px solid"><label><?php echo $paramName?></label></td>
							<td style="border: 1px solid"><?php echo $paramValue?></td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
				<?php
				}
				?>
			</form>
			</div>
			</div>
			</div>
			


