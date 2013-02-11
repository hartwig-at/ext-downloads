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
class Tx_Downloads_ViewHelpers_TypeIconViewHelper extends Tx_Fluid_ViewHelpers_ImageViewHelper {

  /**
   * Renders an icon that correlates to the type of a file
   *
   * @param string $filename The name of the file
   *
   * @return string The <img> tag to render the type icon.
   */
  public function render( $filename ) {
    $nameParts = pathinfo( $filename );
    if( !isset( $nameParts[ "extension" ] ) ) {
      t3lib_div::devLog( "Unable to determine file extension for '" . $filename . "'.", "downloads" );
      return "";
    }
    $fileExtension = $nameParts[ "extension" ];
    $fileExtension = strtolower( $fileExtension );

    $configurationManager = t3lib_div::makeInstance( "Tx_Extbase_Configuration_ConfigurationManager" );
    $settings             = $configurationManager->getConfiguration( Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS );

    if( isset( $settings[ "typeIcons" ][ $fileExtension ] ) ) {
      $typeIconFilename = $settings[ "iconPath" ] . $settings[ "typeIcons" ][ $fileExtension ];

    } else {
      $typeIconFilename = $settings[ "iconPath" ] . "document.png";
    }

    // Everything's fine, render the image.
    return parent::render( $typeIconFilename, 16, 16 );
  }
}