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
 * Created: 2012-11-22 13:28
 *
 * @author     Oliver Salzburg <oliver.salzburg@hartwig-at.de>, Hartwig Communication & Events
 * @author     Felix Nagel
 * @copyright  Copyright (C) 2012, Felix Nagel
 * @copyright  Copyright (C) 2012, Oliver Salzburg
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 * @reference  http://www.felixnagel.com/blog/artikel/2012/07/20/typo3-use-content-element-uid-in-extbase-fluid-templates/
 * @package    TYPO3
 * @subpackage tx_downloads
 */
class Tx_Downloads_ViewHelpers_UidViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
  /**
   * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
   */
  protected $configurationManager;

  /**
   * @param Tx_Extbase_Configuration_ConfigurationManagerInterface An instance of the Configuration Manager
   * @return void
   */
  public function injectConfigurationManager( Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager ) {
    $this->configurationManager = $configurationManager;
  }

  /**
   * Set uid of the content element
   *
   * @return int $uid The uid of the content element
   */
  public function render() {
    // fallback
    $uid = 0;

    if( $this->templateVariableContainer->exists( "contentObjectData" ) ) {
      // this works for templates but not for partials
      $contentObjectData = $this->templateVariableContainer->get( "contentObjectData" );
      $uid               = $contentObjectData[ "uid" ];
    } else {
      // this should work in every circumstance
      $cObj = $this->configurationManager->getContentObject();
      $uid  = $cObj->data[ "uid" ];
    }

    return $uid;
  }
}