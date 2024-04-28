
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <?php echo lang('sub_asfc'); ?> <small></small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i><?php echo lang('home'); ?>
                        
                    </li>
                    <li>
                        <?php echo lang('sub_song'); ?>
                        
                    </li>
                    <li>
                        <?php echo lang('sub_add_song'); ?>
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
                <?php if (!empty($success)) {
                    echo $success;
                } ?>
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box purple ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-Resource"></i> <?php echo lang('sub_add_new_subj'); ?>
                        </div>
                        <div class="tools">
                            <a href="" class="collapse">
                            </a>
                            <a href="" class="reload">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <?php $form_attributs = array('class' => 'form-horizontal', 'role' => 'form');
                        echo form_open('songs/addSong', $form_attributs);
                        ?>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> <?php echo lang('Choir'); ?> <span class="requiredStar"> * </span></label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="Choir_id" data-validation="required" data-validation-error-msg="">
                                            <option value=""><?php echo lang('select'); ?></option>
                                            <?php foreach ($Choir as $row) { ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['Choir_title']; ?></option>
<?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label"> <?php echo lang('sub_title'); ?> <span class="requiredStar">  </span></label>
                                    <div class="col-md-6">
                                        <input type="text" name="song class="form-control" placeholder="Song title here" data-validation="required" data-validation-error-msg="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> <?php echo lang('sub_edition'); ?> <span class="requiredStar">  </span></label>
                                    <div class="col-md-6">
                                        <input type="text" name="edition" class="form-control" placeholder="Song Edition here">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> <?php echo lang('sub_aut_name'); ?> <span class="requiredStar">  </span></label>
                                    <div class="col-md-6">
                                        <input type="text" name="writer_name" class="form-control" placeholder="Song Authore Name here">
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label class="col-md-3 control-label"> <?php echo lang('sub_opt_subj'); ?> </label>
                                        <div class="radio-list">
                                                <label class="radio-inline">
                                                <input type="radio" name="optionalSong" id="optionsRadios4" value="1"> Yes </label>
                                                <label class="radio-inline">
                                                <input type="radio" name="optionalSong" id="optionsRadios5" value="0" checked> No </label>
                                        </div>
                                </div>
                            </div>
                            <div class="form-actions fluid">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" name="submit" class="btn green" value="Add Song"> <?php echo lang('sub_addsub_but'); ?> </button>
                                    <button type="reset" class="btn default"> <?php echo lang('cancel'); ?> </button>
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
<script>
    jQuery(document).ready(function() {
//here is auto reload after 1 second for time and date in the top
        jQuery(setInterval(function() {
            jQuery("#result").load("index.php/home/iceTime");
        }, 1000));
    });
</script>
<script src="assets/global/plugins/jquery.form-validator.min.js" type="text/javascript"></script>
<script> $.validate(); </script>
