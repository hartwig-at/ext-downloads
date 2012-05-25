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
 * ViewHelper to generate an icon that correlates to the type of a file
 *
 * @package TYPO3
 * @subpackage tx_downloads
 */
class Tx_Downloads_ViewHelpers_TypeIconViewHelper extends Tx_Fluid_ViewHelpers_ImageViewHelper {

  /**
   * Renders an icon that correlates to the type of a file
   *
   * @param string $filename
   * @param string $width width of the image. This can be a numeric value representing the fixed width of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
   * @param string $height height of the image. This can be a numeric value representing the fixed height of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
   * @param integer $minWidth minimum width of the image
   * @param integer $minHeight minimum height of the image
   * @param integer $maxWidth maximum width of the image
   * @param integer $maxHeight maximum height of the image
   * @return string The bytes in human-readable format.
   */
  public function render( $filename ) {
    $nameParts = pathinfo( $filename );
    if( !isset( $nameParts[ "extension" ] ) ) {
      t3lib_div::devLog( "Unable to determine file extension for '" . $filename. "'.", "downloads" );
      return;
    }
    $fileExtension = $nameParts[ "extension" ];
    $fileExtension = strtolower( $fileExtension );
    
    $configurationManager = t3lib_div::makeInstance( "Tx_Extbase_Configuration_ConfigurationManager" );
    $settings = $configurationManager->getConfiguration( Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS );
    
    if( isset( $settings[ "typeIcons" ][ $fileExtension ] ) ) {
      $typeIconFilename = $settings[ "iconPath" ] . $settings[ "typeIcons" ][ $fileExtension ];
      
    } else {
      $typeIconFilename = $settings[ "iconPath" ] . "document.png";
    }
    
    // Everything's fine, render the image.
    return parent::render( $typeIconFilename, 16, 16 );
  }

}

?>