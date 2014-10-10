<div id="content">
    <div id="header">
        <img src="<?php echo base_url(); ?>images/mountains.jpg" alt="">
        <h1><?php echo $this->modelaboutus->getorderdetailaboutus(0, 1, 'DESC', 1)->title; ?></h1>
    </div>
    <div id="body" style="padding-bottom: 15px;background: #fff;">
        <h3><?php echo $this->modelaboutus->getorderdetailaboutus(0, 1, 'DESC', 1)->title; ?></h3>
        <img src="<?php echo $this->modelaboutus->getorderdetailaboutus(0, 1, 'DESC', 1)->img; ?>" alt=""></br>
        <?php echo $this->modelaboutus->getorderdetailaboutus(0, 1, 'DESC', 1)->description; ?>
    </div>
