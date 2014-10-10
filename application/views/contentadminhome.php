<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Creati Visia</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Antonius Doni">
        <link href="<?= base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
        <link href="<?= base_url(); ?>assets/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="<?= base_url(); ?>assets/css/style.css" rel="stylesheet">
        <link href="<?= base_url(); ?>assets/css/style-responsive.css" rel="stylesheet">
        <link href="<?= base_url(); ?>assets/trt-ikon/trt-ikon.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url(); ?>assets/js/datepicker/css/datepicker.css" />

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!--<link rel="Shortcut Icon" href="<?= base_url(); ?>gambar/icon.png">-->

    </head>

    <body id="top" class="tooltips">
        <?php echo $content; ?>
        <script src="<?= base_url(); ?>assets/js/jquery.js"></script>
        <script src="<?= base_url(); ?>assets/js/custom.js"></script>

        <script src="<?= base_url(); ?>assets/js/highchart/highcharts.js"></script>
        <script src="<?= base_url(); ?>ajax/baseurl.js"></script>
        <?php echo $ajax; ?>
        <!--NicEdit WYSWYG-->
        <?php date_default_timezone_set('Asia/Jakarta');
        $timenow = date('r');
        $date_added = date('Y', strtotime($timenow));
        $mountyear='01-'.$date_added;$mountyear2='02-'.$date_added;$mountyear3='03-'.$date_added;$mountyear4='04-'.$date_added;$mountyear5='05-'.$date_added;$mountyear6='06-'.$date_added;$mountyear8='08-'.$date_added;$mountyear9='09-'.$date_added;$mountyear10='10-'.$date_added;$mountyear11='11-'.$date_added;$mountyear12='12-'.$date_added;?>
        <script>$(function() {
                $('#line').highcharts({
                    title: {
                        text: 'Monthly Average Visitor',
                        x: -20 //center
                    },
                    subtitle: {
                        text: 'Source: creativisia',
                        x: -20
                    },
                    xAxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                    },
                    yAxis: {
                        title: {
                            text: 'Visitor'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                    },
                    tooltip: {
                        valueSuffix: 'Visitor'
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: [{
                            name: 'Visitor',
                            data: [<?php echo @$this->modelvisited->getSum_visited($mountyear)->jumlah;?>, <?php echo @$this->modelvisited->getSum_visited($mountyear2)->jumlah;?>, <?php echo @$this->modelvisited->getSum_visited($mountyear3)->jumlah;?>,<?php echo @$this->modelvisited->getSum_visited($mountyear4)->jumlah;?>, <?php echo @$this->modelvisited->getSum_visited($mountyear5)->jumlah;?>, <?php echo @$this->modelvisited->getSum_visited($mountyear6)->jumlah;?>, <?php echo @$this->modelvisited->getSum_visited($mountyear7)->jumlah;?>, <?php echo @$this->modelvisited->getSum_visited($mountyear8)->jumlah;?>, <?php echo @$this->modelvisited->getSum_visited($mountyear9)->jumlah;?>, <?php echo @$this->modelvisited->getSum_visited($mountyear10)->jumlah;?>, <?php echo @$this->modelvisited->getSum_visited($mountyear11)->jumlah;?>,<?php echo @$this->modelvisited->getSum_visited($mountyear12)->jumlah;?>]
                        }]
                });
            });</script>

        <!--Datepicker-->
        <script src="<?= base_url(); ?>assets/js/datepicker/js/bootstrap-datepicker.js"></script>
        <script src="<?= base_url(); ?>assets/js/smooth-scroll.js"></script>
        <script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
    </body>
</html>