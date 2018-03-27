<?php

/**
 * @file
 * theme-settings.php
 *
 * Provides theme settings.
 *
 * @see ./includes/settings.inc
 */

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_FORM_ID_alter().
 */
function neon_form_system_theme_settings_alter(&$form, FormStateInterface $form_state, $form_id = NULL) {
  $base_theme_path = drupal_get_path('theme', 'mbase');
  if (!$base_theme_path) {
    $form = array();
    $form['nombase'] = array(
      '#type' => 'markup',
      '#title' => t('Error'),
      '#markup' => '<div class = "nombasetheme">This theme depend on
        <strong><a href = "https://www.drupal.org/project/mbase" target = "_blank">mbase</a></strong>
        base theme. Please install <strong><a href = "https://www.drupal.org/project/mbase" target = "_blank">
        mbase</a></strong> theme first. Please read the readme.txt file.</div>',
    );
    unset($form['olor_scheme_form']);
  }
  else {
    include_once $base_theme_path . '/includes/helper.inc';
    $regions = array(
      'home_welcome' => t('Homepage Welcome'),
      'home_about' => t('Homepage About content'),
      'footer' => t('Footer'),
      'footer_copyright' => t('Footer Copyright'),
      'footer_menu' => t('Footer Menu'),
    );
    $home_page_settings = _mbase_homepage_settings($regions, 'neon');
    $form = $form + $home_page_settings;
  }

  // Settings for Footer map and contact form.
  $form['footersettings']['footersextra'] = array(
    '#type' => 'details',
    '#title' => t('Footers Extra'),
    '#group' => 'footersettings',
    '#weight' => -10,
  );
  $contact_forms = _mbase_neon_get_contact_form_list();
  if ($contact_forms) {
    $default_contact_form = _mbase_setting('contact_form', 'neon', NULL);
    $form['footersettings']['footersextra']['contact_form'] = array(
      '#type' => 'select',
      '#title' => t('Select Contact form'),
      '#options' => $contact_forms,
      '#default_value' => $default_contact_form ? $default_contact_form : '-',
      '#description' => 'Select the contact form to appear in page footer, Make sure you gave proper permission to view the form.',
    );
  }
  $default_map = 'https://maps.google.co.in/maps?f=q&source=s_q&hl=en&geocode=&q=putharachal,+Tamil+Nadu&aq=0&oq=CMSbots.com&sspn=5.674603,10.755615&ie=UTF8&hq=&hnear=putharachal,+Tamil+Nadu&t=m&z=12&output=embed';
  $default_footer_map = _mbase_setting('footer_map', 'neon', NULL);
  $form['footersettings']['footersextra']['footer_map'] = array(
    '#type' => 'textfield',
    '#title' => t('Footer Map'),
    '#maxlength' => 1023,
    '#default_value' => trim($default_footer_map) ? $default_footer_map : $default_map,
    '#description' => t('Paste the google map link, make sure its embedable in iframe.'),
  );

  unset($form['advanced']['mbase_credits']);
}
