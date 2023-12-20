jQuery(document).ready(function ($) {
    var customUploader;

    $('#affsquare_logo_upload_button').on('click', function (e) {
        e.preventDefault();

        if (customUploader) {
            customUploader.open();
            return;
        }

        customUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Logo',
            button: {
                text: 'Choose Logo'
            },
            multiple: false
        });

        customUploader.on('select', function () {
            var attachment = customUploader.state().get('selection').first().attributes;
            console.log("attachment", attachment);
            console.log("customUploader", attachment.filename);
            $('#affsquare_logo_id').val(attachment.id);
            $('img[alt="Current Logo"]').attr('src', attachment.url);
        });

        customUploader.open();
    });
});
