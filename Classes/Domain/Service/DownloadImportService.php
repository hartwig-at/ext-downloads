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
 * Downloads Import Service
 *
 * @package TYPO3
 * @subpackage tx_downloads
 */
class Tx_Downloads_Domain_Service_DownloadImportService implements t3lib_Singleton {
  
  /**
   * @var Tx_Extbase_Object_ObjectManager
   */
  protected $objectManager;

  /**
   * @var Tx_Extbase_Persistence_Manager
   */
  protected $persistenceManager;

  /**
   * @var Tx_Downloads_Domain_Repository_DownloadRepository
   */
  protected $downloadRepository;
  
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
   * Constructs a Tx_Downloads_Domain_Service_DownloadImportService
   *
   * @param Tx_Extbase_Object_ObjectManager $objectManager
   * @param Tx_Extbase_Persistence_Manager $persistenceManager
   * @param Tx_Downloads_Domain_Repository_DownloadRepository $downloadRepository
   * @param Tx_Downloads_Domain_Repository_DownloadCategoryRepository $downloadCategoryRepository
   * @param Tx_Downloads_Domain_Repository_InstallNotesRepository $installNotesRepository
   * @return Tx_Downloads_Domain_Service_DownloadImportService
   */
  public function __construct( Tx_Extbase_Object_ObjectManager                            $objectManager,
                               Tx_Extbase_Persistence_Manager                             $persistenceManager,
                               Tx_Downloads_Domain_Repository_DownloadRepository          $downloadRepository,
                               Tx_Downloads_Domain_Repository_DownloadCategoryRepository  $downloadCategoryRepository,
                               Tx_Downloads_Domain_Repository_InstallNotesRepository      $installNotesRepository ) {
                                 
    $this->objectManager              = $objectManager;
    $this->persistenceManager         = $persistenceManager;
    $this->downloadRepository         = $downloadRepository;
    $this->downloadCategoryRepository = $downloadCategoryRepository;
    $this->installNotesRepository     = $installNotesRepository;
  }
  
  /**
   * @param string $entityName The name of the file or folder.
   * @param integer $category The ID of the category the new downloads belong to.
   * @param string $qualifier The qualifier that will be assigned to new download records.
   * @param integer $installNotes The ID of the install notes that should be assigned to the new downloads.
   */
  public function import( $entityName, $category, $qualifier, $installNotes ) {
    
    $entityName = t3lib_div::getFileAbsFileName( $entityName );
    
    // Don't import directories
    if( is_dir( $entityName ) ) return;
    
    // Avoid directory traversal
    if( strpos( $entityName, ".." ) !== FALSE ) return;
    
    // Retrieve download category
    $categoryObject = $this->downloadCategoryRepository->findByUid( $category );
    
    // Retrieve install notes
    $installNotesObject = $this->installNotesRepository->findByUid( $installNotes );
    
    // Create and store new download record
    $download = $this->objectManager->get( "Tx_Downloads_Domain_Model_Download" );
    $this->downloadRepository->add( $download );
    
    // Try to make up a title for the new download
    $entityPathInfo = pathinfo( $entityName );
    $title = basename( $entityName, '.' . $entityPathInfo[ "extension" ] );
    
    $download->setTitle( $title );
    $download->setFilename( $entityName );
    $download->setDownloadCategory( $categoryObject );
    $download->setQualifier( $qualifier );
    $download->setInstallNotes( $installNotesObject );
    
    $this->persistenceManager->persistAll();
  }
}
?>