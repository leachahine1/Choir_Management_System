<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        

        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <?php echo lang('exa_vrs'); ?><small><?php echo lang('exa_aats'); ?></small>
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
                    <li id="result" class="pull-right topClock"></li>

                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-sm-8 ">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box purple ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-bars"></i> <?php echo lang('exa_caatrs'); ?>
                        </div>
                        <div class="tools">
                            <a href="" class="collapse">
                            </a>
                            <a href="" class="reload">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            <?php echo lang('exa_date'); ?>
                                        </th>
                                        <th>
                                            <?php echo lang('exa_clas_title'); ?>
                                        </th>
                                        <th>
                                            <?php echo lang('exa_title'); ?>
                                        </th>
                                        <th>
                                            <?php echo lang('exa_sub'); ?>
                                        </th>
                                        <th>
                                            <?php echo lang('exa_section_leader_name'); ?>
                                        </th>
                                        <th>
                                            <?php echo lang('exa_soapp'); ?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($shitList as $row) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $row['date']; ?>
                                            </td>
                                            <td>
                                                <?php echo $this->common->Choir_title($row['Choir_id']); ?>
                                            </td>
                                            <td>
                                                <?php echo $row['rehearsal_title']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['song']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['section_leader']; ?>
                                            </td>
                                            <td>
                                                <a class=" btn btn-xs purple tableActionButtonMargin" href="index.php/rehearsal/checkResultShit?id=<?php echo $row['id']; ?>" class="btn btn-xs green"> <i class="fa fa-file-text-o"></i> <?php echo lang('exa_che_res'); ?> </a>
                                                <a class=" btn btn-xs yellow tableActionButtonMargin" href="index.php/rehearsal/approuveResultShit?id=<?php echo $row['id']; ?>&class=<?php echo $row['Choir_id']; ?>" class="btn btn-xs yellow"> <i class="fa fa-check"></i> <?php echo lang('exa_acc_res_shee'); ?> </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>
            <div class="col-sm-4 ">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box purple ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-bars"></i> <?php echo lang('exa_comfcr'); ?>
                        </div>
                        <div class="tools">
                            <a href="" class="collapse">
                            </a>
                            <a href="" class="reload">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body form" >
                        <?php foreach ($ChoirAction as $row1) { ?>
                            <a class="btn default btn-block" href="index.php/rehearsal/finalResult?Choir=<?php echo $row1['Choir_id']; ?>&rehearsal=<?php echo $row1['rehearsal_title']; ?>&rehearsalId=<?php echo $row1['rehearsal_id']; ?>&id=<?php echo $row1['id']; ?>"><?php echo $this->common->Choir_title($row1['Choir_id']); ?></a>
                        <?php } ?>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>
        </div>
        <?php if (!empty($message)) {
            echo $message;
        } ?>
        <br>
        <div class="row">
            <div class="col-sm-12 ">
                <div class="publishButton">
                    <a class="btn purple btn-block publishButtonFont" href="index.php/rehearsal/publishResult" onclick="javascript:return dconfirm();"> <?php echo lang('exa_pub_res'); ?></a>
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
    
    function dconfirm(){
        var confirm1 = confirm('Are you sure? You want to publich result today?');
        if (confirm1 === true) {
            return confirm('This school\'s all Choir rehearsal result is now compleate ?');
        }
        return false;
    }
</script>