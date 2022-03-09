document.addEventListener("DOMContentLoaded", () => {
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
