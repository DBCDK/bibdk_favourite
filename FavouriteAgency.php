<?php

class FavouriteAgency extends TingAgency {

  public $userData;
  public $orderAgency;

  public function __construct($favourite) {
    if (!isset($favourite['oui:agencyId'])) {
      die('no agencyid in FavouriteAgency constructor');
    }
    parent::__construct($favourite['oui:agencyId']);
    $this->userData = isset($favourite['oui:userData']) ? unserialize($favourite['oui:userData']) : NULL;
    $this->orderAgency = ($favourite['oui:orderAgency'] == 'TRUE') ? TRUE : FALSE;
  }

  public function getOrderAgency() {
    return $this->orderAgency;
  }

  public function getUserData() {
    return $this->userData;
  }

}

?>
