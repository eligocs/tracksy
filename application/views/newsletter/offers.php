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
                  <i class="fa fa-newspaper-o" aria-hidden="true"></i>Offers List
               </div>
               <a class="btn btn-success" href="<?php echo site_url("newsletters/addOffers"); ?>" title="Create Newsletter">Add Offer</a>
            </div>
            <div class="portlet-body">
               <div class="table-responsive">
                  <table class="table table-striped display" id="templatetable" cellspacing="0" width="100%">
                     <thead>
                        <tr>
                           <th> # </th>
                           <th> Offer ID </th>
                           <th> Offer Title </th>
                           <th> Action </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if(!empty($data)){ $i=1; foreach($data as $val){?>
                        <tr>
                           <td><?php echo $i++; ?></td>
                           <td><?php echo $val->offerid; ?></td>
                           <td><?php echo $val->title1.','.$val->title2.','.$val->title3; ?></td>
                           <td><?php 
                              if(is_admin()){
                              $row1 = "<a title='delete' href=". base_url('newsletters/deleteOffer/').$val->offerid. " data-id = {$val->offerid} class='btn btn-danger ajax_delete_newsletter'><i class='fa fa-trash-o'></i></a>";
                              }
                              else{
                              	$row1="";
                              }
                              $rowedit = "<a title='Edit' href=".base_url('newsletters/addOffers/').$val->offerid." class='btn btn-success' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
                              $rowsnd = "<a title='Edit' href=".base_url('newsletters/sendOffer/').$val->offerid." class='btn btn-success' ><i class='fa fa-paper-plane' aria-hidden='true'></i></a>";
                              $rowr = "<a title='view' href=" .base_url('newsletters/viewOffer/').$val->offerid." class='btn btn-success' ><i class='fa fa-eye'></i></a>" . $rowedit . $row1.	$rowsnd;
                              echo $rowr;
                              	}} ?></td>
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