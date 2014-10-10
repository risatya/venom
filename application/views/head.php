
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>VENOMRXS.COM - IT'S S VENOMENAL EXCITEMENT!</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/reset.css" type="text/css" media="screen">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" media="screen">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/styletambahan.css" type="text/css" media="screen">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/layout.css" type="text/css" media="screen">
        <link href="<?php echo base_url(); ?>images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.6.min.js"></script>
        <script src="<?php echo base_url(); ?>js/cufon-yui.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/cufon-replace.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/Open_Sans_400.font.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/Open_Sans_Light_300.font.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>js/Open_Sans_Semibold_600.font.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/tms-0.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/tms_presets.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.easing.1.3.js"></script>
        <script src="<?php echo base_url(); ?>js/FF-cash.js" type="text/javascript"></script>

        <link href="<?php echo base_url(); ?>sliders/css/quake.slider.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>sliders/skins/dark-room/quake.skin.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url(); ?>sliders/js/jquery.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>sliders/js/quake.slider-min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>sliders/js/demo.js" type="text/javascript"></script>
		<script type="text/javascript">
			 $(document).ready(function () {
            $('.quake-slider').quake({
                thumbnails: true,
                animationSpeed: 500,
                applyEffectsRandomly: true,
                navPlacement: 'inside',
                navAlwaysVisible: true,
                captionOpacity: '0.3',
                captionsSetup: [
                                 {
                                     "orientation": "top",
                                     "slides": [0, 1],
                                     "callback": captionAnimateCallback
                                 },
                                  {
                                      "orientation": "left",
                                      "slides": [2, 3],
                                      "callback": captionAnimationCallback1
                                  }
                                  ,
                                  {
                                      "orientation": "bottom",
                                      "slides": [4, 5],
                                      "callback": captionAnimateCallback
                                  }
                                  ,
                                  {
                                      "orientation": "right",
                                      "slides": [6, 7],
                                      "callback": captionAnimationCallback1
                                  }
                                ]

            });

            function captionAnimateCallback(captionWrapper, captionContainer, orientation) {
                captionWrapper.css({ left: '-990px' }).stop(true, true).animate({ left: 0 }, 500);
                captionContainer.css({ left: '-990px' }).stop(true, true).animate({ left: 0 }, 500);
            }
            function captionAnimationCallback1(captionWrapper, captionContainer, orientation) {
                captionWrapper.css({ top: '-330px' }).stop(true, true).animate({ top: 0 }, 500);
                captionContainer.css({ top: '-330px' }).stop(true, true).animate({ top: 0 }, 500);
            }
        });
    </script>

    <!--==================================-->
        <!--[if lt IE 7]>
                <div style=' clear: both; text-align:center; position: relative;'>
                        <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://www.theie6countdown.com/images/upgrade.jpg" border="0"  alt="" /></a>
                </div>
        <![endif]-->
        <!--[if lt IE 9]>
                <script type="text/javascript" src="js/html5.js"></script>
                <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen">
        <![endif]-->
    </head>
    <body id="page1">
        <!-- header -->
        <div class="bg">
            <div class="main">
                <header>
                    <div class="row-1">
                        <h1>
                            <a class="logo" href="index.php">Venom RX</a>
                        </h1>
                    	<form action="<?php echo base_url();?>product/searchproduct" method="post">
							<input type="submit" id="button_searching" value="" style="cursor:pointer"><input name="search" id="search_input">
                        </form>
                    </div>
                    <div class="row-2">
                        <nav>
                            <?php echo $menu; ?>
                        </nav>
                    </div>
                    <?php echo $slider; ?>

                </header>
