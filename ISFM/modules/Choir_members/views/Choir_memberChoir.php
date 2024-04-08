<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- END PAGE LEVEL STYLES -->
<?php $user = $this->ion_auth->user()->row();
$userId = $user->id; ?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <?php echo lang('stu_clas_pageTitle'); ?> <small></small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <?php echo lang('home'); ?>
                        
                    </li>
                    <li>
                        <?php echo lang('header_stu_paren'); ?>
                        
                    </li>
                    <li>
                        <?php echo lang('header_stude'); ?>
                        
                    </li>
                    <li>
                        <?php echo lang('header_stu_info'); ?>
                        
                    </li>
                    <li>
                    <?php echo $this->common->Choir_title($Choir_id); ?> 
                    </li>
                    <li id="result" class="pull-right topClock"></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->        
        <!-- BEGIN PAGE CONTENT-->        
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN REHEARSALPLE TABLE PORTLET-->
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <?php echo $this->common->Choir_title($Choir_id) .' '. lang('stu_clas_table_title');
                            if (!empty($section)) {
                                echo $section;
                            }
                            ?>    
                        </div>
                        <div class="tools">
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                            <thead>
                                <tr>
                                    <th>
                                        <?php echo lang('stu_clas_Choir_member_ID'); ?>
                                    </th>
                                    <th>
                                        <?php echo lang('stu_clas_Roll_No'); ?>
                                    </th>
                                    <th>
                                        <?php echo lang('stu_clas_Photo'); ?>
                                    </th>
                                    <th>
                                        <?php echo lang('stu_clas_Choir_member_Name'); ?>
                                    </th>
                                    <th>
                                        <?php echo lang('stu_clas_Phone_No'); ?>
                                    </th>
                                    <th>
                                        <?php echo lang('stu_clas_Address'); ?>
                                    </th>
                                    <th>
                                        <?php echo lang('stu_clas_E-mail'); ?>
                                    </th>
                                    <th>
                                        <?php echo lang('stu_clas_Actions'); ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($Choir_memberInfo as $row) {
                                    //get Choir_member information from "user" table.
//                                    $Choir = $row['Choir_title'];
                                    $stuUserId = $row['user_id'];
                                    $query = $this->db->get_where('users', array('id' => $stuUserId));
                                    foreach ($query->result_array() as $row2) {
                                        $userdata = $row2;
                                    }
                                    $phoneNumber = $userdata['phone'];
                                    $email = $userdata['email'];

                                    //get Choir_member information from "Choir_member_info" table.
                                    $Choir_memberId = $row['Choir_member_id'];
                                    $qusry2 = $this->db->get_where('Choir_member_info', array('Choir_member_id' => $Choir_memberId));
                                    foreach ($qusry2->result_array() as $row3) {
                                        $userInfo = $row3;
                                    }
                                    $photo = $userInfo['Choir_member_photo'];
                                    $address = $userInfo['present_address'];
                                    ?>

                                    <tr>
                                        <td>
                                            <?php echo $row['Choir_member_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['roll_number']; ?>
                                        </td>
                                        <td>
                                            <div class="tableImage">
                                                <img src="assets/uploads/<?php echo $photo; ?>" alt="">
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo $row['Choir_member_title']; ?>
                                        </td>
                                        <td>
                                            <?php echo $phoneNumber; ?>
                                        </td>
                                        <td>
                                            <?php echo $address ?>
                                        </td>
                                        <td>
                                            <?php echo $email; ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-xs green tableActionButtonMargin" href="index.php/Choir_members/Choir_members_details?id=<?php echo $row['id']; ?>&sid=<?php echo $Choir_memberId; ?>&userId=<?php echo $stuUserId; ?>"> <i class="fa fa-file-text-o"></i> <?php echo lang('stu_clas_Details'); ?> </a>
                                            <?php if($this->common->user_access('stud_edit_delete',$userId)){ ?>
                                                <a class="btn btn-xs default tableActionButtonMargin" href="index.php/Choir_members/editChoir_member?di=<?php echo $row['id']; ?>&sid=<?php echo $Choir_memberId; ?>&userId=<?php echo $stuUserId; ?>&Choir_id=<?php echo $Choir_id; ?>"> <i class="fa fa-pencil-square"></i> <?php echo lang('stu_clas_Edit'); ?> </a>
                                                <a class="btn btn-xs red tableActionButtonMargin" href="index.php/Choir_members/Choir_memberDelete?di=<?php echo $row['id']; ?>&sid=<?php echo $Choir_memberId; ?>&userId=<?php echo $stuUserId; ?>" onClick="javascript:return confirm('Are you sure you want to delete this Choir_member?')"> <i class="fa fa-trash-o"></i> <?php echo lang('stu_clas_Delete'); ?> </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END REHEARSALPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
<!-- END CONTENT -->


<!--Begin Page Level Script-->
<script type="text/javascript" src="assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="assets/admin/pages/scripts/table-advanced.js"></script>
<!--End Page Level Script-->
<script>
    jQuery(document).ready(function() {
        //here is auto reload after 1 second for time and date in the top
        jQuery(setInterval(function() {
            jQuery("#result").load("index.php/home/iceTime");
        }, 1000));
    });
</script>
