<?php
/**
 * Created by PhpStorm.
 * User: nkostop
 * Date: 27/05/16
 * Time: 22:34
 */

namespace Drupal\drupalcamp\Controller;


use Drupal\Core\Controller\ControllerBase;

class DrupalcampCodeofconductPage extends ControllerBase
{
    public function getPage() {
        $config = \Drupal::config('drupalcamp.settings');
        $body = $config->get('body');

        return array(
            '#markup' => $body,
        );
    }
}