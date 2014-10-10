<div id="content" style="background: #fff;">
    <script language="javascript" type="text/javascript">
        function readmore(idx) {
            $(document).ready(function() {
                $.ajax({
                    url: getBaseURL() + "index.php/client/readmore/",
                    data: "idx=" + idx,
                    cache: false,
                    dataType: 'json',
                    type: 'POST',
                    beforeSend: function() {
                        $('#top').append('<div id="pageload"></div>');
                    },
                    complete: function() {
                        $('#pageload').remove();

                    },
                    success: function(json) {
                        
                        $("#body").html(json.data);
//                        $("#mores_"+idx).html('');
//                        $("#readmore_"+idx).addClass("read"+idx);

                    },
                    error: function(xmlHttpRequest, textStatus, errorThrown) {
                        start = xmlHttpRequest.responseText.search("<title>") + 7;
                        end = xmlHttpRequest.responseText.search("</title>");
                        errorMsg = " ";
                        if (start > 0 && end > 0)
                            alert("undifine " + errorMsg + xmlHttpRequest.responseText + "  [" + xmlHttpRequest.responseText.substring(start, end) + "]");
                        else
                            alert("Error  " + errorMsg + xmlHttpRequest.responseText);
                    }
                });
            });
        }
    </script>
    <div id="header">
        <img style="width: 700px; margin-left: 0px;" src="<?php echo base_url(); ?>images/mountains.jpg" alt="">
        <h1>OUR CLIENT</h1>
    </div>
    <div id="body" style="padding-bottom: 20px;" class="replace">

        <?php foreach ($results as $data) { ?>
            <h3><?php echo $data->history ?></h3>
            <img src="<?php echo $data->img ?>" alt=""></br>
            <div id="readmore_<?php echo $data->idx ?>" style="width: 670px;margin: auto;"><?php echo $data->readmore ?></div></br>
            <a style="cursor: pointer;text-decoration: none;margin-left: 15px;color: #f47741;font-size: 14px;" class="more" onclick="readmore(<?php echo $data->idx ?>)" id="mores_<?php echo $data->idx ?>">Read more...</a>
            <p style="border-bottom: 1px solid #ccc;margin: 30px;"></p>
        <?php } ?>

        <p style="margin:10px;"><?php echo $links; ?></p>
    </div>

</div>

