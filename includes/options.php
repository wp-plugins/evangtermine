<?php
// Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Optionsmenü hinzufügen
function et_menu() {
	add_options_page( 'Evangelische Termine Options', 'Evangelische Termine', 'manage_options', 'options.php', 'et_options' );
}
add_action( 'admin_menu', 'et_menu' );

function et_show_section() {
	echo "<p>Hier können Sie die Grundeinstellungen für das Plugin vornehmen. Die Grundeinstellungen können aber über die Parameter der Shortcodes/Makros und des Widgets verändert werden.</p>";
}

// Inputfelder
// Veranstalter-ID(s): kommagetrennte Liste der Veranstalter-IDs der Evangelischen Termine
function et_show_vid() {
	$vid = get_option( 'vid' );
	echo '<input name="vid" type="text" value="' . $vid . '" />';
}
// Dekanats-ID: Dekanatsnummer
// Diese ID ist in den Shortcodes/Makros und im Widget nicht überschreibbar.
function et_show_region() {
	$region = get_option( 'region' );
	echo '<input name="region" type="text" value="' . $region . '" />';
}
// Gruppenadministrator-ID: In der Veranstalterauswahl werden die zugehörigen Veranstalter angezeigt.
// Diese ID ist in den Shortcodes/Makros und im Widget nicht überschreibbar.
/*
function et_show_aid() {
	$aid = get_option( 'aid' );
	echo '<input name="aid" type="text" value="' . $aid . '" />';
}
*/

// Über diesen Schalter wird eingestellt, ob ein Termin bis zum Ablauf angezeigt wird oder mit Beginn
// des Termins von der Anzeige ausgeschlossen wird.
function et_show_until() {
	$until = get_option( 'until' ) ? get_option( 'until' ) : ET_OPTION_UNTIL;
	$items = array ( 'yes', 'no' );
	echo '<select id="et_option_until" name="' . $plugin_options[ 'until' ] . '">';
	foreach ( $items as $item ) {
	 	 $selected = ( $until == $item ) ? 'selected="selected"' : '';
	 	 echo '<option value="' . $item . '" ' . $selected . '>' . $item . '</option>';
	} 
	echo '</select>';
}

// Eigene CSS-Datei. Dadurch werden die CSS-Einstellungen der Evangelischen Termine überschrieben. 
function et_show_css() {
	$css = get_option( 'css' );
	echo '<input name="css" type="text" value="' . $css . '" />';
}

// Encoding der Website einstellen
function et_show_encoding() {
	$encoding = get_option( 'encoding' ) ? get_option( 'encoding' ) : ET_DEFAULT_CHARSET;
	$items = array ( 'utf8', 'latin1' );
	echo '<select id="et_option_encoding" name="' . $plugin_options[ 'encoding' ] . '">';
	foreach ( $items as $item ) {
	 	 $selected = ( $encoding == $item ) ? 'selected="selected"' : '';
	 	 echo '<option value="' . $item . '" ' . $selected . '>' . $item . '</option>';
	} 
	echo '</select>';
}

// Aufbau der Optionen
function et_options() {
	if( !current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
?>
<div class="wrap">
	<h2><?php _e('Evangelische Termine'); ?></h2>
	<form method="post" action="options.php">
		<?php settings_fields( 'et_group' ); ?>
		<?php do_settings_sections( 'et_menu_slug' ); ?>
		<?php submit_button(); ?>
	</form>
</div>
<?php
}

// Optionsseite initialisieren
function et_admin_init() {
	add_settings_section( 'et_section', 'Grundeinstellungen', 'et_show_section', 'et_menu_slug' );
	
	add_settings_field( 'vid', 'Veranstalter-ID (bei mehreren Veranstaltern kommagetrennt): ', 'et_show_vid', 'et_menu_slug', 'et_section' );
	add_settings_field( 'region', 'Dekanats-ID: ', 'et_show_region', 'et_menu_slug', 'et_section' );
//	add_settings_field( 'aid', 'Gruppenadministrator-ID: ', 'et_show_aid', 'et_menu_slug', 'et_section' );
	add_settings_field( 'until', 'Until: ', 'et_show_until', 'et_menu_slug', 'et_section' );
	add_settings_field( 'css', 'CSS-Datei: ', 'et_show_css', 'et_menu_slug', 'et_section' );
	add_settings_field( 'encoding', 'Encoding: ', 'et_show_encoding', 'et_menu_slug', 'et_section' );
		
	register_setting( 'et_group', 'vid' );
	register_setting( 'et_group', 'region' );
//	register_setting( 'et_group', 'aid' );
	register_setting( 'et_group', 'until' );
	register_setting( 'et_group', 'css' );
	register_setting( 'et_group', 'encoding' );
}
add_action( 'admin_init', 'et_admin_init' );
	
?>
