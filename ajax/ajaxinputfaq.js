function save() {
    $(document).ready(function() {
        var textbox = CKEDITOR.instances.desc_slider.getData();
        $.ajax({
            url: getBaseURL() + "index.php/inputfaq/save/",
            data: 	"idfaq=" + $("#idfaq").val() + 
					"&idcategory=" + $("#idcategory").val() + 
					"&question=" + $("#question").val() + 
					"&answer=" + encodeURIComponent(textbox) ,
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

function deletedata(idproduct, title) {
    if (confirm('Hapus data ' + title + ' ?')) {
        $(document).ready(function() {

            $.ajax({
                url: getBaseURL() + "index.php/inputproductshow/delete/",
                data: "idproduct=" + idproduct,
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
            url: getBaseURL() + "index.php/inputfaq/search/",
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

function add(idfaq) {
    $(document).ready(function() {
        $.ajax({
            url: getBaseURL() + "index.php/inputfaq/getfromadd/",
            data: "idfaq=" + idfaq,
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
function BrowseServer(dataku)
{	
    // You can use the "CKFinder" class to render CKFinder in a page:
    var finder = new CKFinder();

    finder.basePath = '../';	// The path for the installation of CKFinder (default = "/ckfinder/").
    
    finder.selectActionData = dataku;
	finder.selectActionFunction = function( fileUrl, data ) {

				// Using CKFinderAPI to show simple dialog.
	
				document.getElementById( data['selectActionData'] ).value = fileUrl;
			}
    
	
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
function tampilsubcategory(idx){
	$(document).ready(function() {
        $.ajax({
            url: getBaseURL() + "index.php/inputproductshow/getsubcategory/",
            data: "idx=" + idx,
            cache: false,
            dataType: 'json',
            type: 'POST',
            beforeSend: function() {
                $('#top').append('<div id="pageloads"></div>');
            },
            complete: function() {
                $('#pageloads').remove();
            },
            success: function(json) {
                $("#tampilsubcategory").html(json.data);
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
enterpress();


