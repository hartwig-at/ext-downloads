<?php
/**
 * Copyright (C) 2012, Oliver Salzburg
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 * Created: 2012-11-19 18:05
 *
 * @author     Oliver Salzburg <oliver.salzburg@hartwig-at.de>, Hartwig Communication & Events
 * @copyright  Copyright (C) 2012, Oliver Salzburg
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 * @package    TYPO3
 * @subpackage tx_downloads
 */
class DownloadsImportServiceImplementation extends Tx_Downloads_Service_ImportService {

  /**
   * @var Tx_Downloads_Service_ImportService
   */
  protected $service;


  public function __construct( Tx_Downloads_Service_ImportService $service ) {
    $this->service = $service;
  }

  /**
   * @param string $entityName The name of the file or folder.
   * @param integer $category The ID of the category the new downloads belong to.
   * @param string $qualifier The qualifier that will be assigned to new download records.
   * @param integer $installNotes The ID of the install notes that should be assigned to the new downloads.
   */
  public function import( $entityName, $category, $qualifier, $installNotes ) {
    /** @var Tx_Extbase_Object_ObjectManager */
    $objectManager = t3lib_div::makeInstance( "Tx_Extbase_Object_ObjectManager" );
    /** @var Tx_Extbase_Persistence_Manager */
    $persistenceManager = t3lib_div::makeInstance( "Tx_Extbase_Persistence_Manager" );
    /** @var Tx_Downloads_Domain_Repository_DownloadRepository */
    $downloadRepository = t3lib_div::makeInstance( "Tx_Downloads_Domain_Repository_DownloadRepository" );
    /** @var Tx_Downloads_Domain_Repository_DownloadCategoryRepository */
    $downloadCategoryRepository = t3lib_div::makeInstance( "Tx_Downloads_Domain_Repository_DownloadCategoryRepository" );
    /** @var Tx_Downloads_Domain_Repository_InstallNoteRepository */
    $installNotesRepository = t3lib_div::makeInstance( "Tx_Downloads_Domain_Repository_InstallNoteRepository" );

    $absoluteName = t3lib_div::getFileAbsFileName( $entityName );

    // Don't import directories
    if( is_dir( $absoluteName ) ) {
      return;
    }

    // Avoid directory traversal
    if( strpos( $absoluteName, ".." ) !== FALSE ) {
      return;
    }

    // Retrieve download category
    $categoryObject = $downloadCategoryRepository->findByUid( $category );

    // Retrieve install notes
    $installNoteObject = $installNotesRepository->findByUid( $installNotes );

    // Create and store new download record
    /** @var $download Tx_Downloads_Domain_Model_Download */
    $download = $objectManager->get( "Tx_Downloads_Domain_Model_Download" );
    $downloadRepository->add( $download );

    // Try to make up a title for the new download
    $entityPathInfo = pathinfo( $absoluteName );
    $title          = basename( $absoluteName, '.' . $entityPathInfo[ "extension" ] );

    $download->setTitle( $title );
    $download->setFilename( $entityName );
    $download->setDownloadCategory( $categoryObject );
    $download->setQualifier( $qualifier );
    $download->setInstallNote( $installNoteObject );

    $persistenceManager->persistAll();
  }
}