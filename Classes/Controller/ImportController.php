<?php
class Tx_Downloads_Controller_ImportController extends Tx_Extbase_MVC_Controller_ActionController  {private $implementation;private function getImplementation() {  if( null == $this->implementation ) {    $this->implementation = new DownloadsImportControllerImplementation($this);  }  return $this->implementation;}function __construct() {parent::__construct();}
/**
* downloadRepository
* @var Tx_Downloads_Domain_Repository_DownloadRepository
*/
protected $downloadRepository;
/**
* injectDownloadRepository
* @param Tx_Downloads_Domain_Repository_DownloadRepository $downloadRepository
*/
public function injectDownloadRepository(Tx_Downloads_Domain_Repository_DownloadRepository $downloadRepository) {
  $this->downloadRepository = $downloadRepository;
}
/**
* downloadCategoryRepository
* @var Tx_Downloads_Domain_Repository_DownloadCategoryRepository
*/
protected $downloadCategoryRepository;
/**
* injectDownloadCategoryRepository
* @param Tx_Downloads_Domain_Repository_DownloadCategoryRepository $downloadCategoryRepository
*/
public function injectDownloadCategoryRepository(Tx_Downloads_Domain_Repository_DownloadCategoryRepository $downloadCategoryRepository) {
  $this->downloadCategoryRepository = $downloadCategoryRepository;
}
/**
* installNoteRepository
* @var Tx_Downloads_Domain_Repository_InstallNoteRepository
*/
protected $installNoteRepository;
/**
* injectInstallNoteRepository
* @param Tx_Downloads_Domain_Repository_InstallNoteRepository $installNoteRepository
*/
public function injectInstallNoteRepository(Tx_Downloads_Domain_Repository_InstallNoteRepository $installNoteRepository) {
  $this->installNoteRepository = $installNoteRepository;
}
/**
* frontendUserRepository
* @var Tx_Extbase_Domain_Repository_FrontendUserRepository
*/
protected $frontendUserRepository;
/**
* injectFrontendUserRepository
* @param Tx_Extbase_Domain_Repository_FrontendUserRepository $frontendUserRepository
*/
public function injectFrontendUserRepository(Tx_Extbase_Domain_Repository_FrontendUserRepository $frontendUserRepository) {
  $this->frontendUserRepository = $frontendUserRepository;
}
/**
* accessRepository
* @var Tx_Downloads_Domain_Repository_AccessRepository
*/
protected $accessRepository;
/**
* injectAccessRepository
* @param Tx_Downloads_Domain_Repository_AccessRepository $accessRepository
*/
public function injectAccessRepository(Tx_Downloads_Domain_Repository_AccessRepository $accessRepository) {
  $this->accessRepository = $accessRepository;
}
/**
*/
public function indexAction() { return $this->getImplementation()->indexAction(); }
/**
*/
public function listCategoriesAction() { return $this->getImplementation()->listCategoriesAction(); }
/**
*/
public function listInstallNotesAction() { return $this->getImplementation()->listInstallNotesAction(); }
/**
* @param mixed $directoryName
*/
public function enumDirectoryAction($directoryName) { return $this->getImplementation()->enumDirectoryAction($directoryName); }
/**
* @param mixed $entityName
* @param mixed $category
* @param mixed $qualifier
* @param mixed $installNotes
*/
public function importEntityAsDownloadAction($entityName,$category,$qualifier,$installNotes) { return $this->getImplementation()->importEntityAsDownloadAction($entityName,$category,$qualifier,$installNotes); }
}require_once('DownloadsImportControllerImplementation.php');
?>