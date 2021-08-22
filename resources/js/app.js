require('./bootstrap');

let errorMessage = $("#error-message");
let successMessage = $("#success-message");
let progressBarUpload = $("#progress-bar-container");

$("#file-upload").change(function (event) {
    errorMessage.addClass("d-none");
    if (event.currentTarget.files[0].name){
        $("#label-file-name").text(event.currentTarget.files[0].name);
    }else{
        $("#label-file-name").text("");
    }
})

$("#button-upload").click(function () {
    let files = $("#file-upload").get(0).files[0]
    let chunkSize = 100000;

    errorMessage.addClass("d-none");
    successMessage.addClass("d-none");
    progressBarUpload.addClass("d-none");


    if(files){
        let loaded = 0;
        let reader = new FileReader();
        let blob = files.slice(loaded, chunkSize);
        reader.readAsArrayBuffer(blob);
        reader.onload = function(e) {
            loaded += chunkSize;
            let valueProgress = Math.round((loaded/files.size) * 100);
            if(valueProgress > 100) valueProgress = 100;
            progressBarUpload
                .removeClass("d-none")
                .find(".progress-bar").css("width",  `${valueProgress}%`)
                .text(`${valueProgress}%`)
            if (loaded < files.size) {
                blob = files.slice(loaded, loaded + chunkSize);
                setTimeout(function () {
                    reader.readAsArrayBuffer(blob);
                }, 400)
            }else{
                successMessage.removeClass("d-none").text("Upload File Success!");
                progressBarUpload.addClass("d-none");
            }
        }

    }else{
        errorMessage.removeClass("d-none").text("Please select a mp4 file");
    }
    console.log(files);
})
