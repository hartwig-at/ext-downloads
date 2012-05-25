<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Oliver Salzburg <oliver@hartwig-at.de>, Hartwig Communication & Events
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


/**
 * Controller to import download records
 *
 * @package TYPO3
 * @subpackage tx_downloads
 */
class Tx_Downloads_Controller_ImportController extends Tx_Extbase_MVC_Controller_ActionController {

  /**
   * importService
   *
   * @var Tx_Downloads_Domain_Service_DownloadImportService
   */
  protected $importService;
  
  /**
   * downloadCategoryRepository
   *
   * @var Tx_Downloads_Domain_Repository_DownloadCategoryRepository
   */
  protected $downloadCategoryRepository;
  
  /**
   * installNotesRepository
   *
   * @var Tx_Downloads_Domain_Repository_InstallNotesRepository
   */
  protected $installNotesRepository;
  
  /**
   * @param Tx_Downloads_Domain_Service_DownloadImportService $importService
   * @param Tx_Downloads_Domain_Repository_DownloadCategoryRepository $downloadCategoryRepository
   * @param Tx_Downloads_Domain_Repository_InstallNotesRepository $installNotesRepository
   */
  public function __construct( Tx_Downloads_Domain_Service_DownloadImportService         $importService,
                               Tx_Downloads_Domain_Repository_DownloadCategoryRepository $downloadCategoryRepository,
                               Tx_Downloads_Domain_Repository_InstallNotesRepository     $installNotesRepository ) {
    $this->importService              = $importService;
    $this->downloadCategoryRepository = $downloadCategoryRepository;
    $this->installNotesRepository     = $installNotesRepository;
  }
  
  /**
   * Retrieves a list of all available download categories
   */
  protected function getAvailableCategories() {
    if( null == $this->downloadCategoryRepository ) {
      throw new Exception( "DownloadCategory Repository not available. Maybe it was never injected." );
    }
    
    $downloadCategories = $this->downloadCategoryRepository->findAllForImport();
    return $downloadCategories;
  }
  
  /**
   * Retrieves a list of all available install notes
   */
  protected function getAvailableInstallNotes() {
    if( null == $this->installNotesRepository ) {
      throw new Exception( "InstallNotes Repository not available. Maybe it was never injected." );
    }
    
    $installNotes = $this->installNotesRepository->findAllForImport();
    return $installNotes;
  }

  /**
   * Shows the import jobs selection .
   *
   * @return string The rendered view
   */
  public function indexAction() {
    //$this->view->assign('availableCategories', array_merge(array(0 => 'none'), $this->getAvailableCategories()));
  }
  
  /**
   * Retrieves a list of all defined download categories
   * 
   * @return string The list of available download categories as JSON
   */
  public function listCategoriesAction() {
    // Get available categories
    $downloadCategories = $this->getAvailableCategories();
    
    // Transform for ExtJS combobox
    $names = array();
    foreach( $downloadCategories as $downloadCategory ) {
      $names[] = array( $downloadCategory->getUid(), $downloadCategory->getName() );
    }
    return json_encode( $names );
  }
  
  /**
   * Retrieves a list of all defined install notes.
   * 
   * @return string The list of available install notes as JSON
   */
  public function listInstallNotesAction() {
    // Get available install notes
    $installNotes = $this->getAvailableInstallNotes();
    
    // Transform for ExtJS combobox
    $names = array();
    foreach( $installNotes as $installNote ) {
      $names[] = array( $installNote->getUid(), $installNote->getFiletype() );
    }
    return json_encode( $names );
  }
  
  /**
   * Enumerates entities in a file system directory
   * 
   * @param string $directoryName The directory whose members should be enumerated
   */
  public function enumDirectoryAction( $directoryName ) {
    if( strpos( $directoryName, ".." ) !== FALSE ) return;
    
    $entities = array();
    if( "root" == $directoryName ) {
      //$entities = t3lib_div::getAllFilesAndFoldersInPath( $entities, PATH_site . "fileadmin/", "", true, 1, "" );
      $rootFolder = new Tx_Downloads_Utility_SortedDirectoryIterator( PATH_site . "fileadmin/" );
      $directoryName = "";
    } else {
      $rootFolder = new Tx_Downloads_Utility_SortedDirectoryIterator( PATH_site . "fileadmin/" . $directoryName );
    }
    
    foreach( $rootFolder as $item ) {
      // Skip hidden items and the "." and ".." directories
      if( "." == substr( $item->getFilename(), 0, 1 ) || ".." == $item->getFilename() ) continue;
      
      if( $item->isFile() ) {
        $entities[] = array( 
          "checked" => false, 
          "text"    => $item->getFilename(), 
          "id"      => $directoryName . "/" . $item->getFilename(), 
          "leaf"    => true 
        );
        
      } elseif( $item->isDir() ) {
        $entities[] = array( 
          "checked"           => false,
          "text"              => $item->getFilename(), 
          "id"                => $directoryName . "/" . $item->getFilename(),
          "singleClickExpand" => true 
        );
      }
    }
    
    return json_encode( $entities );
  }

  /**
   * Create a download record for a given file (or all files in a folder).
   * 
   * @param string $entityName The name of the file or folder.
   * @param integer $category The ID of the category the new downloads belong to.
   * @param string $qualifier The qualifier that will be assigned to new download records.
   * @param integer $installNotes The ID of the install notes that should be assigned to the new downloads.
   * @return string "OK" when the import succeeded, something else when it fails.
   */
  public function importEntityAsDownloadAction( $entityName, $category, $qualifier, $installNotes ) {
    $this->importService->import( "fileadmin" . $entityName, $category, $qualifier, $installNotes );
    return "OK";
  }
}
?>