<?php

namespace Drupal\trademark\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\trademark\Controller\TrademarkController;

/**
 * Provides a filter wrap the trademark symbols in HTML superscript tags
 *
 * @Filter(
 *   id = "filter_trademark",
 *   module = "trademark",
 *   title = @Translation("Trademark Filter"),
 *   description = @Translation("Wrap the trademark symbols in HTML superscript tags"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_IRREVERSIBLE,
 *   weight = -10
 * )
 */
class FilterTrademark extends FilterBase {
    /**
     * {@inheritdoc}
     */
    public function process($text, $langcode)
    {
        $controller = new TrademarkController();
        return new FilterProcessResult(($controller->_trademark_process($text)));
    }
    /**
     * {@inheritdoc}
     */
    public function tips($long = FALSE) {
        $replacements = array();
        if (\Drupal::state()->get('trademark.copyright', true)) {
            $replacements[] = '&copy;';
        }
        if (\Drupal::state()->get('trademark.registered', true)) {
            $replacements[] = '&reg;';
        }
        if (\Drupal::state()->get('trademark.trademark', true)) {
            $replacements[] = '&trade;';
        }

        return t('The following symbols will be wrapped in html superscript tags (<code>&lt;sup&gt;</code>): ' . join(', ', $replacements));

    }
}
//
///**
// * Implements hook_filter_info().
// */
//function trademark_filter_info() {
//    $filters = array();
//    $replacements = array();
//    if (\Drupal::state()->get('trademark.copyright', TRUE)) {
//        $replacements[] = '&copy;';
//    }
//    if (\Drupal::state()->get('trademark.registered', TRUE)) {
//        $replacements[] = '&reg;';
//    }
//    if (\Drupal::state()->get('trademark.trademark', FALSE)) {
//        $replacements[] = '&trade;';
//    }
//    $controller = new TrademarkController();
//    $filters['trademark'] = array(
//        'title' => t('Wrap the following symbols in HTML superscript tags (<code>&lt;sup&gt;</code>): !replacements', array('!replacements' => implode(',', $replacements))),
//        'process callback' => '$controller->_trademark_process',
//        'tips callback' => '_trademark_tips',
//    );
//    return $filters;
//}
//
//
///**
// * filter tips callback.
// */
//function _trademark_tips($filter, $format, $long = false) {
//    $replacements = array();
//    if (\Drupal::state()->get('trademark.copyright', true)) {
//        $patterns[] = '/([!])?(&copy;|&#169;|©)/';
//    }
//    if (\Drupal::state()->get('trademark.registered', true)) {
//        $patterns[] = '/([!])?(&reg;|&#174;|®)/';
//    }
//    if (\Drupal::state()->get('trademark.trademark', false)) {
//        $patterns[] = '/([!])?(&trade;|&#153;|™)/';
//    }
//    if ($long && !empty($replacements)) {
//        return t('the following symbols will be wrapped in html superscript tags (<code>&lt;sup&gt;</code>): !replacements', array('!replacements' => implode(',', $replacements)));
//    }
//}