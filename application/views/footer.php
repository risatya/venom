<!-- footer -->
<footer>
    <div class="row-top">
        <div class="row-padding">
            <div class="wrapper">
                <div class="col-1">
                    <h4>Representative Office</h4>
                    <dl class="address">
                        <p><?php echo @$this->modelcontact->getlastcontact(0, 1, 'DESC')->alamat; ?></p>

                        <p> <?php echo @$this->modelcontact->getlastcontact(0, 1, 'DESC')->no_tlp1; ?></p>
                        <p> <?php echo @$this->modelcontact->getlastcontact(0, 1, 'DESC')->no_tlp2; ?></p>
                    </dl>
                </div>
                <div class="col-2">
                    <h4>Follow Us:</h4>
                    <ul class="list-services">
                        <li class="item-1"><a href="<?php echo @$this->modelcontact->getlastcontact(0, 1, 'DESC')->fb; ?>">Facebook</a></li>
                    </ul>
                </div>
                <div class="col-3">
                    <h4>Site Map</h4>
                    <ul class="list-1">
                       <?php $query = $this->modelcategory->getListcategorybybaret(0, 10, 0, 'DESC');
                        foreach ($query->result() as $row) {

                        if(!empty($row->link)){
                        $link=  base_url().''.$row->link.'/'.$row->idx;
                        }else{
                        $link=  base_url();
                        }?>
                        <li><a href="<?php echo @$link; ?>"><?php echo @$row->category ?></a></li>
                       
                       <?php }?>
                    </ul>
                </div>
                <div class="col-4">
                    <div class="indent3">
                        <strong class="footer-logo"><strong>VENOMRXS</strong></strong>
                        <p></p>
                        <p><?php echo @$this->modelcontact->getlastcontact(0, 1, 'DESC')->alamat; ?></p>
                        <!--<p>Yogyakarta-Indonesia 55281</p>-->
                        <p><?php echo @$this->modelcontact->getlastcontact(0, 1, 'DESC')->no_tlp1; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row-bot">
        <div class="aligncenter">
            <p class="p0"><a href="#" target="_blank">Website Template</a> by Smart Designer</p>
            <a href="#" target="_blank">3D Models</a> provided by Smart Designer<br>
            <!-- {%FOOTER_LINK} -->
        </div>
    </div>
</footer>
</div>
</div>
<?php echo $script; ?>
</body>
</html>
