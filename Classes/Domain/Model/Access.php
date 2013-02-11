<?php
class Tx_Downloads_Domain_Model_Access extends Tx_Extbase_DomainObject_AbstractEntity {
/**
* feUser
* @var Tx_Extbase_Domain_Model_FrontendUser
*/
protected $feUser;
/**
* ipAddress
* @var int
*/
protected $ipAddress;
/**
* referrer
* @var string
*/
protected $referrer;
/**
* dateTime
* @var int
*/
protected $dateTime;
/**
* download
* @var Tx_Downloads_Domain_Model_Download
*/
protected $download;
public function getT3ManagedFields() {	 return $this->t3ManagedFields;}public function setT3ManagedFields( $t3ManagedFields ) {	 $this->t3ManagedFields = $t3ManagedFields;}
public function getFeUser() {	 return $this->feUser;}public function setFeUser( $feUser ) {	 $this->feUser = $feUser;}
public function getIpAddress() {	 return $this->ipAddress;}public function setIpAddress( $ipAddress ) {	 $this->ipAddress = $ipAddress;}
public function getReferrer() {	 return $this->referrer;}public function setReferrer( $referrer ) {	 $this->referrer = $referrer;}
public function getDateTime() {	 return $this->dateTime;}public function setDateTime( $dateTime ) {	 $this->dateTime = $dateTime;}
public function getDownload() {	 return $this->download;}public function setDownload( $download ) {	 $this->download = $download;}
}
?>