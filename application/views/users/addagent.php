<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <form role="form" id="addAgent">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-user"></i>Add user</div>
                        <a class="btn btn-success" href="<?php echo site_url("agents"); ?>" title="Back">Back</a>
                    </div>
                </div>
                <div class="portlet-body second_custom_card">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">First Name*</label>
                            <input required type="text" name="first_name" placeholder="First Name" class="form-control"
                                value="" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Last Name</label>
                            <input type="text" placeholder="Last Name" name="last_name" class="form-control" value="" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">User Name*</label><span
                                style='font-size: 11px; color: red;'>(Allowed Characters: a-z,A-Z,0-9,_@#$.)</span>
                            <input type="text" placeholder="User Name! Should be Unique" name="user_name"
                                class="form-control" value="" />
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">User Password*</label>
                            <input id="PaSS" type="password" placeholder="Enter your password" name="password"
                                class="form-control" value="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Confirm Password*</label>
                            <input type="password" placeholder="Confirm password" name="c_password" class="form-control"
                                value="" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Alternate Password*</label><span
                                style='font-size: 11px; color: red;'> (Accessible by manager/admin)</span>
                            <input id="" type="text" placeholder="Enter alternate password" name="alt_pass"
                                class="form-control alt_pass" value="" />
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Email*</label>
                            <input type="email" placeholder="Email" name="email" class="form-control" value="" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Office Timing*</label>
                            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012"
                                data-date-format="mm/dd/yyyy">
                                <input name="in_time" type="text" class="form-control timepicker timepicker-no-seconds"
                                    value="" />
                                <span class="input-group-addon"> to </span>
                                <input name="out_time" type="text" class="form-control timepicker timepicker-no-seconds"
                                    value="" />
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Mobile Number*</label>
                            <input type="text" placeholder="Mobile" maxlength="12" name="mobile" class="form-control"
                                value="" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Gender*</label><br>
                            <input required name="gender" value="male" type="radio" id="male"><label
                                for="male">Male</label>
                            <input required name="gender" value="female" type="radio" id="female"><label
                                for="female">Female</label>
                        </div>
                    </div>

                    <?php $get_all_users_role = get_all_users_role(); ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">User Role*</label>
                            <?php if( is_admin()){ ?>
                            <select required name="user_type" class="form-control">
                                <option value="">Select User Type</option>
                                <?php 
							if( $get_all_users_role ){
								foreach($get_all_users_role as $role ){
									echo "<option value='{$role->role_id}'>". ucwords($role->role_name) ."</option>";
								}
							}
							?>
                            </select>
                            <?php }else{ ?>
                            <select required name="user_type" class="form-control">
                                <option value="">Select User Type</option>
                                <?php 
							if( $get_all_users_role ){
								foreach($get_all_users_role as $role ){
									if( $role->role_id == 99 || $role->role_id == 98 ) continue;
									echo "<option value='{$role->role_id}'>". ucwords($role->role_name) ."</option>";
								}
							}
							?>
                            </select>
                            <?php } ?>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">User Status*</label>
                            <select required name="user_status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Mobile Number For Login*</label><span
                                style='font-size: 11px; color: red;'> (Visible for manager/admin only.)</span>
                            <input type="text" placeholder="Mobile number for login otp. Should be unique."
                                maxlength="10" name="mobile_otp" class="form-control numberf" value="" />
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Website</label>
                            <input type="text" placeholder="Mobile" name="website" class="form-control"
                                value="http://trackitinerary.org/" />
                        </div>
                    </div>


                    <div class="clearfix"></div>
                    <hr>
                    <div class="col-md-12">
                        <div class="margiv-top-10">
                            <input type="hidden" name="added_by" value="<?php echo $user_id; ?>">
                            <button type="submit" class="btn green uppercase add_agent">Add Agent</button>
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
    jQuery.validator.addMethod("strongPass", function(value, element) {
        if (this.optional(element)) {
            return true;
        }
        //var pattern = new RegExp(/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d][A-Za-z\d!@#$%^&*()_+]{4,8}$/);
        //console.log( pattern.test("1@3a") );
        var pattern = new RegExp(/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+]).{4,8}/);
        valid = false;
        if (pattern.test(value)) {
            valid = true;
        }
        return valid;
    }, "At least one number/lowercase/uppercase/specail character.");

    //Prevent Dot from number field
    /* $(".alt_pass").on('keyup keypress', function(e) {
		if(this.value.length==8) return false;
		var keyCode = e.keyCode || e.which;
		if (keyCode != 8) {
            //if not a number
            if (keyCode < 48 || keyCode > 57) {
                //disable key press
                return false;
            } //end if
            else {
				// enable keypress
				return true;
            } //end else
        } //end if
        else {
			// enable keypress
			return true;
        } //end else
				 
	}); */

    var form = $("#addAgent");
    var ajaxReq;
    $("#addAgent").validate({
        rules: {
            password: {
                required: true,
                minlength: 6
            },
            alt_pass: {
                minlength: 4,
                strongPass: true
            },
            c_password: {
                equalTo: "#PaSS"
            },
            email: {
                required: true,
                email: true
            },
            mobile: {
                required: true,
                number: true
            },
            mobile_otp: {
                required: true,
                number: true
            },
            user_name: {
                required: true,
            },

        },
        submitHandler: function(form) {
            var resp = $("#addresEd");
            var formData = $("#addAgent").serializeArray();
            //console.log(formData);
            if (ajaxReq) {
                ajaxReq.abort();
            }
            ajaxReq = $.ajax({
                type: "POST",
                url: "<?php echo base_url('AjaxRequest/ajaxAdduser'); ?>",
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
                        console.log("done");
                        $("#addAgent")[0].reset();
                        window.location.href = "<?php echo site_url("agents");?>";
                    } else {
                        resp.html(
                            '<div class="alert alert-danger"><strong>Error! </strong>' +
                            res.msg + '</div>');
                        console.log("error");
                    }
                },
                error: function(e) {
                    console.log(e);
                    //response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
                }
            });
            return false;
        }
    });
});
</script>