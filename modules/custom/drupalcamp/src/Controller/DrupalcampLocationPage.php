<?php
/**
 * Created by PhpStorm.
 * User: nkostop
 * Date: 25/05/16
 * Time: 20:28
 */

namespace Drupal\drupalcamp\Controller;


use Drupal\Core\Controller\ControllerBase;

class DrupalcampLocationPage extends ControllerBase
{
  public function getPage()
  {
    $build = [];
    $build['#theme'] = 'location_page';

    return $build;
  }
}