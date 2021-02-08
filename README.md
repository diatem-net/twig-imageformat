Image Format 
=========
The Image Format allows you to retrieve an image according to the style defined in the backoffice.


REQUIREMENTS
-------------
Drupal 9.x.


INSTALLATION
-------------
Install this module as usual. Please see
https://www.drupal.org/docs/extending-drupal/installing-modules


USAGE
--------------

paramètres:
	- node id OR term id
	- image format
	- key of image if several images

{% set image = imageformat(node.id, 'field_image', 'style' , key) %}
{% set image = termImageformat(term.id, 'field_image', 'style' , key) %}