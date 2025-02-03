<?php
?>


<!--<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">-->
<!--    <div class="modal-dialog">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <h5 class="modal-title" id="modalHeading">Modal Heading</h5>-->
<!--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
<!--            </div>-->
<!--            <div class="modal-body" id="modalBody"></div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->



<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHeading">Grid Modals</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">

            </div>
        </div>
    </div>
</div>




<?php
$lang = Yii::$app->language;
$user_lang             = Yii::$app->language;
$script = <<< JS
    
    $(document).ready(function() {
        $('.modals').each(function() {
            $(this).insertBefore($(this).parent().parent().parent());
        });
        
        // $('.entry-row').on('click', function() {
        //     console.log('Entry row clicked');
        //     var url = $(this).data('url');
        //     console.log(url);
        //
        //     $.ajax({
        //         url: url,
        //         type: 'GET', // Use 'POST' if your endpoint expects POST requests
        //         success: function(response) {
        //             // Assuming the response contains JSON with 'heading' and 'body' fields
        //             $('#modalHeading').text(response.data.heading);
        //             $('#modalBody').html(response.data.body);
        //             // Show the modal (assuming you are using Bootstrap modal)
        //             var modal = new bootstrap.Modal(document.getElementById('myModal'));
        //             modal.show();
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('An error occurred:', status, error);
        //         }
        //     });
        // });
        
        $(document).on('click', '.entry-row', function(e) {
            // If the clicked element also has the entry-row-btn class, stop propagation and handle it separately
            var url = $(this).data('url');
            if ($(e.target).hasClass('entry-row-btn')) {
                console.log("Button clicked inside row");
                // console.log(url);
                url = $(e.target).data('btn-url'); // Get the button's data-btn-url
                // console.log(btnUrl); // Now it should log the correct URL for the button
                // url = $(this).getElementsByClassName('.entry-row-btn')
                // return; // Exit to prevent row click if button is clicked
            }

    
            // var url = $(this).data('url');
            $.ajax({
                url: url,
                type: 'GET', // Use 'POST' if your endpoint expects POST requests
                success: function(response) {
                    // Assuming the response contains JSON with 'heading' and 'body' fields
                    $('#modalHeading').text(response.data.heading);
                    $('#modalBody').html(response.data.body);
                    // Show the modal (assuming you are using Bootstrap modal)
                    var modal = new bootstrap.Modal(document.getElementById('myModal'));
                    modal.show();
                },
                error: function(xhr, status, error) {
                    console.error('An error occurred:', status, error);
                }
            });
        });
        
        // // Handle button click inside the row (with entry-row-btn class)
        // $(document).on('click', '.entry-row-btn', function(e) {
        //     e.stopPropagation(); // Prevent the row click from triggering
        //
        //     var url = $(this).data('url'); // Get the URL from the button's data-url attribute
        //     console.log(url); // For debugging, to ensure the URL is correct
        //
        //     if (url) {
        //         $.ajax({
        //             url: url,
        //             type: 'GET',
        //             success: function(response) {
        //                 $('#modalHeading').text(response.data.heading);
        //                 $('#modalBody').html(response.data.body);
        //                 var modal = new bootstrap.Modal(document.getElementById('myModal'));
        //                 modal.show();
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error('An error occurred:', status, error);
        //             }
        //         });
        //     }
        // });
        
        
        
        $(document).on('click', '.submitFormThroughJson', function (e) {
            e.preventDefault();
            var form = $(this).closest('form');
        
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Get the currently active/visible modal
                        var activeModal = document.querySelector('.modal.show');
                        
                        if (activeModal) {
                            // Use Bootstrap's modal instance to hide it
                            var modalInstance = bootstrap.Modal.getInstance(activeModal);
                            if (modalInstance) {
                                modalInstance.hide(); // This will close the modal
                            }
                        }
                        
                        // Handle success (e.g., show success message, update UI)
                        notify(response.success, response.message);
                        
                    } else {
                        // Handle validation errors or other issues
                        // $.each(response.errors, function (key, val) {
                        //     var field = form.find('#' + key.replace(/\./g, '\\.'));
                        //     field.addClass('is-invalid');
                        //     field.next('.invalid-feedback').html(val.join('<br>'));
                        // });
                     // Get the first form field's ID to dynamically determine the model name
                            // Log all form field IDs for debugging
                        
                        
                        // Clear all previous validation error messages and 'is-invalid' classes
                        form.find('.is-invalid').removeClass('is-invalid'); // Remove invalid class
                        form.find('.invalid-feedback').remove(); // Remove any old error messages

                            
                        // Check if the form has any visible input, select, or textarea fields (skip hidden fields)
                        var formFields = form.find('input:not([type=hidden]), select, textarea');
                
                        // If no fields are found, log an error and return
                        // if (formFields.length === 0) {
                        //     console.error("No visible form fields found. Check if the form exists or the selector is correct.");
                        //     return;
                        // }
                
                        // Get the first form field's ID to dynamically determine the model name
                        var firstField = formFields.first();
                        // console.log("First visible field found:", firstField); // Log the first visible field
                
                        // Check if the first field has an ID
                        if (firstField.length && firstField.attr('id')) {
                            var firstFieldId = firstField.attr('id');
                            // console.log("First visible field ID:", firstFieldId); // Log the first field's ID
                            var modelName = firstFieldId.split('-')[0];
                            // console.log("Model name determined:", modelName);
                        } 
                        // else {
                            // console.error("The first visible form field does not have an ID.");
                            // return;
                        // }
        
                        // Handle validation errors
                        $.each(response.error, function (key, value) {
                            // Use dynamically determined model name to target the field IDs
                            var input = form.find('#' + modelName + '-' + key);
                            // console.log('#' + modelName + '-' + key);
                            // console.log(input);
                
                            if (input.length > 0) {
                                input.addClass('is-invalid'); // Add invalid class to highlight the input
                                input.closest('.form-group').find('.invalid-feedback').remove(); // Clear old error messages
                
                                // Add new error message below the input field
                                input.after('<div class="invalid-feedback">' + value.join('<br>') + '</div>');
                            }
                        });
                        
                        notify(response.success, response.message);
                    }
                },
                error: function (xhr, status, error) {
                    // Handle general error
                    notify(false, error);
        
                    // alert('An error occurred: ' + error);
                }
            });
        });
        
        
   });

    function notify(success, message, timer = 1000) {
        Swal.fire({
            position: "top-end",
            icon: success ? "success" : "error",
            text: message,
            showConfirmButton: false,
            timer: timer
        });
        
        reloadCurrentPage();
    }
    
    function reloadCurrentPage() {
        // Find the active <li> with selected="true"
        var activeTab = $('ul.nav-tabs-custom li a[aria-selected="true"]');
        
        // If there's an active tab
        if (activeTab.length > 0) {
            // Get the href attribute (which will be #something)
            var tabHref = activeTab.attr('href');  // This will give us #something
            
            // Get the current URL (without the hash part)
            var currentUrl = window.location.href.split('#')[0];
            currentUrl += tabHref;
            console.log(currentUrl);
            window.location.href = currentUrl;
            window.location.reload();
        }        
    }

JS;
$this->registerJs($script, \yii\web\View::POS_END);
?>