<?php

/* 
  ========================================
  Emoji aus dem header entfernen
  ======================================== 
*/
  if( get_field('sys_remove_emoji', 'option') == 1 ) {
	add_action('init', 'opt_remove_emoji');

	if ( ! function_exists( 'opt_remove_emoji' ) ) :
		function opt_remove_tinymce_emoji($plugins) {
			if (!is_array($plugins)) {return array();}
			return array_diff($plugins, array('wpemoji'));
		}
		function opt_remove_emoji() {
			if( !is_admin() ) {
				remove_action('wp_head', 'print_emoji_detection_script', 7);
				remove_action('admin_print_scripts', 'print_emoji_detection_script');
				remove_action('admin_print_styles', 'print_emoji_styles');
				remove_action('wp_print_styles', 'print_emoji_styles');
				remove_filter('the_content_feed', 'wp_staticize_emoji');
				remove_filter('comment_text_rss', 'wp_staticize_emoji');
				remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
				add_filter('tiny_mce_plugins', 'opt_remove_tinymce_emoji');
				add_filter('emoji_svg_url', '__return_false');
			}
		}
	endif;
} // opt_remove_emoji


/* ========================================
   Login Shake entfernen (Admin Login wackelt wenn etwas falsch war)
   ======================================== */
if( get_field('sys_remove_login_shake', 'option') == 1 ) {
	add_action('login_head', 'opt_login_shake');
	if ( ! function_exists( 'opt_login_shake' ) ) :
		function opt_login_shake() {
			remove_action('login_head', 'wp_shake_js', 12);
		}
	endif; 
} // opt_login_shake


/* ========================================
   Remove query strings from static content (Performance)
   die an jedem css und js angehängten Versionen entfernen.
   Performance, da jede Version von Browser extra geladen wird
   ======================================== */
if( get_field('sys_remove_script_version', 'option') == 1 ) {
	add_action('init', 'opt_remove_scriptver');
	if ( ! function_exists( 'opt_remove_scriptver' ) ) :
		function opt_remove_query_strings_q( $src ) {
			if(strpos( $src, '?ver=' ))
				$src = remove_query_arg( 'ver', $src );
			return $src;
		}
		function opt_remove_scriptver() {
			if( !is_admin()) {
				add_filter( 'style_loader_src', 'opt_remove_query_strings_q', 9999, 2);
				add_filter( 'script_loader_src', 'opt_remove_query_strings_q', 9999, 2);
			}
		}
	endif; 
} // opt_remove_scriptver


/* ========================================
   Nicht benötigte Header Links entfernen (Performance)
   ======================================== 
Standardmäßig lädt WordPress mehrere Funktionen, Dienste und Skripte, die nicht zwingend erforderlich sind und normalerweise
Ihre Installation verlangsamen und Hosting-Ressourcen verschwenden. 
*/
if(get_field('sys_headlinks_entfernen', 'option')&& get_field('sys_headlinks_entfernen', 'option')['sys_remove_wp_generator'] == 1 ) {
	//Remove All Meta Generators
	function remove_meta_generators($html) {
    if($html){
      $pattern = '/<meta name(.*)=(.*)"generator"(.*)>/i';
      $html = preg_replace($pattern, '', $html);
    }
		return $html;
	}
	function clean_meta_generators($html) {
		ob_start('remove_meta_generators');
	}

	if( !is_admin() ) {
		remove_action('wp_head', 'wp_generator');
		add_action('get_header', 'clean_meta_generators', 100);
		add_action('wp_footer', function(){ ob_end_flush(); }, 100);
	}
}

/* Remove Feedlinks */
if(get_field('sys_headlinks_entfernen', 'option')&& get_field('sys_headlinks_entfernen', 'option')['sys_remove_feed_links'] == 1 ) {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
}

/* Remove Redundant shortlink */
if(get_field('sys_headlinks_entfernen', 'option')&& get_field('sys_headlinks_entfernen', 'option')['sys_remove_redundant_shortlink'] == 1 ) {
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
	remove_action('wp_head', 'wp_shortlink_header', 10, 0);
    remove_action('template_redirect', 'wp_shortlink_header', 11);
}

/* Remove parent post rel link */
if(get_field('sys_headlinks_entfernen', 'option')&& get_field('sys_headlinks_entfernen', 'option')['sys_remove_parent_post_rel_link'] == 1 ) {
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'rest_output_link_wp_head', 10, 0);
}

/* Remove adjacent post rel link */
if(get_field('sys_headlinks_entfernen', 'option')&& get_field('sys_headlinks_entfernen', 'option')['sys_remove_adjacent_posts_rel_link'] == 1 ) {
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
}

