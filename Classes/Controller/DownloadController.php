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
 *
 *
 * @package downloads
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Downloads_Controller_DownloadController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * downloadRepository
	 *
	 * @var Tx_Downloads_Domain_Repository_DownloadRepository
	 */
	protected $downloadRepository;

	/**
	 * injectDownloadRepository
	 *
	 * @param Tx_Downloads_Domain_Repository_DownloadRepository $downloadRepository
	 * @return void
	 */
	public function injectDownloadRepository(Tx_Downloads_Domain_Repository_DownloadRepository $downloadRepository) {
		$this->downloadRepository = $downloadRepository;
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
	  t3lib_div::devLog( "Begin listing downloads", "downloads" );
	  //$this->flashMessages->add('This is a flash message :)');
    //throw new Exception( "This is an exception" );
    
    // Retrieve the absolute path to file type icons
    $iconPath = t3lib_div::getFileAbsFileName( $this->settings["iconPath"] );
    
    // Determine which records to display
	  //$allDownloads = $this->downloadRepository->findAll();
	  $records   = $this->settings[ "records" ];
    $downloads = $this->downloadRepository->findAllWithUid( $records );
    
    foreach( $downloads as $download ) {
      $download->setFileSize( filesize( $download->getFileName() ) );
      $download->setFileTime( filemtime( $download->getFileName() ) );
      
      // Retrieve file extension
      $filetype_check = array_reverse( explode( ".", $download->getFileName() ) );
      $fileExtension = $filetype_check[ 0 ];
      
      // Do we have an icon for that type?
      //if( file_exists( $iconPath . "file_extension_" . $fileExtension . ".png" ) ) {
      if( isset( $this->settings[ "typeIcons" ][ $fileExtension ] ) ) {
        $download->setFileType( strtoupper( $fileExtension ) );
      } else {
        $download->setFileType( "default" );
      }
      
      // Determine target file name
      $linkName = Tx_Downloads_Utility_Filename::construct( $download );
      $download->setLinkText( $linkName );
    }
    
		$this->view->assign( "downloads", $downloads );
    t3lib_div::devLog( "End listing downloads", "downloads" );
	}


  /**
   * Original implementation by Alexander Dick (http://stackoverflow.com/questions/5554211/how-can-i-trigger-a-download-with-typo3-extbase)
   * @param integer $id
   * @param string $filename Ignored
   * @return void
   */  
  public function downloadAction( $id, $filename ) {
    // First, enumerate all download records on this page
    $records = $this->settings[ "records" ];
    
    // Is the download record even on this page?
    if( !t3lib_div::inList( $records, $id ) ) {
      // We don't care.
      // die( "no match" );
    }
    
    // findAllWithUid makes sure the category is retrieved with the download
    // and that access restrictions on both are respected.
    $downloads = $this->downloadRepository->findAllWithUid( "$id" );
    if( $downloads->count() != 1 ) die( "invalid set" );
    
    //$download = $this->downloadRepository->findByUid( $id );
    $download = $downloads->getFirst();
    if( null == $download ) die( "invalid id" );
    
    $file     = $download->getFileName();
    //$fileName = basename( $file );
    $fileName = Tx_Downloads_Utility_Filename::construct( $download );
    if( is_file( $file ) ) {
      $fileLen = filesize( $file );          
      $ext     = strtolower( substr( strrchr( $fileName, '.' ), 1 ) );

      switch( $ext ) {
        case 'txt':
          $cType = 'text/plain'; 
        break;
                      
        case 'pdf':
          $cType = 'application/pdf'; 
        break;
        
        case 'exe':
          $cType = 'application/octet-stream';
        break;
        
        case 'zip':
          $cType = 'application/zip';
        break;
        
        case 'doc':
          $cType = 'application/msword';
        break;
        
        case 'xls':
          $cType = 'application/vnd.ms-excel';
        break;
        
        case 'ppt':
          $cType = 'application/vnd.ms-powerpoint';
        break;
        
        case 'gif':
          $cType = 'image/gif';
        break;
        
        case 'png':
          $cType = 'image/png';
        break;
        
        case 'jpeg':
        case 'jpg':
          $cType = 'image/jpg';
        break;
        
        case 'mp3':
          $cType = 'audio/mpeg';
        break;
        
        case 'wav':
          $cType = 'audio/x-wav';
        break;
        
        case 'mpeg':
        case 'mpg':
        case 'mpe':
          $cType = 'video/mpeg';
        break;
        
        case 'mov':
          $cType = 'video/quicktime';
        break;
        
        case 'avi':
          $cType = 'video/x-msvideo';
        break;

        //forbidden filetypes
        case 'inc':
        case 'conf':
        case 'sql':                 
        case 'cgi':
        case 'htaccess':
        case 'php':
        case 'php3':
        case 'php4':                        
        case 'php5':
        exit;

        default:
          $cType = 'application/force-download';
        break;
      }

      $headers = array(
        'Pragma'                    => 'public', 
        'Expires'                   => 0, 
        'Cache-Control'             => 'must-revalidate, post-check=0, pre-check=0',
        'Cache-Control'             => 'public',
        'Content-Description'       => 'File Transfer',
        'Content-Type'              => $cType,
        'Content-Disposition'       => 'attachment; filename="'. $fileName .'"',
        'Content-Transfer-Encoding' => 'binary', 
        'Content-Length'            => $fileLen         
      );

      foreach( $headers as $header => $data ) {
        $this->response->setHeader( $header, $data );
      } 

      $this->response->sendHeaders();                 
      @readfile( $file );   

    }   
    exit;   
  }

	/**
	 * action show
	 *
	 * @param $download
	 * @return void
	 */
	public function showAction(Tx_Downloads_Domain_Model_Download $download) {
		$this->view->assign('download', $download);
	}

	/**
	 * action new
	 *
	 * @param $newDownload
	 * @dontvalidate $newDownload
	 * @return void
	 */
	public function newAction(Tx_Downloads_Domain_Model_Download $newDownload = NULL) {
		$this->view->assign('newDownload', $newDownload);
	}

	/**
	 * action create
	 *
	 * @param $newDownload
	 * @return void
	 */
	public function createAction(Tx_Downloads_Domain_Model_Download $newDownload) {
		$this->downloadRepository->add($newDownload);
		$this->flashMessageContainer->add('Your new Download was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param $download
	 * @return void
	 */
	public function editAction(Tx_Downloads_Domain_Model_Download $download) {
		$this->view->assign('download', $download);
	}

	/**
	 * action update
	 *
	 * @param $download
	 * @return void
	 */
	public function updateAction(Tx_Downloads_Domain_Model_Download $download) {
		$this->downloadRepository->update($download);
		$this->flashMessageContainer->add('Your Download was updated.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param $download
	 * @return void
	 */
	public function deleteAction(Tx_Downloads_Domain_Model_Download $download) {
		$this->downloadRepository->remove($download);
		$this->flashMessageContainer->add('Your Download was removed.');
		$this->redirect('list');
	}

}
?>