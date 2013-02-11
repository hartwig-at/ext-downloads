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
 * Created: 2012-11-19 00:03
 *
 * @author     Oliver Salzburg <oliver.salzburg@hartwig-at.de>, Hartwig Communication & Events
 * @copyright  Copyright (C) 2012, Oliver Salzburg
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 * @package    TYPO3
 * @subpackage tx_downloads
 */
require_once( "ImportController.php" );
class DownloadsImportControllerImplementation extends Tx_Downloads_Controller_ImportController {
  /**
   * controller
   * @var Tx_Downloads_Controller_ImportController
   */
  private $controller = NULL;

  public function __construct( $interface ) {
    $this->controller = $interface;
  }

  /**
   * Retrieves a list of all available download categories
   */
  protected function getAvailableCategories() {
    if( null == $this->controller->downloadCategoryRepository ) {
      throw new Exception( "DownloadCategory Repository not available. Maybe it was never injected." );
    }

    $downloadCategories = $this->controller->downloadCategoryRepository->findAllForImport();
    return $downloadCategories;
  }

  /**
   * Retrieves a list of all available install notes
   */
  protected function getAvailableInstallNotes() {
    if( null == $this->controller->installNoteRepository ) {
      throw new Exception( "InstallNotes Repository not available. Maybe it was never injected." );
    }

    $installNotes = $this->controller->installNoteRepository->findAllForImport();
    return $installNotes;
  }

  /**
   * Shows the import jobs selection .
   *
   * @return string The rendered view
   */
  public function indexAction() {
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
    /** @var $downloadCategory Tx_Downloads_Domain_Model_DownloadCategory */
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
    /** @var $installNote Tx_Downloads_Domain_Model_InstallNote */
    foreach( $installNotes as $installNote ) {
      $names[] = array( $installNote->getUid(), $installNote->getFiletype() );
    }
    return json_encode( $names );
  }

  /**
   * Enumerates entities in a file system directory
   *
   * @param string $directoryName The directory whose members should be enumerated
   * @return string
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
    /** @var $subscribeService Tx_Downloads_Service_ImportService */
    $importService = t3lib_div::makeInstance( "Tx_Downloads_Service_ImportService" );
    $importService->import( "fileadmin" . $entityName, $category, $qualifier, $installNotes );
    return "OK";
  }
}