/* Remove adjacent post rel link */
if(get_field('sys_headlinks_entfernen', 'option')&& get_field('sys_headlinks_entfernen', 'option')['sys_remove_wlwmanifest'] == 1 ) {
	remove_action('wp_head', 'wlwmanifest_link');
}

/* ========================================
   XML-RPC in WordPress deaktivieren
   Genutzt wird XML-RPC für das Remote Posting via Microsoft Word, für Pingbacks,
   für die iOS und Android Apps, eben für Dinge, die nicht unbedingt jeder Nutzer
   auch verwendet oder gar benötigt.
   ======================================== */
if(get_field('sys_headlinks_entfernen', 'option')&& get_field('sys_headlinks_entfernen', 'option')['sys_remove_xmlrpc'] == 1 ) {
	add_filter( 'init', 'opt_remove_xmlrpc' );
	if ( ! function_exists( 'opt_remove_xmlrpc' ) ) :
		function opt_remove_x_pingback( $headers ) {unset( $headers['X-Pingback'] ); return $headers;}
		function opt_remove_xmlrpc() {
			if( !is_admin() ) {
				add_filter( 'xmlrpc_enabled', '__return_false' );
				add_filter( 'wp_headers', 'opt_remove_x_pingback' );
			}
		}
	endif;
} // opt_remove_xmlrpc

// end opt_removeheadlinks


/* ========================================
    Remove Gutenberg Block Library CSS from loading on the frontend
   ======================================== */
if( get_field('sys_remove_gutenberg', 'option') == 1 ) {
	function remove_wp_block_library_css()
	{
		wp_dequeue_style('wp-block-library');
		wp_dequeue_style('wp-block-library-theme');
		wp_dequeue_style('wc-blocks-style'); // Remove WooCommerce block CSS
	}
	add_action('wp_enqueue_scripts', 'remove_wp_block_library_css', 100);
}

/* ========================================
    Kommentare in Wordpress komplett deaktivieren
   ======================================== */
if( get_field('sys_disable_comments', 'option') == 1 ) {
	add_action('init', 'opt_disable_comments');
	if ( ! function_exists( 'opt_disable_comments' ) ) :
		function disable_comments_status() {return false;}
		function disable_comments_post_types_support() {
			$post_types = get_post_types();
			foreach($post_types as $post_type) {
				if (post_type_supports($post_type, 'comments')) {
					remove_post_type_support($post_type, 'comments');
					remove_post_type_support($post_type, 'trackbacks');
				}
			}
		}
		function disable_comments_hide_existing_comments($comments) {$comments = array();return $comments;}
		function disable_comments_admin_menu() {remove_menu_page('edit-comments.php');}
		function disable_menus_admin_bar_render() {global $wp_admin_bar;$wp_admin_bar->remove_menu('comments');}
		function opt_disable_comments() {
			add_filter('comments_open', 'disable_comments_status', 20, 2);
			add_filter('pings_open', 'disable_comments_status', 20, 2);
			add_action('admin_init', 'disable_comments_post_types_support');
			add_filter('comments_array', 'disable_comments_hide_existing_comments', 10, 2);
			add_action('admin_menu', 'disable_comments_admin_menu');
			add_action('wp_before_admin_bar_render', 'disable_menus_admin_bar_render');
		}
	endif;
} // opt_disable_comments


/* ========================================
    WP Embeds entfernen (wird als iframes von WP genutzt)
   ======================================== */
if(get_field('sys_wp_embeds_entfernen', 'option')&& get_field('sys_wp_embeds_entfernen', 'option')['sys_remove_filter_feed_content'] == 1 ) {
	// Remove content feed filter
	remove_filter('the_content_feed', '_oembed_filter_feed_content');
}

if( get_field('sys_wp_embeds_entfernen', 'option')&&get_field('sys_wp_embeds_entfernen', 'option')['sys_remove_embed_discover'] == 1 ) {
	// Avoid oEmbed auto discovery
	add_filter('embed_oembed_discover', '__return_false');
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'wp_oembed_add_host_js');
}

