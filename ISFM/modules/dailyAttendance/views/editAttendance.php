<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <?php echo lang('att_ecatt'); ?> <small></small>
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
                        <?php echo lang('header_attendance'); ?>
                    </li>
                    <li>
                        <?php echo lang('header_daily_attend'); ?>
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
                <div class="portlet box purple">
                    <div class="portlet-title">
                        <div class="caption">
                            <?php echo lang('att_eaib'); ?>
                        </div>
                        <div class="tools">
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <?php
                        $form_attributs = array('class' => 'form-horizontal', 'role' => 'form');
                        $id = $this->input->get('ghtnidjdfjkid');
                        echo form_open("dailyAttendance/editAttendance?ghtnidjdfjkid=$id", $form_attributs);
                        ?>
                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-sm-offset-1 col-sm-2">
                                    <input type="text" placeholder="<?php echo lang('att_rn'); ?>" class="form-control" disabled="">  
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" placeholder="<?php echo lang('att_sn'); ?>" class="form-control" disabled="">  
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" placeholder="<?php echo lang('att_act'); ?>" class="form-control" disabled="">  
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" placeholder="<?php echo lang('att_att'); ?>" class="form-control" disabled="">  
                                </div>
                            </div>
                        </div>
                        <?php
                        foreach ($editInfo as $row) {
                            ?>
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="col-sm-offset-1 col-sm-2">
                                        <input type="text" name="rollNumber" value="<?php echo $row['roll_no'] ?>" class="form-control" readonly="">  
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" name="Choir_memberName" value="<?php echo $row['Choir_member_title']; ?>" class="form-control" readonly="">  
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="action" required>
                                            <option value="0"><?php echo lang('select'); ?></option>
                                            <option value="P"><?php echo lang('att_pre'); ?></option>
                                            <option value="A"><?php echo lang('att_absent'); ?></option>
                                        </select> 
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" placeholder="<?php echo $row['percentise_month']; ?> %" class="form-control" disabled="">
                                    </div>

                                    <input type=hidden name="userId" value="<?php echo $row['user_id']; ?>">
                                    <input type="hidden" name="Choir_memberInfoId" value="<?php echo $row['Choir_member_id'] ?>">
                                    <input type=hidden name="ChoirTitle" value="<?php echo $row['Choir_title']; ?>">
                                    <input type="hidden" name="section" value="<?php echo $row['section'] ?>">
                                    <input type=hidden name="in_velu" value="<?php echo $i; ?>">
                                </div>
                            </div>
                            <?php } ?> 
                        <div class="form-actions fluid">
                            <div class="col-sm-offset-3 col-md-9">
                                <button class="btn blue" type="submit" name="submit" value="Submit"><?php echo lang('att_submit'); ?></button>
                                <button class="btn default" type="reset"><?php echo lang('refresh'); ?></button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                        <!-- END FORM-->
                    </div>
                </div>
                <!-- END REHEARSALPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
<!-- END CONTENT -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="assets/admin/pages/scripts/table-advanced.js"></script>
<script>
    jQuery(document).ready(function () {
        //here is auto reload after 1 second for time and date in the top
        jQuery(setInterval(function () {
            jQuery("#result").load("index.php/home/iceTime");
        }, 1000));
    });
</script>
