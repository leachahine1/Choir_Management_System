<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <?php echo lang('exa_ct_result'); ?><small></small>
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
                        <?php echo lang('header_rehearsal_resu'); ?>
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
                            <i class="fa fa-bars"></i> <?php echo lang('exa_result_board'); ?>
                        </div>
                        <div class="tools">
                            <a href="" class="collapse">
                            </a>
                            <a href="" class="reload">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="tiles">
                            <div class="col-md-12 resultMotherDiv">
                                <?php
                                // if (!empty($result)) {
                                    // var_dump($result); // Add this to see what's inside $result

                                    foreach ($result as $row) {
                                        ?>
                                        <a href="index.php/rehearsal/fullResult?Choir=<?php echo $row['Choir_id']; ?>&rehearsal=<?php echo $row['rehearsal_title']; ?>">
                                            <div class="tile bg-purple">
                                                <div class="tile-body">
                                                    <i class="fa fa-th-list"></i>
                                                </div>
                                                <div class="tile-object">
                                                    <div class="name tile-object_one">
                                                        <?php echo $this->common->Choir_title($row['Choir_id']); ?>
                                                    </div>
                                                    <div class="name tile-object_two">
                                                        <?php echo $row['rehearsal_title']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <?php
                                    }
                                // } else {
                                    ?>
                                    <!-- <h1 class="textAlignCenter"><?php echo lang('exa_rwnpni'); ?></h1> -->
                                <?php
                            //  }
                              ?>
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
    function ChoirSection(str) {
        var xmlhttp;
        if (str.length === 0) {
            document.getElementById("ajaxResult").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                document.getElementById("ajaxResult").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "index.php/rehearsal/ajaxChoirRehearsal?q=" + str, true);
        xmlhttp.send();
    }
</script>
<script>
    jQuery(document).ready(function () {
//here is auto reload after 1 second for time and date in the top
        jQuery(setInterval(function () {
            jQuery("#result").load("index.php/home/iceTime");
        }, 1000));
    });
</script>