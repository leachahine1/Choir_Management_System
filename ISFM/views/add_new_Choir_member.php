<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <?php echo lang('admi_page_title'); ?> <small></small>
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
                        <?php echo lang('header_admission'); ?>
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
                            <i class="fa fa-bars"></i> <?php echo lang('admi_form_title'); ?>
                        </div>
                        <div class="tools">
                            <a href="" class="collapse">
                            </a>
                            <a href="" class="reload">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <?php $form_attributs = array('class' => 'form-horizontal', 'role' => 'form', 'name' => 'myForm', 'onsubmit' => 'return validateForm()');
                        echo form_open_multipart('users/admission', $form_attributs);
                        ?>
                        <div class="form-body">
                            <?php
                            if (!empty($success)) {
                                echo $success;
                            }
                            ?>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('admi_FirstName'); ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="" name="first_name" data-validation="required" data-validation-error-msg="<?php echo lang('First name is required field.'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('admi_LastName'); ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="" name="last_name" data-validation="required" data-validation-error-msg="<?php echo lang('admi_LastName_error_msg'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('admi_FatherName'); ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="father_name" placeholder="" data-validation="required" data-validation-error-msg="<?php echo lang('admi_FatherName_error'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('admi_MotherName'); ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="mother_name" placeholder="" data-validation="required" data-validation-error-msg="<?php echo lang('admi_MotherName_error_msg'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3"><?php echo lang('admi_DateOfBirth'); ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-4">
                                    <input class="form-control" name="birthdate" id="mask_date2" type="text" data-validation="required" data-validation-error-msg="<?php echo lang('admi_DateOfBirth_error_msg'); ?>">
                                    <span class="help-block">
                                        Date Type  DD/MM/YYYY </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('admi_Sex'); ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-4 marginLeftSex">
                                    <div class="radio-list">
                                        <label class="radio-inline">
                                            <input type="radio" name="sex" id="optionsRadios4" value="Male" data-validation="required" data-validation-error-msg="<?php echo lang('admi_sex_error_msg'); ?>"><?php echo lang('admi_Male'); ?></label>
                                        <label class="radio-inline">
                                            <input type="radio" name="sex" id="optionsRadios5" value="Female"> <?php echo lang('admi_Female'); ?> </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="sex" id="optionsRadios6" value="Other"> <?php echo lang('admi_Other'); ?> </label>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="col-md-3 control-label"> <?php echo lang('admi_PermanentAddress'); ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="permanent_address" rows="3" data-validation="required" data-validation-error-msg="<?php echo lang('admi_PermanentAddress_error_msg'); ?>"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> <?php echo lang('admi_PhoneNumber'); ?> <span class="requiredStar"> * </span></label>
                                
                                    <div class="col-md-1">
                                        <input type="text" class="form-control" name="phoneCode" placeholder="+880"  data-validation="required" data-validation-error-msg="" value="<?php if(!empty($countryPhoneCode)){echo $countryPhoneCode;}?>">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="phone" placeholder=""  data-validation="required" data-validation-error-msg="">
                                        <span class="help-block">
                                            1600-000000</span>
                                    </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('admi_Email'); ?><span class="requiredStar"> * </span></label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" onkeyup="checkEmail(this.value)" placeholder="demo@demo.com" name="email" data-validation="email required" data-validation-error-msg="<?php echo lang('admi_Email_error_msg'); ?>">
                                    <span class="help-block">This Choir_member can login his profile by this Email and Password </span>
                                    <div id="checkEmail" class="col-md-12"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> <?php echo lang('admi_Password'); ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password" placeholder="" data-validation="required" data-validation-error-msg="<?php echo lang('Password field is required field.'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('admi_ConfirmPassword'); ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirm" placeholder="" data-validation="required" data-validation-error-msg="<?php echo lang('admi_ConfirmPassword_error_msg'); ?>">
                                </div>
                            </div>
                          
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo lang('admi_Choir'); ?> <span class="requiredStar"> * </span></label>
                                <div class="col-md-6">
                                    <select name="Choir" onchange="ChoirInfo(this.value)" class="form-control" data-validation="required" data-validation-error-msg="<?php echo lang('admi_Choir_error_msg');?>">
                                        <option value=""><?php echo lang('admi_select_Choir');?></option>
<?php foreach ($s_Choir as $row) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['Choir_title']; ?></option>
<?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div id="txtHint">

                            </div>


                            <div class="alert alert-success">
                                <?php echo lang('admi_submit_doc');?>
                            </div>
                           
                        </div>
                        <div class="form-actions fluid">
                            <div class="col-md-offset-3 col-md-6">
                                <button type="submit" class="btn green" name="submit" value="submit"><?php echo lang('save');?></button>
                                <button type="reset" class="btn default"><?php echo lang('refresh');?></button>
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


<!-- BEGIN PAGE LEVEL script -->
<script type="text/javascript" src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript" src="assets/global/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
<script type="text/javascript" src="assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script src="assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
<script src="assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/components-form-tools.js"></script>
<script src="assets/global/plugins/jquery.form-validator.min.js" type="text/javascript"></script>
<script> $.validate(); </script>
<script>
    jQuery(document).ready(function() {
        ComponentsFormTools.init();
    });
</script>
<script type="text/javascript">
    var RecaptchaOptions = {
        theme: 'custom',
        custom_theme_widget: 'recaptcha_widget'
    };
</script>
<script>
    function ChoirInfo(str) {
        var xmlhttp;
        if (str.length === 0) {
            document.getElementById("txtHint").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "index.php/users/Choir_member_info?q=" + str, true);
        xmlhttp.send();
    }
    function checkEmail(str) {
        var xmlhttp;
        if (str.length === 0) {
            document.getElementById("checkEmail").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                document.getElementById("checkEmail").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "index.php/commonController/checkEmail?val=" + str, true);
        xmlhttp.send();
    }
</script>
<script>
    jQuery(document).ready(function() {
//here is auto reload after 1 second for time and date in the top
        jQuery(setInterval(function() {
            jQuery("#result").load("index.php/home/iceTime");
        }, 1000));
    });
</script>
<!-- END PAGE LEVEL script -->