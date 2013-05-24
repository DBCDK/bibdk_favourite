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
  
  /** Get userid for favourite
   * 
   * There are a number of possible userids. Run through userdata and return
   * the first found
   * 
   * @return boolean 
   */
   public function getUserId() {
     $possibilities = array('cpr','userId','barcode','cardno','customId',);
     foreach ($possibilities as $pos) {
       if (isset($this->userData[$pos])) {
         return $this->userData[$pos];
       }
     }
     return FALSE;
   }
   
   public function getPinCode () {
     return isset($this->userData['pincode']) ? $this->userData['pincode'] : FALSE;
   }
   
   public function getUserStatus() { 
     return isset($_SESSION['userStatus'][$this->getAgencyId()]) ? $_SESSION['userStatus'][$this->getAgencyId()] : FALSE;
   }
   
   public function setUserStatus($res){
     $_SESSION['userStatus'][$this->getAgencyId()] = $res;
   }
}

?>
