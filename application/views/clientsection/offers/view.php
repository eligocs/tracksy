<?php $offer = $offer_data[0];  ?>
<div class="page-container customer_view_section view_call_info">
    <?php  if($offer){ ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-users"></i>Offer</div>
                    <a class="btn btn-success" href="<?php echo site_url("clientsection/offers"); ?>"
                        title="Back">Back</a>
                </div>
            </div>
            <?php $message = $this->session->flashdata('success'); 
					if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
				?>
            <div class="portlet-body second_custom_card">
                <div class="customer-details">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-2"><strong>Title:</strong></div>
                            <div class="col-md-10"><?php echo $offer->title; ?></div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-2"><strong>Description:</strong></div>
                            <div class="col-md-10"><?php echo $offer->description; ?></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2"><strong>Offer Type:</strong></div>
                            <div class="col-md-10"><?php echo $offer->offer_type; ?></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2"><strong>Coupon Code:</strong></div>
                            <div class="col-md-10"><?php echo $offer->coupon_code; ?></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2"><strong>Terms & Conditions:</strong></div>
                            <div class="col-md-10"><?php echo $offer->term_and_conditions; ?></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2"><strong>Coupon Status:</strong></div>
                            <div class="col-md-10">
                                <?php echo isset($offer->offer_status) && $offer->offer_status == 1 ? "Active" : "Inactive"; ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2"><strong>Created:</strong></div>
                            <div class="col-md-10"><?php echo $offer->created; ?></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2"><strong>Offer Added By:</strong></div>
                            <div class="col-md-10"><?php echo get_user_name($offer->agent_id); ?></div>
                        </div>

                        <div class="text-center">
                            <a title='Edit Offer'
                                href="<?php echo site_url("clientsection/offer_edit/{$offer->id}"); ?>" class=""><i
                                    class="fa fa-pencil"></i> Edit Offer</a>
                        </div>

                    </div> <!-- row -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php }else{
	redirect(404);
 } ?>