$(document).ready(function() {
    console.log("jQuery is working!");
    // Clear error messages on focus
    $('input').on('focus', function() {
        $('.alert-danger').remove();
    });
});
