$(document).ready(function() {
    const emailInput = $('#email-input');
    const checkButton = $('#check-button');
    const messageArea = $('#message-area');

    checkButton.on('click', function() {
        const emailValue = emailInput.val();

        // Reset styling
        emailInput.removeClass('bg-red-100 border-red-500 text-red-700');
        emailInput.removeClass('bg-green-100 border-green-500 text-green-700');
        messageArea.html('');

        // Use jQuery.ajax to post data TO THIS SAME FILE
        $.ajax({
            url: '', // Posts to the same file
            type: 'POST',
            // Data is sent as an object
            data: {
                email: emailValue,
                action: 'check_email'
            },
            dataType: 'json', // We expect a JSON response

            // Runs if the request is successful
            success: function(data) {
                if (data.status === 'error') {
                    // Add error classes based on the JSON response
                    emailInput.addClass('bg-red-100 border-red-500 text-red-700');
                    messageArea.text(data.message);
                    messageArea.addClass('text-red-600');
                    messageArea.removeClass('text-green-600');
                } else {
                    // Add success classes
                    emailInput.addClass('bg-green-100 border-green-500 text-green-700');
                    messageArea.text(data.message);
                    messageArea.addClass('text-green-600');
                    messageArea.removeClass('text-red-600');
                }
            },

            // Runs if the request fails
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error:', errorThrown);
                messageArea.text('A network error occurred.');
                messageArea.addClass('text-red-600');
            }
        });
    });
});

