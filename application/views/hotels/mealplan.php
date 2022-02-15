<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <?php 
		$message = $this->session->flashdata('success'); 
		$err = $this->session->flashdata('error'); 
		if($err){ echo '<span class="help-block help-block-error1 red">'.$err.'</span>';} 
		if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';}
		?>
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>All Meal Plans
                    </div>

                    <a class="btn btn-success" href="<?php echo site_url("hotels/addmealplan"); ?>"
                        title="Add Season">Add Mealplan</a>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive margin-top-20">
                        <table id="hotels" class="table table-striped display">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Name</th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--Get data-->
                                <?php if( !empty($mealplan) ){
								$i = 1;
								foreach( $mealplan as $meal ){
									echo "<tr><td>{$i}</td>
										<td>{$meal->name}</td>
									<td><a href=" . site_url("hotels/editmealplan/{$meal->id}") . " class='btn_pencil' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";//Show delete button if season greater than four
									if( $i > 4 ){
										echo "<a href='javascript:void(0)' data-id='{$meal->id}' class='btn btn-danger ajax_delete_mealplan'>Delete</a></td></tr>";
									}									
									$i++;
								}
							}else{
								echo "<tr><td colspan=4><p style='color:red;'>No Data Found.</p></td></tr>";
							} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- Modal -->

<script type="text/javascript">
jQuery(document).ready(function($) {
    $(document).on("click", ".ajax_delete_mealplan", function() {
        var id = $(this).attr("data-id");
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>" + "hotels/mealplan_delete?id=" + id,
                type: "GET",
                data: id,
                dataType: "json",
                cache: false,
                success: function(r) {
                    if (r.status = true) {
                        location.reload();
                        //console.log("ok" + r.msg);
                    } else {
                        alert("Error! Please try again.");
                    }
                }
            });
        }
    });
});
</script>