<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
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
                    <?php echo lang('exa_eea'); ?><small></small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <?php echo lang('home'); ?>
                        
                    </li>
                    <li>
                        <?php echo lang('header_academic'); ?>
                        
                    </li>
                    <li>
                        <?php echo lang('header_rehearsalina'); ?>
                        
                    </li>
                    <li>
                        <?php echo lang('header_exa_attan'); ?>
                        
                    </li>
                    <li>
                        <?php echo lang('exa_eea'); ?>
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
                            <?php echo lang('exa_eseai'); ?>
                        </div>
                        <div class="tools">
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <?php $form_attributs = array('class' => 'form-horizontal', 'role' => 'form');
                        $id = $this->input->get('id');
                        echo form_open("rehearsal/editRehearsalAttendance?id=$id", $form_attributs);
                        ?>
                            <?php $i = 1;
                            foreach ($rehearsalAttendanceInf as $row) {
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
                                                <?php
                                                $att = $row['attendance'];
                                                if ($att == 'P') {
                                                    ?>
                                                    <option value="P" class="rehearsalAttendancePresent"><?php echo lang('exa_present'); ?></option>
                                                <?php } else { ?>
                                                    <option value="A" class="rehearsalAttendanceAbsent"><?php echo lang('exa_absent'); ?></option>
    <?php } ?>
                                                <option value="P"><?php echo lang('exa_present'); ?></option>
                                                <option value="A"><?php echo lang('exa_absent'); ?></option>
                                            </select> 
                                        </div>
                                    </div>
                                </div>
    <?php $i++;
}
?>

                            <div class="form-actions fluid">
                                <div class="col-sm-offset-3 col-md-9">
                                    <button class="btn green" type="submit" name="submit" value="Update"><?php echo lang('exa_update'); ?></button>
                                    <button onclick="location.href = 'javascript:history.back()'" type="button" class="btn blue"><?php echo lang('back'); ?></button>
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
    jQuery(document).ready(function() {
    //here is auto reload after 1 second for time and date in the top
        jQuery(setInterval(function() {
            jQuery("#result").load("index.php/home/iceTime");
        }, 1000));
    });
</script>