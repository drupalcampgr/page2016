/**
 * @file
 *
 * Initiane mean menu for main menu.
 *
 */
(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.drupalcamp2016MeanMenu = {
    attach: function (context, settings) {

      // Place your code here.
      $('header nav').meanmenu({
        meanMenuContainer: 'header',
        meanScreenWidth: "979",
        meanRemoveAttrs: true,
        meanMenuOpen: '<div class="mean__trigger-icon-wrapper"><div class="mean__trigger-icon mean__trigger-icon--first"></div><div class="mean__trigger-icon mean__trigger-icon--second"></div><div class="mean__trigger-icon mean__trigger-icon--third"></div></div>',
        meanMenuClose: '<div class="mean__trigger-icon-wrapper mean__trigger-icon-wrapper--closed"><div class="mean__trigger-icon mean__trigger-icon--first"></div><div class="mean__trigger-icon mean__trigger-icon--second"></div><div class="mean__trigger-icon mean__trigger-icon--third"></div></div>'
      });
    }
  };

})(jQuery, Drupal);
