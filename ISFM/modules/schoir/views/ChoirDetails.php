<link href="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="assets/admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Choir Details <small> Information</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>Home
                        
                    </li>
                    <li>
                        Choir
                        
                    </li>
                    <li>
                        All Choir
                    </li>
                    <li id="result" class="pull-right topClock"></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <?php foreach ($Choir as $row){
            $Choir_id = $row['id'];
            $ChoirTile = $row['Choir_title'];
            $totalChoir_member = $row['Choir_member_amount'];
        }?>
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="portlet sale-summary">
                            <div class="portlet-title">
                                <div class="caption">
                                    <?php echo $ChoirTile; ?>  Information
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="reload">
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <ul class="list-unstyled">
                                    <li>
                                        <span class="sale-info">
                                            Total Choir_members
                                        </span>
                                        <span class="sale-num">
                                            <?php echo $totalChoir_member; ?> </span>
                                    </li>
                                    <li>
                                        <span class="sale-info">
                                            Section <i class="fa fa-img-down"></i>
                                        </span>
                                        <span class="sale-num">
                                            <?php echo $ChoirSection; ?> </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-9 profile-info datilsBodyMB">
                        <div class="portlet box purple">
                            <div class="portlet-title">
                                <div class="caption">
                                    <?php echo $ChoirTile; ?> Songs And Section_leaders
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse">
                                    </a>
                                    <a href="javascript:;" class="reload">
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                    #
                                                </th>
                                                <th>
                                                    Song Title
                                                </th>
                                                <th>
                                                    Song Section_leader
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; foreach($song as $row){?>
                                            <tr>
                                                <td>
                                                    <?php echo $no; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['song_title']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['song_section_leader']; ?>
                                                </td>

                                            </tr>
                                            <?php $no++; }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end row-->
                <div class="row">

                    <div class="col-md-12 profile-info datilsBodyMB">
                        <div class="portlet box purple">
                            <div class="portlet-title">
                                <div class="caption">
                                    <?php echo $ChoirTile; ?> Weekly Choir Routine
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse">
                                    </a>
                                    <a href="javascript:;" class="reload">
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body ChoirDetailsColor">
                                <?php
                                foreach ($day as $row3) {
                                    $dayTitle = $row3['day_name'];
                                    $dayStatus = $row3['status'];
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12 dbilcss5">
                                            <div class="col-sm-2 day <?php echo $dayStatus; ?>">
                                                <?php echo $dayTitle; ?>
                                            </div>
                                            <?php
                                            //$query = array();
                                            $query = $this->Choirmodel->getWhere('Choir_routine', 'day_title', $dayTitle, 'Choir_id', $Choir_id);
                                            foreach ($query as $row4) {
                                                ?>
                                                <div class="col-sm-2 song dbilcss6">

                                                    <p class="dbilcss7"><?php echo $row4['song']; ?></p>
                                                    <p class="dbilcss7"><?php echo $row4['song_section_leader']; ?></p>
                                                    <p class="dbilcss8"><?php echo $row4['start_time']; ?> - <?php echo $row4['end_time']; ?></p>
                                                    <p class="dbilcss8">Rome: <?php echo $row4['room_number']; ?></p>

                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>

                </div>
                        <div class="col-md-offset-3 col-md-6">
                            <a class="btn blue btn-block ChoirDetailsFont" href="javascript:history.back()">
                                <i class="fa fa-mail-reply-all"></i> Go Back </a>
                        </div>
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
