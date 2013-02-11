<?php
class Tx_Downloads_Service_ImportService   {private $implementation;private function getImplementation() {  if( null == $this->implementation ) {    $this->implementation = new DownloadsImportServiceImplementation($this);  }  return $this->implementation;}function __construct() {}
/**
* @param mixed $entityName
* @param mixed $category
* @param mixed $qualifier
* @param mixed $installNotes
*/
public function import($entityName,$category,$qualifier,$installNotes) { return $this->getImplementation()->import($entityName,$category,$qualifier,$installNotes); }
}require_once('DownloadsImportServiceImplementation.php');
?>