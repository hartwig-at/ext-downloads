<?php
class Tx_Downloads_Domain_Repository_AccessRepository extends Tx_Extbase_Persistence_Repository {
private $implementation;
private function getImplementation() {
  if( null == $this->implementation ) {
    $this->implementation = new DownloadsAccessRepositoryImplementation($this);
  }
  return $this->implementation;
}
public function getSortedStatistics() { return $this->getImplementation()->getSortedStatistics(); }
public function getDailyDownloadCount() { return $this->getImplementation()->getDailyDownloadCount(); }
public function getTopReferrer() { return $this->getImplementation()->getTopReferrer(); }

}
require_once('AccessRepositoryImplementation.php');

?>