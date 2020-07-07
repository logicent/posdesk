$(window).on('load', function() 
{
    $('#item_view a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
        // $(this) show a btn as active
    });
    $('#item_view a:first').tab('show')

    // Select2
    $('.search-for-item').select2({
        theme: "bootstrap",
        placeholder: 'Scan or search by item code, barcode or item name...'
    });

    // $('#form_amount_paid').on('change', 
    //     function(e) {
    //         if ($(this).val() == '')
    //             return false;

    //         amountDue = $('#form_amount_due').val();
    //         amountPaid = $(this).val(); // Amount Tendered
    //         changeDue = amountPaid - amountDue;
    //         $('#sale_change_due').text(changeDue.toFixed(2));
    //         $('#form_change_due').val(changeDue.toFixed(2));
    //         // balanceDue = amountDue - amountPaid;
    //         // $('#form_balance_due').val(balanceDue.toFixed(2));
    //     });

// TODO: Test Ajax behavior
    // $(".search-for-item").select2({
    //     ajax: {
    //         url: '/cashier/invoice/search',
    //         dataType: 'json',
    //         delay: 250,
    //         data: function (params) {
    //             return {
    //                 q: params.term, // search term
    //                 page: params.page
    //             };
    //         },
    //         processResults: function (data, params) {
    //             // parse the results into the format expected by Select2
    //             // since we are using custom formatting functions we do not need to
    //             // alter the remote JSON data, except to indicate that infinite
    //             // scrolling can be used
    //             params.page = params.page || 1;
        
    //             return {
    //                 results: data.items,
    //                 pagination: {
    //                     more: (params.page * 30) < data.total_count
    //                 }
    //             };
    //         },
    //         cache: true
    //     },
    //     placeholder: 'Search for a repository',
    //     minimumInputLength: 1,
    //     // templateResult: formatRepo,
    //     // templateSelection: formatRepoSelection
    // });
    
    function formatRepo (repo) {
        if (repo.loading) {
        return repo.text;
        }
    
        var $container = $(
        "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'></div>" +
            "<div class='select2-result-repository__description'></div>" +
            "<div class='select2-result-repository__statistics'>" +
                "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> </div>" +
                "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> </div>" +
                "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> </div>" +
            "</div>" +
            "</div>" +
        "</div>"
        );
    
        $container.find(".select2-result-repository__title").text(repo.full_name);
        $container.find(".select2-result-repository__description").text(repo.description);
        $container.find(".select2-result-repository__forks").append(repo.forks_count + " Forks");
        $container.find(".select2-result-repository__stargazers").append(repo.stargazers_count + " Stars");
        $container.find(".select2-result-repository__watchers").append(repo.watchers_count + " Watchers");
    
        return $container;
    }
    
    function formatRepoSelection (repo) {
        return repo.full_name || repo.text;
    }
});
