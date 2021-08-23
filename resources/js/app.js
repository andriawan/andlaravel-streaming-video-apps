require('./bootstrap');

let errorMessage = $("#error-message");
let successMessage = $("#success-message");
let progressBarUpload = $("#progress-bar-container");
let fileUploadElement = $("#file-upload");
let buttonUploadElement = $("#button-upload");
let labelFileName = $("#label-file-name");

fileUploadElement.change(function (event) {
    errorMessage.addClass("d-none");
    if (event.currentTarget.files[0].name) {
        labelFileName.text(event.currentTarget.files[0].name);
    } else {
        labelFileName.text("");
    }
})

function sendChunkFile(data) {
    let form = new FormData()
    form.append("video", new File([data.reader.result], "uploaded_video"))
    $.ajax({
        type: "POST",
        data: form,
        contentType: false,
        processData: false,
        url: "/api/video",
        success: function () {
            if (data.loaded < data.files.size) {
                data.loaded += data.chunkSize;
                console.log("dt", data);
                let valueProgress = Math.round((data.loaded / data.files.size) * 100);
                if (valueProgress > 100) valueProgress = 100;
                data.progressBarUpload
                    .removeClass("d-none")
                    .find(".progress-bar").css("width", `${valueProgress}%`)
                    .text(`${valueProgress}%`)
                data.blob = data.files.slice(data.loaded, data.loaded + data.chunkSize);
                data.reader.readAsArrayBuffer(data.blob);
            } else {
                data.successMessage.removeClass("d-none").text("Upload File Success!");
                data.progressBarUpload.addClass("d-none");
                data.buttonUploadElement.prop("disabled", false);
                data.fileUploadElement.prop("disabled", false).val('');
                data.labelFileName.text("");
            }
        }
    })


}

buttonUploadElement.click(function () {

    let data = {
        loaded: 0,
        reader: new FileReader(),
        chunkSize: 1048576,
        errorMessage,
        successMessage,
        progressBarUpload,
        fileUploadElement,
        buttonUploadElement,
        labelFileName
    }

    data.buttonUploadElement.prop("disabled", true);
    data.fileUploadElement.prop("disabled", true);
    data.errorMessage.addClass("d-none");
    data.successMessage.addClass("d-none");
    data.progressBarUpload.addClass("d-none");

    data.files = data.fileUploadElement.get(0).files[0];


    if (data.files) {
        data.progressBarUpload
            .removeClass("d-none")
            .find(".progress-bar").css("width", "100%")
            .text("Uploading...");
        data.blob = data.files.slice(data.loaded, data.chunkSize);
        data.reader.readAsArrayBuffer(data.blob);
        data.reader.onload = function (e) {
            sendChunkFile(data)
        }

    } else {
        data.errorMessage.removeClass("d-none").text("Please select a mp4 file");
        data.buttonUploadElement.prop("disabled", false);
        data.fileUploadElement.prop("disabled", false)
    }
})
