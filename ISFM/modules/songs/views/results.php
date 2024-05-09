<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <?php echo lang('testing_song'); ?> <small></small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>Home
                    </li>
                    <li>
                        <?php echo lang('sub_song'); ?>
                    </li>
                    <li>
                        <?php echo lang('header_ass_opt_sub'); ?>
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
                            <i class="fa fa-book"></i> <?php echo lang('ref_song'); ?>
                        </div>
                        <div class="tools">
                            <a href="" class="collapse">
                            </a>
                            <a href="" class="reload">
                            </a>
                        </div>
                    </div>
                <div class="portlet-body" style="overflow-y: auto; max-height: 400px;">
                        <!-- First image and title -->
                        <div style="margin-bottom:20px;">
                            <?php
                                $images_dir = 'Images';
                                $images = glob($images_dir . '/*.png');
                                if ($images) {
                                    $first_image = $images[1]; // Assuming the first image in the directory is the second one in HTML
                                    echo '<img src="' . $first_image . '" alt="First Image" style="display:block;margin:auto;width:800px;">';
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="portlet box purple ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-book"></i> <?php echo lang('test_song'); ?>
                        </div>
                        <div class="tools">
                            <a href="" class="collapse">
                            </a>
                            <a href="" class="reload">
                            </a>
                        </div>
                    </div>
                <div class="portlet-body" style="overflow-y: auto; max-height: 400px;">
                        <!-- Second image and title -->
                        <div style="margin-bottom:20px;">
                            <?php
                                if ($images && count($images) > 1) {
                                    $second_image = $images[0]; // Assuming the second image in the directory is the first one in HTML
                                    echo '<img src="' . $second_image . '" alt="Second Image" style="display:block;margin:auto;width:800px;">';
                                }
                            ?>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->
<script>
    window.addEventListener('beforeunload', function() {
        // Make an AJAX request to the PHP function to delete files
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'index.php/songs/deleteFiles', true); // Adjust the URL as per your controller and route
        xhr.send();
    });
</script>


