# downloads-sasd v0.1.0

Initial public release of the `downloads-sasd` project.

`downloads-sasd` is the foundation of the future `downloads.sasd.de` platform of SASD GmbH. This first release establishes a clean, lightweight and extensible PHP-based catalog application for distributing software artifacts, manuals, training materials and related downloadable resources.

The project is intentionally designed as a pragmatic first implementation: simple enough to start quickly, but structured in a way that supports future growth, including a later migration from JSON-backed storage to a database-backed architecture.

## Release Overview

Version `v0.1.0` introduces the initial application skeleton and the first functional catalog workflow. The project already provides a clear separation between HTTP handling, controllers, services, repositories, views, configuration, catalog data and static assets.

This release focuses on the following goals:

- establishing a maintainable architectural baseline
- supporting direct artifact discovery via `downloads.sasd.de`
- preparing the platform for multilingual growth
- enabling a file-based and metadata-driven workflow without requiring a database
- keeping the migration path to a more advanced implementation open

## Included in This Release

### Application Foundation

The first release ships with a lightweight PHP application structure centered around a front controller and a clean internal separation of responsibilities.

Included are:

- a public entry point
- bootstrap and configuration loading
- HTTP routing foundation
- dedicated controllers for core pages and download flows
- services for catalog and search logic
- repository abstractions prepared for future backend replacement
- view templates for the public-facing pages

The structure is intentionally conservative and framework-light in order to remain transparent, understandable and easy to evolve.

### JSON-Backed Catalog Architecture

This version uses JSON-based metadata as the initial storage model. Catalog entries and artifact information are managed through structured files rather than a relational database.

This provides several practical benefits for the initial phase:

- low operational complexity
- fast setup
- easy manual maintenance
- straightforward versioning through Git
- reduced infrastructure requirements
- a clean foundation for later repository replacement

The internal design already anticipates a future transition to database-backed repositories.

### Public Download Catalog

The release includes the first functional catalog concept for downloadable resources.

Supported content types include:

- software products
- downloadable artifacts
- manuals and documentation
- books and companion material
- training documents
- archive-ready resources

The application is designed so that users can discover artifacts directly through the download domain, even without first visiting a separate product or software presentation site.

### Search and Filtering

A first searchable catalog experience is included in this release.

The implementation supports:

- basic catalog browsing
- search-based artifact discovery
- filterable listings
- product and artifact detail pages
- a dedicated download flow

This provides the baseline for a user-friendly distribution platform and prepares the codebase for future refinement of search, indexing and filtering behavior.

### Multilingual Foundation

Internationalization is already considered in `v0.1.0`.

This release includes:

- German language support
- English language support
- language files for interface text
- content structures prepared for multilingual catalog data

This foundation is intended to support future expansion into additional languages such as French, Spanish, Portuguese, Italian, Polish, Turkish, Arabic, Hindi, Korean, Chinese and Japanese.

The project is therefore not merely translated at the surface level; multilingual support is part of the structural design from the beginning.

### CLI Support for Catalog Maintenance

To keep the first version practical and maintainable, CLI tooling is already included for catalog-related tasks.

This release provides scripts for:

- catalog validation
- catalog rebuilding

These tools support a workflow that remains simple and reliable without introducing a full administrative backend too early.

### Documentation and Repository Readiness

The repository has been prepared to be presentable and usable from the start.

Included in this release are:

- project README
- MIT license
- repository metadata
- `.gitignore`
- project mockup/screenshot
- example data and placeholder files

This ensures that the release is not only technically functional, but also professionally documented as a public project foundation.

## Architectural Intent

`downloads-sasd` is not meant to be a throwaway prototype. Even in this initial release, the codebase follows a deliberate architectural direction.

The most important decisions in this version are:

- file-based storage first, database later
- repository abstraction instead of direct file access throughout the application
- clear separation between catalog logic and presentation
- early multilingual preparation
- stable conceptual basis for future SASD product distribution workflows

This makes `v0.1.0` a foundational release rather than a temporary sketch.

## Current Scope and Known Limitations

As an initial release, `v0.1.0` intentionally keeps the scope focused.

Not yet included in this version are:

- a browser-based administrative backend
- authenticated editorial workflows
- upload staging and publication workflows
- database-backed repositories
- advanced search indexing
- pagination and performance tuning for large catalogs
- cryptographic signing workflows
- release automation and CI quality gates

These omissions are intentional and consistent with the current project phase. The goal of this release is to establish a solid and understandable base before adding operational complexity.

## Intended Next Steps

The following areas are natural candidates for future releases:

- internal editorial and upload interface
- richer artifact metadata and validation rules
- improved filtering and sorting
- archive and lifecycle handling
- checksum and signature workflows
- database-backed repository implementations
- expanded language support
- CI-based validation and release quality checks

## Compatibility and Usage

This release is intended as the first working baseline for local development, architectural discussion and iterative extension.

It is suitable for:

- repository initialization
- local development
- architectural review
- UI and workflow refinement
- catalog modeling
- preparation of a future production deployment

## License

This project is released under the MIT License.

## Closing Note

Version `v0.1.0` marks the starting point of the `downloads.sasd.de` platform effort. It provides a serious architectural baseline, a coherent repository structure and a practical implementation approach aligned with the long-term SASD direction: clear structure, maintainability, multilingual readiness and a deliberate path from simple beginnings to a more capable product platform.
