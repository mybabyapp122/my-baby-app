<?php

use common\libraries\CustomWidgets;
use common\models\UserSearch;
use yii\widgets\ActiveForm;

$school_id = $model->id;
$this->title = Yii::t('app', 'School Dashboard');
$this->params['breadcrumbs'][] = $school_id;
?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><?= $model->name ?></h4>

            <div class="page-title-right">
                <div class="row">
                    <div class="align-content-center">

                        <p class="text-muted mb-0"><?= Yii::t('app', 'Account Status') ?></p>
                        <span class="badge badge-pill bg-success"><?= ucfirst($model->status) ?></span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<br>
<br>

<div class="row">
    <div class="col-xxl-3">
        <div class="card mt-n5">
            <div class="card-body p-4">
                <div class="text-center">
                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                        <img src="<?= $model->getSchoolDp() ?>"  class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                            <input id="profile-img-file-input" type="file" class="profile-img-file-input"  data-model="user" data-model-id="<?= $school_id ?>">


                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                            <span class="avatar-title rounded-circle bg-light text-body">
                                                <i class="ri-camera-fill"></i>
                                            </span>
                            </label>
                        </div>
                    </div>
                    <h5 class="fs-16 mb-1"><?= ucfirst($model->name ?? '') ?></h5>
                </div>
            </div>
        </div>
        <!--end card-->
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-5">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0"><?= Yii::t('app', 'Complete Your Profile') ?></h5>
                    </div>
                    <div class="flex-shrink-0">
                        <!--                                <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i class="ri-edit-box-line align-bottom me-1"></i> Edit</a>-->
                    </div>
                </div>
                <div class="progress animated-progress custom-progress progress-label">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $completionPercentage ?>%" aria-valuenow="<?= $completionPercentage ?>" aria-valuemin="0" aria-valuemax="100">
                        <div class="label"><?= $completionPercentage ?>%</div>
                    </div>
                </div>
            </div>
        </div>

        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-xxl-9">
        <div class="card mt-xxl-n5">
            <div class="card-header">
                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link text-body active" data-bs-toggle="tab" href="#schoolProfile" role="tab">
                            <i class="la la-home" ></i>
                            <?= Yii::t('app', 'School Profile') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-body" data-bs-toggle="tab" href="#devices" role="tab">
                            <i class="la la-mobile-phone"></i>
                            <?= Yii::t('app', 'Devices') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-body" data-bs-toggle="tab" href="#teachersList" role="tab">
                            <i class="la la-user-friends"></i>
                            <?= Yii::t('app', 'Teachers') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-body" data-bs-toggle="tab" href="#students" role="tab">
                            <i class="la la-user-graduate"></i>
                            <?= Yii::t('app', 'Students') ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-body" data-bs-toggle="tab" href="#grades" role="tab">
                            <i class="la la-book-open"></i>
                            <?= Yii::t('app', 'Grades') ?>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-body" data-bs-toggle="tab" href="#availability" role="tab">
                            <i class="la la-calendar"></i>
                            <?= Yii::t('app', 'Availability Calendar') ?>
                        </a>
                    </li>



                    <li class="nav-item">
                        <a class="nav-link text-body" data-bs-toggle="tab" href="#chats" role="tab">
                            <i class="la la-calendar"></i>
                            <?= Yii::t('app', 'Chats') ?>
                        </a>
                    </li>



                    <?php if (Yii::$app->user->can('developer')) { ?>
                        <li class="nav-item">
                            <a class="nav-link text-body" data-bs-toggle="tab" href="#actions" role="tab">
                                <i class="la la-cog"></i>
                                <?= Yii::t('app', 'Actions') ?>
                            </a>
                        </li>
                    <?php } ?>

                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content">
                    <div class="tab-pane active school-view-tab-pane" id="schoolProfile"></div>

                    <div class="tab-pane school-view-tab-pane" id="devices" role="tabpanel"></div>

                    <div class="tab-pane school-view-tab-pane" id="teachersList" role="tabpanel"></div>

                    <div class="tab-pane school-view-tab-pane" id="students" role="tabpanel"></div>

                    <div class="tab-pane school-view-tab-pane" id="grades" role="tabpanel"></div>

                    <div class="tab-pane school-view-tab-pane" id="availability" role="tabpanel"> </div>

                    <div class="tab-pane school-view-tab-pane" id="chats" role="tabpanel"> </div>

                    <div class="tab-pane school-view-tab-pane" id="actions" role="tabpanel"> </div>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->





