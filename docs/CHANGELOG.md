# Changelog

All notable changes to this project will be documented in this file.

The format is inspired by *Keep a Changelog* and the project aims to follow
[Semantic Versioning](https://semver.org/) where practical.

---

## [Unreleased]

### Planned
- Internal editorial workflow for adding and managing products and artifacts
- Extended metadata validation and catalog integrity checks
- Improved search, filtering and sorting capabilities
- Additional language support beyond German and English
- Optional database-backed repository implementations
- Checksum and signature workflow improvements
- CI-based validation and release quality checks

---

## [0.1.0] - 2026-03-31

### Added
- Initial public project release of `downloads-sasd`
- Lightweight PHP-based application foundation for the future `downloads.sasd.de` platform
- Clean project structure with separation of public entry point, configuration, application bootstrap, domain logic, repositories, services and views
- Front controller-based request handling
- Initial controller and routing structure for catalog, product, artifact and download-related pages
- JSON-backed catalog architecture as the first storage model
- Repository abstraction prepared for future migration to database-backed implementations
- Initial public catalog concept for software downloads, manuals, books, training material and related artifacts
- Product and artifact discovery workflows independent of a separate software presentation domain
- Search and filter foundation for catalog navigation
- Product and artifact detail page concept
- Basic download delivery flow
- Multilingual foundation with German and English support
- Language file structure prepared for future expansion to additional languages
- Catalog validation CLI script
- Catalog rebuild CLI script
- Example catalog data and placeholder artifact structure
- Repository documentation including README, license, repository metadata and project screenshot
- `.gitignore` and repository preparation for public version control hosting

### Changed
- Established the initial architectural baseline for a file-based first version with a clear migration path toward a later database-backed implementation

### Notes
- This version intentionally keeps the scope limited in order to establish a clean, understandable and extensible foundation
- No browser-based administrative backend is included in this release
- No authenticated editorial workflow is included in this release
- No database integration is included in this release
- Advanced search indexing, release automation and CI quality gates are deferred to future versions

---

## Versioning Notes

This project uses the changelog to document user-visible and repository-relevant
changes at a professional level. Early releases may include foundational
architectural milestones in addition to functional changes, because those
decisions are relevant to maintainability, migration strategy and long-term
product direction.
