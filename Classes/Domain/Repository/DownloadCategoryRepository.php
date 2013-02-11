<?php
class Tx_Downloads_Domain_Repository_DownloadCategoryRepository extends Tx_Extbase_Persistence_Repository {
private $implementation;
private function getImplementation() {
  if( null == $this->implementation ) {
    $this->implementation = new DownloadsDownloadCategoryRepositoryImplementation($this);
  }
  return $this->implementation;
}
public function findAllForImport() { return $this->getImplementation()->findAllForImport(); }

}
require_once('DownloadCategoryRepositoryImplementation.php');

?>