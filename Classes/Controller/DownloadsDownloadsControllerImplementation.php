<?php
/**
 * Copyright (C) 2013, Oliver Salzburg
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
 * Created: 2013-02-11 17:42
 *
 * @author     Oliver Salzburg <oliver.salzburg@hartwig-at.de>, Hartwig Communication & Events
 * @copyright  Copyright (C) 2013, Oliver Salzburg
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 * @package    TYPO3
 * @subpackage tx_downloads
 */
require_once( "DownloadsController.php" );
class DownloadsDownloadsControllerImplementation extends Tx_Downloads_Controller_DownloadsController {

  /**
   * controller
   * @var Tx_Downloads_Controller_DownloadsController
   */
  private $controller = null;

  public function __construct( $interface ) {
    $this->controller = $interface;
  }

  /**
   * List downloads
   *
   * @return void
   */
  public function listAction() {
    t3lib_div::devLog( "Begin listing downloads", "downloads" );

    // Retrieve the absolute path to file type icons
    $iconPath = t3lib_div::getFileAbsFileName( $this->settings[ "iconPath" ] );

    // Determine which records to display
    $records   = $this->controller->settings[ "records" ];
    $downloads = $this->controller->downloadRepository->findAllWithUid( $records );

    /** @var $download Tx_Downloads_Domain_Model_Download */
    foreach( $downloads as $download ) {
      $download->setFileSize( filesize( $download->getFileName() ) );
      $download->setFileTime( filemtime( $download->getFileName() ) );

      // Retrieve file extension
      $filetype_check = array_reverse( explode( ".", $download->getFileName() ) );
      $fileExtension  = $filetype_check[ 0 ];

      // Do we have an icon for that type?
      //if( file_exists( $iconPath . "file_extension_" . $fileExtension . ".png" ) ) {
      if( isset( $this->settings[ "typeIcons" ][ $fileExtension ] ) ) {
        $download->setFileType( strtoupper( $fileExtension ) );
      } else {
        $download->setFileType( "default" );
      }
    }

    $this->controller->view->assign( "downloads", $downloads );
    t3lib_div::devLog( "End listing downloads", "downloads" );
  }


  /**
   * Original implementation by Alexander Dick (http://stackoverflow.com/questions/5554211/how-can-i-trigger-a-download-with-typo3-extbase)
   * @param integer $id
   * @param string $filename Ignored
   * @return void
   */
  public function downloadAction( $id, $filename ) {
    // Search engines will try to strip off the filename from URLs and see what they get.
    // Usually that would get them the same valid download, we don't want that.
    if( "" == $filename ) {
      $this->controller->throwStatus( 403, "Missing file" );
      return;
    }

    // First, enumerate all download records on this page
    $records = $this->settings[ "records" ];

    // Is the download record even on this page?
    if( !t3lib_div::inList( $records, $id ) ) {
      // We don't care.
      // die( "no match" );
    }

    // findAllWithUid makes sure the category is retrieved with the download
    // and that access restrictions on both are respected.
    /** @var $downloads Tx_Extbase_Persistence_QueryResultInterface */
    $downloads = $this->controller->downloadRepository->findAllWithUid( "$id" );
    if( $downloads->count() != 1 ) {
      die( "invalid set" );
    }

    /** @var $download Tx_Downloads_Domain_Model_Download */
    $download = $downloads->getFirst();
    if( null == $download ) {
      die( "invalid id" );
    }

    $file = $download->getFileName();
    //$fileName = basename( $file );
    $fileName = Tx_Downloads_Utility_Filename::construct( $download );
    if( is_file( $file ) ) {
      $fileLength = filesize( $file );
      $ext        = strtolower( substr( strrchr( $fileName, '.' ), 1 ) );

      switch( $ext ) {
        case "txt":
          $contentType = "text/plain";
          break;

        case "pdf":
          $contentType = "application/pdf";
          break;

        case "exe":
          $contentType = "application/octet-stream";
          break;

        case "zip":
          $contentType = "application/zip";
          break;

        case "doc":
          $contentType = "application/msword";
          break;

        case "xls":
          $contentType = "application/vnd.ms-excel";
          break;

        case "ppt":
          $contentType = "application/vnd.ms-powerpoint";
          break;

        case "gif":
          $contentType = "image/gif";
          break;

        case "png":
          $contentType = "image/png";
          break;

        case "jpeg":
        case "jpg":
          $contentType = "image/jpg";
          break;

        case "mp3":
          $contentType = "audio/mpeg";
          break;

        case "wav":
          $contentType = "audio/x-wav";
          break;

        case "mpeg":
        case "mpg":
        case "mpe":
          $contentType = "video/mpeg";
          break;

        case "mov":
          $contentType = "video/quicktime";
          break;

        case "avi":
          $contentType = "video/x-msvideo";
          break;

        //forbidden filetypes
        case "inc":
        case "conf":
        case "sql":
        case "cgi":
        case "htaccess":
        case "php":
        case "php3":
        case "php4":
        case "php5":
          exit;

        default:
          $contentType = "application/force-download";
          break;
      }

      $headers = array(
        "Pragma"                    => "public",
        "Expires"                   => 0,
        "Cache-Control"             => "must-revalidate, post-check=0, pre-check=0",
        "Cache-Control"             => "public",
        "Content-Description"       => "File Transfer",
        "Content-Type"              => $contentType,
        "Content-Disposition"       => "attachment; filename=\"" . $fileName . '"',
        "Content-Transfer-Encoding" => "binary",
        "Content-Length"            => $fileLength
      );

      foreach( $headers as $header => $data ) {
        $this->controller->response->setHeader( $header, $data );
      }

      // Remember download
      $access = new Tx_Downloads_Domain_Model_Access();
      $access->setDownload( $download );
      $access->setDateTime( time() );

      $user = $this->getFrontendUser();
      if( null != $user ) {
        $access->setFeUser( $user );
      }

      // Set IP address
      $ipAddress = $this->getRealIpAddress();
      $access->setIpAddress( $ipAddress );

      // Set referrer
      $referrer = $_SERVER[ "HTTP_REFERER" ];
      $access->setReferrer( $referrer );

      $this->controller->response->sendHeaders();
      @readfile( $file );

      $this->controller->accessRepository->add( $access );
      $this->controller->persistenceManager = $this->controller->objectManager->get( "Tx_Extbase_Persistence_Manager" );
      $this->controller->persistenceManager->persistAll();
    }
    exit;
  }

