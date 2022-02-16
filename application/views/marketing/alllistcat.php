<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>All Categories
                    </div>
                    <a class="btn btn-success" href="<?php echo site_url("marketing/addcat"); ?>" title="add agent">Add
                        Category</a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive second_custom_card">
                    <table class="table table-striped display" id="table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Category ID </th>
                                <th> Category Name </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
							if(!empty($row)){
								$count = 1;
								//getAllCategory
								foreach($row as $cat){	?>
                            <tr>
                                <td><?php echo $count;?></td>
                                <td><?php echo $cat->id;?></td>
                                <td><?php echo $cat->category_name;?></td>
                                <td>
                                    <a title='edit' href=" <?php echo site_url("marketing/editcat/".$cat->id);?>"
                                        class="btn_pencil  ajax_edit_cat_table"><i class='fa fa-pencil'></i></a>

                                    <?php if( $cat->super_category != 1 ){ ?>
                                    <a title="delete" href="javascript:void(0)" data-id="<?php echo $cat->id;?>"
                                        class='btn_trash ajax_delete_cat'><i class='fa fa-trash-o'></i></a>
                                    <?php } ?>

                                </td>
                            </tr>
                            <?php $count++;
								} 
							} else {?>
                            <tr>
                                <td colspan="3" style="text-align:center;"> No Records Found Click here to <a
                                        href="<?php echo site_url("marketing/addcat")?>">add new category</a></td>
                                <?php } ?>
                            </tr>
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
    $(document).on("click", ".ajax_delete_cat", function() {
        var user_id = $(this).attr("data-id");
        //alert(user_id);
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>" + "AjaxRequest/ajax_deleteCat?id=" + user_id,
                type: "GET",
                data: user_id,
                dataType: "json",
                cache: false,
                success: function(r) {
                    if (r.status = true) {
                        location.reload();
                        console.log("ok" + r.msg);
                    } else {
                        alert("Error! Please try again.");
                    }
                }
            });
        }
    });
});
</script>