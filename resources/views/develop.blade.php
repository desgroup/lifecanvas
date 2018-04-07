<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Uploader</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">

    <link rel="stylesheet" href="/assets/uploader/css/pe-icon-7-stroke.css">
    <link rel="stylesheet" href="/assets/uploader/css/drop_uploader.css">

    <!--script src="js/jquery-2.2.4.min.js"></script-->
    <script src="/assets/uploader/js/jquery-3.2.1.js"></script>
    <script src="/assets/uploader/js/drop_uploader.js"></script>

    <script>
        $(document).ready(function(){
            $('input[type=file]').drop_uploader({
                uploader_text: '',
                browse_text: 'Browse',
                only_one_error_text: 'Only one file allowed',
                not_allowed_error_text: 'File type is not allowed',
                big_file_before_error_text: 'Files, bigger than',
                big_file_after_error_text: 'is not allowed',
                allowed_before_error_text: 'Only',
                allowed_after_error_text: 'files allowed',
                browse_css_class: 'button button-primary',
                browse_css_selector: 'file_browse',
                uploader_icon: '<i class="pe-7s-cloud-upload"></i>',
                file_icon: '<i class="pe-7s-file"></i>',
                time_show_errors: 5,
                layout: 'thumbnails',
                method: 'normal',
                url: 'ajax_upload.php',
                delete_url: 'ajax_delete.php',
            });
        });
    </script>

</head>
<body style="background: #fff;">
<div class="container">
    <form method="POST" action="upload.php" enctype="multipart/form-data">
        <div class="row">
            <div class="twelve column" style="margin-top: 5%">
                <h4>Single File Upload Form</h4>

                <input type="file" name="file" accept="image/*" data-maxfilesize="10000000">
                <input class="button-primary" type="submit" value="Submit">

            </div>
        </div>
    </form>
</div>
</body>
</html>
