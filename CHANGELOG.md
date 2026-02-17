# Changelog

All notable changes to this project will be documented in this file.

## [1.1.0] - 2026-02-17

### Added
- Added complete modal content for Help, Terms, and Privacy.
- Added footer follow links: GitHub and Xifeng.
- Added page-level wide layout support (`page_content_class`, `page_inner_class`) for static pages.

### Changed
- Reworked homepage "Why Choose" cards to a new layout: large icon as top-right background and left-aligned content.
- Updated footer brand and copyright to lowercase `://domain.ls`.
- Updated footer logo style to a stronger brand presentation (bold, branded type).
- Updated modal typography rules: Chinese content uses PingFang; English markers use Cairo Play.
- Improved logo hover animation: center-origin scale with smoother transform performance.
- Adjusted WHOIS page container width behavior to align with homepage wide layout.

### Fixed
- Fixed unstable homepage logo hover zoom behavior.
- Fixed WHOIS page width not applying due to global container constraints.
- Fixed footer logo being selectable by adding non-selectable styles.

