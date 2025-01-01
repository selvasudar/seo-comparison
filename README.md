# SEO Comparison Tool for WordPress

## Description

The SEO Comparison Tool is a WordPress plugin that allows you to compare your website with competitor websites from a technical SEO perspective using Google's Gemini AI. The plugin provides detailed analysis and actionable recommendations for improving your website's SEO performance.

## Features

- Compare your website with competitor URLs
- AI-powered SEO analysis using Google's Gemini API
- Detailed technical SEO recommendations
- Analysis of multiple SEO aspects including:
  - Meta tags and descriptions
  - Content structure and headings
  - Page speed and performance
  - Mobile responsiveness
  - URL structure
  - Internal linking
  - Image optimization
  - Schema markup
- Clean, user-friendly interface
- Secure API key management
- Formatted, easy-to-read results

## Installation

1. Download the plugin files
2. Create a new directory `seo-comparison` in your WordPress installation's `wp-content/plugins` directory
3. Upload the plugin files to the created directory with the following structure:
   ```
   seo-comparison/
   ├── css/
   │   └── style.css
   ├── js/
   │   └── script.js
   ├── seo-comparison.php
   └── readme.md
   ```
4. Activate the plugin through the WordPress admin panel at Plugins > Installed Plugins

## Configuration

1. Obtain a Gemini API key from Google Cloud Console
2. In your WordPress admin panel, navigate to "SEO Comparison"
3. Enter your Gemini API key in the API Key section and save

## Usage

1. Go to the SEO Comparison tool in your WordPress admin panel
2. Enter your website URL in the "Your Website URL" field
3. Enter your competitor's URL in the "Competitor URL" field
4. Click "Compare URLs"
5. Wait for the analysis to complete (typically 15-20 seconds)
6. Review the detailed comparison and recommendations

## Technical Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Active Gemini API key
- Modern web browser (Chrome, Firefox, Safari, Edge)

## Security Features

- WordPress nonce verification for AJAX requests
- Input sanitization and validation
- Secure API key storage
- Request timeout handling
- Error handling and user feedback

## Customization

The plugin's appearance can be customized by modifying the CSS file located at:
```
wp-content/plugins/seo-comparison/css/style.css
```

## Troubleshooting

Common issues and solutions:

1. **API Key Invalid**
   - Verify your Gemini API key is correct
   - Ensure the API key has been saved in the plugin settings

2. **Request Timeout**
   - The default timeout is set to 20 seconds
   - Check your internet connection
   - Try again during off-peak hours

3. **Analysis Not Loading**
   - Clear your browser cache
   - Check browser console for JavaScript errors
   - Verify WordPress permissions

## Known Limitations

- Maximum request timeout of 20 seconds
- Requires active internet connection
- Analysis is limited to publicly accessible URLs
- One comparison at a time

## Updates and Maintenance

The plugin does not currently support automatic updates. To update:
1. Download the latest version
2. Deactivate and delete the current version
3. Install and activate the new version
4. Reconfigure your API key

## Support

For support:
1. Check this documentation
2. Visit the plugin's support forum
3. Submit issues on the project repository
4. Contact the plugin developer

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This plugin is licensed under the GPL v2 or later.

## Credits

- Developed using WordPress Plugin Boilerplate
- Powered by Google's Gemini AI
- Icons and styling from WordPress core

## Version History

- 1.0.0: Initial release
  - Basic comparison functionality
  - Gemini AI integration
  - Formatted results display

## Future Plans

- Multiple URL comparisons
- Export functionality
- Historical comparison data
- Custom analysis parameters
- Automated scheduling
- PDF report generation

---

*Note: This plugin requires a valid Gemini API key to function. API usage may incur charges from Google.*