<?php
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$template_directory = get_template_directory();

include $template_directory . '/functions/tables/elements/fields/index.php';
include $template_directory . '/functions/tables/elements/forms/index.php';
include $template_directory . '/functions/tables/elements/forms-and-fields/index.php';
include $template_directory . '/functions/tables/elements/models/index.php';
include $template_directory . '/functions/tables/elements/models-and-forms/index.php';

include $template_directory . '/functions/tables/elements/organizations/index.php';
include $template_directory . '/functions/tables/elements/publications/index.php';
include $template_directory . '/functions/tables/elements/taxonomies/index.php';
include $template_directory . '/functions/tables/elements/terms/index.php';
include $template_directory . '/functions/tables/elements/glossaries/index.php';
include $template_directory . '/functions/tables/elements/qualis/index.php';
include $template_directory . '/functions/tables/elements/quantis/index.php';

include $template_directory . '/functions/tables/elements/terms-and-objects/index.php';

include $template_directory . '/functions/tables/elements/performances/index.php';
include $template_directory . '/functions/tables/elements/goodpractices/index.php';
include $template_directory . '/functions/tables/elements/objects/index.php';
include $template_directory . '/functions/tables/elements/sources/index.php';

include $template_directory . '/functions/tables/elements/graphs/index.php';

