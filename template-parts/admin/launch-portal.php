<?php

wp_enqueue_script( 'launch_portal_structure', 'https://hewittmatthews.co.uk/wp-content/themes/hewitt-matthews/includes/launch-portal/launch-portal-structure.js', array(), THEME_VERSION);
wp_enqueue_script( 'launch_portal_script', 'https://hewittmatthews.co.uk/wp-content/themes/hewitt-matthews/includes/launch-portal/launch-portal.js', array('jquery'), THEME_VERSION);
wp_localize_script( 'launch_portal_structure', 'websiteName', array( 'website_name' => get_bloginfo('name') ) );
wp_localize_script( 'launch_portal_script', 'websiteName', array( 'website_name' => get_bloginfo('name') ) );
wp_localize_script( 'launch_portal_script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
wp_enqueue_style( 'launch_portal_styles', 'https://hewittmatthews.co.uk/wp-content/themes/hewitt-matthews/includes/launch-portal/launch-portal.css', array(), THEME_VERSION);

?>