# Adk Redirects

Adk Redirects is a streamlined WordPress plugin engineered to provide website administrators with robust control over URL redirection. This plugin facilitates the creation and management of permanent 301 redirects, essential for maintaining search engine rankings and ensuring a seamless user experience during site migrations, content updates, or URL structure changes.

The plugin introduces a dedicated custom post type within the WordPress admin interface, offering an intuitive and familiar environment for managing redirect rules. Administrators can define source URLs and their corresponding destination URLs with precision.

## Key Features:

- Permanent 301 Redirects: Exclusively utilizes HTTP 301 status codes, signaling to search engines and browsers that a URL has permanently moved, thereby transferring link equity to the new destination.
- Flexible URL Matching: Supports five primary matching types for source URLs:
- Custom Post Type Management: Redirect rules are managed as individual entries within a custom post type, providing a clear, organized, and easily searchable interface. This leverages core WordPress UI components for ease of use and integration.
- Optimized for Non-Existent URLs: The plugin is designed to intercept requests for URLs that would typically result in a 404 "Not Found" error. If a configured redirect rule matches the requested non-existent URL, the plugin executes the 301 redirect to the specified destination.

## Technical Implementation:

Adk Redirects integrates with the WordPress core via the template_redirect action hook. This allows for efficient interception of requests early in the WordPress loading process, ensuring redirects are handled before any page content is rendered. By operating on URLs that would otherwise lead to a 404 page, the plugin avoids unnecessary processing for valid existing content.

## Use Cases:

- Redirecting old or outdated URLs to new content.
- Managing URL changes after a website redesign or migration.
- Consolidating duplicate content by redirecting variations to a canonical URL.
- Fixing broken links from external sources by redirecting them to relevant pages.
- Simplifying complex URL structures by redirecting to more user-friendly permalinks.
- This plugin provides a focused and efficient solution for administrators needing precise control over 301 redirects directly within their WordPress environment.

## Requirements

- PHP 8.0 or higher.
- Wordpress 6.8.0 or higher (may work on earlier versions but has not been tested).

## License

Adk Redirects is open source and released under MIT License. See [LICENSE](LICENSE.md) file for more information.

## About the Author

Adk Redirects is coded by [Jonathan Volks](https://jonathanvolks.com/). A marketing web developer who codes with simplicity in mind to build Marketing focused websites. Want to get in touch? [Visit my website](https://jonathanvolks.com/) to learn how to contact me.

