<?php if($newsletter){ 	$news = $newsletter[0]; ?>
<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Send Message</div>
                    <a class="btn btn-success pull-right" href="<?php echo site_url("msg_center"); ?>"
                        title="Back">Back</a>
                </div>
            </div>

            <!--Show success message if Category edit/add -->
            <?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>


            <style>
            .nl-input-field,
            .body_edit {
                /*width: 92%;*/
                margin-left: auto !important;
                float: none;
                margin-right: auto !important;
                padding: 10px;
                line-height: 100%;
            }

            .form-group.nl-input-field {
                margin-bottom: 5px;
                border: 1px solid #eaeaea;
            }

            .label-success {
                background-color: #5cb85c;
            }

            .progress-bar {
                text-align: left;
                font-size: inherit;
            }

            .email_sent_list span {
                display: inline-block;
                width: 30%;
                display: inline-block;
                height: 28px;
                border-bottom: 1px solid #cecece;
                margin: 5px 1%;
            }

            .mails-db {
                margin-bottom: 20px;
            }

            .email_sent_list {
                height: 250px;
            }

            .mails-db-outer .well {
                padding: 10px;
                border: 1px solid #e4e4e4;
                margin-top: 5px;
            }

            div#mails-db {
                border: 1px solid #e6e6e6;
                padding-top: 10px;
            }

            .heading-label {
                background: #f1f1f1;
                padding: 10px;
                border: 1px solid #ececec;
                margin-top: 0;
            }
            </style>
			<div class="custom_card">
				<form role="form" class="form-horizontal form-bordered" id="filter_frm">
					<div class="form-group nl-input-field">
						<label for="subject"><strong>Message:</strong></label>
						<?php echo $news->message; ?>
					</div>
					<div class="form-group nl-input-field">
						<label for="body"><strong>Message Body:</strong></label>
					</div>
					<div class="form-group nl-input-field">
						<textarea required maxlength="160" name="text_message"
							class="form-control"><?php echo $news->message; ?></textarea>
					</div>
					<!--get marketing users by marketing category -->

					<div class="form-group nl-input-field">
						<label for="body"><strong>Select Contacts:</strong></label>
					</div>

					<div class="clearfix cat_wise_filter">

						<!--Get customers added by current agent if sales team-->
						<?php if( isset( $user_role ) && $user_role == 96  ){ ?>
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label">Choose Category*</label>
								<select required name="cat" class="form-control" id="mak_cat">
									<option value="">Select Category</option>
									<option value="all_leads">All Leads</option>
									<option value="working_lead">Working Leads</option>
									<option value="booked_lead">Booked Leads</option>
									<option value="declined_lead">Declined Leads</option>
									<option value="closed_lead">Closed Leads</option>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label">Leads Date Range</label>
								<input type="text" class="form-control" id="daterange" name="dateRange" value="" />
							</div>
						</div>
						<!--empty val for city and state -->
						<input type="hidden" value="" name="date_from" id="date_from" />
						<input type="hidden" value="" name="date_to" id="date_to" />
						<input type="hidden" value="" name="state" />
						<input type="hidden" value="" name="city" />

						<?php }else{ ?>
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label">Choose Category*</label>
								<select required name="cat" class="form-control" id="mak_cat">
									<option value="">Select Category</option>
									<option value="closed_lead">Closed Leads</option>
									<option value="booked_lead">Booked Leads</option>
									<option value="declined_lead">Declined Leads</option>
									<option value="process_lead">Process Leads</option>
									<option value="reference">Reference Customers</option>
									<?php if(!empty($marketing_category)) {	?>
									<?php foreach($marketing_category as $cat){?>
									<option value="<?php echo $cat->id;?>"><?php echo $cat->category_name;?></option>
									<?php }	?>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-3 hideonlead">
							<label class="control-label">State * </label>
							<div class="form-group">
								<select name='state' class='form-control' id='state'>
									<option value="">All States</option>
									<?php $state_list = get_indian_state_list(); 
											if( $state_list ){
												foreach($state_list as $state){
													echo '<option value="'.$state->id.'">'.$state->name.'</option>';
												}
											} ?>
								</select>
							</div>
						</div>

						<div class="col-md-3 hideonlead">
							<div id="city_list">
								<div class='form-group'>
									<label>City:</label>
									<select name='city' id="cityID" class='form-control city'>
										<option value="">All Cities</option>
									</select>
								</div>
							</div>
						</div>
						<?php } ?>
						<div class="col-md-3">
							<div class="">
								<label for="" class="d_block">&nbsp;</label>
								<a href="javascript:void(0);" class="btn green uppercase get_marketing_users">Get
									Customers</button>
									<a href="javascript:void(0);" class="btn green uppercase reset_filter margin_left_15"><i
											class="fa fa-refresh"></i> Reset</a>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="res"></div>
					</div>
					<div class="clearfix"></div>

					<!--ajax user listing-->
					<div class="clearfix" id="customer_listing"></div>
					<?php //if( !empty($customers) ){ ?>
					<hr>
					<div class="form-actions">
						<div class="row">
							<div class="col-md-12 nl-input-field">
								<button type="submit" class="btn green" id="send_sms_btn">
									<i class="fa fa-check"></i> Send Message </button>
							</div>
						</div>
					</div>
					<input type="hidden" name="news_id" id="news_id" value="<?php echo $news->id; ?>">
					<input type="hidden" name="action_type" value="edit">
					<?php// } ?>
				</form>
			</div>
            <div class="clearfix"></div>
            <div id="res"></div>


            <div class="clearfix"></div>

            <?php if( !empty( $news->sent_to ) ){ ?>
            <div id="send-mails" class="custom_card margin-top-30">
                <h3>Sending History</h3>
                <div class="form-group nl-input-field  ">
                    <h5 class="heading-label"> <strong>Sent:</strong></h5>
                    <?php $sent_e = explode(",", $news->sent_to);
									$len = count($sent_e);
									$i = 0;
									echo '<div class="email_sent_list">';
										if( !empty( $sent_e ) ){
											foreach( $sent_e as $e ){
												if(++$i === $len) {
													echo "<span>{$e}</span>";
												}else{
													echo "<span>{$e}</span> ";
												}	
											}
										}else{
											echo "<strong>Email Not sent yet.</strong>";
										}
									echo "</div>";
								?>

                </div>

            </div>
            <?php } ?>
        </div>

    </div>
</div>
</div>
<?php } ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
    //$("#sendMessage").validate();
    //hide state and city if type = closed_lead || process_lead
    $('#mak_cat').on('change', function(e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        if (valueSelected == "closed_lead" || valueSelected == "process_lead") {
            $(".hideonlead").hide();
        } else {
            $(".hideonlead").show();
        }
    });
});
</script>

