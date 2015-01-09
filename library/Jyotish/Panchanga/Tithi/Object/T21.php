<?php
/**
 * @link      http://github.com/kunjara/jyotish for the canonical source repository
 * @license   GNU General Public License version 2 or later
 */

namespace Jyotish\Panchanga\Tithi\Object;

use Jyotish\Panchanga\Karana\Karana;

/**
 * Class of tithi 21.
 *
 * @author Kunjara Lila das <vladya108@gmail.com>
 */
class T21 extends TithiObject {
    /**
     * Tithi key
     * 
     * @var int
     */
    protected $tithiKey = 21;

    /**
     * Devanagari number 6 in transliteration.
     * 
     * @var array
     * @see Jyotish\Alphabet\Devanagari
     */
    protected $tithiTranslit = ['d6'];

    /**
     * Karana of tithi.
     * 
     * @var string
     */
    protected $tithiKarana = array(
        1 => Karana::NAME_GARA,
        2 => Karana::NAME_VANIJA
    );

    public function __construct($options = null) {
        parent::__construct($options);
    }
}