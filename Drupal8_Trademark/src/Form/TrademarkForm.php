<?php
//function trademark_admin_settings() {
//    $form = array();
//
//    $form['trademark_copyright'] = array(
//        '#type' => 'checkbox',
//        '#title' => t('Wrap copyright &copy; symbols'),
//        '#default_value' => variable_get('trademark_copyright', TRUE),
//        '#description' => t("By enabling this option, copyright &copy; symbols will be wrapped in a HTML superscript tag (<code>&lt;sup&gt;</code>)."),
//    );
//    $form['trademark_registered'] = array(
//        '#type' => 'checkbox',
//        '#title' => t('Wrap registered &reg; symbols'),
//        '#default_value' => variable_get('trademark_registered', TRUE),
//        '#description' => t("By enabling this option, registered &reg; symbols will be wrapped in a HTML superscript tag (<code>&lt;sup&gt;</code>)."),
//    );
//    $form['trademark_trademark'] = array(
//        '#type' => 'checkbox',
//        '#title' => t('Wrap trademark &trade; symbols'),
//        '#default_value' => variable_get('trademark_trademark', FALSE),
//        '#description' => t("By enabling this option, trademark &trade; symbols will be wrapped in a HTML superscript tag (<code>&lt;sup&gt;</code>). By default this option is disabled as the trademark symbol is usually rendered as superscript natively."),
//    );
//
//    $form['trademark_node_title'] = array(
//        '#type' => 'checkbox',
//        '#title' => t('Filter Node Titles'),
//        '#default_value' => variable_get('trademark_node_title', TRUE),
//        '#description' => t("By default, node titles do not run through content input filters. By enabling this option, this will ensure that all node titles are checked for trademark symbols."),
//    );
//    return system_settings_form($form);
//}
namespace Drupal\trademark\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class TrademarkForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'trademark_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        // Form constructor.
        $form = parent::buildForm($form, $form_state);
        // Default settings.
            $config = $this->config('trademark.settings');

        $form['copyright'] = array(
            '#type' => 'checkbox',
            '#title' => $this->t('Wrap copyright &copy; symbols'),
            '#default_value' => $config->get('trademark.copyright'),
            '#description' => $this->t("By enabling this option, copyright &copy; symbols will be wrapped in a HTML superscript tag (<code>&lt;sup&gt;</code>)."),
        );
        $form['registered'] = array(
            '#type' => 'checkbox',
            '#title' => $this->t('Wrap registered &reg; symbols'),
            '#default_value' => $config->get('trademark.registered'),
            '#description' => $this->t("By enabling this option, registered &reg; symbols will be wrapped in a HTML superscript tag (<code>&lt;sup&gt;</code>)."),
        );
        $form['trademark'] = array(
            '#type' => 'checkbox',
            '#title' => $this->t('Wrap trademark &trade; symbols'),
            '#default_value' => $config->get('trademark.trademark'),
            '#description' => $this->t("By enabling this option, trademark &trade; symbols will be wrapped in a HTML superscript tag (<code>&lt;sup&gt;</code>). By default this option is disabled as the trademark symbol is usually rendered as superscript natively."),
        );

        $form['node_tiles'] = array(
            '#type' => 'checkbox',
            '#title' => $this->t('Filter Node Titles'),
            '#default_value' => $config->get('trademark.node_tiles'),
            '#description' => $this->t("By default, node titles do not run through content input filters. By enabling this option, this will ensure that all node titles are checked for trademark symbols."),
        );

        return $form;
    }
    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {

    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $config = $this->config('trademark.settings');
        $config->set('trademark.copyright', $form_state->getValue('copyright'));
        $config->set('trademark.registered', $form_state->getValue('registered'));
        $config->set('trademark.trademark', $form_state->getValue('trademark'));
        $config->set('trademark.node_tiles', $form_state->getValue('node_tiles'));
        $config->save();
        return parent::submitForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [
            'trademark.settings',
        ];
    }

}