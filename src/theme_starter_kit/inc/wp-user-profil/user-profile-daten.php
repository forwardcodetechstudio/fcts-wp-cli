<?php
/* ============================================================================== 
	User Profile Demo
 ============================================================================== */
/**
 * Function: User custom fields
 * Description: 
 *   Hinzufügen von Demo Feldern in den WP-User 
 *   Zweck: Das "User Profile Tabs" zu Testen
 *   In Wordpress ist die Hauptüberschrift "Profil" in H1 Tag
 *   Zur Trennung der Blöcke untereinander sind Überschriften in H2 Tags gesetzt
 *   Dann gibt es evtl. noch Sub-Überschriften in H3 Tags
 *   Es gibt 2 Alternativen:
 *      Wir gestalten alle H2 Tags als Registerkarte (schaut besser aus), als Trennung verwenden wir -----------
 *      Wir nutzen als Gruppenüberschrift anstelle von H2 Tags, H4 Tags, somit bleiben alle WP eigenen Daten oberhalb der Registerkarten
 *      Dazu muss im Javascript die Zeilen: 126, 130 und 134 angepasst werden
*/

add_action( 'show_user_profile', 'cust_profile_fields' );
add_action( 'edit_user_profile', 'cust_profile_fields' );
function cust_profile_fields( $user ) {
	?>
    <?php
}

function display_acf_fields($post_id,$group_field_name,$title,$field_id){
  // $group_field_name = 'contact_details';
  $fields = acf_get_field($field_id);
  if ($fields) {
    // debug($fields);
    echo "<h2>$title</h2>";
    echo '<table class="form-table">';
    // acf_render_field_wrap($fields,'tr');
    foreach ($fields['sub_fields'] as $field) {
        $sub_field_name = $group_field_name . '_' . $field['name'];
        $sub_field_value = get_field($sub_field_name, $post_id);
        $field['value'] = $sub_field_value;
        $field['prefix'] = "acf[$group_field_name]";
        acf_render_field_wrap($field,'tr');
        }
        echo '</table>';
  }
}

// add_action('personal_options_update', 'save_custom_acf_user_fields');
// add_action('edit_user_profile_update', 'save_custom_acf_user_fields');

// function save_custom_acf_user_fields($user_id) {
//     if (!current_user_can('edit_user', $user_id)) {
//         return false;
//     }
// }