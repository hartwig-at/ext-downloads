<?php
class Tx_Downloads_Domain_Repository_DownloadRepository extends Tx_Extbase_Persistence_Repository {
private $implementation;
private function getImplementation() {
  if( null == $this->implementation ) {
    $this->implementation = new DownloadsDownloadRepositoryImplementation($this);
  }
  return $this->implementation;
}
public function findAllWithUid($uids) { return $this->getImplementation()->findAllWithUid($uids); }
public function getTopDownloads($raw) { return $this->getImplementation()->getTopDownloads($raw); }

}
require_once('DownloadRepositoryImplementation.php');

?>