  /**
   * Gets a frontend user which is taken from the global registry or as fallback from TSFE->fe_user.
   *
   * @return  Tx_Extbase_Domain_Model_FrontendUser The current extended frontend user object
   */
  protected function getFrontendUser() {

    /** @var $tsfe tslib_fe */
    $tsfe = $GLOBALS[ "TSFE" ];

    // SHOULD BE: if( is_object( $tsfe->fe_user ) ) {
    // PROBLEM CODE: if( $tsfe->fe_user ) {
    if( is_object( $tsfe->fe_user ) ) {
      /** @var $user tslib_feUserAuth */
      $fe_user = $tsfe->fe_user;

      ob_start();
      var_dump( $fe_user );
      $debug_fe_user = ob_get_contents();
      ob_end_clean();

      $feUserId = $fe_user->user[ 'uid' ];


      if( !$tsfe->loginUser ) {
        //error_log( "Trying to look up user while not actually logged in (TEST loginUser) ! UID:" . $feUserId . " DEBUG:" . $debug_fe_user );
        return null;
      }

      if( !is_numeric( $feUserId ) ) {
        //error_log( "Trying to look up user while not actually logged in (TEST feUserId) ! UID:" . $feUserId . " DEBUG:" . $debug_fe_user );
        return null;
      }

      /** @var $frontendUser Tx_Extbase_Domain_Model_FrontendUser */
      $frontendUser = $this->controller->frontendUserRepository->findOneByUid( $feUserId );

      if( null == $frontendUser ) {
        //throw new LogicException( "\$frontendUser is null \$feUserId is '$feUserId'" );
        error_log( "Frontend User is NULL (TEST frontendUser) ! UID:" . $feUserId . " DEBUG:" . $debug_fe_user );
        return $frontendUser;
      }

      $uid = $frontendUser->getUid();
      if( $uid != $feUserId ) {
        error_log( "CRITICAL! User ID mismatch (TEST getUid-feUserId) ! UID:" . $feUserId . " RETURNED:" . $uid . " DEBUG:" . $debug_fe_user );
        return null;
      }

      return $frontendUser;

    } else {
      // User is not logged in.
    }
    return NULL;
  }

  /**
   * Get the IP address of the connecting client.
   * @see http://roshanbh.com.np/2007/12/getting-real-ip-address-in-php.html
   * @return int The IP address of the client as an unsigned 32-bit integer.
   */
  function getRealIpAddress() {
    if( !empty( $_SERVER[ "HTTP_CLIENT_IP" ] ) ) {
      $ip = $_SERVER[ "HTTP_CLIENT_IP" ];

    } elseif( !empty( $_SERVER[ "HTTP_X_FORWARDED_FOR" ] ) ) {
      $ip = $_SERVER[ "HTTP_X_FORWARDED_FOR" ];

    } else {
      $ip = $_SERVER[ "REMOTE_ADDR" ];
    }
    return ip2long( $ip );
  }
}