if(get_field('sys_wp_embeds_entfernen', 'option')&& get_field('sys_wp_embeds_entfernen', 'option')['sys_remove_maybe_load_embeds'] == 1 ) {
	add_action('init', 'opt_wp_embed');
	if ( ! function_exists( 'opt_wp_embed' ) ) :
		function opt_wp_embed() {
			global $wp, $wp_embed;

			if( !is_admin() ) {
				$wp->public_query_vars = array_diff($wp->public_query_vars, array('embed'));
				remove_filter('the_content', array($wp_embed, 'autoembed'), 8);

				// Abort embed libraries loading
				remove_action('plugins_loaded', 'wp_maybe_load_embeds', 0);

				// No auto-embedding support
				add_filter('pre_option_embed_autourls', '__return_false');

				// Remove header actions
				remove_action('embed_head', 'enqueue_embed_scripts', 1);
				remove_action('embed_head', 'print_emoji_detection_script');
				remove_action('embed_head', 'print_embed_styles');
				remove_action('embed_head', 'wp_print_head_scripts', 20);
				remove_action('embed_head', 'wp_print_styles', 20);
				remove_action('embed_head', 'wp_no_robots');
				remove_action('embed_head', 'rel_canonical');
				remove_action('embed_head', 'locale_stylesheet', 30);

				remove_action('embed_content_meta', 'print_embed_comments_button');
				remove_action('embed_content_meta', 'print_embed_sharing_button');

				remove_action('embed_footer', 'print_embed_sharing_dialog');
				remove_action('embed_footer', 'print_embed_scripts');
				remove_action('embed_footer', 'wp_print_footer_scripts', 20);

				remove_filter('excerpt_more', 'wp_embed_excerpt_more', 20);
				remove_filter('the_excerpt_embed', 'wptexturize');
				remove_filter('the_excerpt_embed', 'convert_chars');
				remove_filter('the_excerpt_embed', 'wpautop');
				remove_filter('the_excerpt_embed', 'shortcode_unautop');
				remove_filter('the_excerpt_embed', 'wp_embed_excerpt_attachment');

				// Remove data and results filters
				remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
				remove_filter('oembed_response_data', 'get_oembed_response_data_rich', 10);
				remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);

				// WooCommerce embeds in short description
				remove_filter('woocommerce_short_description', 'wc_do_oembeds');
				add_filter('tiny_mce_plugins', 'disableEmbedsTinyMcePlugin');
				add_filter('rewrite_rules_array', 'disableEmbedsRewrites');

				wp_deregister_script('wp-embed'); 
			}
		}
	endif;
}

function disableEmbedsTinyMcePlugin($plugins) {
	return array_diff($plugins, array('wpembed', 'wpview'));
}
function disableEmbedsRewrites($rules) {
	$new_rules = array();
	foreach($rules as $rule => $rewrite) {
		if( false !== ($pos = strpos($rewrite, '?')) ) {
			$params = explode('&', substr($rewrite, $pos + 1));
			if( in_array('embed=true', $params) ) {
				continue;
			}
		}
		$new_rules[$rule] = $rewrite;
	}
	return $new_rules;
}

// opt_wp_embed


/* ========================================
    Heartbeat von WordPress verlängern
   ======================================== */
if( get_field('sys_heartbeat', 'option') == 1 ) {
	function wb_set_heartbeat_time_interval($settings) {
		$settings['interval'] = get_field('sys_heartbeat_interval', 'option');
	}
	add_filter( 'heartbeat_settings', 'wb_set_heartbeat_time_interval' );
} // op_set_heartbeat


/* ========================================
    Sonstige WordPress Standards (Remove other unnecessary tags)
   ======================================== */
if( get_field('sys_global_styles', 'option') == 1 ) {
	remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
	remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
}
if( get_field('sys_global_styles_render_svg_filters', 'option') == 1 ) {
	remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
}


/* ========================================
    Standard WordPress Dashboard Widgets entfernen
   ======================================== */
function remove_dashboard_widgets() {
	global $wp_meta_boxes;

	if( get_field('wpdash_wp_welcome_panel', 'option') == 1 ) {
		remove_action('welcome_panel', 'wp_welcome_panel');
	}

	if( get_field('wpdash_dashboard_quick_press', 'option') == 1 ) {
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	}
	if( get_field('wpdash_dashboard_incoming_links', 'option') == 1 ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	}
	if( get_field('wpdash_dashboard_right_now', 'option') == 1 ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	}
	if( get_field('wpdash_dashboard_plugins', 'option') == 1 ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	}
	if( get_field('wpdash_dashboard_recent_drafts', 'option') == 1 ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	}
	if( get_field('wpdash_dashboard_recent_comments', 'option') == 1 ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	}
	if( get_field('wpdash_dashboard_primary', 'option') == 1 ) {
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	}
	if( get_field('wpdash_dashboard_secondary', 'option') == 1 ) {
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	}
	if( get_field('wpdash_dashboard_activity', 'option') == 1 ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	}
	if( get_field('wpdash_rank_math_dashboard_widget', 'option') == 1 ) {
		unset($wp_meta_boxes['dashboard']['normal']['high']['rank_math_dashboard_widget']);
	}
	if( get_field('wpdash_dashboard_site_health', 'option') == 1 ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health']);
	}
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

