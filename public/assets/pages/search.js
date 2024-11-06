(function ($){
    $(document).on('submit', 'form.searchForm', function (e){
        //Prevent the form from submitting
        e.preventDefault();
        
        //Get form data
        const formData = $(this).serialize();

        //Ajax request
        $.ajax(
            'http://localhost/project/public/ajax/search_results.php',
            {
                type: "GET",
                dataType: "html",
                data: formData
            }
        ).done(function(result) {
            //Clear results container
            $('.results').html('');

            //Append results to container
            $('.results').append(result);

            //Push url state
            history.pushState({}, '', 'http://localhost/project/public/list.php?' + formData);
        });

    });
}) (jQuery);