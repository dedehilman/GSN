let EXITS_DOCUMENT = null;
var MEDIA_URL = '';

$(function() {
    Dropzone.autoDiscover = false;
    var uploadedDocumentMap = {};
    const previewNode = document.querySelector("#fileUploaderItem");
    previewNode.id = "";
    const previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    const myDropzone = new Dropzone(document.body, {
        url: MEDIA_URL,
        headers: {
            "X-CSRF-TOKEN": $('input[name="_token"]').val(),
        },
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: true,
        previewsContainer: "#fileUploaderContainer",
        clickable: ".fileinput-button",
        init: function () {
            if (EXITS_DOCUMENT && EXITS_DOCUMENT.length > 0) {
                for (let i in EXITS_DOCUMENT) {
                    const file = EXITS_DOCUMENT[i];
                    this.options.addedfile.call(this, file);
                    console.log(String(file.mime_type).includes("image"));
                    if (String(file.mime_type).includes("image"))
                        this.options.thumbnail.call(
                            this,
                            file,
                            file.public_url
                        );
                    file.previewElement.classList.add("dz-complete");
                    file.previewElement.addEventListener("click", () =>
                        window.open(file.public_url, "_blank")
                    );

                    file.previewElement.querySelector(".progress-bar-success").style.width = "100%";
                    $("form").append('<input type="hidden" name="document[]" value="' + file.file_name + '">');
                }
            }
        },
    });

    myDropzone.on("success", function (file, response) {
        if(response.status == '200') {
            $("form").append('<input type="hidden" name="document[]" value="' + response.name + '">');
            uploadedDocumentMap[file.name] = response.name;    
        } else {
            $(file.previewElement).find('.progress-bar').removeClass('bg-success').addClass('bg-danger');
            $(file.previewElement).find('.error').html(response.message);
        }
    });
    
    myDropzone.on("removedfile", function (file) {
        file.previewElement.remove();
        let name = "";
        if (typeof file.file_name !== "undefined") {
            name = file.file_name;
        } else {
            name = uploadedDocumentMap[file.name];
        }
    
        $("form").find('input[name="document[]"][value="' + name + '"]').remove();
    });

    $('.dz-remove').on('click', function(){
        $(this).closest('.dz-processing').remove();
    });
});