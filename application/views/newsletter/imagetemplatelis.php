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
                  <i class="fa fa-newspaper-o" aria-hidden="true"></i>Image Template List
               </div>
               <a class="btn btn-success" href="<?php echo site_url("newsletters/imgtemplate"); ?>" title="Create Newsletter">Add Image Template</a>
            </div>
            <div class="portlet-body second_custom_card">
               <div class="table-responsive margin-top-20">
                  <table class="table table-striped display" id="templatetable" cellspacing="0" width="100%">
                     <thead>
                        <tr>
                           <th> # </th>
                           <th> Template ID </th>
                           <th> Subject </th>
                           <th> Action </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $i=1; foreach($data as $val){?>
                        <tr>
                           <td><?php echo $i++; ?></td>
                           <td><?php echo $val->id; ?></td>
                           <td><?php echo $val->img_name; ?></td>
                           <td><?php 
                              if(is_admin()){
                              $row1 = "<a title='delete' href=". base_url('newsletters/deleteImgTemplate/').$val->id. " data-id = {$val->id} class='btn btn-danger ajax_delete_newsletter'><i class='fa fa-trash-o'></i></a>";
                              }
                              else{
                              	$row1="";
                              }
                              $rowedit = "<a title='Edit' href=".base_url('newsletters/editImgTemplate/').$val->id." class='btn btn-success' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
                              $rowr = "<a title='view' href=" .base_url('newsletters/viewImgTemplate/').$val->id." class='btn btn-success' ><i class='fa fa-eye'></i></a>" . $rowedit . $row1;
                              echo $rowr;
                              	} ?></td>
                        </tr>
                        <!--Data table -->
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
<script>
   $(document).ready( function () {
       $('#templatetable').dataTable();
   } );
</script>