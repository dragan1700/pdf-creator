# pdf creator Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## 1.0.6 - 2021-10-01
### Changed
- Replaced hard-coded base-path variables with .env variable

## 1.0.6 - 2021-10-01
### Added
- PDF Cover page with illustration and logo
- Plugin logo (seen in control panel)
- Page list created dynamically after site-selection
- Updated composer.json to include the HTML5-compatible DOMDocument parser ivopetkov/html5-dom-document-php
- README

## 1.0.5 - 2021-09-29
### Added
- Site chooser (select menu)
- Page list created after site-selection (w.i.p.)

## 1.0.4 - 2021-09-28
### Added
- Control panel with list of pages for report selection
- Sortable pages
- Trash area to remove pages from selection
- Multi-drag support
- CSS and markup changes (moved page URL to far right, to prevent accidental opening a URL inside the control panel)
- Service to handle the PDF logic
- Added an HTML5-compatible DOMDocument library to handle HTML5 tags like nav, main etc.
- Added service to controller ("stitch it all together")
- Code-cleanup and @todo remarks for future development

## 1.0.0 - 2021-09-22
### Added
- Initial release
