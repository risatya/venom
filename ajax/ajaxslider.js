function save() {
    $(document).ready(function() {
        var textbox = CKEDITOR.instances.desc_slider.getData();
        $.ajax({
            url: getBaseURL() + "index.php/slider/save/",
            data: "idx=" + $("#idx").val() + "&Title=" + $("#title_slider").val() + "&image=" + encodeURIComponent($("#images_slider").val()) + "&description=" + encodeURIComponent(textbox) + "&sort_order=" + $("#sort_slider").val() + "&link=" + $("#link_slider").val(),
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
                url: getBaseURL() + "index.php/slider/delete/",
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
//        $("#title_slider").val("");
//        $("#images_slider").val("");
//        $("#desc_slider").val("");
//        $("#link_slider").val("");
//        $("#sort_slider").val("");
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
            url: getBaseURL() + "index.php/slider/search/",
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

function ck() {
    if (typeof CKEDITOR == 'undefined')
    {
//                    document.write(
//                            '<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
//                            'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
//                            'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
//                            'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
//                            'value (line 32).');
    }
    else
    {
        var editor = CKEDITOR.replace('desc_slider',
                {
                    filebrowserBrowseUrl: getBaseURL() + 'js/ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl: getBaseURL() + 'js/ckfinder/ckfinder.html?type=Images',
                    filebrowserFlashBrowseUrl: getBaseURL() + 'js/ckfinder/ckfinder.html?type=Flash',
                    filebrowserUploadUrl: getBaseURL() + 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    filebrowserImageUploadUrl: getBaseURL() + 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    filebrowserFlashUploadUrl: getBaseURL() + 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                }
        );

        // Just call CKFinder.setupCKEditor and pass the CKEditor instance as the first argument.
        // The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
        CKFinder.setupCKEditor(editor, '../');

        // It is also possible to pass an object with selected CKFinder properties as a second argument.
        // CKFinder.setupCKEditor( editor, { basePath : '../', skin : 'v1' } ) ;
    }
}
function add(xid) {
    $(document).ready(function() {
        $.ajax({
            url: getBaseURL() + "index.php/slider/getfromadd/",
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
                ck();
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
function BrowseServer()
{
    // You can use the "CKFinder" class to render CKFinder in a page:
    var finder = new CKFinder();
    finder.basePath = '../';	// The path for the installation of CKFinder (default = "/ckfinder/").
    finder.selectActionFunction = SetFileField;
    finder.popup();

    // It can also be done in a single line, calling the "static"
    // popup( basePath, width, height, selectFunction ) function:
    // CKFinder.popup( '../', null, null, SetFileField ) ;
    //
    // The "popup" function can also accept an object as the only argument.
    // CKFinder.popup( { basePath : '../', selectActionFunction : SetFileField } ) ;
}
function SetFileField(fileUrl)
{
    document.getElementById('images_slider').value = fileUrl;
}




enterpress();