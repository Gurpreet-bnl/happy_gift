(function ($) {
    if ($('#initDatatable').length) {
        $('#initDatatable').DataTable({
            searching: false,
            ordering:  false,
            paging: true,
            "language": {
                "emptyTable": "Nothing to show"
            }
        });
    }
})(jQuery);
