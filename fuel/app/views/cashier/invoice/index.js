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

    $('#form_submit_cash_sale').on('click', function () {
        // check if Sale item(s) exist
        el_items = $('#items').find('tbody');
        // item_rows = el_items.find('tr').not('#no_items').length;
        has_no_items = el_items.find('tr#no_items').length == 1;
        if (has_no_items) {
            alert('Sorry, at least 1 Item must be added to Sale');
            $('#item_search').focus();
            return false;
        }
        
        // check if Sale payments exist or balance is > 0
        if ($('#form_balance_due').val() > 0) 
        {
            alert('Sorry, full Payment must be added to Sale');

            if ($('tr.accordion-body.collapse').hasClass('in') === false)
                $('tr.accordion-toggle').trigger('click');
            $('tr.accordion-body.collapse').addClass('in');

            // check default payment method and set focus to it
            $('.payment-entry:first').focus();
            return false;
        }
        // continue Submit Cash Sale
    });

    $('#form_submit_credit_sale').on('click', function () {
        // check if Sale item(s) exist
        el_items = $('#items').find('tbody');
        has_no_items = el_items.find('tr#no_items').length == 1;
        if (has_no_items) {
            alert('Sorry, at least 1 Item must be added to Sale');
            return false;
        }
        
        // continue Submit Credit Sale
    }); 

    $('#form_submit_sales_return').on('click', function () {
        // check if Sale item(s) exist
        el_items = $('#items').find('tbody');
        has_no_items = el_items.find('tr#no_items').length == 1;
        if (has_no_items) {
            alert('Sorry, at least 1 Item must be added to Return');
            return false;
        }
    });

    $('#hold_sale').on('click', function () {
        // Check if Sale item(s) exist in till bill
        el_items = $('#items').find('tbody');
        has_no_items = el_items.find('tr#no_items').length == 1;
        if (has_no_items) {
            // Check if draft POS Invoices for current user + TODAY date exist in DB
            // If found load a popup to allow Cashier selection of any Sale Invoice
            //
        }
        else {
            // use AJAX to Submit Cashier Invoice as Draft/Unpaid with loaded items
        }

        return false;
    });

    $('#cancel_sale').on('click', function () {
        // Check if POS Profile for current user requires approval to cancel
        // if has_no_items then do nothing
        // else Cancel and release committed quantities if applicable
        // use AJAX to call new_sale() action
        $('#item_search').focus();
        return false;
    });

    $('#cash_sale').on('click', function () {
        $('#form_sale_type').val('Cash Sale');
    });

    $('#credit_sale').on('click', function () {
        $('#form_sale_type').val('Credit Sale');
    });

    $('#sales_return').on('click', function () {
        $('#form_sale_type').val('Sales Return');
    });

// TODO: Test Ajax behavior
    // $("#item_search").select2({
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
