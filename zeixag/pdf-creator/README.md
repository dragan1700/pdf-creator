# pdf creator plugin for Craft CMS 3.x

create PDFs

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires
- Craft CMS 3.0.0-beta.23 or later
- ivopetkov/html5-dom-document-php:2.* (PHP's own DOMDocument parser doesn't recognize HTML5 tags)

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require /pdf-creator

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for pdf creator.

## pdf creator Overview

- The plugin creates PDFs from a selection of Craft pages. Typical use-cases might be annual reports or catalogues.
- Each PDF has a cover page, and a dynamic table to contents.
- PDF meta data (author, description etc.) can be set inside the control panel, as well as the filename.
- PDFs are password-protected for edits - only open, copy + print is enabled, all other features are disabled (can be easily changed in the code).
- The plugin stores PDFs alongside with HTML files, the latter being only generated for debugging.
- The plugin basically fetches each page via URL, grabs the content inside <main></main>, and makes sure the document heading structure is intact.
- What is an h1 on the web-page, will be an h2 in the PDF. This was taken into account to ensure accessibility best-practice.

## Configuring pdf creator

- Currently, the plugin doesn't have any settings page. All configurations have to be made manually inside the code.

## Using pdf creator

- Go to the control panel, select a site, select pages, enter title, filename etc., and hit the "Generate PDF" button.
- Use at your own risk.

## pdf creator Roadmap

Some things to do, and ideas for potential features:

* Code clean-up: avoid too much inline JS and CSS in the template/index.twig file (and elsewhere).
* Optimize print stylesheet: Each site has its own frontend components and styles; therefore we can't ensure every possible HTML + CSS thrown at mpdf (the underlying PHP library that does all the
  dirty work) will look pretty in the PDF. But we can identify some common frontend problems when it comes to print.
* Indicate loading / spinner when we still wait for the PDF-generation response
* Settings page inside Craft, to avoid having to touch code for configurations / settings.
* Create plugin-icon (the one that is currently the defult plug - seen in settings/plugins).
* Eventually release it (?)

Brought to you by [Dragan Nikolic @ Zeix](https://zeix.com/team/dragan-nikolic/)
