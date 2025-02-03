<?php
use yii\helpers\Url;

$uploadUrl = Url::to(['user/upload-image']);
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;
$this->registerJs(<<<JS
    $(document).on('change', '#profile-img-file-input', function () {
        var formData = new FormData();
        formData.append('images', $(this)[0].files[0]);

        // Get model and model_id from data attributes
        var model = $(this).data('model');
        var modelId = $(this).data('model-id');

        // Append model and model_id to the form data
        formData.append('model', model);
        formData.append('model_id', modelId);
        formData.append('$csrfParam', '$csrfToken');

        $.ajax({
            url: '$uploadUrl' + '?model=' + model + '&model_id=' + modelId,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.success) {
                    notify(data.success, data.message);
                    // Optionally, update the profile image preview here
                } else {
                    notify(data.success, data.message);
                }
            },
            error: function (xhr, status, error) {
                    notify(false, error);
                }
        });
    });
JS
);
?>