/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function save() {
    $(document).ready(function() {
       
        $.ajax({
            url: getBaseURL() + "index.php/inputuser/save/",
            data: "idx=" + $("#idx").val() + "&username=" + $("#username").val()+ "&passwd=" + $("#passwd").val()+ "&email=" + $("#email").val()+ "&nama=" + $("#nama").val() ,
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
                clear();
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

function deletedata(idx, title) {
    if (confirm('Hapus data ' + title + ' ?')) {
        $(document).ready(function() {

            $.ajax({
                url: getBaseURL() + "index.php/inputuser/delete/",
                data: "idx=" + idx,
                cache: false,
                dataType: 'json',
                type: 'POST',
                beforeSend: function() {
                    $('#top').append('<div id="pageload"></div>');
                },
                complete: function() {
                    $('#pageload').remove();
                    alert("Data Delete");
                },
                success: function(msg) {
                    clear();
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
}

function clear() {
    $(document).ready(function() {
        $("#idx").val("0");

    });
}



function search(xstart, xSearch) {
    xSearch = "";
    try
    {
        if ($("#edSearch").val() != "") {
            xSearch = $("#edSearch").val();
        }
    } catch (err) {
        xSearch = "";
    }
    if (typeof(xSearch) == "undefined") {
        xSearch = "";
    }
    $(document).ready(function() {

        $.ajax({
            url: getBaseURL() + "index.php/inputuser/search/",
            data: "xstart=" + xstart + "&edSearch=" + xSearch,
            cache: false,
            dataType: 'json',
            type: 'POST',
            success: function(json) {
//                alert(json.tabledata);

                $(".span10").html(json.tabledata);
                enterpress();
            },
            error: function(xmlHttpRequest, textStatus, errorThrown) {
                start = xmlHttpRequest.responseText.search("<title>") + 7;
                end = xmlHttpRequest.responseText.search("</title>");
                errorMsg = " error on search jadwal " + xmlHttpRequest.responseText;
                if (start > 0 && end > 0)
                    alert("Rangerti " + errorMsg + "  [" + xmlHttpRequest.responseText.substring(start, end) + "]");
                else
                    alert("Error juga" + errorMsg);
            }
        });
    });
}

function enterpress() {
    $(document).ready(function() {
        $("#edSearch").keypress(function(event) {
            if (event.which === 13) {
                search(0);
            }

        });

    });
}

function add(xid) {
    $(document).ready(function() {
        $.ajax({
            url: getBaseURL() + "index.php/inputuser/getfromadd/",
            data: "idx=" + xid,
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
                $("#content").html(json.data);
               

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

function cancel() {
    $(document).ready(function() {
        document.location.reload();
    });
}

enterpress();