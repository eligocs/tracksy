<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-plus"></i>Add New Review
                    </div>
                    <a class="btn btn-success" href="<?php echo site_url("clientsection/reviews"); ?>"
                        title="Back">Back</a>
                </div>
            </div>
            <div class="portlet-body second_custom_card">
                <form role="form" id="addReview">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Client Name*</label>
                                <input type="text" required placeholder="eg: Mr. Naveen Sharma" name="inp[client_name]"
                                    class="form-control" value="" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Client Contact*</label>
                                <input type="number" required placeholder="eg: 989898989" name="inp[client_contact]"
                                    class="form-control" value="" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Package Name*</label>
                                <input type="text" required placeholder="eg: Shimla Manali" name="inp[package_name]"
                                    class="form-control" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Feedback*</label>
                                <textarea required placeholder="Client review ( only 120 characters.)"
                                    name="inp[feedback]" class="feedback form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Client Rating*</label>
                                <div class="star-rating">
                                    <fieldset>
                                        <input type="radio" required id="star5" name="inp[rating]" value="5" /><label
                                            for="star5" title="Outstanding">5 stars</label>
                                        <input type="radio" required id="star4" name="inp[rating]" value="4" /><label
                                            for="star4" title="Very Good">4 stars</label>
                                        <input type="radio" required id="star3" name="inp[rating]" value="3" /><label
                                            for="star3" title="Good">3 stars</label>
                                        <input type="radio" required id="star2" name="inp[rating]" value="2" /><label
                                            for="star2" title="Poor">2 stars</label>
                                        <input type="radio" required id="star1" name="inp[rating]" value="1" /><label
                                            for="star1" title="Very Poor">1 star</label>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="col-md-10">
                        <div class="margiv-top-10">
                            <input type="hidden" name="inp[agent_id]" value="<?php echo $agent_id; ?>" />
                            <button type="submit" class="btn green uppercase add_vehicle">Add Review</button>
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
    var form = $("#addReview");
    var resp = $("#addresEd"),
        ajaxReq;
    $("#addReview").validate({
        submitHandler: function(form) {
            var formData = $("#addReview").serializeArray();
            //console.log(formData);
            if (ajaxReq) {
                ajaxReq.abort();
            }
            ajaxReq = $.ajax({
                type: "POST",
                url: "<?php echo base_url('clientsection/ajax_add_review'); ?>",
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
                        $("#addReview")[0].reset();
                        window.location.href =
                            "<?php echo site_url("clientsection/review_view/");?>" + res
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
</script>