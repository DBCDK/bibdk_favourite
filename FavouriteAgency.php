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
    $possibilities = array('cpr', 'userId', 'barcode', 'cardno', 'customId',);
    foreach ($possibilities as $pos) {
      if (isset($this->userData[$pos])) {
        return $this->userData[$pos];
      }
    }
    return FALSE;
  }

  public function getPinCode() {
    return isset($this->userData['pincode']) ? $this->userData['pincode'] : FALSE;
  }

  public function getUserStatus() {
    // check if userstatus is already in $_SESSION
    if (isset($_SESSION['userStatus'][$this->getAgencyId()])) {
     // dpm('CACHEHIT');
      return $_SESSION['userStatus'][$this->getAgencyId()];
    }
    //dpm('CACHEMISS');
    // get parameters
    $userId = $this->getUserId();
    $userPincode = $this->getPinCode();
    $libraryCode = $this->getAgencyId();

    if (module_exists('ting_openuserstatus')) {
      // get userstatus from webservice
      $response = ting_openuserstatus_do_userstatus($userId, $userPincode, $libraryCode);
      if (isset($response['error'])) {
        return $response;
      }
      // no errors found. add response to $_SESSION
      $_SESSION['userStatus'][$this->getAgencyId()] = $response;
      // last check
      return isset($_SESSION['userStatus'][$this->getAgencyId()]) ? $_SESSION['userStatus'][$this->getAgencyId()] : FALSE;
    }
    // cannot retrive userstatus
    return FALSE;
  }
  
  public function cancelOrder(array $orders) {
    $userId = $this->getUserId();
    $userPincode = $this->getPinCode();
    $libraryCode = $this->getAgencyId();
    
    $response = ting_openuserstatus_do_cancelorder($userId, $userPincode, $libraryCode, $orders);
    
    return $response;
    
  }
  
  

  public function setUserStatus($res) {
    $_SESSION['userStatus'][$this->getAgencyId()] = $res;
  }
}

?>
