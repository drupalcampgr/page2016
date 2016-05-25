<?php
/**
 * Created by PhpStorm.
 * User: nkostop
 * Date: 25/05/16
 * Time: 20:28
 */

namespace Drupal\drupalcamp\Controller;


use Drupal\Core\Controller\ControllerBase;

class DrupalcampRegisterPage extends ControllerBase
{
  public function getPage()
  {
    $registerForm =  \Drupal::formBuilder()->getForm('Drupal\drupalcamp\Form\register');

    $build = [];
    $build['#theme'] = 'register_page';
    $build['#registerForm'] = $registerForm;

    return $build;
  }
}