$(document).ready(function () {
    $('#member-dropdown').on('change', function () {
        var selectedMemberId = $(this).val();

        if (selectedMemberId) {
            $.ajax({
                url: addMemberUrl, // Declare this in PHP and pass it as a global JS variable
                type: 'POST',
                data: {
                    user_id: selectedMemberId,
                    group_id: groupId
                },
                success: function (response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        notify(false, response.message);
                    }
                },
                error: function () {
                    notify(false, 'An error occurred. Please try again.');
                }
            });
        }
    });

    function loadMessages() {
        $.get(loadMessagesUrl, function (data) {
            $('#chat-messages').html(data);
            $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
        });
    }

    $('#chat-form').on('beforeSubmit', function (e) {
        var form = $(this);
        var messageInput = $('#chat-message-input');
        var chatMessages = $('#chat-messages');
        var message = messageInput.val().trim();

        if (!message) {
            alert('Message cannot be empty');
            return false;
        }

        // Serialize the form data before clearing the input field
        var formData = form.serialize();

        // Optimistically append the message
        var timestamp = new Date().toLocaleTimeString();

        var pendingMessage = $(`
            <div class="card mb-2">
                <div class="card-body p-2">
                    <!-- User and Timestamp -->
                    <div class="d-flex justify-content-between align-items-center mb-1">                       
                        <strong class="text-primary"><i class="fa fa-clock"></i> ${username}</strong>
                        <span class="text-muted small">${timestamp}</span>
                    </div>
                    <!-- Message Content -->
                    <p class="mb-0">${message}</p>
                </div>
            </div>
        `);
        chatMessages.append(pendingMessage);

        // chatMessages.append('<div class="chat-message">' +
        //     '<strong>You:</strong> ' + message + ' <span class="text-muted" style="font-size: 0.8em;">' + timestamp + '</span>' +
        //     '</div>');

        chatMessages.scrollTop(chatMessages[0].scrollHeight);
        messageInput.val('');

        // Send the message
        $.post(form.attr('action'), formData, function (response) {
            loadMessages();
            if (response.success) {
                pendingMessage.find('.text-muted').text('Sent');
                pendingMessage.removeClass('pending');
            } else {
                pendingMessage.remove();
                console.log('Error: ' + response.message);
                // loadMessages();
            }

            // if (!response.success) {
            //     alert('Error: ' + response.message);
            //     loadMessages(); // Reload messages on failure
            // }
        });

        return false;
    });

    // Initial load
    loadMessages();
    setInterval(loadMessages, 5000); // Auto-refresh messages
});
