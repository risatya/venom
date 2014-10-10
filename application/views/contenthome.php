<section id="content">
    <div class="padding">
        <div class="box-bg margin-bot">
        <table><tr>
 <?php
						$i = 0;
						foreach($isiCat->result() as $row) :
						$i++;
						?> 
                  <td>      
            <div class="wrapper">
                       
                <?php if($i==1){
                   $str="first"; 
                }else if($i==2){
                     $str="second"; 
                }else{
                  $str="third";   
                }
?>
                    <div class="col-1">
                        <div class="box <?php echo $str; ?>">
                            <div class="pad">
                                <div class="wrapper indent-bot">
                                    <strong class="numb img-indent2">0<?php echo $i; ?></strong>
                                    <div class="extra-wrap">
                                        <h3 class="color-<?php echo $i; ?>"><?php echo "$row->category"; if ($row->idx == 20){echo "<br><br>";}?></h3>
                                    </div>
                                </div>
                                <div class="wrapper">
                                    <a class="button img-indent-r" href="<?php echo base_url(); ?>product/sub/<?php echo "$row->idx"; ?>"></a>
                                    <div class="extra-wrap">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
           
            </div>
            </td>
            <?php endforeach; ?>
            </tr></table>
                    </div>
    </div>
</section>
