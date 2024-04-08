<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <?php echo lang('header_sub_result'); ?>
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
                        <?php echo lang('header_sub_result'); ?>
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
                <div class="portlet box green ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-bars"></i> <?php echo lang('header_sub_result'); ?>
                        </div>
                        <div class="tools">
                            <a href="" class="collapse">
                            </a>
                            <a href="" class="reload">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <?php
                        $form_attributs = array('class' => 'form-horizontal', 'role' => 'form');
                        echo form_open('rehearsal/submitResult', $form_attributs);
                        ?>
                        <?php $user = $this->ion_auth->user()->row(); ?>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"> <?php echo lang('exa_sub_tit'); ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="" name="rehearsalTitle" value="<?php echo $songTitle; ?>" readonly="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"> <?php echo lang('exa_Choir') ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-6">
                                    <input class="form-control" type="hidden" name="Choir_id" value="<?php echo $Choir_id; ?>" readonly="">
                                    <input class="form-control" type="text" name="Choir" value="<?php echo $this->common->Choir_title($Choir_id); ?>" readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> <?php echo lang('exa_section_leader_name'); ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" name="section_leaderName" value="<?php echo $user->username; ?>" readonly="">

                                </div>
                            </div>
                            <input class="form-control" type="hidden" name="rehearsalRutinID" value="<?php echo $rehearsalRUtinID; ?>">
                            <input class="form-control" type="hidden" name="rehearsalId" value="<?php echo $rehearsalId; ?>">
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <?php echo lang('exa_gtmagp'); ?>
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
                                                        <?php echo lang('exa_ct_sn'); ?> Choir_member Name
                                                    </th>
                                                    <th>
                                                        <?php echo lang('exa_ct_sid'); ?> Choir_member ID
                                                    </th>
                                                    <th>
                                                        <?php echo lang('exa_ct_result'); ?> Result
                                                    </th>
                                                    <th>
                                                        <?php echo lang('exa_ct_grade'); ?> Grade
                                                    </th>
                                                    <th>
                                                        <?php echo lang('exa_ct_toma'); ?> Total Mark
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;
                                                foreach ($Choir_members as $row) {
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $row['roll_number']; ?>
                                                            <input type="hidden" name="rollNumber_<?php echo $i; ?>" value="<?php echo $row['roll_number']; ?>">
                                                        </td>
                                                        <td>
                                                            <?php echo $row['Choir_member_title']; ?>
                                                            <input type="hidden" name="Choir_memberTitle_<?php echo $i; ?>" value="<?php echo $row['Choir_member_title']; ?>">
                                                        </td>
                                                        <td>
                                                            <?php echo $row['Choir_member_id']; ?>
                                                            <input type="hidden" name="Choir_memberId_<?php echo $i; ?>" value="<?php echo $row['Choir_member_id']; ?>">
                                                        </td>
                                                        <td>
                                                            <select class="form-control editresultSelect" name="result_<?php echo $i; ?>"  data-validation="required" data-validation-error-msg="">
                                                                <option value=""> Select.... </option>
                                                                <option value="Pass"> <?php echo lang('exa_pass'); ?> </option>
                                                                <option value="Fail"> <?php echo lang('exa_fail'); ?> </option>
                                                                <option value="Absent"> <?php echo lang('exa_absent'); ?> </option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control editresultSelect" name="gread_<?php echo $i; ?>"  data-validation="required" data-validation-error-msg="">
                                                                <option value="">  </option>
                                                                <?php
                                                                foreach ($gread as $row1) {
                                                                    $pre_point = $row1['point'];
                                                                    $Choir_member_id = $row['Choir_member_id'];
                                                                    if ($this->rehearsalmodel->che_opt_sub($Choir_member_id, $songTitle)) {
                                                                        $point = $pre_point - 2;
                                                                    } else {
                                                                        $point = $pre_point;
                                                                    }
                                                                    ?>
                                                                    <option value="<?php echo $row1['grade_name']; ?>,<?php echo $point; ?>"> <?php echo $row1['grade_name']; ?> </option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="text" name="totalMark_<?php echo $i; ?>" placeholder="<?php echo lang('exa_ct_toma'); ?>"  data-validation="required" data-validation-error-msg="">
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <input class="form-control" type="hidden" name="ivalue" value="<?php echo $i; ?>"/>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions fluid">
                            <div class="col-md-offset-3 col-md-6">
                                <button type="submit" class="btn green" name="submit"><?php echo lang('exa_subm_res'); ?></button>
                                <button onclick="location.href = 'javascript:history.back()'" class="btn default"><?php echo lang('back'); ?></button>
                                <button type="reset" class="btn red"><?php echo lang('refresh'); ?></button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
<!-- END CONTENT -->
<script src="assets/global/plugins/jquery.form-validator.min.js" type="text/javascript"></script>
<script> $.validate();</script>
<script>
    jQuery(document).ready(function () {
//here is auto reload after 1 second for time and date in the top
        jQuery(setInterval(function () {
            jQuery("#result").load("index.php/home/iceTime");
        }, 1000));
    });
</script>
