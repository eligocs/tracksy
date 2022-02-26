<div class="page-container itinerary-view view_call_info">
    <div class="page-content-wrapper">
        <div class="page-content">
            <?php if( !empty($payment ) ){ 
				$pay = $payment[0]; 
				$r_amount = 0;
				$temp_key = get_iti_temp_key( $pay->iti_id ); ?>

            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-users"></i>Itinerary ID : <?php echo $pay->iti_id; ?>
                        { Package Type: <strong class=""> <?php echo check_iti_type( $pay->iti_id ); ?></strong> }
                    </div>
                    <a class="btn btn-success pull-right" href="<?php echo site_url("payments"); ?>"
                        title="Back">Back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 margin-bottom-20">
                    <div class="d_inline_block">
                        <a title='View Quotation' target="_blank"
                            href=" <?php echo site_url("itineraries/view/{$pay->iti_id}/{$temp_key}") ; ?> "
                            class='btn btn-danger'><i class='fa fa-eye' aria-hidden='true'></i> View Quotation </a>
                    </div>
                    <!--Close Lead If All Payment Received-->

                    <!--check for if refund pending-->
                    <?php $refund_exist = !empty( $pay->refund_amount ) && ($pay->refund_status == "unpaid") ? "Unpaid" : ""; ?>

                    <?php if( $refund_exist ){ ?>
                    <h4 class="text-center red"><strong>Refund Pending</strong></h4>
                    <form id="refund_payment">
                        <h3 class="text-center">REFUND PAYMENT</h3>
                        <p class="text-center"><strong><strong>Note By Agent : </strong> <span
                                    class='red'><?php echo $pay->amendment_note; ?></span></p>
                        <div class="form-group col-md-3">
                            <label for="usr">Total Refund Amount:</label>
                            <input type="text" readonly class="form-control" id="refund_amount" name="refund_amount"
                                value="<?php echo $pay->refund_amount; ?>" />
                        </div>

                        <div class="form-group col-md-3">
                            <label for="usr">Refund Due Date:</label>
                            <input type="text" readonly class="form-control"
                                value="<?php echo $pay->refund_due_date; ?>" />
                        </div>

                        <div class="form-group col-md-3">
                            <div class="form-group2">
                                <label class=" "><strong>Bank Name:</strong></label>
                                <input class="form-control" id="bank_name" type="text" placeholder="eg: HDFC, ICIC"
                                    name="bank_name" value="">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="form-group2">
                                <label class=" "><strong>Payment Type*:</strong></label>
                                <input required class="form-control" id="pay_type" type="text"
                                    placeholder="eg: Cash/cheque/online" name="pay_type" value="">
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="usr">&nbsp;</label>
                            <button type="submit" class="btn green uppercase submit_frm" id="submit_frm">Submit To
                                Refund</button>
                        </div>
                        <div class="clearfix"></div>
                        <div class="resPonse_refund"></div>

                        <input type="hidden" name="customer_id" value="<?php echo $pay->customer_id; ?>">
                        <input type="hidden" name="iti_id" value="<?php echo $pay->iti_id; ?>">
                        <input type="hidden" name="tra_id" value="<?php echo $pay->id; ?>">
                    </form>

                    <?php } ?>
                    <?php $pay_recieved = get_iti_pay_receive_percentage($pay->iti_id); ?>
                    <?php if( $pay_recieved >= 50  && $pay->iti_close_status == 0 && !$refund_exist ){ ?>
                    <div class="close_iti text-right">
                        <a href="javascript: void(0)" id="update_closeStatus"
                            data-customer_id="<?php echo $pay->customer_id; ?>"
                            data-iti_id="<?php echo $pay->iti_id; ?>" class="btn btn-success"
                            title="click to close itinerary"><i class="fa fa-close" aria-hidden="true"></i> Close
                            Itinerary</a>
                    </div>
                    <hr>
                    <?php }elseif( $pay->iti_close_status == 1 ){
						echo '<p class="text-center d_inline_block"><strong class="badge_danger_pill"><i class="fa fa-close" aria-hidden="true"></i> Lead Closed</strong></p>'; ?>

                    <div class="close_iti pull-right d_inline_block">
                        <a href="javascript: void(0)" id="update_closeStatus"
                            data-customer_id="<?php echo $pay->customer_id; ?>"
                            data-iti_id="<?php echo $pay->iti_id; ?>" class="btn btn-success "
                            title="click to close itinerary"><i class="fa fa-close" aria-hidden="true"></i> Close
                            Itinerary (already closed)</a>
                    </div>

                    <?php echo "<hr>";
					} ?>
                    <!--End Close Lead If All Payment Received-->
                </div>

                <!--Check for Installment -->
                <?php 
					//check how many installment received by Agent
					$paytransaction = !empty( $payment_transaction ) ? count($payment_transaction) : 0;
					//Add 1 to total transaction as first installment taken on the time of approved booking 
					$inst_count = 	$paytransaction + 1;
				?>
                <!--End Check for Installment -->
                <div class="col-md-12 custom_card">
                    <div class="portlet-body ">
                        <div class="customer-details">
                            <div class=" ">
                                <div class="well well-sm bg_lightpurple padding_10">
                                    <h3 class="text-white">&nbsp;Payment Details</h3>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Itinerary Id:</strong></div>
                                    <div class="col-md-6 form_vr"><?php echo $pay->iti_id; ?></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Customer Name:</strong></div>
                                    <div id='cus_name' class="col-md-6 form_vr"><?php echo $pay->customer_name; ?></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Customer Contact:</strong></div>
                                    <div class="col-md-6 form_vr"><?php echo $pay->customer_contact; ?></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Customer Email:</strong></div>
                                    <div class="col-md-6 form_vr red"><?php echo $pay->customer_email; ?></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Package Cost:</strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo number_format($pay->total_package_cost) . " /-"; ?></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Advance Received (as 1st
                                            installment):</strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo number_format($pay->advance_recieved) . " /-"; ?></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Advance Received Date (as 1st
                                            installment):</strong></div>
                                    <div class="col-md-6 form_vr"><?php echo $pay->booking_date; ?></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Next Installment Amount:</strong></div>
                                    <div class="col-md-6 form_vr"><?php echo $pay->next_payment; ?></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Next Installment Date:</strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo display_month_name( $pay->next_payment_due_date ); ?></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Balance Pending:</strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo number_format( $pay->total_balance_amount ) . " /-"; ?></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong class='red'>Travel Date</strong></div>
                                    <div class="col-md-6 form_vr"><strong
                                            class='green'><?php echo display_month_name($pay->travel_date); ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!--receipts-->
                <div class="col-md-12 custom_card margin-top-30">
                    <table class="table table-bordered d-table">
                        <thead class="thead-default">
                            <tr>
                                <p class="text-center uppercase green margin-bottom-10 margin-top-10 font_size_16">
                                    <strong>All Receipts</strong>                                    
                                    <a target='_blank' href='<?php echo site_url("/accounts/create_receipt/{$pay->customer_id}"); ?>' title='Click here to create new receopt' class='btn btn-success pull-right'>Create New Recipt</a>
                                </p>
                               <div class="d-flex align_items_center justify_content_between margin-bottom-10">
                                    <p class="text-center uppercase green margin-bottom-10 margin-top-10 font_size_16">
                                            <strong>All Receipts</strong>                                
                                        </p>
                                        <a target='_blank' href='<?php echo site_url("/accounts/create_receipt/{$pay->customer_id}"); ?>' title='Click here to create new receopt' class='btn btn-success'>Create New Recipt</a>
                               </div>
                            </tr>
                            <tr>
                                <th> # </th>
                                <th> Receipt Type </th>
                                <th> Transfer Ref.</th>
                                <th> Amount</th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
								if( !empty( $receipts ) ){
									$indx = 1;
									foreach( $receipts as $receipt ){ ?>
                            <tr>
                                <td><?php echo $indx; ?></td>
                                <td><?php echo ucfirst($receipt->receipt_type) ?></td>
                                <td><?php echo $receipt->transfer_ref ?></td>
                                <td><?php echo $receipt->amount_received ?></td>
                                <?php echo "<td><a href=" . site_url("accounts/update_receipt/{$receipt->id}") . " class='btn_pencil margin-right-10 ajax_edit_hotel_table'  target='_blank' title='Update receipt' ><i class='fa fa-pencil'></i></a>
												<a href=" . site_url("accounts/view_receipt/{$receipt->id}") . " class='btn_eye' target='_blank' title='view' ><i class='fa fa-eye'></i></a></td>"; ?>
                            <tr>
                                <?php 
										$indx++;
									} 
								}else{
									echo "<tr><td colspan=5>No receipts found.</td></tr>";
								}
								?>
                        </tbody>
                    </table>
                </div>

                <!--TRANSCTIONS-->
                <div class="clearfix">&nbsp;</div>
                <div class="col-md-12 custom_card margin-top-10">
                    <div class="table-responsive">
                        <table class="table table-bordered d-table">
                            <thead class="thead-default">
                                <tr>
                                    <p class="text-center uppercase green margin-bottom-10 margin-top-10 font_size_16">
                                        <strong>Payment Transactions</strong></p>
                                </tr>
                                <tr>
                                    <th> Sr.No</th>
                                    <th> Pay. Received</th>
                                    <th> Pay. Refund</th>
                                    <th> Date</th>
                                    <th> Bank Name</th>
                                    <th> Type</th>
                                    <th> Agent</th>
                                    <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td><?php echo number_format($pay->advance_recieved) . " /-"; ?></td>
                                    <td>0</td>
                                    <td><?php echo !empty($pay->booking_date) ? date("d M, Y",strtotime($pay->booking_date)) : ""; ?>
                                    </td>
                                    <td><?php echo $pay->bank_name; ?></td>
                                    <td></td>
                                    <td><?php echo get_user_name($pay->agent_id); ?></td>
                                    <td></td>
                                </tr>

                                <?php 
								$pay_received = 0;
								$i = 2;
								if( !empty( $payment_transaction ) ){ 
									foreach( $payment_transaction as $pay_trans ){ ?>
                                <tr data-tra_id="<?php echo $pay_trans->tra_id;?>">
                                    <td><?php echo $i++; ?>.</td>
                                    <td class="e_tra_amount"
                                        data-tra_amount="<?php echo $pay_trans->payment_received; ?>">
                                        <?php echo number_format($pay_trans->payment_received) . " /-"; ?>
                                    </td>
                                    <td>0</td>
                                    <td class="e_tra_date" data-tra_date="<?php echo $pay_trans->invoice_date; ?>">
                                        <?php echo date("d M ,Y", strtotime($pay_trans->invoice_date)); ?>
                                    </td>
                                    <td class="e_bank_name" data-bank_name="<?php echo $pay_trans->bank_name; ?>">
                                        <?php echo $pay_trans->bank_name; ?></td>
                                    <td class="e_payment_type"
                                        data-payment_type="<?php echo $pay_trans->payment_type; ?>">
                                        <?php echo $pay_trans->payment_type; ?></td>
                                    <td><?php echo get_user_name($pay_trans->agent_id); ?></td>
                                    <td>
                                        <a title="Update details" class="btn_pencil edit_trans" target="_blank"
                                            href="javascript: void(0)"><i class="fa fa-pencil"></i></a>
                                        <!--a title="Delete" data-id="<?php echo $pay_trans->tra_id; ?>"
                                            class="btn_trash del_trans" target="_blank" href="javascript: void(0)"><i
                                                class="fa fa-trash-o"></i></a-->
                                    </td>
                                </tr>
                                <?php 
									$pay_received += $pay_trans->payment_received;
									} 
								}
								//If refund exists
								$j=$i+1;
								if( !empty( $refund_transaction ) ){ 
									foreach( $refund_transaction as $ref_stat ){ 
									?>
                                <tr class='red'>
                                    <td><?php echo $j; ?>.</td>
                                    <td></td>
                                    <td><?php echo number_format($ref_stat->refund_amount) . " /-"; ?></td>
                                    <td><?php echo $ref_stat->created; ?></td>
                                    <td><?php echo $ref_stat->bank_name; ?></td>
                                    <td><?php echo get_user_name($ref_stat->agent_id); ?></td>
                                </tr>
                                <?php 
										$r_amount += $ref_stat->refund_amount;
										$j++;
									} 
								} ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="clearfix">&nbsp;</div>
                <?php 
				$advance_rec = $pay->advance_recieved;
				$total_amount_received = $advance_rec + $pay_received; 
				?>
                <!--if iti not closed -->
                <?php if( $pay->iti_close_status == 0 ){ ?>
                <div class="col-md-12 custom_card margin-top-10">
                    <div class="portlet-body">
                        <div class="customer-details">
                            <div class=" ">
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Total Package Cost:</strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo number_format($pay->total_package_cost) . " /-"; ?></strong></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Total Payment Received:</strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo number_format($total_amount_received) . " /-"; ?></div>
                                </div>

                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Advance Received: </strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo number_format($pay->advance_recieved) . " /-"; ?></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Advance Received Date:</strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo display_month_name( $pay->booking_date ); ?></div>
                                </div>

                                <?php if( !empty( $pay->second_payment_bal ) ){ ?>
                                <?php $pd = $pay->second_pay_status == "paid" ? "<strong class='green'>PAID</strong>" : "<strong class='red'>UNPAID</strong>"; ?>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Second Installment Amount:
                                            (<?php echo $pd; ?>) </strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo number_format($pay->second_payment_bal) . " /-"; ?></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Second Installment Date:</strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo display_month_name( $pay->second_payment_date ); ?></div>
                                </div>
                                <?php } ?>

                                <?php if( !empty( $pay->third_payment_bal ) ){ ?>
                                <?php $pd = $pay->third_pay_status == "paid" ? "<strong class='green'>PAID</strong>" : "<strong class='red'>UNPAID</strong>"; ?>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Third Installment Amount:
                                            (<?php echo $pd; ?>)</strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo number_format($pay->third_payment_bal) . " /-"; ?></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Third Installment Date:</strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo display_month_name ( $pay->third_payment_date ); ?></div>
                                </div>
                                <?php } ?>

                                <?php if( !empty( $pay->final_payment_bal ) ){ ?>
                                <?php $pd = $pay->final_pay_status == "paid" ? "<strong class='green'>PAID</strong>" : "<strong class='red'>UNPAID</strong>"; ?>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Final Installment Amount:
                                            (<?php echo $pd; ?>)</strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo number_format($pay->final_payment_bal) . " /-"; ?></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Final Installment Date: </strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo display_month_name( $pay->final_payment_date ); ?></div>
                                </div>
                                <?php } ?>
                                <?php if( !empty( $pay->total_discount ) ){ ?>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong class='red'>Total Discount:</strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo number_format($pay->total_discount) . " /-"; ?></div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong></strong></div>
                                    <div class="col-md-6 form_vr"></div>
                                </div>
                                <?php } ?>

                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Balance Pending:</strong></div>
                                    <div class="col-md-6 form_vr">
                                        <?php echo number_format($pay->total_balance_amount) . " /-"; ?></div>
                                </div>

                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong>Approval Note:</strong></div>
                                    <div class="col-md-6 form_vr"><?php echo $pay->approved_note; ?></div>
                                </div>

                                <?php if( $refund_transaction ){ ?>
                                <div class="col-md-6 col-lg-6">
                                    <div class="col-md-6 form_vl"><strong class='red'>Refund Amount:</strong></div>
                                    <div class="col-md-6 form_vr"><strong
                                            class='red'><?php echo number_format($r_amount) . " /-"; ?></strong></div>
                                </div>
                                <?php } ?>

                            </div> <!-- row -->
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="clearfix">&nbsp;</div>
            <!-- End Payment Details -->
            <?php 
					$nextPay = !empty( $pay->next_payment ) ? trim( $pay->next_payment ) : 0;
					$chkBalance = !empty( $pay->total_balance_amount ) ? trim( $pay->total_balance_amount ) : 0;
					
					//if( is_empty( $chkBalance ) && empty($nextPay)  ){
					if( ( is_empty( $chkBalance ) && empty($nextPay) ) || $pay->iti_close_status == 1  ){
						echo "<div class='well well-sm text-center red'><strong>No Balance Pending</strong></div>";
					}else{ 
						$nxtPayAmount = "<strong class='green'> Payment Amount To Receive: " . number_format( $nextPay ) . " /- </strong>";
						echo "<div class='well well-sm text-center'>
							{$nxtPayAmount}
							<strong class='red'> Total Pending Balance: " . number_format( $chkBalance ) . " /- </strong>
							</div>"; 
							
							$newBalPending = $pay->total_balance_amount - $nextPay; 
							$fmsg = $newBalPending == 0 ? "<strong class='red'>This is final installment you need to receive all Amount</strong>" : "";
						?>
            <!--postpone payment-->
            <!-- Pending Vouchers  -->
            <div class="custom_card">
                <div class="portlet ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-bubbles font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">PAYMENT SECTION</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content ">
                            <div class="portlet-body tabbable-line">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#pvtab_1_1" data-toggle="tab"> Receive Payment </a>
                                    </li>
                                    <li>
                                        <a href="#pvtab_1_2" data-toggle="tab"> Postpone Dates </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <!--Receive Payment TAB-->
                                    <div class="tab-pane fade active in" id="pvtab_1_1">
                                        <form id="update_payment">
                                            <h3 class="text-center margin-bottom-30">RECIEVE PAYMENT</h3>
                                            <div class="form-group col-md-3">
                                                <label for="usr">Total Package Cost:</label>
                                                <input type="text" readonly class="form-control"
                                                    value="<?php echo $pay->total_package_cost; ?>" />
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="usr">Total Amount Received:</label>
                                                <input type="text" readonly class="form-control"
                                                    value="<?php echo $total_amount_received; ?>" />
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="usr">Total Balance Pending:</label>
                                                <input type="text" readonly class="form-control" name="last_balance"
                                                    id="total_bal" value="<?php echo $pay->total_balance_amount; ?>" />
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class=""><strong>Invoice Date*:</strong></label>
                                                <input type="text" id="invoice_date" required name="invoice_date"
                                                    placeholder="Invoice Date" class="form-control invoice_date"
                                                    value="">
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="form-group col-md-4">
                                                <label class=""><strong>Inst. Amount To Receive:</strong></label>&nbsp;
                                                <strong class="red"><?php echo number_format( $nextPay ); ?> /-
                                                </strong> Ins Date : <?php echo $pay->next_payment_due_date; ?>

                                                <input type="number" required
                                                    data-ins_number="<?php echo $inst_count; ?>" readonly
                                                    id="current_payment" name="total_payment_recieve"
                                                    data-pre_amount="<?php echo $nextPay; ?>"
                                                    placeholder="Payment Received. eg: 5000" class="form-control"
                                                    value="<?php echo $nextPay; ?>">

                                            </div>
                                            <!--Show adjustment amount only if not final installment -->
                                            <?php if( $inst_count < 3 ){ ?>
                                            <div class="form-group col-md-4">
                                                <label class=""><input type="checkbox" class="extraCheck" value="Yes">
                                                    <strong>Adjustment In Amount:</strong></label>
                                            </div>
                                            <?php }  ?>

                                            <!--DISCOUNT BUTTON -->
                                            <div class="form-group col-md-4">
                                                <label class=""><input type="checkbox" class="discountCheck"
                                                        value="Yes"> <strong>Discount:</strong></label>
                                                <input type="number" readonly id="discount" name="discount"
                                                    placeholder="Discount Price" class="form-control" value="">
                                            </div>
                                            <?php switch( $inst_count ){
													//Get installment count
													case 1: ?>
                                            <?php 
														$due_ins_payment = $pay->second_payment_bal;
														$due_ins_date = $pay->second_payment_date;
														?>
                                            <div class="clearfix"></div>
                                            <div class="nextInstallments">
                                                <!--show if third payment is pending-->
                                                <div id="newBal"></div>
                                                <div class="form-group col-md-4">
                                                    <label class=""><strong>Third Installment Amount:</strong></label>
                                                    <input type="number" id="third_pay_balance" name="third_payment_bal"
                                                        placeholder="Third Installment Amount"
                                                        class="form-control pending_pay"
                                                        data-pre_amount="<?php echo $pay->third_payment_bal; ?>"
                                                        value="<?php echo $pay->third_payment_bal; ?>">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class=""><strong>Third Installment Due Date:</strong></label>
                                                    <input readonly="readonly" data-date-format="yyyy-mm-dd"
                                                        class="input-group form-control date_picker"
                                                        id="third_payment_date" type="text"
                                                        data-pre_date="<?php echo $pay->third_payment_date; ?>"
                                                        value="<?php echo $pay->third_payment_date; ?>"
                                                        name="third_payment_date" />
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="form-group col-md-4">
                                                    <label class=""><strong>Final Installment Amount:</strong></label>
                                                    <input type="number" readonly="readonly" id="final_pay_balance"
                                                        name="final_payment_bal" placeholder="Final Installment Amount"
                                                        class="form-control pending_pay"
                                                        data-pre_amount="<?php echo $pay->final_payment_bal; ?>"
                                                        value="<?php echo $pay->final_payment_bal; ?>">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class=""><strong>Final Installment Due Date:</strong></label>
                                                    <input readonly="readonly" data-date-format="yyyy-mm-dd"
                                                        class="input-group form-control date_picker"
                                                        id="final_payment_date"
                                                        data-pre_date="<?php echo $pay->final_payment_date; ?>"
                                                        type="text" value="<?php echo $pay->final_payment_date; ?>"
                                                        name="final_payment_date" />
                                                </div>
                                            </div>
                                            <?php break;
													case 2: ?>
                                            <div class="clearfix"></div>
                                            <div class="nextInstallments">
                                                <div id="newBal"></div>
                                                <div class="form-group col-md-4">
                                                    <label class=""><strong>Final Installment Amount:</strong></label>
                                                    <input type="number" readonly="readonly" id="final_pay_balance"
                                                        name="final_payment_bal" placeholder="Final Installment Amount"
                                                        class="form-control pending_pay"
                                                        data-pre_amount="<?php echo $pay->final_payment_bal; ?>"
                                                        value="<?php echo $pay->final_payment_bal; ?>">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class=""><strong>Final Installment Due Date:</strong></label>
                                                    <input readonly="readonly" data-date-format="yyyy-mm-dd"
                                                        class="input-group form-control date_picker"
                                                        id="final_payment_date"
                                                        data-pre_date="<?php echo $pay->final_payment_date; ?>"
                                                        type="text" value="<?php echo $pay->final_payment_date; ?>"
                                                        name="final_payment_date" />
                                                </div>
                                            </div>
                                            <?php break;
													default:
														// continue;
													break; ?>
                                            <?php } ?>
                                            <!--End Installment Condition-->
                                            <div class="clearfix"></div>
                                            <div class="form-group col-md-3">
                                                <div class="form-group2">
                                                    <label class=" "><strong>Bank Name:</strong></label>
                                                    <input class="form-control" id="bank_name" type="text"
                                                        placeholder="eg: HDFC, ICIC" name="bank_name" value="">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <div class="form-group2">
                                                    <label class=" "><strong>Payment Type:</strong></label>
                                                    <input required class="form-control" id="pay_type" type="text"
                                                        placeholder="eg: Cash/cheque" name="pay_type" value="">
                                                </div>
                                            </div>

                                            <?php /*
												<div class="form-group col-md-3">
													<div class="form-group2">
														<label class=" "><strong>Travel Date*:</strong></label>
														<input readonly="readonly" required data-date-format="yyyy-mm-dd" class="input-group form-control date_picker" type="text" value="<?php echo $pay->travel_date; ?>"
                                            name="travel_date" />
                                    </div>
                                </div> */ ?>

                                <div class="form-group col-md-3">
                                    <label class=""><strong>Balance Due After Payment Receive:</strong></label>
                                    <input type="number" readonly id="due_balance" name="new_due_balance"
                                        data-pre_balance="<?php echo $newBalPending; ?>" placeholder="Due Balance"
                                        class="form-control" value="<?php echo $newBalPending; ?>">
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group col-md-12">
                                    <?php echo $fmsg; ?>
                                </div>
                                <input type="hidden" name="iti_id" value="<?php echo $pay->iti_id; ?>">
                                <input type="hidden" name="customer_id" value="<?php echo $pay->customer_id; ?>">
                                <input type="hidden" name="tra_id" value="<?php echo $pay->id; ?>">
                                <input type="hidden" name="ins_number" value="<?php echo $inst_count; ?>">
                                <!--div class="margiv-top-10">
                                    <button type="submit" class="btn green uppercase submit_frm"
                                        id="submit_frm">Submit</button>
                                </div-->
                                <div class="clearfix"></div>
                                <div class="resPonse"></div>
                                </form>
                            </div>
                            <!--TAB 1 CLOSE-->
                            <!--Postpone TAB-->
                            <div class="tab-pane" id="pvtab_1_2">
                                <form id="form_postpone_dates">
                                    <!--show if third payment is pending-->
                                    <h3 class="text-center">POSTPONE DATE</h3>
                                    <?php if( !empty($pay->second_payment_bal) && ( $pay->second_pay_status == "unpaid") ) { ?>
                                    <div class="form-group col-md-4">
                                        <label class=""><strong>Second Installment Amount:</strong></label>
                                        <input type="number" readonly class="form-control"
                                            value="<?php echo $pay->second_payment_bal; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class=""><strong>Second Installment Due Date:</strong></label>
                                        <input readonly="readonly" required data-date-format="yyyy-mm-dd"
                                            class="input-group form-control postpone_date" id="second_payment_date_post"
                                            type="text" data-pre_date="<?php echo $pay->second_payment_date; ?>"
                                            value="<?php echo $pay->second_payment_date; ?>"
                                            name="second_payment_date" />
                                    </div>
                                    <div class="clearfix"></div>
                                    <?php } ?>
                                    <!--show if third payment is pending-->
                                    <?php if( !empty($pay->third_payment_bal) && ( $pay->third_pay_status == "unpaid") ){ ?>
                                    <div class="form-group col-md-4">
                                        <label class=""><strong>Third Installment Amount:</strong></label>
                                        <input type="number" readonly class="form-control"
                                            value="<?php echo $pay->third_payment_bal; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class=""><strong>Third Installment Due Date:</strong></label>
                                        <input readonly="readonly" required data-date-format="yyyy-mm-dd"
                                            class="input-group form-control postpone_date" id="third_payment_date_post"
                                            type="text" data-pre_date="<?php echo $pay->third_payment_date; ?>"
                                            value="<?php echo $pay->third_payment_date; ?>" name="third_payment_date" />
                                    </div>
                                    <div class="clearfix"></div>
                                    <?php } ?>
                                    <!--show if final payment is pending-->
                                    <?php if( !empty($pay->final_payment_bal) && ( $pay->final_pay_status == "unpaid") ){ ?>
                                    <div class="form-group col-md-4">
                                        <label class=""><strong>Final Installment Amount:</strong></label>
                                        <input type="number" readonly="readonly" class="form-control pending_pay"
                                            value="<?php echo $pay->final_payment_bal; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class=""><strong>Final Installment Due Date:</strong></label>
                                        <input readonly="readonly" data-date-format="yyyy-mm-dd" required
                                            class="input-group form-control postpone_date" id="final_payment_date_post"
                                            data-pre_date="<?php echo $pay->final_payment_date; ?>" type="text"
                                            value="<?php echo $pay->final_payment_date; ?>" name="final_payment_date" />
                                    </div>
                                    <?php } ?>

                                    <input type="hidden" name="iti_id" value="<?php echo $pay->iti_id; ?>">
                                    <input type="hidden" name="customer_id" value="<?php echo $pay->customer_id; ?>">
                                    <input type="hidden" name="tra_id" value="<?php echo $pay->id; ?>">
                                    <input type="hidden" name="ins_number" value="<?php echo $inst_count; ?>">
                                    <div class="margiv-top-10">
                                        <button type="submit" class="btn green uppercase submit_pfrm"
                                            id="submit_pfrm">Submit</button>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="ajax_resPonse"></div>
                                    <!--Update Payment Details-->
                                </form>
                            </div>
                        </div>
                        <!--TAB CONTENT-->
                        <!--amendment_note-->
                        <?php if( !empty( $pay->amendment_note ) ){ ?>
                        <div class='clearfix well well-sm text-center'><strong>Amendment Note : </strong> <span
                                class='red'><?php echo $pay->amendment_note; ?></span></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--eND IF Payment Pending-->
    <?php }	?>
</div>
<?php }else{
				redirect("payments");
			} ?>
</div>
</div>
<!-- END CONTENT BODY -->
</div>
<!-- Booking Payment Script -->
<style>
#successModal,
#closeItiModal,
#editPayModal {
    top: 20%;
}
</style>
<!-- Modal -->
<div id="successModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close editPopClose" data-dismiss="modal">Close</button>
                <h4 class="modal-title">Payment Update Successfully</h4>
            </div>
            <div class="modal-body text-center">
                <p><strong>Payment Update Successfully.</strong></p>
                <br>
                <a href="" onclick="location.reload()" class="btn green uppercase">OK</a>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>


<!-- Close ITINERARY Modal -->
<div id="closeItiModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeitibtn" data-dismiss="modal">Close</button>
                <h4 class="modal-title">Close Itinerary</h4>
            </div>
            <div class="modal-body text-center">
                <form id="frm_update_closeIti">
                    <?php 
						$min_new_cost = round($pay->total_package_cost * 25/100 );
					?>
                    <div class="frm_section">
                        <!--loader-->
                        <div class="spinner_load" style="display: none;">
                            <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
                            <span class="sr-only">Loading...</span>
                        </div>
                        <!--end loader-->
                        <div class="col-md-6">
                            <label class=" "><strong>Final Package Cost:</strong></label>
                            <input required type="number" readonly value="<?php echo $pay->total_package_cost; ?>"
                                class="form-control" id="pkup">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for=""><strong>Balance Pending:</strong></label>
                                <input required type="number" readonly value="<?php echo $pay->total_balance_amount; ?>"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pkup">Add New Final Cost Of Package:
                                    (<?php echo "<strong class='red'>Min: " . $min_new_cost . " - Max : " . $pay->total_package_cost . " </strong>"; ?>)</label>
                                <input required name="total_package_cost" type="number"
                                    min="<?php echo $min_new_cost; ?>" max="<?php echo $pay->total_package_cost; ?>"
                                    value="" class="form-control" id="newfinalcost">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for=""><strong>Customer Name*:</strong></label>
                                <input required name="customer_name" type="text"
                                    value="<?php echo $pay->customer_name; ?>" class="form-control">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <input type="hidden" name="iti_id" value="<?php echo $pay->iti_id; ?>">
                        <input type="hidden" name="package_actual_cost" value="<?php echo $pay->total_package_cost; ?>">
                        <input type="hidden" name="customer_id" value="<?php echo $pay->customer_id; ?>">
                        <input type="hidden" name="id" value="<?php echo $pay->id; ?>">
                        <button type="submit" id="reqDis_btn" class="btn btn-default">Update</button>
                        <div id="priceRes"></div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<!--EDIT PAYMENT-->
<div id="editPayModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeitibtn" data-dismiss="modal">Close</button>
                <h4 class="modal-title">Edit Payment Details</h4>
            </div>
            <div class="modal-body text-center">
                <form id="frm_edit_tra_detail">
                    <div class="col-md-6">
                        <label class=" "><strong>Trans. Amount*:</strong></label>
                        <input required type="number" value="" name="tra_amount" class="form-control" id="e_t_amount">
                    </div>

                    <div class="form-group col-md-6">
                        <label class=""><strong>Invoice Date*:</strong></label>
                        <input type="text" id="einvoice_date" required name="einvoice_date" placeholder="Invoice Date"
                            class="form-control einvoice_date" value="">
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-6">
                        <label class=" "><strong>Bank Name*:</strong></label>
                        <input required type="text" value="" name="tra_bank_name" class="form-control"
                            id="e_t_bank_name">
                    </div>

                    <div class="col-md-6">
                        <label class=" "><strong>Payment Type*:</strong></label>
                        <input required type="text" value="" name="e_t_payment_type" class="form-control"
                            placeholder="online/offline etc." id="e_t_payment_type">
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <input type="hidden" id="edit_tra_id" name="id" value="<?php echo $pay->id; ?>">
                    <button type="submit" id="reqtrad_btn" class="btn btn-default">Update</button>
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<script>
//VALIDATE AND SUBMIT POSTPONE_DATES FORM
jQuery(document).ready(function($) {
    $("#refund_payment").validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            //Total amount received
            var TOTAL_REFUND = $("#refund_amount").val();
            var CUSTOMER_NAME = $("#cus_name").html();

            if (confirm("Are you sure to refund " + TOTAL_REFUND + " to " + CUSTOMER_NAME + " ?")) {
                postpone_dates();
            }

            function postpone_dates() {
                var ajaxReq;
                var resp = $(".resPonse_refund");
                $("#refund_payment").attr("disabled", "disabled");
                var formData = $("#refund_payment").serializeArray();
                //console.log(formData);

                //Abort ajax request
                if (ajaxReq) {
                    ajaxReq.abort();
                }

                ajaxReq = $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('payments/refund_amount_by_service_team'); ?>",
                    dataType: 'json',
                    data: formData,
                    beforeSend: function() {
                        resp.html(
                            '<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>'
                        );
                    },
                    success: function(res) {
                        //$("#refund_payment")[0].reset();
                        if (res.status == true) {
                            $("#submit_pfrm").removeAttr("disabled");
                            resp.html(
                                '<div class="alert alert-success"><strong>Success! </strong>' +
                                res.msg + '</div>');
                            console.log("done");
                            location.reload();
                        } else {
                            resp.html(
                                '<div class="alert alert-danger"><strong>Error! </strong>' +
                                res.msg + '</div>');
                            $("#submit_pfrm").removeAttr("disabled");
                            console.log("error");
                            //location.reload();
                        }
                    },
                    error: function(e) {
                        resp.html(
                            '<div class="alert alert-danger"><strong>Error! </strong>Try again later.</div>'
                        );
                        console.log(e);
                    }
                });
                return false;
            }
        }
    });
});
</script>
<!--POSTPONE DATES Script -->
<script type="text/javascript">
jQuery(document).ready(function($) {
    //Date picker subtract add
    $("#invoice_date, #einvoice_date").datepicker({
        format: "yyyy-mm-dd",
    });
    //Get dates
    var s_date = $("#second_payment_date_post").val();
    var t_date = $("#third_payment_date_post").val();
    var f_date = $("#final_payment_date_post").val();
    //Second Installment
    $("#second_payment_date_post").datepicker({
        format: "yyyy-mm-dd",
        startDate: "now()",
    }).on('changeDate', function(selectedDate) {
        //console.log(selectedDate);
        var _this_val = $(this).val();
        //Get dates
        var t_date = $("#third_payment_date_post").val();
        var f_date = $("#final_payment_date_post").val();
        //check if final ins date less then this date
        if (new Date(f_date) <= new Date(_this_val)) {
            $("#final_payment_date_post").val("");
        }
        //check if Third ins date less then this date
        if (new Date(t_date) <= new Date(_this_val)) {
            $("#third_payment_date_post").val("");
        }
        var addDay = moment(selectedDate.date).add(1, 'day').toDate();
        //console.log(addDay);

        $('#third_payment_date_post').datepicker('setStartDate', addDay);
        $('#final_payment_date_post').datepicker('setStartDate', addDay);
    });
    //Third Installment	
    $("#third_payment_date_post").datepicker({
        format: "yyyy-mm-dd",
        startDate: moment(s_date).add(1, 'day').toDate(),
    }).on('changeDate', function(selectedDate) {
        //Get dates
        var s_date = $("#second_payment_date_post").val();
        var f_date = $("#final_payment_date_post").val();
        //console.log( f_date );
        var _this_val = $(this).val();
        //check if final ins date less then this date
        if (new Date(_this_val) <= new Date(s_date)) {
            $("#second_payment_date_post").val("");
        }

        //check if Third ins date less then this date
        if (new Date(f_date) <= new Date(_this_val)) {
            $("#final_payment_date_post").val("");
        }
        var addDay = moment(selectedDate.date).add(1, 'day').toDate();
        var subDay = moment(selectedDate.date).subtract(1, 'day').toDate();
        //console.log(addDay);
        $('#second_payment_date_post').datepicker('setEndDate', subDay);
        $('#final_payment_date_post').datepicker('setStartDate', addDay);
    });
    //Final Installment
    $("#final_payment_date_post").datepicker({
        format: "yyyy-mm-dd",
        startDate: moment(t_date).add(1, 'day').toDate(),
    }).on('changeDate', function(selectedDate) {
        //console.log(selectedDate);
        //Get dates
        var s_date = $("#second_payment_date_post").val();
        var t_date = $("#third_payment_date_post").val();
        var _this_val = $(this).val();
        //check if final ins date less then this date
        if (new Date(_this_val) <= new Date(s_date)) {
            $("#second_payment_date_post").val("");
        }
        //check if Third ins date less then this date
        if (new Date(_this_val) <= new Date(t_date)) {
            $("#third_payment_date_post").val("");
        }

        var addDay = moment(selectedDate.date).add(1, 'day').toDate();
        var subDay = moment(selectedDate.date).subtract(1, 'day').toDate();
        //console.log(addDay);

        $('#second_payment_date_post').datepicker('setEndDate', subDay);
        $('#third_payment_date_post').datepicker('setEndDate', subDay);
    });

    //VALIDATE AND SUBMIT POSTPONE_DATES FORM
    $("#form_postpone_dates").validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            //Total amount received
            var TOTALRECIEVED = $("#total_payment_recieve").val();

            if (confirm("Are you sure to postpone dates ?")) {
                postpone_dates();
            }

            function postpone_dates() {
                var ajaxReq;
                var resp = $(".ajax_resPonse");
                $("#submit_pfrm").attr("disabled", "disabled");
                var formData = $("#form_postpone_dates").serializeArray();
                //console.log(formData);

                //Abort ajax request
                if (ajaxReq) {
                    ajaxReq.abort();
                }

                ajaxReq = $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('payments/postpone_payment_dates'); ?>",
                    dataType: 'json',
                    data: formData,
                    beforeSend: function() {
                        resp.html(
                            '<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>'
                        );
                    },
                    success: function(res) {
                        //$("#form_postpone_dates")[0].reset();
                        if (res.status == true) {
                            $("#submit_pfrm").removeAttr("disabled");
                            resp.html(
                                '<div class="alert alert-success"><strong>Success! </strong>' +
                                res.msg + '</div>');
                            console.log("done");
                            location.reload();
                        } else {
                            resp.html(
                                '<div class="alert alert-danger"><strong>Error! </strong>' +
                                res.msg + '</div>');
                            $("#submit_pfrm").removeAttr("disabled");
                            console.log("error");
                            //location.reload();
                        }
                    },
                    error: function(e) {
                        resp.html(
                            '<div class="alert alert-danger"><strong>Error! </strong>Try again later.</div>'
                        );
                        console.log(e);
                    }
                });
                return false;
            }
        }
    });
});
</script>
<!--END POSTPONE DATES Script -->
<!-- Booking Payment Script -->
<script type="text/javascript">
jQuery(document).ready(function($) {
    //check
    var total_pending_ins = $(".pending_pay").length;
    //console.log( "Total " +  total_pending_ins);

    $(document).on("click", ".extraCheck", function() {
        var currentPay = parseFloat($("#current_payment").attr("data-pre_amount"));

        if ($(this).is(":checked")) {
            $("#current_payment").val(currentPay).removeAttr("readonly");
            $(".discountCheck").attr("checked", false);
            $("#discount").val(0).attr("readonly", "readonly");
        } else {
            $(".nextInstallments").show();
            $("#final_payment_date").removeAttr("required");
            $("#newBal").text("");
            //set pre defined amount
            $(".pending_pay").each(function() {
                var _thisAmount = parseFloat($(this).attr("data-pre_amount"));
                $(this).val(_thisAmount);
                //$(this).attr("readonly", "readonly");
            });
            //var $("#current_payment").val( $(this).attr("data-pre_amount") );
            var thirdInsDate = $("#third_payment_date").attr("data-pre_date");
            var finalInsDate = $("#final_payment_date").attr("data-pre_date");
            $("#third_payment_date").val(thirdInsDate);
            $("#final_payment_date").val(finalInsDate);

            var total_due_balace = parseFloat($("#due_balance").attr("data-pre_balance"));
            $("#current_payment").val(currentPay).attr("readonly", "readonly");
            $("#due_balance").val(total_due_balace);
        }
    });

    //discount checkbox click
    $(document).on("click", ".discountCheck", function() {
        var currentPay = parseFloat($("#current_payment").attr("data-pre_amount"));
        $("#current_payment").val(currentPay);
        var total_due_balace = parseFloat($("#due_balance").attr("data-pre_balance"));
        $("#due_balance").val(total_due_balace);
        //set pre defined amount
        $(".pending_pay").each(function() {
            var _thisAmount = parseFloat($(this).attr("data-pre_amount"));
            $(this).val(_thisAmount);
            //$(this).attr("readonly", "readonly");
        });
        //var $("#current_payment").val( $(this).attr("data-pre_amount") );
        var thirdInsDate = $("#third_payment_date").attr("data-pre_date");
        var finalInsDate = $("#final_payment_date").attr("data-pre_date");
        $("#third_payment_date").val(thirdInsDate);
        $("#final_payment_date").val(finalInsDate);
        $("#newBal").text("");

        if ($(this).is(":checked")) {
            $("#discount").removeAttr("readonly");
            $(".extraCheck").attr("checked", false);
            $("#current_payment").attr("readonly", "readonly");
        } else {
            $("#discount").val(0).attr("readonly", "readonly");
        }

    });


    //Prevent Dot from number field
    $("input[type='number']").on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode == 8) return true;
        if (this.value.length == 8) return false;

        if (keyCode != 8) {
            if (keyCode < 48 || keyCode > 57) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    });

    /* On Next payment blur */
    /* On Next payment blur */
    $(document).on("blur", "#next_pay_balance", function() {
        if ($(this).attr("readonly")) return false;

        $("#final_payment_bal, #third_payment_bal").val("");
        $("#final_payment_date").removeAttr("required");
        $(".date_picker_validation").datepicker("clearDates");
        var _this = $(this);
        var _this_val = parseFloat($(this).val());
        var total_cost = $("#fnl_amount").val();
        var advance = $("#pack_advance_recieve").val();
        var balance_pay = $("#balance_pay");
        var thrPay = $("#third_payment_bal");

        //if not valid input
        if (_this_val == '' || !$.isNumeric(_this_val) || _this_val < 0) {
            $(".resPonse").html(
                '<div class="alert alert-danger"><strong>Error! </strong>Please enter positive value</div>'
            );
            _this.val("");
            return false;
        } else {
            $(".resPonse").html('');
        }

        //Check Pending Balace 
        var pending = (total_cost - advance).toFixed(0);

        //Check Second installment
        var calcFiftyPercentage = (total_cost - (total_cost * 50 / 100)).toFixed(0);
        var second_ins = calcFiftyPercentage - advance;
        if (_this_val < second_ins) {
            $(".resPonse").html(
                '<div class="alert alert-danger"><strong>Error! </strong>Next Payment should be Greater than or equal amount = ' +
                second_ins + '</div>');
            _this.val("");
            return false;
        }

        //if advance is greater than final amount
        if (_this_val > pending) {
            $(".resPonse").html(
                '<div class="alert alert-danger"><strong>Error! </strong>Next Payment should be less than or equal Pending amount = ' +
                pending + '</div>');
            _this.val("");
            return false;
        } else {
            $(".resPonse").html('');
        }
        var removeAt = _this_val >= pending ? thrPay.attr("readonly", "readonly") : thrPay.removeAttr(
            "readonly");
        var addAttr = _this_val < pending ? $("#third_payment_bal, #third_payment_date").attr(
            "required", "required") : $("#third_payment_bal, #third_payment_date").removeAttr(
            "required");
    });


    $(document).on("blur", "#current_payment", function() {
        //Return false if having readonly
        if ($(this).attr("readonly")) return false;

        //Check for installment if second installment add pending bal to final installment
        var INS_NUMBER = $(this).attr("data-ins_number");
        var FIN_INPUT = $("#final_pay_balance").length;

        var nextB = $("#newBal");
        var _this = $(this);
        var currentPay = parseFloat($("#current_payment").val());
        var _this_val = parseFloat($(this).val());
        //check for validation
        var validate = numer_validation(_this);
        // Empty next payment installment
        $(".pending_pay").val("");

        var total_balace = $("#total_bal").val();
        //check if Next Payment is more than balance
        var total_due_balace = $("#due_balance").attr("data-pre_balance");
        var due_balance = total_balace - currentPay;
        _this_val > 1 && (due_balance <= 0) ? $(".nextInstallments").hide() : $(".nextInstallments")
            .show();

        if (_this_val > total_balace) {
            $(".resPonse").html(
                '<div class="alert alert-danger"><strong>Error! </strong>Extra Payment should be less than or equal Balance amount ' +
                total_balace + '</div>');
            $("#current_payment,#due_balance").val("");
            $("#total_payment_recieve").val(currentPay);
            $(".nextInstallments").show();
        } else {
            $("#due_balance").val(due_balance);
            $("#newBal").text("Pending Balace: " + due_balance);

            var FINALINST = INS_NUMBER == 2 ? $("#final_pay_balance").val(due_balance) : "";
            var FINALINSTR = INS_NUMBER == 2 ? $("#final_payment_date").attr("required", "required") :
                "";
            var THIRDINST = INS_NUMBER == 1 && FIN_INPUT == 0 ? $("#third_pay_balance").val(
                due_balance) : "";
        }

        //remove attr readonly if balance is zero if having third and final installment pending
        _this_val > 1 && total_pending_ins > 1 ? $("#third_pay_balance").removeAttr("readonly") : $(
            "#third_pay_balance").attr("readonly", "readonly");

        _this_val > 1 && total_pending_ins > 1 ? $("#third_pay_balance, #third_payment_date").attr(
            "required", "required") : $("#third_pay_balance,#third_payment_date").removeAttr(
            "required");

        _this_val > 1 && (due_balance > 0) ? nextB.text("Total Pending: " + due_balance) : nextB.text(
            "");

    });

    //Third Installment Blur
    /* On Third payment blur */
    $(document).on("blur", "#third_pay_balance", function() {
        //Return false if having readonly
        if ($(this).attr("readonly")) return false;

        var _this = $(this);
        //validate current field
        var validate = numer_validation(_this);

        var _this_val = parseFloat($(this).val());
        var pendingBal = parseFloat($("#due_balance").val());

        //add required if balance is pending
        var addThisRequired = pendingBal >= 1 ? $("#third_pay_balance,#third_payment_date").attr(
            "required", "required") : $("#third_pay_balance,#third_payment_date").removeAttr(
            "required");

        //Check Pending Balance 
        var pending = (pendingBal - _this_val).toFixed(0);
        //console.log( pending );
        //if advance is greater than final amount
        if (_this_val > pendingBal) {
            $(".resPonse").html(
                '<div class="alert alert-danger"><strong>Error! </strong>Next Payment should be less than Pending amount = ' +
                pendingBal + '</div>');
            _this.val("");
            $("#final_pay_balance").val("");
            return false;
        } else {
            $(".resPonse").html('');
        }

        //check for final amount 
        var finalAmount = (pendingBal - _this_val).toFixed(0);
        var fDat = $("#final_payment_date, #final_payment_date");
        $("#final_pay_balance").val(finalAmount);
        var addAtt = finalAmount >= 1 ? fDat.attr("required", "required") : fDat.removeAttr("required");

    });


    //ON Discount Blur
    $(document).on("blur", "#discount", function() {
        //Return false if having readonly
        if ($(this).attr("readonly")) return false;

        var _this = $(this);
        var dueBal = parseFloat($("#due_balance").val());
        var currentIns = parseFloat($("#current_payment").attr("data-pre_amount")),
            dueBalance = dueBal == "" ? 0 : dueBal;
        var _this_val = parseFloat($(this).val());
        //check for validation
        var validate = numer_validation(_this);
        // Empty next payment installment

        if (_this_val > currentIns && validate) {
            $(".resPonse").html(
                '<div class="alert alert-danger"><strong>Error! </strong>Discount should be less than or equal Balance amount ' +
                currentIns + '</div>');
            $("#discount").val("");
            $("#current_payment").val(currentIns);

        } else {
            var CURRENTPAY = currentIns - _this_val;
            $("#current_payment").val(CURRENTPAY);
        }

    });

    //check for valid amount 
    function numer_validation(input_field) {
        var _this_val = parseFloat(input_field.val());
        if (_this_val == '' || !$.isNumeric(_this_val) || _this_val < 0) {
            $(".resPonse").html(
                '<div class="alert alert-danger"><strong>Error! </strong>Please enter positive value</div>');
            input_field.val("");
            return false;
        } else {
            $(".resPonse").html('');
            return true;
        }
    }


    //Close Itinerary Status
    $(document).on("click", "#update_closeStatus", function(e) {
        e.preventDefault();
        //open modal
        $('#closeItiModal').modal('show');
    });

    $("#frm_update_closeIti").validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            //Total amount received
            var TOTALNEWCOST = $("#newfinalcost").val();
            if (confirm(
                    "Are you sure to proceed ? Please make sure that the amount is correct. : You are enter RS. " +
                    TOTALNEWCOST + " /-")) {
                updatecloseiti();
            }

            function updatecloseiti() {
                //validate form
                var ajaxReq;
                var resp = $("#priceRes");
                var formData = $("#frm_update_closeIti").serializeArray();
                //Get call type value
                if (ajaxReq) {
                    ajaxReq.abort();
                }
                ajaxReq = $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('payments/updateCloseStatus'); ?>",
                    dataType: 'json',
                    data: formData,
                    beforeSend: function() {
                        $(".spinner_load").show();
                        resp.html(
                            '<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>'
                        );
                    },
                    success: function(res) {
                        $(".spinner_load").hide();
                        $("#frm_update_closeIti")[0].reset();
                        if (res.status == true) {
                            resp.html(
                                '<div class="alert alert-success"><strong>Success! </strong>' +
                                res.msg + '</div>');
                            alert("Success: " + res.msg);
                            location.reload();
                        } else {
                            resp.html(
                                '<div class="alert alert-danger"><strong>Error! </strong>' +
                                res.msg + '</div>');
                            alert("Error: " + res.msg);
                            location.reload();
                        }
                    },
                    error: function(e) {
                        $(".spinner_load").hide();
                        resp.html(
                            '<div class="alert alert-danger"><strong>Error! </strong>Try again later.</div>'
                        );
                    }
                });
                return false;
            }
        }
    });
    /*
    	var _this = $(this);
    	var iti_id = _this.attr("data-iti_id");
    	var cus_id = _this.attr("data-customer_id");
    	console.log(iti_id);
    	if (confirm("Are you sure?")) {
    		$.ajax({
    			type: "POST",
    			url: "<?php echo base_url('payments/updateCloseStatus'); ?>" ,
    			dataType: 'json',
    			data: {iti_id: iti_id, cus_id: cus_id},
    			beforeSend: function(){
    				//resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
    			},
    			success: function(res) {
    				if (res.status == true){
    					console.log("done");
    					location.reload(); 
    				}else{
    					alert("Error! Please try again later.");
    					console.log("error");
    				}
    			},
    			error: function(e){
    				console.log(e);
    			}
    		});
    	}	*/


    /***********UPDATE PAYMENT Details DATEPICKER***********/
    //datepicker
    $(".date_picker").datepicker({
        startDate: "now"
    });
    $(".transaction_date").datepicker({
        startDate: "-10d"
    });

    //set final date
    var CheckIn = $("#third_payment_date").datepicker('getDate');
    var nextDayMin = moment(CheckIn).add(1, 'day').toDate();
    $('#final_payment_date').datepicker('setStartDate', nextDayMin);
    /*
	$('#third_payment_date').datepicker({
        format: "yyyy-mm-dd",
    }).on('changeDate', function(ev){
		$('#final_payment_date').val("");
		var _thisDate = ev.date;
		var nextDayMin = moment(_thisDate).add(1, 'day').toDate();
		$('#final_payment_date').datepicker('setStartDate', nextDayMin);
	}); */

    //Third Installment	
    $("#third_payment_date").datepicker({
        format: "yyyy-mm-dd",
    }).on('changeDate', function(selectedDate) {
        //Get dates
        var f_date = $("#final_payment_date").val();
        //console.log( f_date );
        var _this_val = $(this).val();
        //check if final ins date less then this date
        if (new Date(f_date) <= new Date(_this_val)) {
            $("#final_payment_date").val("");
        }

        var addDay = moment(selectedDate.date).add(1, 'day').toDate();
        //console.log(addDay);
        $('#final_payment_date').datepicker('setStartDate', addDay);
    });
    //Final Installment
    var tdate = $("#third_payment_date").val();
    $("#final_payment_date").datepicker({
        format: "yyyy-mm-dd",
        startDate: moment(tdate).add(1, 'day').toDate(),
    }).on('changeDate', function(selectedDate) {
        //console.log(selectedDate);
        //Get dates
        var tdate = $("#third_payment_date").val();
        var _this_val = $(this).val();
        //check if final ins date less then this date
        if (new Date(_this_val) <= new Date(tdate)) {
            $("#third_payment_date").val("");
        }
        var subDay = moment(selectedDate.date).subtract(1, 'day').toDate();
        //console.log(addDay);
        $('#third_payment_date').datepicker('setEndDate', subDay);
    });

    /***********end UPDATE PAYMENT Details DATEPICKER***********/
    /* On Advance Received blur */
    /* $(document).on("blur", "#payment_recieve", function(){
    	$("#next_pay_balance").val("");
    	var amount_received = parseFloat($(this).val());
    	
    	if( amount_received < 0 || $.isNumeric( $(this).val() ) == false ){
    		$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Please enter positive Amount value</div>');
    		$(this).val("");
    		return false;
    	}else{
    		$(".resPonse").html("");
    	}	
    	
    	//check if payment received is more than balance
    	var total_balace = $("#total_bal").val();
    	if( amount_received > total_balace ){
    		$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Payment should be less than Balance amount</div>');
    		$("#payment_recieve").val("");
    		$("#due_balance").val("");
    	}else{
    		//calculate Total Balace
    		var due_balance = total_balace - amount_received;
    		$("#due_balance").val(due_balance);
    	}
    	
    	
    	//remove required attribute if Balance is null
    	if( $("#due_balance").val() < 1 ){
    		$("#next_payment_date").removeAttr("required");
    		$("#next_payment_date").removeClass("date_picker");
    		$("#next_payment_date").val("");
    		$("#next_pay_balance").val("");
    		$("#next_pay_balance").attr("disabled", "disabled");
    	}else{
    		$("#next_payment_date").attr("required", "required");
    		$("#next_payment_date").addClass("date_picker");
    		$("#next_pay_balance").removeAttr("disabled");
    	}
    }); */


});
</script>

