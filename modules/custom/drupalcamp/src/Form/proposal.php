<?php

/**
 * Created by PhpStorm.
 * User: nkostop
 * Date: 25/05/16
 * Time: 20:32
 */

namespace Drupal\drupalcamp\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class proposal extends FormBase {
  public function getFormId() {
    return 'proposal_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['speakerName'] = [
      '#type' => 'textfield',
      '#title' => t('Speaker Name'),
      '#required' => TRUE,
      '#attributes' => [
        'class' => [
          '',
        ],
      ],
      '#prefix' => '',
      '#suffix' => '',
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => 'E-mail',
      '#required' => TRUE,
      '#prefix' => '',
      '#ajax' => [
        'callback' => array($this, 'validateEmail'),
        'event' => 'change',
        'progress' => array(
          'type' => 'throbber',
          'message' => t('Verifying email...'),
        ),
      ],
      '#suffix' => '',
    ];

    $form['sessionTitle'] = [
      '#type' => 'textfield',
      '#title' => t('Session title'),
      '#required' => TRUE,
      '#prefix' => '',
      '#suffix' => '',
    ];

    $form['description'] = [
      '#type' => 'textfield',
      '#title' => t('Description'),
      '#required' => TRUE,
      '#prefix' => '',
      '#suffix' => '',
    ];

    $form['submit'] = [
      '#type' => 'button',
      '#value' => $this->t('Submit'),
      '#attributes' => [
        'class' => [
          'form__submit',
        ],
      ],
      '#ajax' => [
        'callback' => 'Drupal\drupalcamp\Form\proposal::sendCallback',
        'event' => 'click',
        'progress' => [
          'type' => 'throbber',
          'message' => t('Your registration is been send...'),
        ],
      ],
    ];

    return $form;
  }

  public function validateEmail(array &$form, FormStateInterface $form_state) {
    if (!(\Drupal::service('email.validator')
      ->isValid($form_state->getValue('email')))
    ) {
      $ajax_response = new AjaxResponse();
      $ajax_response->addCommand(new HtmlCommand('#response-message', t('Email in not valid. Please enter a valid email address.')));

      // Return the AjaxResponse Object.
      return $ajax_response;
    }
    else {
      $ajax_response = new AjaxResponse();
      $ajax_response->addCommand(new HtmlCommand('#response-message', ''));

      // Return the AjaxResponse Object.
      return $ajax_response;
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $mailManager = \Drupal::service('plugin.manager.mail');

    $module = 'drupalcamp';
    $key = 'proposal_form';
    $system_site_config = \Drupal::config('system.site');
    $to = $system_site_config->get('mail');
    $params['message'] = $form_state->getValue('speakerName'); //TODO:fix field
    $params['subject'] = $form_state->getValue('speakerName');
    $params['name'] = $form_state->getValue('speakerName');
    $params['email'] = $form_state->getValue('email');
    $langcode = \Drupal::currentUser()->getPreferredLangcode();
    $send = true;

    $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
    if ($result['result'] !== true) {
      $message = t('There was a problem');
      drupal_set_message($message, 'error');
      \Drupal::logger('drupalcamp')->error($message);
    } else {
      $message = t('Your proposal has been submitted.');
      drupal_set_message($message);
      \Drupal::logger('drupalcamp')->notice($message);
    }
    drupal_set_message($this->t('You have successfully submitted a proposal.'));
  }

  public static function sendCallback(array &$form, FormStateInterface $form_state)
  {

    if((\Drupal::service('email.validator')->isValid($form_state->getValue('email')))&&(!empty($form_state->getValue('speakerName')))&&(!empty($form_state->getValue('sessionTitle')))&&(!empty($form_state->getValue('description')))) {

      $speakerName = $form_state->getValue('speakerName');
      $sessionTitle = $form_state->getValue('sessionTitle');
      $email = $form_state->getValue('email');
      $description =$form_state->getValue('description');
      $node = Node::create(array(
          'type' => 'proposals',
          'title' => $speakerName.': '.$sessionTitle,
          'langcode' => 'en',
          'uid' => '1',
          'status' => 1,
          'field_email' => $email,
          'field_speaker_name' => $speakerName,
          'field_session_title' => $sessionTitle,
          'body' => $description,
      ));

      $node->save();

      $ajax_response = new AjaxResponse();

      $mailManager = \Drupal::service('plugin.manager.mail');

      $module = 'drupalcamp';
      $key = 'proposal_form';
      $system_site_config = \Drupal::config('system.site');
      $to = $system_site_config->get('mail');
      $params['message'] = $form_state->getValue('speakerName'); //TODO:fix field
      $params['subject'] = $form_state->getValue('speakerName');
      $params['name'] = $form_state->getValue('speakerName');
      $params['email'] = $form_state->getValue('email');
      $langcode = \Drupal::currentUser()->getPreferredLangcode();
      $send = true;

      $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
      if ($result['result'] !== true) {
        $message = t('There was a problem please try again later');
        drupal_set_message($message, 'error');
        \Drupal::logger('drupalcamp')->error($message);
      } else {
        $message = t('Your proposal has been submitted.');
        drupal_set_message($message);
        \Drupal::logger('drupalcamp')->notice($message);
        $ajax_response->addCommand(new HtmlCommand('#proposal-form',''));
      }
    } else {
      $message = t('Proposal not send. Please fill in all fields.');
    }

    $ajax_response->addCommand(new HtmlCommand('#response-message',$message));

    // Return the AjaxResponse Object.
    return $ajax_response;
  }

}