<script type="text/javascript">
jQuery(document).ready(function($) {

    //Date range
    $("#daterange").daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            autoUpdateInput: false,
            showDropdowns: true,
            minDate: new Date(2016, 10 - 1, 25),
            //singleDatePicker: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                    .endOf('month')
                ]
            },
        },
        function(start, end, label) {
            $('#daterange').val(start.format('D MMMM, YYYY') + ' to ' + end.format('D MMMM, YYYY'));
            $("#date_from").val(start.format('YYYY-MM-DD'));
            $("#date_to").val(end.format('YYYY-MM-DD'));
            console.log("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD'));
        });

    $("#send_sms_btn").hide();
    var resp = $(".res"),
        ajaxReq, _res_html = $("#customer_listing");
    $(".reset_filter").click(function() {
        _res_html.html("");
        $("#send_sms_btn").hide();
        $("#mak_cat").val("");
    });

    $(".get_marketing_users").click(function(e) {
        if ($("#mak_cat").val() == "") {
            resp.html(
                '<div class="alert alert-danger"><strong>Error! </strong>Please select marketing user category first.</div>'
                );
            return false;
        }
        e.preventDefault();
        var formData = $("#filter_frm").serializeArray();
        var news_id = $("#news_id").val();
        var city_id = $("#cityID").val();
        var state_id = $("#state").val();
        var cat = $("#mak_cat").val();
        console.log(city_id);
        if (ajaxReq) {
            ajaxReq.abort();
        }
        ajaxReq = $.ajax({
            type: "POST",
            url: "<?php echo base_url('msg_center/ajax_get_marketing_ref_cus_list'); ?>",
            dataType: 'json',
            data: formData,
            beforeSend: function() {
                console.log("sending...");
                $("#send_sms_btn").hide();
                resp.html(
                    '<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>'
                    );
            },
            success: function(res) {

                if (res.status == true) {
                    $("#send_sms_btn").show();
                    $("#sendMessage").show();
                    resp.html("");
                    _res_html.html(res.res_html);
                    //console.log("done");
                } else {

                    $("#sendMessage").hide();
                    _res_html.html("");
                    resp.html('<div class="alert alert-danger"><strong>Error! </strong>' +
                        res.msg + '</div>');
                    console.log("No data found");
                }
            },
            error: function(e) {
                $("#sendMessage").hide();
                _res_html.html("");
                console.log(e);
                //response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
            }
        });
        return false;

    });

    /*get cities from state*/
    $(document).on('change', 'select#state', function() {
        var selectState = $("#state option:selected").val();

        var _this = $(this);
        $("#place").val("");
        _this.parent().append(
            '<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('marketing/cityListByStateId'); ?>",
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
</script>

<script type="text/javascript">
jQuery(document).ready(function() {
    //Show newsletter body in editor
    var body_view = $(".body_view");
    var body_edit = $(".body_edit");
    $(document).on("click", "#copy_news a", function(e) {
        e.preventDefault();
        body_view.hide();
        body_edit.show();
        $(this).parent().addClass("showView");

    });
    $(document).on("click", "#copy_news.showView a", function(e) {
        e.preventDefault();
        body_view.show();
        body_edit.hide();
        $(this).parent().removeClass("showView");

    });


});
</script>
<script type="text/javascript">
jQuery(document).ready(function($) {
    /* select only three customers emails */
    var limit = 1000;
    $('input.cus_emails').on('change', function(e) {
        if ($('input.cus_emails:checked').length > limit) {
            $(this).prop('checked', false);
            $("#checkAll").prop("checked", true);
            alert("allowed only 1000 customer email");
        } else {
            $("#checkAll").removeAttr("checked");
        }
    });
    /* select first 1000 checkboxs on checkAll click */
    $(document).on("click", "#checkAll", function() {
        if ($(this).prop("checked")) {
            $("input.cus_emails").removeAttr("checked")
            var checkBoxes = $("input.cus_emails:lt(1000)");
            $(checkBoxes).prop("checked", !checkBoxes.prop("checked"));
        } else {
            var checkBoxes = $("input.cus_emails").removeAttr("checked");
        }
    });
    var ajaxRstr;
    $("#filter_frm").validate({
        submitHandler: function(form) {
            var response = $("#res");
            var formData = $("#filter_frm").serializeArray();
            if (ajaxRstr) {
                ajaxRstr.abort();
            }
            ajaxRstr = jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "msg_center/send_flash_text_sms",
                dataType: 'json',
                data: formData,
                beforeSend: function() {
                    response.html(
                        '<div class="alert alert-success"><strong></strong><i class="fa fa-spinner fa-spin"></i> Please wait...</div>'
                        );
                },
                success: function(res) {
                    console.log(res);
                    if (res.status == true) {
                        response.html(
                            '<div class="alert alert-success"><strong>Success! </strong>' +
                            res.msg + '</div>');
                        //console.log("done");
                        location.reload();
                    } else {
                        response.html(
                            '<div class="alert alert-danger"><strong>Error! </strong>' +
                            res.msg + '</div>');
                        //console.log("error");
                    }
                },
                error: function() {
                    response.html(
                        '<div class="alert alert-danger"><strong>Error! </strong>Please Try again later! </div>'
                        );
                }
            });
        }
    });
    /* Send Mail */
});
</script>
<script>
/* Popu Up window */
jQuery(document).ready(function() {
    $.fn.customerPopup = function(e, intWidth, intHeight, blnResize) {
        // Prevent default anchor event
        e.preventDefault();

        // Set values for window
        intWidth = intWidth || '500';
        intHeight = intHeight || '400';
        strResize = (blnResize ? 'yes' : 'no');

        // Set title and open popup with focus on it
        var strTitle = ((typeof this.attr('title') !== 'undefined') ? this.attr('title') : 'Social Share'),
            strParam = 'width=' + intWidth + ',height=' + intHeight + ',resizable=' + strResize,
            objWindow = window.open(this.attr('href'), strTitle, strParam).focus();
    }

    /* ================================================== */
    $('.sm_share').on("click", function(e) {
        $(this).customerPopup(e);
    });
});
</script>