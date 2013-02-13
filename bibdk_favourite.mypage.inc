<?php

/**
 * Implements hook_bibdk_mypage_tabs().
 */
function bibdk_favourite_bibdk_mypage_tabs($max_rows=3) {

  global $user;
  require_once (DRUPAL_ROOT . '/profiles/bibdk/modules/ting_agency/TingAgency.php');

  $form['bibdk_favourite'] = array(
    '#type'         => 'fieldset',
    '#tree'         => TRUE,
    '#theme'        => 'bibdk_mypage-form',
    '#attributes'   => array('class' => array('element-wrapper', 'bibdk-mypage-wrapper')),
  );

  $form['bibdk_favourite']['header'] = array(
    '#type'           => 'markup',
    '#markup'         => t('Favourites'),
  );

  $form['bibdk_favourite']['rows'] = array(
    '#type'         => 'fieldset',
    '#tree'         => TRUE,
  );

  $agencies = isset($_SESSION['bibdk_favourites']) ? $_SESSION['bibdk_favourites'] : array();
  if ( sizeof($agencies) > 0 ) {
    $agencies = array_slice($agencies, 0, $max_rows);
    foreach ($agencies as $id => $favourite) {
      $favourite = unserialize($favourite);
      $branch = $favourite->getBranch();
      if (empty($branch)) {
        break;
      }
      $form['bibdk_favourite']['rows'][$id] = array(
        'label_row'  => array(
                            '#type'     => 'markup',
                            '#markup'   => $branch->branchName,
                           ),
        'value_row'  => array(
                            '#type'     => 'markup',
                            '#markup'   => ( $favourite->orderAgency ) ? t('(Order agency)') : NULL,
                           ),
      );
    }
  }
  else {
    $form['bibdk_favourite']['rows'] = array(
        '#type'     => 'markup',
        '#markup'   => t('No favorites selected yet'),
    );
  }

  $form['bibdk_favourite']['link_profile2_tab'] = array(
    '#type'           => 'link',
    '#title'          => t('Edit favorites'),
    '#title_display'  => 'invisible',
    '#href'           => 'user/' . $user->uid . '/edit/bibdk_favourite_list',
    '#options'        => array('attributes' => array('title' => t('Edit favorites'))),
  );

  return $form;
}

