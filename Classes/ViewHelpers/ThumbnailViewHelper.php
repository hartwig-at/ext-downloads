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
 * Created: 2012-09-06 15:07
 *
 * @author     Oliver Salzburg <oliver.salzburg@hartwig-at.de>, Hartwig Communication & Events
 * @copyright  Copyright (C) 2012, Oliver Salzburg
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 * @package    TYPO3
 * @subpackage tx_downloads
 */
class Tx_Downloads_ViewHelpers_ThumbnailViewHelper extends Tx_Fluid_ViewHelpers_ImageViewHelper {

  /**
   * Renders a thumbnail of a given image. If no thumbnail can be rendered, the image is omitted.
   *
   * @param string  $src
   * @param string  $width     width of the image. This can be a numeric value representing the fixed width of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
   * @param string  $height    height of the image. This can be a numeric value representing the fixed height of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
   * @param integer $minWidth  minimum width of the image
   * @param integer $minHeight minimum height of the image
   * @param integer $maxWidth  maximum width of the image
   * @param integer $maxHeight maximum height of the image
   *
   * @throws Tx_Fluid_Core_ViewHelper_Exception
   * @return string The bytes in human-readable format.
   */
  public function render( $src, $width = NULL, $height = NULL, $minWidth = NULL, $minHeight = NULL, $maxWidth = NULL, $maxHeight = NULL ) {
    $nameParts = pathinfo( $src );
    if( !isset( $nameParts[ "extension" ] ) ) {
      t3lib_div::devLog( "Unable to determine file extension for '" . $src . "'.", "downloads" );
      return "";
    }
    $fileExtension = $nameParts[ "extension" ];

    // Retrieve file extensions that are marked as "image types".
    $validExtensions = $GLOBALS[ "TYPO3_CONF_VARS" ][ "GFX" ][ "imagefile_ext" ];

    // If the given file is not a valid image type, don't render an image.
    if( !t3lib_div::inList( $validExtensions, strtolower( $fileExtension ) ) ) {
      return "";
    }

    // Everything's fine, render the image.
    if( TYPO3_MODE === "BE" ) {
      $this->simulateFrontendEnvironment();
    }
    $setup = array(
      "width"  => $width,
      "height" => $height,
      "minW"   => $minWidth,
      "minH"   => $minHeight,
      "maxW"   => $maxWidth,
      "maxH"   => $maxHeight,
      "params" => "-flatten -colorspace RGB"
      /*-background transparent -normalize xc:white*/
    );
    if( TYPO3_MODE === "BE" && substr( $src, 0, 3 ) === "../" ) {
      $src = substr( $src, 3 );
    }
    $imageInfo                        = $this->contentObject->getImgResource( $src, $setup );
    $GLOBALS[ "TSFE" ]->lastImageInfo = $imageInfo;
    if( !is_array( $imageInfo ) ) {
      throw new Tx_Fluid_Core_ViewHelper_Exception( "Could not get image resource for \"" . htmlspecialchars( $src ) . "\".", 1253191060 );
    }
    $imageInfo[ 3 ]                     = t3lib_div::png_to_gif_by_imagemagick( $imageInfo[ 3 ] );
    $GLOBALS[ "TSFE" ]->imagesOnPage[ ] = $imageInfo[ 3 ];

    $imageSource = $GLOBALS[ "TSFE" ]->absRefPrefix . t3lib_div::rawUrlEncodeFP( $imageInfo[ 3 ] );
    if( TYPO3_MODE === "BE" ) {
      $imageSource = '../' . $imageSource;
      $this->resetFrontendEnvironment();
    }
    $this->tag->addAttribute( 'src', $imageSource );
    $this->tag->addAttribute( 'width', $imageInfo[ 0 ] );
    $this->tag->addAttribute( 'height', $imageInfo[ 1 ] );
    if( $this->arguments[ 'title' ] === '' ) {
      $this->tag->addAttribute( 'title', $this->arguments[ 'alt' ] );
    }

    return $this->tag->render();
  }

}