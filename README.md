# Pixel Quest - Starter Kit

This Drupal Module comes with some pre-defined sub-modules to help get a Drupal Website configured, as well as some enhanced functionality.

**WARNING:** While there aren't any strict composer requirements on this package, there are some Drupal requirements / additional contrib modules that are necessary. Please view the `Extend` and review the `Requires:` list for each of the following.

### Administrative Enhancements
This module helps by giving an enhanced version of the general /admin/content, /admin/content/media views. It also introduces some Bulk Actions that will help with Publishing and Archiving revision content, general pathauto patterns, and more.

### Smart Paths
This module introduces two content type fields: A Reference Field called `Parent Content` and an Optional Title field called `Optional Path`. Together, along with the pathauto pattern, this will help give your site a way to nest content within their respective paths. In addition, if you update a path that has sub paths associated with it, those other pieces of content will have their paths updated as well.

### Smart Layout Styles
This module introduces a split for the utilization of Layout Builder Styles. Meaning this takes the defined and set customized styles out of the full `attributes.class` and puts them into their own arrays for easier use in designing Layout Builder twig templates and styling.

### Starter Content
This module creates three different content types: Basic, Landing, and Home Pages. Once you enable and the configuration is imported, you can then disable this module, making it a clean end-result.

### Starter Media
This module helps create the basic media types a site could use: Document, Image, Audio, Remote Video and Local Video. Once you enable and the configuration is imported, you can then disable this module, making it a clean end-result.

### Starter Users
This module helps define additional fields for your users. Once you enable and the configuration is imported, you can then disable this module, making it a clean end-result.
