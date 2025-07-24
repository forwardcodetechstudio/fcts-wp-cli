<?php
add_action('wp_head',function(){
  echo get_field('analytics_script_head','option')??'';
});
add_action('wp_body_open',function(){
  echo get_field('analytics_script_body','option')??'';
});
add_action('wp_footer',function(){
  echo get_field('analytics_script_footer','option')??'';
});
