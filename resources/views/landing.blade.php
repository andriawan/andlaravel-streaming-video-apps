<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>And Video Streaming Simple Apps</title>
    <link rel="stylesheet" href={{ asset('css/app.css') }}>
</head>
<body>
    <div class="container mt-4">
        <div class="jumbotron bg-secondary text-white">
            <h1 class="display-4">AndLaravel Video Streaming</h1>
            <p class="lead">Hello, this is my experimental Apps in learning building Video Streaming Simple Apps</p>
            <hr class="my-4">
            <p>This is very-very experimental. Just use for fun only!</p>
            <div id="error-message" class="d-none alert alert-danger" role="alert">
            </div><div id="success-message" class="d-none alert alert-success" role="alert">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button id="button-upload" class="btn btn-primary" type="button">Upload</button>
                </div>
                <div class="custom-file">
                    <input id="file-upload" accept="video/mp4" type="file" class="custom-file-input" id="inputGroupFile01">
                    <label id="label-file-name" class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>
            <div id="progress-bar-container" class="progress d-none">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