<!-- End Booking Payment Script -->
<script type="text/javascript">
jQuery(document).ready(function($) {
    $("#update_payment").validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            //Total amount received
            var TOTALRECIEVED = $("#current_payment").val();

            if (confirm("Please make sure you are receving : RS. " + TOTALRECIEVED + " /-")) {
                saveData();
            }

            function saveData() {
                //validate form
                var ajaxReq;
                var resp = $(".resPonse");

                $("#submit_frm").attr("disabled", "disabled");
                var formData = $("#update_payment").serializeArray();
                //console.log(formData);

                //Get call type value
                if (ajaxReq) {
                    ajaxReq.abort();
                }

                ajaxReq = $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('payments/updatePaymentDetails'); ?>",
                    dataType: 'json',
                    data: formData,
                    beforeSend: function() {
                        resp.html(
                            '<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>'
                        );
                    },
                    success: function(res) {
                        $("#update_payment")[0].reset();
                        if (res.status == true) {
                            resp.html(
                                '<div class="alert alert-success"><strong>Success! </strong>' +
                                res.msg + '</div>');
                            console.log("done");
                            $("#successModal").show();
                            //location.reload(); 
                        } else if (res.status == "invalid") {
                            resp.html(
                                '<div class="alert alert-danger"><strong>Error! </strong>' +
                                res.msg + '</div>');
                            $("#submit_frm").removeAttr("disabled");
                            console.log("error");
                            //alert( "Error: " + res.msg );
                            //location.reload();
                        } else {
                            resp.html(
                                '<div class="alert alert-danger"><strong>Error! </strong>' +
                                res.msg + '</div>');
                            //$("#submit_frm").removeAttr("disabled");
                            console.log("error");
                            alert("Error: " + res.msg);
                            //location.reload();
                        }
                    },
                    error: function(e) {
                        resp.html(
                            '<div class="alert alert-danger"><strong>Error! </strong>Try again later.</div>'
                        );
                        console.log(e);
                    }
                });
                return false;
            }
        }
    });
});
</script>

