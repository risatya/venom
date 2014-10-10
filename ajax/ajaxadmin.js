function login() {
//   alert("edUser=" + $("#username").val() + "&edPassword=" + $("#edpass").val());
        $(document).ready(function() {
            $.ajax({
                url: getBaseURL() + "index.php/admin/login/",
                data: "edUser=" + $("#username").val() + "&edPassword=" + $("#edpass").val(),
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
                    if (json.data) {
//                    onload();
                        document.location = json.location;
                    } else
                    {
                        alert("Login Anda Salah Silahkan di ulangi");
                    }
                },
                error: function(xmlHttpRequest, textStatus, errorThrown) {
                    start = xmlHttpRequest.responseText.search("<title>") + 7;
                    end = xmlHttpRequest.responseText.search("</title>");
                    errorMsg = xmlHttpRequest.responseText;
                    if (start > 0 && end > 0)
                        alert("Rangerti " + errorMsg + xmlHttpRequest.responseText + "  [" + xmlHttpRequest.responseText.substring(start, end) + "]");
                    else
                        alert("Error juga " + errorMsg + xmlHttpRequest.responseText);
                }
            });
        });
    
}
function enterpress() {
    $(document).ready(function() {
        $("#edpass").keypress(function(event) {
            if (event.which == 13) {
                login();
            }

        });

    });
}
enterpress();