<div class="page-container customer_content">
    <div class="page-content-wrapper">
        <div class="page-content">
            <?php //echo get_country_name(101);	?>
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="icon-plus"></i>Add New Hotel</div>
                    <a class="btn btn-success" href="<?php echo site_url("hotels"); ?>" title="Back">Back</a>
                </div>
            </div>

            <form role="form" id="addHotel" enctype="multipart/form-data">

                <div class="portlet-body second_custom_card">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Select Country*</label>
                                <select name="country" class="form-control country">
                                    <option value="">Choose Country</option>
                                    <?php $country = get_country_list();
						if($country){
							foreach( $country as $c ){
								echo '<option value="'. $c->id . '">' . $c->name . '</option>';
							}
						}
						?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div id="state_list">
                                <div class='form-group'><label>State*:</label><select disabled name='state'
                                        class='form-control state'>
                                        <option value="">Select state</option>
                                    </select></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div id="city_list">
                                <div class='form-group'><label>City*:</label><select name='city' disabled
                                        class='form-control city'>
                                        <option value="">Select City</option>
                                    </select></div>
                            </div>
                        </div>


                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Hotel Category*</label>
                                <select name="category" class="form-control cat">
                                    <option value="">Choose Category</option>
                                    <?php $hotels_cat = hotel_categories();
						if($hotels_cat){
							foreach( $hotels_cat as $cat ){
								echo '<option value="'. $cat->star_id . '">' . $cat->name . '</option>';
							}
						}
						?>

                                </select>

                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Hotel Name*</label>
                                <input type="text" placeholder="Hotel Name" name="name" class="form-control" value="" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Hotel Email*</label>
                                <input type="text"
                                    placeholder="Email for multi email.eg: hotel@test.com,hotel2@test.com" id="email"
                                    name="email" class="form-control" value="" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Hotel Address*</label>
                                <textarea name="address" class="form-control"
                                    placeholder="Hotel Full Address"></textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Hotel Contact Number*</label>
                                <input type="text" placeholder="Hotel Phone Number" name="contact" class="form-control"
                                    value="" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Hotel Website</label>
                                <input type="text" placeholder="Website Link" name="website" class="form-control"
                                    value="" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                    <img alt="" class="img-responsive" src="" />
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"
                                    style="max-width: 200px; max-height: 150px;"> </div>
                                <div>
                                    <span class="btn default btn-file">
                                        <span class="fileinput-newa"> Click here to upload hotel image </span>
                                        <span class="fileinput-existss"> </span>
                                        <input id="image_url" type="file" name="image_url"> </span>
                                    <a href="javascript:;" class="btn default fileinput-exists"
                                        data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                            <div class="clearfix margin-top-10">
                                <span class="label label-danger">NOTE! </span>&nbsp;&nbsp;&nbsp;
                                <span class='red'> Image size not bigger then 2 MB and dimensions(650px X 250px).</span>
                            </div>
                        </div>
                    </div> <!-- row -->

                    <hr>
                    <div class="col-md-12 text-left">
                        <div class="margiv-top-10">
                            <button type="submit" class="btn green uppercase add_hotel">Add Hotel</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="addresEd" class="sam_res"></div>
            </form>
        </div><!-- portlet body -->
    </div> <!-- portlet -->

</div>
<!-- END CONTENT BODY -->
</div>
<!-- Modal -->
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
    jQuery.validator.addMethod("multiemail", function(value, element) {
        if (this.optional(element)) {
            return true;
        }
        var emails = value.split(','),
            valid = true;
        for (var i = 0, limit = emails.length; i < limit; i++) {
            value = emails[i];
            valid = valid && jQuery.validator.methods.email.call(this, value, element);
        }
        return valid;
    }, "Separate email with a comma without spaces.");
    /*get states from country*/
    $("select.country").change(function() {
        var selectCountry = $(".country option:selected").val();
        var _this = $(this);
        _this.parent().append(
            '<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotelStateData'); ?>",
            data: {
                country: selectCountry
            }
        }).done(function(data) {
            $(".bef_send").hide();
            $(".state").html(data);
            $(".state").removeAttr("disabled");
            $(".city").html("<option vlaue=''>select city</option>");

        }).error(function() {
            $("#state_list").html("Error! Please try again later!");
        });
    });
    /*get cities from state*/
    $(document).on('change', 'select.state', function() {
        var selectState = $(".state option:selected").val();
        var _this = $(this);
        _this.parent().append(
            '<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotelCityData'); ?>",
            data: {
                state: selectState
            }
        }).done(function(data) {
            $(".bef_send").hide();
            $(".city").html(data);
            $(".city").removeAttr("disabled");
        }).error(function() {
            $("#city_list").html("Error! Please try again later!");
        });
    });
});

jQuery(document).ready(function($) {
    var ajaxReq;
    var form = $("#addHotel");
    $("#addHotel").validate({
        rules: {
            country: {
                required: true
            },
            state: {
                required: true
            },
            city: {
                required: true
            },
            category: {
                required: true
            },
            name: {
                required: true
            },
            address: {
                required: true
            },
            contact: {
                required: true
            },
            email: {
                required: true,
                multiemail: true
            },
        },
    });
    $(document).on("submit", '#addHotel', function(e) {
        e.preventDefault();

        var resp = $("#addresEd");
        var formData = $("#addHotel").serializeArray();
        //console.log(formData);
        if (ajaxReq) {
            ajaxReq.abort();
        }
        ajaxReq = $.ajax({
            type: "POST",
            url: "<?php echo base_url('hotels/ajax_add_hotel'); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
            },
            success: function(data) {
                console.log(data);
                if (data == "success") {
                    resp.html(
                        '<div class="alert alert-success"><strong>Success: </strong> Hotel add successfully!</div>'
                        );
                    $("#addHotel")[0].reset();
                } else {
                    resp.html(data);
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

    });
});
</script>