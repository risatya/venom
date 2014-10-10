function save() {
    $(document).ready(function() {

        $.ajax({
            url: getBaseURL() + "index.php/inputsubcategory/save/",
            data: "idx=" + $("#idx").val() + 
				  "&subcategory=" + $("#subcategory").val() + 
				  "&idsubcategory=" + $("#idsubcategory").val(),
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

function deletedata(idsubcategory, title) {
    if (confirm('Hapus data ' + title + ' ?')) {
        $(document).ready(function() {

            $.ajax({
                url: getBaseURL() + "index.php/inputsubcategory/delete/",
                data: "idsubcategory=" + idsubcategory,
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
            url: getBaseURL() + "index.php/inputcategory/search/",
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

function add_subctgr(idsubcategory) {
    $(document).ready(function() {
        $.ajax({
            url: getBaseURL() + "index.php/inputsubcategory/getfromadd/",
            data: "idsubcategory=" + idsubcategory,
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
