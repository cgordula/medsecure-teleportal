/******/ (() => { // webpackBootstrap
/*!*******************************!*\
  !*** ./resources/js/admin.js ***!
  \*******************************/
$(document).ready(function () {
  // Clear error messages on focus
  $('input').on('focus', function () {
    $('.alert-danger').remove();
  });

  // Set timeout for success message
  var successMessage = $('#success-message');
  if (successMessage.length) {
    setTimeout(function () {
      successMessage.fadeOut('slow', function () {
        $(this).remove(); // Remove the element after fading out
      });
    }, 3000); // 3000 milliseconds = 3 seconds
  }

  // Set timeout for error message
  var errorMessage = $('#error-message');
  if (errorMessage.length) {
    setTimeout(function () {
      errorMessage.fadeOut('slow', function () {
        $(this).remove(); // Remove the element after fading out
      });
    }, 3000); // 3000 milliseconds = 3 seconds
  }
});
/******/ })()
;