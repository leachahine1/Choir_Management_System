<?php $user = $this->ion_auth->user()->row(); $userId = $user->id;?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <?php $Choir_id;
                    echo $this->common->Choir_title($Choir_id); ?> <?php echo lang('clas_routine'); ?><small></small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <?php echo lang('home'); ?>
                        
                    </li>
                    <li>
                        <?php echo lang('header_cor_clas'); ?>
                        
                    </li>
                    <li>
                        <?php echo lang('header_stu_timble'); ?>
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
                            <i class="fa fa-bars"></i><?php
                    echo $this->common->Choir_title($Choir_id);;
                    ?> <?php echo lang('clas_full_routine'); ?>
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="javascript:;" class="reload">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body form">

                        <div class="alert alert-warning">
                            <div class="portlet box blue">
<?php if($this->common->user_access('rutin_edit_delete',$userId)){ ?>
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <?php echo lang('clas_eod');
    echo $this->common->Choir_title($Choir_id); echo lang('clas_rb'); ?>
                                        </div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse">
                                            </a>
                                            <a href="javascript:;" class="reload">
                                            </a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                <div class="portlet-body">
                                    <?php
                                    foreach ($day as $row3) {
                                        $dayTitle = $row3['day_name'];
                                        $dayStatus = $row3['status'];
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12 ChoirRoutineRow">
                                                <div class="col-sm-2 day <?php echo $dayStatus; ?>">
                                                <?php echo $dayTitle; ?>
                                                </div>
                                                <?php
                                                //$query = array();
                                                $query = $this->Choirmodel->getWhere('Choir_routine', 'day_title', $dayTitle, 'Choir_id', $Choir_id);
                                                foreach ($query as $row4) {
                                                    ?>
                                                    <div class="">
                                                        <div class="col-sm-2 effect left_to_right songMotherDiv">
                                                            <div class="backDiv song">
                                                                <p><?php echo $row4['song']; ?></p>
                                                                <p><?php echo $row4['song_section_leader']; ?></p>
                                                                <p class="pFontSize"><?php echo $row4['start_time']; ?> - <?php echo $row4['end_time']; ?></p>
                                                                <p class="pFontSize">Rome: <?php echo $row4['room_number']; ?></p>
                                                            </div>
                                                    <?php if($this->common->user_access('rutin_edit_delete',$userId)){ ?>
                                                                <div class="info">
                                                                    <button class="btn blue btn-xs buttonMargin" onclick="window.location.href = 'index.php/sChoir/editRoutine?id=<?php echo $row4['id']; ?>&Choir=<?php echo $Choir_id; ?>'" type="button"><i class="fa fa-cogs"></i> <?php echo lang('edit'); ?></button>
                                                                    <a class="btn btn-xs red buttonMargin" href="index.php/sChoir/deleteRoutine?id=<?php echo $row4['id']; ?>&Choir_id=<?php echo $Choir_id; ?>" onClick="javascript:return confirm('Are you sure you want to delete this song from this Choir routine?')"> <i class="fa fa-trash-o"></i> <?php echo lang('delete'); ?> </a>
                                                                </div>
                                                    <?php } ?>
                                                        </div>
                                                    </div>
                                        <?php } ?>
                                            </div>
                                        </div>
<?php } ?>
                                </div>
                            </div>
                            <div class="form-actions fluid marginTopNone">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn blue col-sm-9 col-xs-12 routineGoBack" type="button" onclick="window.location.href = 'javascript:history.back()'"><?php echo lang('back'); ?></button>
                                </div>
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


<!-- BEGIN GOOGLE RECAPTCHA -->
<script type="text/javascript">
    var RecaptchaOptions = {
        theme: 'custom',
        custom_theme_widget: 'recaptcha_widget'
    };

    $(document).ready(function() {
        $("button").click(function() {
            $("p").toggle();
        });
        
        //here is auto reload after 1 second for time and date in the top
        jQuery(setInterval(function() {
            jQuery("#result").load("index.php/home/iceTime");
        }, 1000));
    });
</script>
