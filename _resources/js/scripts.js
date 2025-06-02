jQuery(document).ready(function ($) {
    $('#AdkRedirects-Add-URL').on('click', function () {
        var container = $('#AdkRedirectsDomains');
        var newIndex = container.find('.AdkRedirectsDomains__row').length;
        var newRow = $('<div class="AdkRedirectsDomains__row">' +
            '<label for="website_url_' + newIndex + '">URL ' + (newIndex + 1) + ':</label> ' +
            '<input type="text" id="website_url_' + newIndex + '" name="adk-redirect-option-domains[]" value="" class="regular-text"> ' +
            '<button type="button" class="button AdkRedirects-Remove-URL">Remove</button>' +
            '</div>');
        container.append(newRow);
    });

    $(document).on('click', '.AdkRedirects-Remove-URL', function () {
        $(this).closest('.AdkRedirectsDomains__row').remove();
    });
});