jQuery(document).ready(function ($) {
    $('#add-new-url').on('click', function () {
        var container = $('#additionalDomainsContainer');
        var newIndex = container.find('.additionalDomainsRow').length;
        var newRow = $('<div class="additionalDomainsRow">' +
            '<label for="website_url_' + newIndex + '">URL ' + (newIndex + 1) + ':</label> ' +
            '<input type="text" id="website_url_' + newIndex + '" name="redirect_settings_website_urls[]" value="" class="regular-text"> ' +
            '<button type="button" class="button remove-url">Remove</button>' +
            '</div>');
        container.append(newRow);
    });

    $(document).on('click', '.remove-url', function () {
        $(this).closest('.additionalDomainsRow').remove();
    });


    // ====================================================================================================
    // Display Long URL on 404 Report
    // ====================================================================================================
    if ($(".ADK-404-TOGGLE").length > 0) {
        $(".ADK-404-TOGGLE").on("click", function (e) {
            e.preventDefault();
            const row = $(this).attr("href");
            $(row).toggle();
        });

    }
});