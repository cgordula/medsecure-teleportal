import 'bootstrap';

import $ from 'jquery';
window.$ = window.jQuery = $;


$(document).ready(function() {
    // Clear error messages on focus
    $('input').on('focus', function() {
        $('.alert-danger').remove();
    });

    // Set timeout for success message
    let successMessage = $('#success-message');
    if (successMessage.length) {
        setTimeout(function() {
            successMessage.fadeOut('slow', function() {
                $(this).remove(); // Remove the element after fading out
            }); 
        }, 3000); // 3000 milliseconds = 3 seconds
    }

    // Set timeout for error message
    let errorMessage = $('#error-message');
    if (errorMessage.length) {
        setTimeout(function() {
            errorMessage.fadeOut('slow', function() {
                $(this).remove(); // Remove the element after fading out
            }); 
        }, 3000); // 3000 milliseconds = 3 seconds
    }
});


