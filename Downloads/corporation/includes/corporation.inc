<?php

/**
 * @file
 * Corporation.inc.
 *
 * Filename:     corporation.inc
 * Website:      http://www.ordasoft.com
 * Description:  template
 * Author:       ordasoft dev team ordasoft.com.
 */

/**
 * Get theme functionalities.
 */
function corporation_get_theme(&$variables) {
  corporation_load_debuggers($variables);
  corporation_add_libraries();
}

/**
 * Get the path to the static files folder in the theme.
 */
function corporation_get_staticpath($addprefix = FALSE, $theme_key = 'corporation') {
  $ret = '';
  if ($addprefix) {
    $ret = '/';
  }
  $ret .= drupal_get_path('theme', $theme_key) . '/static/';
  return $ret;
}

/**
 * Add meta tags to the html header.
 */
function corporation_add_head_items() {
  $viewport = theme_get_setting('os_viewport');
  if (!empty($viewport)) {
    $user_scalable = theme_get_setting('os_viewport_user_scaleable');
    $initial_scale = theme_get_setting('os_viewport_initial_scale');
    $minimum_scale = theme_get_setting('os_viewport_minimum_scale');
    $maximum_scale = theme_get_setting('os_viewport_maximum_scale');
    $content = "width=device-width, initial-scale=" . $initial_scale . ", minimum-scale=" . $minimum_scale . ", maximum-scale=" . $maximum_scale . ", user-scalable=" . $user_scalable;
    $element = array(
      '#tag' => 'meta',
      '#attributes' => array(
        'name' => 'viewport',
        'content' => $content,
      ),
    );
    drupal_add_html_head($element, 'os-viewport');
  }

  $cleartype = theme_get_setting('os_cleartype');
  if (!empty($cleartype)) {
    $meta = array(
      '#tag' => 'meta',
      '#attributes' => array('http-equiv' => 'cleartype', 'content' => 'on'),
    );

    drupal_add_html_head($meta, 'os-cleartype');
  }
}
