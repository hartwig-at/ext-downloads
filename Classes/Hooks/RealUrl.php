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
 *
 * Userfunc to encode speaking URLs
 * This removes repeated identifiers that aren't really required to qualify a download instruction
 * Taken from: http://www.t3node.com/blog/hiding-repeated-segments-with-realurl/
 */
class Tx_Downloads_Hooks_RealUrl {

  public static function encode( &$params, &$ref ) {
    if( FALSE === strpos( $params[ "URL" ], "download/Downloads/download/" ) ) {
      return;
    }

    // Fix excessive download identifiers
    $params[ "URL" ] = str_replace( "download/Downloads/download/", "download/", $params[ "URL" ] );

    $assumedSuffix       = ".html";
    $assumedSuffixOffset = strlen( $params[ "URL" ] ) - strlen( $assumedSuffix );
    // Does the URL end with the assumed suffix?
    if( strrpos( $params[ "URL" ], $assumedSuffix ) == $assumedSuffixOffset ) {
      $params[ "URL" ] = substr( $params[ "URL" ], 0, $assumedSuffixOffset );
    }
  }

  public static function decode( &$params, &$ref ) {
    if( FALSE === strpos( $params[ "URL" ], "download/" ) ) {
      return;
    }

    // Add back controller and action identifiers
    $params[ "URL" ] = str_replace( "download/", "download/Downloads/download/", $params[ "URL" ] );

    $assumedSuffix       = ".html";
    $assumedSuffixOffset = strlen( $params[ "URL" ] ) - strlen( $assumedSuffix );
    // Does the URL end with the assumed suffix?
    if( strrpos( $params[ "URL" ], $assumedSuffix ) != $assumedSuffixOffset ) {
      $params[ "URL" ] .= $assumedSuffix;
    }
  }
}