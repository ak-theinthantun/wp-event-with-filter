# Description

Event Filter Pro is an advanced filtering system for Events custom post type in WordPress. It offers an intuitive filtering interface with support for AJAX and REST API, making it fast and user-friendly.

# Features

- AJAX-based filtering for seamless user experience.
- REST API support for flexible integration.
- Filter by search, event type, and event category.
- Sorting options for newest to oldest or oldest to newest.- - - Customizable per-page options.
- Easy shortcode integration.
- Secure API with nonce verification.

# Installation

- Download the plugin ZIP file.
- Go to your WordPress dashboard.
- Navigate to Plugins > Add New > Upload Plugin.
- Upload the ZIP file and activate the plugin.

# Usage

Use the shortcode [event_filter] to display the filter on any page.

Customize with attributes like [event_filter per_page_options="3,6,9,12"].

# REST API
- Endpoint: /wp-json/event-filter/v1/events
- Supported parameters:
- search: Search query.
- event_type: Event type slug.
- event_category: Event category slug.
- sort: Sorting option (newest or oldest).
- per_page: Number of items per page.
- page: Current page number.

# Development

- Clone the repo.
- Customize the code as needed.

# Support

If you encounter any issues or have questions, please contact txeintxanxtun@gmail.com
