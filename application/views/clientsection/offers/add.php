<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-plus"></i>Add New Offer
                    </div>
                    <a class="btn btn-success" href="<?php echo site_url("clientsection/offers"); ?>"
                        title="Back">Back</a>
                </div>
            </div>
            <div class="portlet-body second_custom_card">
                <form role="form" id="frm_offers">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Title*</label>
                                <input type="text" required placeholder="eg: Coupon Title" name="inp[title]"
                                    class="form-control" value="" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Description*</label>
                                <textarea required placeholder="offer description" name="inp[description]"
                                    class="description form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Offer Type*</label>
                                <input type="text" required placeholder="eg: Weekend,diwali etc" name="inp[offer_type]"
                                    class="form-control" value="" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Coupon Code*</label>
                                <input type="text" required placeholder="eg: DIWALI20" onkeydown="upperCaseF(this)"
                                    maxlength="20" name="inp[coupon_code]" class="form-control" value="" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Terms and Conditions*</label>
                                <textarea required placeholder="Terms and Conditions.." name="inp[term_and_conditions]"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Enable Coupon For Client</label>
                                <select class="form-control" name="inp[offer_status]">
                                    <option value="">Select option</option>
                                    <option value="1">Enable</option>
                                    <option value="0">Enable Later</option>
                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="col-md-10">
                        <div class="margiv-top-10">
                            <input type="hidden" name="inp[agent_id]" value="<?php echo $agent_id; ?>" />
                            <button type="submit" class="btn green uppercase">Add Offer</button>
                        </div>
                    </div>
                </form>
                <div class="clearfix"></div>
                <div id="addresEd"></div>
            </div><!-- portlet body -->
        </div> <!-- portlet -->
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- Modal -->
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
    var form = $("#frm_offers");
    var resp = $("#addresEd"),
        ajaxReq;
    $("#frm_offers").validate({
        submitHandler: function(form) {
            var formData = $("#frm_offers").serializeArray();
            //console.log(formData);
            if (ajaxReq) {
                ajaxReq.abort();
            }
            ajaxReq = $.ajax({
                type: "POST",
                url: "<?php echo base_url('clientsection/ajax_add_offer'); ?>",
                dataType: 'json',
                data: formData,
                beforeSend: function() {
                    resp.html(
                        '<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>'
                        );
                },
                success: function(res) {
                    if (res.status == true) {
                        resp.html(
                            '<div class="alert alert-success"><strong>Success! </strong>' +
                            res.msg + '</div>');
                        //console.log("done");
                        $("#frm_offers")[0].reset();
                        window.location.href =
                            "<?php echo site_url("clientsection/offer_view/");?>" + res
                            .id;
                    } else {
                        resp.html(
                            '<div class="alert alert-danger"><strong>Error! </strong>' +
                            res.msg + '</div>');
                        //console.log("error");
                    }
                },
                error: function(e) {
                    //console.log(e);
                    resp.html(
                        '<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>'
                        );
                }
            });
            return false;
        }
    });

});

function upperCaseF(a) {
    setTimeout(function() {
        a.value = a.value.toUpperCase();
    }, 1);
}
</script>