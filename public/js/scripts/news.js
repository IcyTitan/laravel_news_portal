/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************!*\
  !*** ./resources/js/scripts/news.js ***!
  \**************************************/
document.addEventListener("DOMContentLoaded", function () {
  $("#select-category").change(function () {
    var selectedCategory = $('#select-category').val();
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: SET_CATEGORY,
      headers: {
        'X-CSRF-TOKEN': CSFR_TOKEN
      },
      data: {
        category: selectedCategory
      },
      success: function success(response) {
        console.log('response');
        window.location.reload();
      }
    });
  });
  $("#select-pagination").change(function () {
    var selectedCount = $('#select-pagination').val();
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: SET_PAGINATION,
      headers: {
        'X-CSRF-TOKEN': CSFR_TOKEN
      },
      data: {
        count: selectedCount
      },
      success: function success(response) {
        console.log('count');
        window.location.reload();
      }
    });
  });
});
/******/ })()
;