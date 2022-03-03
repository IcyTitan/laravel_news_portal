document.addEventListener("DOMContentLoaded", () => {
    $( "#select-category" ).change(()=>{
        let selectedCategory = $('#select-category').val();
        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: SET_CATEGORY,
            headers: {
                'X-CSRF-TOKEN': CSFR_TOKEN
            },
            data: {
                category: selectedCategory,
            },
            success: function (response) {
                console.log('response');
                window.location.reload();
            }
        });
    });

    $( "#select-pagination" ).change(()=>{
        let selectedCount = $('#select-pagination').val();
        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: SET_PAGINATION,
            headers: {
                'X-CSRF-TOKEN': CSFR_TOKEN
            },
            data: {
                count: selectedCount,
            },
            success: function (response) {
                console.log('count');
                window.location.reload();
            }
        });
    });
});
