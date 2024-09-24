jQuery(document).ready(function($){
    $('#select-members').select2({
        ajax: {
            url: tsg_ajax.ajax_url,
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    action: 'search_users', // The action we will hook into
                    search: params.term // The search query
                };
            },
            processResults: function (data) {
                return {
                    results: data // Parse the results into the format expected by Select2
                };
            },
            cache: true
        },
        placeholder: 'Select members',
        minimumInputLength: 2, // Start searching after 2 characters
        multiple: true, // Allow multiple selections
    });
})