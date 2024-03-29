

function ckfin() {
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
        var editor = CKEDITOR.replace('description',
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

function getfindertextarea() {
    $(document).ready(function() {
        ckfin();
    });
}
function save() {
    $(document).ready(function() {
        var textbox = CKEDITOR.instances.description.getData();
        $.ajax({
            url: getBaseURL() + "index.php/kata/save/",
            data: "idx=" + $("#idx").val() + "&title=" + $("#about").val()  + "&img=" + encodeURIComponent($("#images_slider").val()) + "&img2=" + encodeURIComponent($("#images_slider2").val()) + "&description=" + encodeURIComponent(textbox),
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

getfindertextarea();

