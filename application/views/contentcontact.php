<script src="<?php echo base_url(); ?>ajax/baseurl.js"></script>
<script language="javascript" type="text/javascript">
    function sendTomail() {
        $(document).ready(function() {
            $.ajax({
                url: getBaseURL() + "index.php/contact/sendTomail/",
                data: "name=" + $("#name").val() + "&email2=" + $("#email2").val() + "&message=" + $("#message").val(),
                cache: false,
                dataType: 'json',
                type: 'POST',
                beforeSend: function() {
                    $('#top').append('<div id="pageload"></div>');
                },
                complete: function() {
                    $('#pageload').remove();

                },
                success: function(msg) {
                    alert("Message Has been Send");


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
<section id="content">
    <div class="padding">
        <div class="wrapper margin-bot">
            <div class="col-3" style="width: 535px;">
                <div class="indent">
                    <h2 class="p0">Contact Form</h2>
                    <form id="contact-form">					
                        <fieldset>
                            <span class="text-form">Name:</span><input name="name" type="text" id="name"/> <br />
                            <span class="text-form">Email:</span><input name="email2" type="text" id="email2"/>   <label>&nbsp;</label>
                            <div class="wrapper" style="display:none"><div class="text-form">Message:</div><textarea id="message"></textarea></div>
                            <div class="buttons" style="margin-top:50px">
                                <a class="button-2" href="#" onClick="document.location.href='<?php echo base_url(); ?>product/23'">Clear</a>
                                <a class="button-2" href="#" onClick="sendTomail();">Send</a>
                            </div>									 
                        </fieldset>						
                    </form>
                </div>

            </div>
            <div class="col-4">
                <div class="block-news">
                    <h3 class="color-4 indent-bot2">Contacts</h3>
                    
                    <dl class="contact p3">
                        <dt><span>Our Address:</span><?php echo @$this->modelcontact->getlastcontact(0, 1, 'DESC')->alamat; ?></dt>
                        <!--<dd>Yogyakarta-Indonesia 55281</dd>-->
                        <dd><span>Phone : </span><?php echo @$this->modelcontact->getlastcontact(0, 1, 'DESC')->no_tlp1; ?></dd>
                    </dl>
                    <h3 class="color-4 indent-bot2">Representative Office :</h3>
                    <p><?php echo @$this->modelcontact->getlastcontact(0, 1, 'DESC')->alamat; ?></p>
                    <!--<p>Kel Sepinggan Raya-Balikpapan Indonesia76115</p>-->
                    <p>Phone : <?php echo @$this->modelcontact->getlastcontact(0, 1, 'DESC')->no_tlp1; ?></p>
                    <p>Fax     : <?php echo @$this->modelcontact->getlastcontact(0, 1, 'DESC')->no_tlp2; ?></p>
                </div>
            </div>
        </div>

    </div>
</section>
