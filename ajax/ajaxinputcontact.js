
function cancel() {
    $(document).ready(function() {
        document.location.reload();
    });
}



function save() {
    $(document).ready(function() {

        $.ajax({
            url: getBaseURL() + "index.php/inputcontact/save/",
            data: "idx=" + $("#idx").val() + "&name_company=" + encodeURIComponent($("#name_company").val()) +  "&alamat=" + encodeURIComponent($("#alamat").val()) + "&no_tlp1=" + encodeURIComponent($("#no_tlp1").val()) + "&no_tlp2=" + encodeURIComponent($("#no_tlp2").val()) + "&hp1=" +encodeURIComponent( $("#hp1").val() )+ "&hp2=" + encodeURIComponent($("#hp2").val() )+ "&hp3=" + encodeURIComponent($("#hp3").val()) + "&email=" + encodeURIComponent($("#email").val() )+ "&fb=" + encodeURIComponent($("#fb").val()) + "&twitter=" + encodeURIComponent($("#twitter").val()) + "&gplus=" +encodeURIComponent( $("#gplus").val())+ "&pin=" + encodeURIComponent($("#pin").val())+ "&username=" + encodeURIComponent($("#username").val())+ "&passwd=" +encodeURIComponent( $("#passwd").val()),
            cache: false,
            dataType: 'json',
            type: 'POST',
            beforeSend: function() {
                $('#top').append('<div id="pageload"></div>');
            },
            complete: function() {
                $('#pageload').remove();
                alert("Data Saved");
            },
            success: function(msg) {
//                clear();
                cancel();

            },
            error: function(xmlHttpRequest, textStatus, errorThrown) {
                start = xmlHttpRequest.responseText.search("<title>") + 7;
                end = xmlHttpRequest.responseText.search("</title>");
                errorMsg = " ";
                if (start > 0 && end > 0)
                    alert("Rangerti " + errorMsg + xmlHttpRequest.responseText + "  [" + xmlHttpRequest.responseText.substring(start, end) + "]");
                else
                    alert("Error juga " + errorMsg + xmlHttpRequest.responseText);
            }
        });
    });
}


