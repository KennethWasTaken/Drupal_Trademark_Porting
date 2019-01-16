<?php

namespace Drupal\trademark\Controller;

use Drupal\Core\Controller\ControllerBase;

class TrademarkController extends ControllerBase {
    public function test() {
        $build = [
            '#markup' => t('<strong>Normal</strong>: &trade;, &reg; and &copy;test
<br />
<strong>With <code>&lt;sup&gt;</code></strong>: <sup>&trade;</sup>, <sup>&reg;</sup> and <sup>&copy;</sup>')
        ];
        $build['#markup'] .= t('test');
//        $build['#markup']=$this->_trademark_process( $build['#markup']);
        return $build;
    }
    /**
     * replacement process callbacks.
     */
    public function _trademark_process($text, $filter = null) {
        $patterns = array();

            if (\Drupal::state()->get('trademark.copyright', true)) {
                $patterns[] = '/([!])?(&copy;|&#169;|©)/';
            }
            if (\Drupal::state()->get('trademark.registered', true)) {
                $patterns[] = '/([!])?(&reg;|&#174;|®)/';
            }
            if (\Drupal::state()->get('trademark.trademark', false)) {
                $patterns[] = '/([!])?(&trade;|&#153;|™)/';
            }
            if (is_array($text)) {
                $text = current($text);
            }
            return preg_replace_callback(
                $patterns,
                function($matches) {
                if ($matches[1] != '!') {
                    $matches = '<sup class="trademark-processed">' . $matches[2] . '</sup>';
                }
                return $matches;
            }, $text);
    }
}

?>



