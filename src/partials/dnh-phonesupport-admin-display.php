<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://digitalnomadhungary.com
 * @since      1.0.0
 *
 * @package    DnhPhonesupport
 * @subpackage DnhPhonesupport/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<form method="POST" action='options.php'>
    <?php
    settings_fields($this->plugin_name);
    do_settings_sections('phonesupport-settings-page');
    submit_button();
    ?>
</form>
