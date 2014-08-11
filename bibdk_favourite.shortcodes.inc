<?php

/** Implements hook_shortcode_info
 *
 * @return mixed
 */
function bibdk_favourite_shortcode_info() {
  // Quote shortcode example
  $shortcodes['favourite_library'] = array(
    'title' => t('Favourite Library'),
    'description' => t('Insert favourite library'),
    'process callback' => 'bibdk_favourite_shortcode_favourite_library',
    'tips callback' => 'bibdk_favourite_shortcode_favourite_library_tip',
    'attributes callback' => '_shortcode_settings_form',
    'default settings' => array(),
  );

  return $shortcodes;
}

function bibdk_favourite_shortcode_favourite_library($attributes, $default_text) {
  $favourites = array();
  if (ding_user_is_provider_user()) {
    $favourites = bibdk_favourite_get_favourites();
  }

  if (!empty($favourites)) {
    $favourite = reset($favourites);
    return drupal_render(bibdk_favourite_form_view_items_from_session($favourite, 0, false, false));
  }

  return t($default_text);
}

function bibdk_favourite_shortcode_favourite_library_tip() {
  return 'dette er en test';
}
