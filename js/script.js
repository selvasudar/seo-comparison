// js/script.js
jQuery(document).ready(function($) {
    $('#url-comparison-form').on('submit', function(e) {
        e.preventDefault();
        
        const yourUrl = $('#your_url').val();
        const competitorUrl = $('#competitor_url').val();
        
        if (!yourUrl || !competitorUrl) {
            alert('Please enter both URLs');
            return;
        }

        // Show loading state
        $('#comparison-results').removeClass('hidden')
            .find('#analysis-content')
            .html('<p>Analyzing URLs, please wait...</p>');

        $.ajax({
            url: seoComparisonAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'handle_url_comparison',
                nonce: seoComparisonAjax.nonce,
                your_url: yourUrl,
                competitor_url: competitorUrl
            },
            success: function(response) {
                if (response.success) {
                    if (response.data.formatted_html) {
                        $('#analysis-content').html(response.data.formatted_html);
                    } else {
                        $('#analysis-content').html(
                            '<div class="error-message">Unable to parse API response.</div>'
                        );
                    }
                } else {
                    $('#analysis-content').html(
                        '<div class="error-message">' + 
                        (response.data || 'An error occurred during analysis') + 
                        '</div>'
                    );
                }
            },
            error: function() {
                $('#analysis-content').html(
                    '<div class="error-message">Failed to connect to the server.</div>'
                );
            }
        });
    });
});