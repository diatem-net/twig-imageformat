<?php

namespace Drupal\twig_imageformat\TwigExtension;

use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;
use Drupal\image\Entity\ImageStyle;
use Drupal\file\Entity\File;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
/**
 * Add a imageformat() && termImageformat() function to Twig
 */
class ImageFormat extends AbstractExtension 
{

    /**
    * {@inheritdoc}
    */
    public function getName()
    {
        return 'twig_imageformat.twig_extension';
    }

    /**
    * Generates a list of all Twig functions that this extension defines.
    */
    public function getFunctions()
    {
        return array(
            new TwigFunction(
              'imageformat',
              array($this, 'imageformat'),
              array('is_safe' => array('html'))
            ),
            new TwigFunction(
              'termImageformat',
              array($this, 'termImageformat'),
              array('is_safe' => array('html'))
            )
        );
    }

    public static function imageformat($nid, $field, $style = 'aucun', $key = 0)
    {
      $derivativeUri = null;
      $node = Node::load($nid);
      if ($node && $field && $node->hasField($field)) {       
        if ($images = $node->get($field)->getValue()) {        
          $image = $images[$key];
          $file = File::load($image['target_id']);
          if ($style == 'aucun') {
            $derivativeUri = $file->uri->value;
          } else {
            $imageStyle = ImageStyle::load($style);
            $derivativeUri = $imageStyle->buildUri($file->uri->value);
            if (!file_exists($derivativeUri)) {
              $imageStyle->createDerivative($file->uri->value, $derivativeUri);
            }
          }
        }
      }
      return $derivativeUri ? \Drupal::service('file_url_generator')->generateAbsoluteString($derivativeUri) : null;
    }



    public static function termImageformat($tid, $field, $style = 'aucun', $key = 0)
    {
      $derivativeUri = null;
      $node = Term::load($tid);

      if ($node && $field && $node->hasField($field)) {       
        if ($images = $node->get($field)->getValue()) {         
          $image = $images[$key];
          $file = File::load($image['target_id']);
          if ($style == 'aucun') {
            $derivativeUri = $file->uri->value;
          } else {
            $imageStyle = ImageStyle::load($style);
            $derivativeUri = $imageStyle->buildUri($file->uri->value);
            if (!file_exists($derivativeUri)) {
              $imageStyle->createDerivative($file->uri->value, $derivativeUri);
            }
          }
        }
      }
      return $derivativeUri ? \Drupal::service('file_url_generator')->generateAbsoluteString($derivativeUri) : null;
    }

}
