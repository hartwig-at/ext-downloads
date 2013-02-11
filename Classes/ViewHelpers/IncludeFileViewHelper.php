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
 * Created: 2012-11-22 13:11
 *
 * @author     Georg Ringer <typo3@ringerge.org>
 * @author     Oliver Salzburg <oliver.salzburg@hartwig-at.de>, Hartwig Communication & Events
 * @copyright  Copyright (C) 2010, Georg Ringer
 * @copyright  Copyright (C) 2012, Oliver Salzburg
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 * @package    TYPO3
 * @subpackage tx_downloads
 */
class Tx_Downloads_ViewHelpers_IncludeFileViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

  /**
   * Include a CSS/JS file
   *
   * @param string $path path to the file
   * @param boolean $compress if file should be compressed
   * @return void
   */
  public function render( $path, $compress = FALSE ) {
    $path = $GLOBALS[ "TSFE" ]->tmpl->getFileName( $path );

    if( $path ) {
      // JS
      if( strtolower( substr( $path, -3 ) ) === ".js" ) {
        $GLOBALS[ "TSFE" ]->getPageRenderer()->addJsFile( $path, NULL, $compress );

        // CSS
      } elseif( strtolower( substr( $path, -4 ) ) === ".css" ) {
        $GLOBALS[ "TSFE" ]->getPageRenderer()->addCssFile( $path, "stylesheet", "all", "", $compress );
      }
    }
  }
}