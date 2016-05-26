<?php
/**
 * Created by PhpStorm.
 * User: nkostop
 * Date: 25/05/16
 * Time: 20:28
 */

namespace Drupal\drupalcamp\Controller;


use Drupal\Core\Controller\ControllerBase;

class DrupalcampSubmitProposalPage extends ControllerBase
{
  public function getPage()
  {
    
    $proposalForm =  \Drupal::formBuilder()->getForm('Drupal\drupalcamp\Form\proposal');

    $build = [];
    $build['#theme'] = 'proposal_page';
    $build['#proposalForm'] = $proposalForm;

    return $build;
  }
}