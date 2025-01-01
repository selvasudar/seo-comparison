<?php
/*
Plugin Name: SEO Comparison Tool
Description: Compare two URLs for Technical SEO analysis using Gemini AI
Version: 1.0
Author: Your Name
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add menu item to WordPress admin
function seo_comparison_menu() {
    add_menu_page(
        'SEO Comparison Tool',
        'SEO Comparison',
        'manage_options',
        'seo-comparison',
        'seo_comparison_page',
        'dashicons-chart-line'
    );
}
add_action('admin_menu', 'seo_comparison_menu');

// Register plugin settings
function seo_comparison_settings() {
    register_setting('seo-comparison-settings', 'gemini_api_key');
}
add_action('admin_init', 'seo_comparison_settings');

// Enqueue necessary scripts and styles
function seo_comparison_scripts($hook) {
    if ($hook != 'toplevel_page_seo-comparison') {
        return;
    }
    
    wp_enqueue_style('seo-comparison-styles', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('seo-comparison-script', plugins_url('js/script.js', __FILE__), array('jquery'), '1.0', true);
    wp_localize_script('seo-comparison-script', 'seoComparisonAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('seo_comparison_nonce')
    ));
}
add_action('admin_enqueue_scripts', 'seo_comparison_scripts');

// Create the admin page
function seo_comparison_page() {
    ?>
    <div class="wrap">
        <h1>SEO Comparison Tool</h1>
        <h3>Compares two URL in the aspect of Technical SEO</h3>
        <!-- API Key Settings -->
        <div class="api-key-section">
            <form method="post" action="options.php">
                <?php settings_fields('seo-comparison-settings'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">Gemini API Key</th>
                        <td>
                            <input type="text" 
                                   name="gemini_api_key" 
                                   value="<?php echo esc_attr(get_option('gemini_api_key')); ?>" 
                                   class="regular-text"
                                   placeholder="Enter your Gemini API key">
                        </td>
                    </tr>
                </table>
                <?php submit_button('Save API Key'); ?>
            </form>
        </div>

        <!-- URL Comparison Form -->
        <div class="seo-comparison-form">
            <form id="url-comparison-form">
                <table class="form-table">
                    <tr>
                        <th scope="row">Your Website URL</th>
                        <td>
                            <input type="url" 
                                   name="your_url" 
                                   id="your_url" 
                                   class="regular-text" 
                                   required 
                                   placeholder="https://your-website.com">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Competitor URL</th>
                        <td>
                            <input type="url" 
                                   name="competitor_url" 
                                   id="competitor_url" 
                                   class="regular-text" 
                                   required 
                                   placeholder="https://competitor-website.com">
                        </td>
                    </tr>
                </table>
                <button type="submit" class="button button-primary">Compare URLs</button>
            </form>
        </div>

        <!-- Results Section -->
        <div id="comparison-results" class="comparison-results hidden">
            <h2>SEO Analysis Results</h2>
            <div id="analysis-content"></div>
        </div>
    </div>
    <?php
}

// Handle AJAX request for URL comparison
// function handle_url_comparison() {
//     check_ajax_referer('seo_comparison_nonce', 'nonce');
    
//     $your_url = sanitize_url($_POST['your_url']);
//     $competitor_url = sanitize_url($_POST['competitor_url']);
//     $api_key = get_option('gemini_api_key');

//     if (empty($api_key)) {
//         wp_send_json_error('Please configure your Gemini API key first.');
//         return;
//     }

//     $prompt = "Compare these two URLs from a technical SEO perspective and provide detailed analysis: 
//                My website: $your_url 
//                Competitor website: $competitor_url
//                Please analyze and list specific improvements needed for my website, including:
//                1. Meta tags and descriptions
//                2. Content structure and headings
//                3. Page speed and performance
//                4. Mobile responsiveness
//                5. URL structure
//                6. Internal linking
//                7. Image optimization
//                8. Schema markup
//                Format the response in clear sections with actionable recommendations.";

//     $response = wp_remote_post(
//         "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $api_key,
//         array(
//             'headers' => array(
//                 'Content-Type' => 'application/json',
//             ),
//             'body' => json_encode(array(
//                 'contents' => array(
//                     array(
//                         'parts' => array(
//                             array('text' => $prompt)
//                         )
//                     )
//                 )
//             )),
//             'timeout' => 20,  // Adding 20 second timeout
//             'httpversion' => '1.1'
//         )
//     );

//     if (is_wp_error($response)) {
//         wp_send_json_error('Failed to connect to Gemini API: ' . $response->get_error_message());
//         return;
//     }

//     $body = wp_remote_retrieve_body($response);
//     $data = json_decode($body, true);

//     if (isset($data['error'])) {
//         wp_send_json_error('API Error: ' . $data['error']['message']);
//         return;
//     }

//     wp_send_json_success($data);
// }
// add_action('wp_ajax_handle_url_comparison', 'handle_url_comparison');

function handle_url_comparison() {
    check_ajax_referer('seo_comparison_nonce', 'nonce');
    
    $your_url = sanitize_url($_POST['your_url']);
    $competitor_url = sanitize_url($_POST['competitor_url']);
    $api_key = get_option('gemini_api_key');

    if (empty($api_key)) {
        wp_send_json_error('Please configure your Gemini API key first.');
        return;
    }

    $prompt = "Compare these two URLs from a technical SEO perspective and provide detailed analysis: 
               My website: $your_url 
               Competitor website: $competitor_url
               Please analyze and list specific improvements needed for my website, including:
               1. Meta tags and descriptions
               2. Content structure and headings
               3. Page speed and performance
               4. Mobile responsiveness
               5. URL structure
               6. Internal linking
               7. Image optimization
               8. Schema markup
               Format the response in clear sections with actionable recommendations.";

    $response = wp_remote_post(
        "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $api_key,
        array(
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => json_encode(array(
                'contents' => array(
                    array(
                        'parts' => array(
                            array('text' => $prompt)
                        )
                    )
                )
            )),
            'timeout' => 20,
            'httpversion' => '1.1'
        )
    );

    if (is_wp_error($response)) {
        if ($response->get_error_code() === 'http_request_failed' && strpos($response->get_error_message(), 'timed out') !== false) {
            wp_send_json_error('The request timed out after 20 seconds. Please try again.');
        } else {
            wp_send_json_error('Failed to connect to Gemini API: ' . $response->get_error_message());
        }
        return;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['error'])) {
        wp_send_json_error('API Error: ' . $data['error']['message']);
        return;
    }

    // Format the response before sending
    if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
        $formatted_content = format_gemini_response($data['candidates'][0]['content']['parts'][0]['text']);
        $data['formatted_html'] = $formatted_content;
    }

    wp_send_json_success($data);
}
add_action('wp_ajax_handle_url_comparison', 'handle_url_comparison');

function format_gemini_response($text) {
    // Initialize formatted text
    $html = $text;
    
    // Replace headers (## style)
    $html = preg_replace('/##\s*([^\n]+)/', '<h2>$1</h2>', $html);
    
    // Replace bold text (** style)
    $html = preg_replace('/\*\*([^\*]+)\*\*/', '<strong>$1</strong>', $html);
    
    // Handle bullet points
    $lines = explode("\n", $html);
    $in_list = false;
    $formatted_lines = [];
    
    foreach ($lines as $line) {
        $trimmed = trim($line);
        
        // Check if line starts with *
        if (strpos($trimmed, '* ') === 0) {
            if (!$in_list) {
                $formatted_lines[] = '<ul>';
                $in_list = true;
            }
            $list_item = substr($trimmed, 2); // Remove * and space
            $formatted_lines[] = "<li>$list_item</li>";
        } else {
            if ($in_list) {
                $formatted_lines[] = '</ul>';
                $in_list = false;
            }
            
            // Handle empty lines and regular text
            if (empty($trimmed)) {
                $formatted_lines[] = '<br>';
            } else {
                // Check if it's a section heading (ends with :)
                if (preg_match('/^([^:]+):$/', $trimmed)) {
                    $formatted_lines[] = "<h3>$trimmed</h3>";
                } else {
                    $formatted_lines[] = "<p>$trimmed</p>";
                }
            }
        }
    }
    
    // Close any open list
    if ($in_list) {
        $formatted_lines[] = '</ul>';
    }
    
    return implode("\n", $formatted_lines);
}