<!--Transactions EDIT Delete SECTION-->
<script>
jQuery(document).ready(function($) {

    //EDIT Transactions Details
    $(document).on("click", ".edit_trans", function(e) {
        e.preventDefault();
        var _this = $(this);
        var id = _this.closest("tr").attr("data-tra_id");
        var amount = _this.closest("tr").find(".e_tra_amount").attr('data-tra_amount');
        var date = _this.closest("tr").find(".e_tra_date").attr("data-tra_date");
        var bank_name = _this.closest("tr").find(".e_bank_name").attr("data-bank_name");
        var payment_type = _this.closest("tr").find(".e_payment_type").attr("data-payment_type");

        $("#e_t_amount").val(amount);
        $("#e_t_bank_name").val(bank_name);
        $("#einvoice_date").val(date);
        $("#e_t_payment_type").val(payment_type);
        $("#edit_tra_id").val(id);
        $("#editPayModal").modal("show");
    });
    //sumbit tra edit form	
    $("#frm_edit_tra_detail").validate({
        submitHandler: function(form, event) {
            event.preventDefault();
            //Total amount received
            var TOTALNEWCOST = $("#e_t_amount").val();
            if (confirm(
                    "Are you sure to proceed ? Please make sure that the amount is correct. : You are enter RS. " +
                    TOTALNEWCOST + " /-")) {
                update_tra_payiti();
            }

            function update_tra_payiti() {
                //validate form
                var ajaxReq;
                var formData = $("#frm_edit_tra_detail").serializeArray();
                //Get call type value
                if (ajaxReq) {
                    ajaxReq.abort();
                }
                ajaxReq = $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('payments/edit_payment_tra_data'); ?>",
                    dataType: 'json',
                    data: formData,
                    beforeSend: function() {
                        $(".fullpage_loader").show();
                    },
                    success: function(res) {
                        $(".fullpage_loader").hide();
                        $("#frm_edit_tra_detail")[0].reset();
                        if (res.status == true) {
                            alert("Success: " + res.msg);
                            location.reload();
                        } else {
                            alert("Error: " + res.msg);
                            location.reload();
                        }
                    },
                    error: function(e) {
                        $(".fullpage_loader").hide();
                        location.reload();
                    }
                });
                return false;
            }
        }
    });


    //alert( id  + " amount " + amount + " date " + date + " bank_name " + bank_name + " payment_type " + payment_type );
    /* if ( confirm("Are you sure to delete transaction ?") ){
    	$.ajax({
    		url: "<?php echo base_url(); ?>" + "payments/delete_payment_transaction",
    		type:"POST",
    		data:{ id: id },
    		dataType: "json",
    		cache: false,
    		beforeSend: function(){
    			$(".fullpage_loader").show();
    		},
    		success: function(r){
    			$(".fullpage_loader").hide();
    			if(r.status = true){
    				alert(r.msg);
    			}else{						
    				alert("error");
    				console.log("Error.......");					
    			}
    			location.reload();
    		},
    		error: function(){
    			$(".fullpage_loader").hide();
    			alert("error");					
    		}
    	});
    }	 */



    //DELETE TRANSACTION
    $(document).on("click", ".del_trans", function(e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        if (confirm("Are you sure to delete transaction ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>" + "payments/delete_payment_transaction",
                type: "POST",
                data: {
                    id: id
                },
                dataType: "json",
                cache: false,
                beforeSend: function() {
                    $(".fullpage_loader").show();
                },
                success: function(r) {
                    $(".fullpage_loader").hide();
                    if (r.status = true) {
                        alert(r.msg);
                    } else {
                        alert("error");
                        console.log("Error.......");
                    }
                    location.reload();
                },
                error: function() {
                    $(".fullpage_loader").hide();
                    alert("error");
                }
            });
        }
    });
});
</script>