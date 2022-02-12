<div class="page-container">
   <div class="page-content-wrapper">
      <div class="page-content">
         <!-- BEGIN SAMPLE TABLE PORTLET-->
         <?php $message = $this->session->flashdata('success'); 
            if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
            ?>
         <div class="portlet box blue">
            <div class="portlet-title">
               <div class="caption">
                  <i class="fa fa-newspaper-o" aria-hidden="true"></i>Message Log Listing
               </div>
               <a class="btn btn-success" href="<?php echo site_url("msg_center/send_new_message"); ?>" title="Send Message">Create Message</a>
            </div>
            <div class="portlet-body second_custom_card">
               <div class="table-responsive margin-top-20">
                  <table class="table table-striped display" id="msg_listing_table" cellspacing="0" width="100%">
                     <thead>
                        <tr>
                           <th> # </th>
                           <th> Message ID </th>
                           <th> Message </th>
                           <th> Sent To </th>
                           <th> Sent Date/time </th>
                           <th> Agent </th>
                           <th> Action </th>
                        </tr>
                     </thead>
                     <tbody>
                        <!--Data table -->
                        <?php if( isset( $msg_listing ) && !empty( $msg_listing ) ){ 
                           $i = 1;
                           foreach( $msg_listing as $msg ){ ?>
                        <tr>
                           <td><?php echo $i; ?> </td>
                           <td><?php echo $msg->id; ?> </td>
                           <td><?php echo $msg->message; ?> </td>
                           <?php 
                              $emails_ids = explode(',', $msg->sent_to);
                              $len = count($emails_ids);
                              if( $len > 3 ){
                              	$counter = 1;
                              	$contacts = "";
                              	foreach( $emails_ids as $sent_to ){
                              		if( $counter === 3 ) {
                              			$contacts .= rtrim($contacts, ", ");
                              			$contacts .= " ..........";
                              			break;
                              		}
                              		$contacts .= "{$sent_to}, "; 
                              		$counter++;
                              	}
                              }else{
                              	$contacts = $msg->sent_to;
                              }
                              ?>
                           <td><?php echo rtrim($contacts, ", "); ?> </td>
                           <td><?php echo $msg->updated; ?> </td>
                           <td><?php echo get_user_name($msg->agent_id); ?> </td>
                           <td>
                              <div class="d-flex">
								<a title='View Sending Details' href="<?php echo site_url("msg_center/view_message/{$msg->id}"); ?> " class='btn btn-success' ><i class='fa fa-eye'></i></a>
								<a title='Send Message' href="<?php echo site_url("msg_center/resend_message/{$msg->id}"); ?> " class='btn btn-success' ><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
								<?php 
									if( is_admin() ){ ?>
								<a title='delete' href='javascript:void(0)' data-id = <?php echo $msg->id; ?> class='btn btn-danger ajax_delete_newsletter'><i class='fa fa-trash-o'></i></a>
								<?php } ?>
							  </div>
                           </td>
                        </tr>
                        <?php }
                           }else{
                           	echo "<tr><td colspan=5>No Data Found. </td></tr>";	
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
   jQuery(document).ready(function($){
   $(document).on("click", ".ajax_delete_newsletter",function(){
   	var id = $(this).attr("data-id");
   	//alert(user_id);
   	if (confirm("Are you sure?")) {
   		$.ajax({
   			url: "<?php echo base_url(); ?>" + "msg_center/update_msg_del_status?id=" + id,
   			type:"GET",
   			dataType: "json",
   			cache: false,
   			success: function(r){
   				if(r.status = true){
   					location.reload();
   				  console.log("ok" + r.msg);
   				}else{
   					alert("Error! Please try again.");
   				}
   			}
   		});	
   	}   
   });
   }); 
</script>
<script type="text/javascript">
   $(document).ready(function() {
       //datatables
       $('#msg_listing_table').DataTable();
   });
</script>