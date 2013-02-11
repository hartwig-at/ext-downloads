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
 * Created: 2013-02-11 18:01
 *
 * @author     Oliver Salzburg <oliver.salzburg@hartwig-at.de>, Hartwig Communication & Events
 * @copyright  Copyright (C) 2013, Oliver Salzburg
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 * @package    TYPO3
 * @subpackage tx_downloads
 */

class DownloadsHooksLabelsImplementation {
  /**
   * Retrieve the label for a download record.
   * Internally uses the filename construction approach.
   * This way, the names in the frontend match the backend.
   *
   * @param array $params
   * @param mixed $pObj
   */
  public static function getUserLabelDownload( array &$params, &$pObj ) {
    // Get some extbase going
    $bootstrap = new Tx_Extbase_Core_Bootstrap();
    $bootstrap->initialize(
      array(
        "extensionName" => "downloads",
        "pluginName"    => "Downloads",
        "persistence."  => array(
          "storagePid" => $params[ "row" ][ "pid" ]
        )
      )
    );

    // Get our repository to get the "real" (persistence) object
    $repository = t3lib_div::makeInstance( "Tx_Downloads_Domain_Repository_DownloadRepository" );
    $item = $repository->findByUid( $params[ "row" ][ "uid" ] );

    // Item not found? Weird. But let's stick with the input data then
    if( null == $item ) return;

    // Fix the title
    $params[ "title" ] = Tx_Downloads_Utility_Filename::construct( $item, false );
  }
}