<?php


$script = <<< JS


$(document).ready(function() {
    
    function dynamicTab() {
        // Get the fragment (the part after # in the URL)
        var hash = window.location.hash;

        // If the hash exists and corresponds to a valid tab, activate it
        if (hash) {
            // Show the tab linked to the hash
            $('.tab-pane').removeClass('active');
            $(hash).addClass('active');
            
            // Activate the corresponding tab link
            $('.nav-link').removeClass('active');
            $('.nav-link[href="' + hash + '"]').addClass('active');
        } else {
            // If no hash is found, you could activate the first tab by default
            $('.nav-link').first().addClass('active');
            $('.tab-pane').first().addClass('active');
        }        
    }
    
    dynamicTab();
});


$(document).on('click', '.updateSchoolInfo', function (e) {
    e.preventDefault();
    var form = $(this).closest('form');

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                // Handle success (e.g., show success message, update UI)
                notify(response.success, response.message);
            } else {
                // Handle validation errors or other issues
                // $.each(response.errors, function (key, val) {
                //     var field = form.find('#' + key.replace(/\./g, '\\.'));
                //     field.addClass('is-invalid');
                //     field.next('.invalid-feedback').html(val.join('<br>'));
                // });
                console.log('HELLO');
                 console.log(response.errors);
                // Handle validation errors
                $.each(response.errors, function (key, value) {
                    var input = form.find('#' + key);
                    input.addClass('is-invalid');
                    input.closest('.form-group').find('.invalid-feedback').remove(); // Clear old error messages
                    input.after('<div class="invalid-feedback">' + value.join('<br>') + '</div>');
                });
            }
        },
        error: function (xhr, status, error) {
            // Handle general error
            notify(false, error);

            // alert('An error occurred: ' + error);
        }
    });
});

$(document).on('click', '.logout-device', function (e) {
    e.preventDefault();
    var form = $(this).closest('form');
    var action = $(this).data('action');
    var teacherId = $(this).data('user-id');

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: {
            school_id: $school_id,
            teacher_id: teacherId, // Send device ID
            action: action // Indicate logout device action
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                // Handle success (e.g., show success message, update UI)
                notify(response.success, response.message);
            } else {
                // Handle validation errors or other issues
                $.each(response.errors, function (key, val) {
                    var field = form.find('#' + key.replace(/\./g, '\\.'));
                    field.addClass('is-invalid');
                    field.next('.invalid-feedback').html(val.join('<br>'));
                });
            }
        },
        error: function (xhr, status, error) {
            // Handle general error
            notify(false, error);
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const tabPanes = document.querySelectorAll('.school-view-tab-pane');
    
    // Load the first tab content by default
    const firstActiveTab = document.querySelector('.school-view-tab-pane.active');
    if (firstActiveTab && !firstActiveTab.dataset.loaded) {
        loadTabContent(firstActiveTab.id); // Load the first tab if marked active
    }
    
    tabPanes.forEach(pane => {
        const observer = new MutationObserver(mutations => {
            mutations.forEach(mutation => {
                if (mutation.attributeName === 'class') {
                    const target = mutation.target;
                    if (target.classList.contains('active') && !target.dataset.loaded) {
                        loadTabContent(target.id);
                    }
                }
            });
        });

        observer.observe(pane, { attributes: true });
    });

    function loadTabContent(target) {
        const url = 'load-tab-content?tab='+target+'&id='+'$model->id';
        
        const element = document.getElementById(target);
        if (element) {
            element.innerHTML = '<div id="loader" class="spinner-grow spinner-grow-sm" role="status">LOADING</div>'; // Show spinner
        } else {
            console.error('Target element not found:', target); // Debugging log
        }
        fetch(url, {
            method: 'GET'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(html => {
            if (element) {
                element.innerHTML = html; // Render the content in the tab pane
                element.dataset.loaded = true; // Mark the tab as loaded
            } else {
                console.error('Target element not found:', element); // Debugging log
            }
        })
        .catch(error => {
            if (element) {
                element.innerHTML = '<p>Error loading content</p>'; // Handle errors
            }
            console.error('Error loading content:', error);
        });
    }
});
//
// document.addEventListener('DOMContentLoaded', function () {
//     flatpickr("#JoiningdatInput", {
//         enableTime: true,
//         dateFormat: "Y-m-d H:i:s",
//         defaultDate: $("#JoiningdatInput").data("default-date")
//     });
// });


JS;
$this->registerJs($script, \yii\web\View::POS_END);?>
