<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <?php echo lang('exa_check_re_sheet'); ?> <small></small>
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
                        <?php echo lang('header_app_res_she'); ?>
                    </li>
                    <li>
                        <?php echo lang('exa_check_re_sheet'); ?>
                    </li>
                    <li id="result" class="pull-right topClock"></li>


                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12 ">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box purple ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-bars"></i> <?php
                            echo lang('exa_che_t_1');
                            echo $rehearsalTitle;
                            echo lang('exa_che_t_2');
                            echo ' ' . $this->common->Choir_title($Choir_id);
                            ?>,  <?php echo lang('exa_che_t_3'); ?>  " <?php echo $song; ?> " 
                        </div>
                        <div class="tools">
                            <a href="" class="collapse">
                            </a>
                            <a href="" class="reload">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label textAlignRight"> <?php echo lang('exa_etit'); ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Title here" name="rehearsalTitle" value="<?php echo $rehearsalTitle; ?>" readonly="">
                                </div><div class="clearfix"> </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label textAlignRight"> <?php echo lang('exa_Choir'); ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" name="Choir" value="<?php echo $this->common->Choir_title($Choir_id); ?>" readonly="">
                                </div><div class="clearfix"> </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label textAlignRight"> <?php echo lang('exa_section_leader_name'); ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" name="section_leaderName" value="<?php echo $section_leader; ?>" readonly="">
                                </div><div class="clearfix"> </div>
                            </div>
                            <div class="portlet box purple">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <?php echo lang('exa_asr'); ?>
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                        <a href="javascript:;" class="reload"></a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <?php echo lang('exa_ct_role'); ?>
                                                    </th>
                                                    <th>
                                                        <?php echo lang('exa_ct_sn'); ?>
                                                    </th>
                                                    <th>
                                                        <?php echo lang('exa_ct_sid'); ?>
                                                    </th>
                                                    <th>
                                                        <?php echo lang('exa_ct_result'); ?>
                                                    </th>
                                                    <th>
                                                        <?php echo lang('exa_ct_grade'); ?>
                                                    </th>
                                                    <th>
                                                        <?php echo lang('exa_ct_point'); ?>
                                                    </th>
                                                    <th>
                                                        <?php echo lang('exa_ct_toma'); ?>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($resultShit as $row) { ?>
                                                    <tr>
                                                        <td><?php echo $row['roll_number'] ?></td>
                                                        <td><?php echo $row['Choir_member_name'] ?></td>
                                                        <td><?php echo $row['Choir_member_id'] ?></td>
                                                        <td><?php echo $row['result'] ?></td>
                                                        <td><?php echo $row['grade'] ?></td>
                                                        <td><?php echo $row['point'] ?></td>
                                                        <td><?php echo $row['mark'] ?></td>
                                                        <td>
                                                            <a href="index.php/rehearsal/editResult?id=<?php echo $row['id'] ?>" class="btn btn-xs default"> <i class="fa fa-pencil-square"></i> <?php echo lang('edit'); ?> </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions fluid">
                            <div class="col-md-offset-3 col-md-6">
                                <button onclick="location.href = 'javascript:history.back()'" class="btn default"><?php echo lang('back'); ?></button>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
<!-- END CONTENT -->
<script>
    jQuery(document).ready(function () {
//here is auto reload after 1 second for time and date in the top
        jQuery(setInterval(function () {
            jQuery("#result").load("index.php/home/iceTime");
        }, 1000));
    });
</script>
