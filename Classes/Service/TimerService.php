<?php
class Tx_Downloads_Service_TimerService   {private $implementation;private function getImplementation() {  if( null == $this->implementation ) {    $this->implementation = new DownloadsTimerServiceImplementation($this);  }  return $this->implementation;}function __construct() {}
/**
*/
public function getTimeMarker() { return $this->getImplementation()->getTimeMarker(); }
/**
* @param mixed $marker
*/
public function getTimeDiff($marker) { return $this->getImplementation()->getTimeDiff($marker); }
}require_once('DownloadsTimerServiceImplementation.php');
?>