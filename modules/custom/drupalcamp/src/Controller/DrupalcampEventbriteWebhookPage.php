<?php
/**
 * Created by PhpStorm.
 * User: nkostop
 * Date: 25/05/16
 * Time: 20:28
 */

namespace Drupal\drupalcamp\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use jamiehollern\eventbrite\Eventbrite;
use Drupal\node\Entity\Node;

class DrupalcampEventbriteWebhookPage extends ControllerBase
{
  public function getWebhook(Request $request)
  {
    $params = array();
    $content = $request->getContent();
    if (!empty($content)) {
      // 2nd param to get as array
      $params = json_decode($content, TRUE);
      
      $url = $params['api_url'];
     $orderId = substr($url, 40);
      
    } else {
      $params = 'NULL POST';
      $orderId = 0;
    }
   

    $eventbrite = new Eventbrite('SWTQJC6JLKXUXV6OPASJ');
    $response = $eventbrite->get('orders/'.$orderId, ['expand' => 'attendees']);
    $attendees = $response['body']['attendees'];
    foreach ($attendees as $attende => $value){
      $firstName = $value['profile']['first_name'];
      $lastName = $value['profile']['last_name'];
      $email = $value['profile']['email'];
      $jobTitle = $value['profile']['job_title'];
      
      $node = Node::create(array(
          'type' => 'registered_attendants',
          'title' => $lastName.' '.$firstName,
          'langcode' => 'en',
          'uid' => '1',
          'status' => 1,
          'field_email' => $email,
          'field_firstname' => $firstName,
          'field_lastname' => $lastName,
          'field_occupation' => $jobTitle,
          'field_occupation' => TRUE,
      ));

      $node->save();
      \Drupal::logger('eventbrite_webhook')->info('New attende saved: '.$lastName.' '.$firstName);
    }

    return new JsonResponse($response);
  }
}