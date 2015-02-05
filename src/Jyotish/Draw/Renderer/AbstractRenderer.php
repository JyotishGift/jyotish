<?php
/**
 * @link      http://github.com/kunjara/jyotish for the canonical source repository
 * @license   GNU General Public License version 2 or later
 */

namespace Jyotish\Draw\Renderer;

use Jyotish\Graha\Graha;
use Jyotish\Base\Data;
use Jyotish\Base\Utils;

/**
 * Abstract class for rendering.
 * 
 * @author Kunjara Lila das <vladya108@gmail.com>
 */
abstract class AbstractRenderer {

    protected $resource = null;
    protected $data = null;

    protected $options = [
        'topOffset' => 0,
        'leftOffset' => 0,
        
        'fontSize' => 10,
        'fontName' => null,
        'fontColor' => '000',
        
        'strokeWidth' => 1,
        'strokeColor' => '000',
        
        'fillColor' => 'fff',
    ];

    public function get($name) {
        if (isset($this->$name)) {
            return $this->$name;
        }

        return null;
    }

    /**
     * Return graha label.
     * 
     * @param string $graha
     * @param Data $Data
     * @param array $options
     * @return string
     */
    public function getGrahaLabel($graha, Data $Data, array $options) {
        $grahas = $Data->getGrahaInBhava();

        switch ($options['labelGrahaType']) {
            case 0:
                $label = $graha;
                break;
            case 1:
                if ($graha != Graha::KEY_LG) {
                    $grahaObject = Graha::getInstance($graha);
                    $label = Utils::unicodeToHtml($grahaObject->grahaUnicode);
                } else {
                    $label = $graha;
                }
                break;
            case 2:
                $label = call_user_func($options['labelGrahaCallback'], $graha);
                break;
            default:
                $label = $graha;
                break;
        }

        if ($graha == Graha::KEY_RA or $graha == Graha::KEY_KE or $graha == Graha::KEY_LG) {
            $grahaLabel = $label;
        }else{
            $grahaLabel = $grahas[$graha]['direction'] == 1 ? $label : '(' . $label . ')';
        }
        
        return $grahaLabel;
    }
    
    public function getResource() {
        return $this->resource;
    }

    public function getData() {
        return $this->data;
    }

    public function setOptions($options) {
        foreach ($options as $key => $value) {
            $method = 'set' . $key;
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function setTopOffset($value) {
        if (!is_numeric($value) || intval($value) < 0) {
            throw new Exception\OutOfRangeException(
                    'Vertical position must be greater than or equals 0.'
            );
        }
        $this->options['topOffset'] = intval($value);
    }

    public function setLeftOffset($value) {
        if (!is_numeric($value) || intval($value) < 0) {
            throw new Exception\OutOfRangeException(
                    'Horizontal position must be greater than or equals 0.'
            );
        }
        $this->options['leftOffset'] = intval($value);
    }

    public function setFontSize($value) {
        if (!is_numeric($value) || intval($value) < 8) {
            throw new Exception\OutOfRangeException(
                    'Font size must be greater than or equals 8.'
            );
        }
        $this->options['fontSize'] = intval($value);
    }

    public function setFontColor($value) {
        $this->options['fontColor'] = $value;
    }

    public function setStrokeWidth($value) {
        if (!is_numeric($value) || floatval($value) < 0) {
            throw new Exception\OutOfRangeException(
                    'Stroke width must be greater than or equals 0.'
            );
        }
        $this->options['strokeWidth'] = $value;
    }

    abstract public function drawPolygon($points);

    abstract public function drawText($text, $x, $y, $options);

    abstract public function setFontName($value);

    abstract public function render();
}