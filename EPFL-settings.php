<?php
/*
 * Plugin Name: EPFL General settings
 * Description: General settings for allow users
 * Version:     1.4
 * Author:      <a href="mailto:wwp-admin@epfl.ch">wwp-admin@epfl.ch</a>
 * Text Domain: EPFL-settings
 */


function EPFL_settings_load_plugin_textdomain() {
  // wp-content/plugins/plugin-name/languages/EPFL-settings-fr_FR.mo
  load_plugin_textdomain( 'EPFL-settings', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'EPFL_settings_load_plugin_textdomain' );


function EPFL_settings_register_settings() {
   add_option( 'EPFL_settings_option_name', 'This is my option value.');
   register_setting( 'EPFL_settings_options_group', 'EPFL_settings_option_name', 'EPFL_settings_callback' );
   register_setting( 'EPFL_settings_options_group', 'blogname' );
   register_setting( 'EPFL_settings_options_group', 'blogdescription' );
   register_setting( 'EPFL_settings_options_group', 'WPLANG' );
   register_setting( 'EPFL_settings_options_group', 'epfl_google_analytics_id' );
   register_setting( 'EPFL_settings_options_group', 'epfl_hide_coronavirus_info_header' );
}
add_action( 'admin_init', 'EPFL_settings_register_settings' );


//add menu EPFL settings under settings menu
function EPFL_settings_register_options_page() {
  add_options_page('EPFL settings', 'EPFL settings', 'manage_options', 'EPFL_settings', 'EPFL_settings_options_page');
}
add_action('admin_menu', 'EPFL_settings_register_options_page');

//config settings page
function EPFL_settings_options_page()
{
?>
  <div>
  <?php screen_icon(); ?>
  <h2><?php echo __("General Settings", 'EPFL-settings');?></h2>
  <form method="post" action="options.php">
  <?php settings_fields( 'EPFL_settings_options_group' ); ?>
  <?php $lang = get_site_option( 'WPLANG' );  $languages = get_available_languages();?>

  <table class="form-table">
    <tbody><tr>
      <th scope="row"><label for="blogname"><?php echo __ ("Site Title", 'EPFL-settings');?></label></th>
      <td><input type="text" id="blogname" name="blogname" value="<?php echo get_option('blogname'); ?>" />
        <p class="description" id="tagline-description"><?php echo __ ("Acronym (example : IC)", 'EPFL-settings');?></p>
        <p class="description" id="tagline-description"><a href="<?php admin_url(); ?> admin.php?page=mlang_strings"><?php echo __ ("Site Title translation", 'EPFL-settings');?></a></p></td>
    </tr>
    <tr>
      <th scope="row"><label for="blogdescription"><?php echo __ ("Tagline", 'EPFL-settings');?></label></th>
      <td><input type="text" id="blogdescription" name="blogdescription" value="<?php echo get_option('blogdescription'); ?>" />
      <p class="description" id="tagline-description"><?php echo __ ("Explicit name (example : School of Computer and Communication Sciences)", 'EPFL-settings');?></p>
      </td>
    </tr>
    <tr>
      <th scope="row"><label for="WPLANG"><?php echo __ ("Site administration Language", 'EPFL-settings'    );?></label></th>
      <td><?php wp_dropdown_languages(array('name' => 'WPLANG', 'id' => 'site-language', 'selected' => $lang, 'languages' => $languages, 'show_available_translations' => false)); ?></td>
    </tr>
    <tr>
      <th scope="row"><label for="plugin:epfl_accred:unit_id"><?php echo __ ("Accred Unit", 'EPFL-settings');?></label></th>
      <td><a href="https://units.epfl.ch/#/unites/<?php echo get_option('plugin:epfl_accred:unit_id'); ?>" target="blank"><label for="plugin:epfl_accred:unit_id"><?php echo get_option('plugin:epfl_accred:unit_id'); ?></label></a></th>
      <p class="description" id="tagline-description"><?php echo __ ("Accred unit allowed to manage this Wordpress site", 'EPFL-settings');?></p>
      </td>
    </tr>
    <tr>
      <th scope="row"><label for="epfl_google_analytics_id"><?php echo __ ("Additional Google Analytics ID", 'EPFL-settings');?></label></th>
      <td>
        <input type="text" id="epfl_google_analytics_id" name="epfl_google_analytics_id" value="<?php echo get_option('epfl_google_analytics_id'); ?>" />
        <p class="description" id="tagline-description"><?php echo __ ("Set an additionnal Google Analytics for custom tracking (ex: UA-4833294-1)", 'EPFL-settings');?></p>
      </td>
    </tr>
    <?php # this entry is reserved for admin
    if (current_user_can('administrator')):
    ?>
    <tr>
      <th scope="row"><label for="epfl_hide_coronavirus_info_header"><?php echo __ ("'Coronavirus info' links", 'EPFL-settings');?></label></th>
      <td>
        <input type="checkbox" id="epfl_hide_coronavirus_info_header" name="epfl_hide_coronavirus_info_header" value="1" <?= checked( 1, get_option( 'epfl_hide_coronavirus_info_header' ), false ) ?> />
        <?php echo __ ("Hide the coronavirus info links (header and in the menu)", 'EPFL-settings');?>
      </td>
    </tr>
    <?php endif; ?>
  </table>
  <?php  submit_button(); ?>
  </form>
  </div>
<?php
} ?>
