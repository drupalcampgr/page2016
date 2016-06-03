<?php

namespace Drupal\drupalcamp\Controller;

use Drupal\Core\Controller\ControllerBase;

class DrupalcampVolunteerPage extends ControllerBase
{
  public function getPage()
  {
    $form =  \Drupal::formBuilder()->getForm('Drupal\drupalcamp\Form\register');

    $build = [];
    $build['#theme'] = 'volunteer_page';
    $build['#volunteerForm'] = $form;

    return $build;
  }

}