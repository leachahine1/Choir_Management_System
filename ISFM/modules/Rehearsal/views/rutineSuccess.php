<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE CONTENT-->
        <?php
        foreach ($rehearsalInfo as $row) {
            $rehearsalID = $row['id'];
            $rehearsalTitle = $row['rehearsal_title'];
            $startDate = $row['start_date'];
            $Choir_title = $this->common->Choir_title($row['Choir_id']);
            $total_time = $row['total_time'];
        }
        ?>
        <div class="row">
            <div class="col-md-12 ">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box green ">
                    <div class="portlet-title">
                        <div class="caption">
                            " <?php echo $rehearsalTitle; ?> " <?php echo lang('exa_rou_succ_1'); ?> " <?php echo $Choir_title; ?> "
                        </div>
                        <div class="tools">
                            <a href="" class="collapse">
                            </a>
                            <a href="" class="reload">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="alert alert-warning">
                            <div class="col-md-12 clearfix">
                                <a class="btn red-sunglo noprint" href="index.php/rehearsal/deleteRehearsalAndRoutine?rehearsalId=<?php echo $rehearsalID; ?>" onclick="javascript:return confirm('<?php echo lang('exa_routi_del_conf'); ?>')"> <?php echo lang('exa_delete_ex_rou'); ?> </a>
                            </div>
                            <div>
                                <button class="btn default printRoutine noprint" onClick="window.print()"> <i class="fa fa-print"></i> <?php echo lang('exa_perou'); ?> </button>
                                <div class="row">
                                    <div class="col-md-12 textAlignCenter">
                                        <H2><?php echo $schoolName; ?></H2>
                                        <p>
                                        <h4 class="rtsh"><?php echo lang('exa_etit'); ?>: <?php echo $rehearsalTitle; ?></h4>
                                        <?php echo lang('exa_start_date'); ?> : <?php echo $startDate; ?><br>
                                        <?php echo lang('exa_Choir'); ?> : <?php echo $Choir_title; ?><br>
                                        <?php echo lang('exa_total_time'); ?> : <?php echo $total_time; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="portlet box green">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <?php echo lang('exa_erdas'); ?>
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
                                                            <?php echo lang('date'); ?>
                                                        </th>
                                                        <th>
                                                            <?php echo lang('exa_sub_tit'); ?>
                                                        </th>
                                                        <th>
                                                            <?php echo lang('exa_sub_code'); ?>
                                                        </th>
                                                        <th>
                                                            <?php echo lang('exa_rnih'); ?>
                                                        </th>
                                                        <th>
                                                            <?php echo lang('exa_start_time'); ?>
                                                        </th>
                                                        <th>
                                                            <?php echo lang('exa_end_time'); ?>
                                                        </th>
                                                        <th>
                                                            <?php echo lang('exa_shift'); ?>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($rutineInfo as $row1) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $i; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row1['rehearsal_date']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row1['rehearsal_song']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row1['song_code']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row1['rome_number']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row1['start_time']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row1['end_time']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $row1['rehearsal_shift']; ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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