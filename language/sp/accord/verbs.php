<?php return array(

  // Present
  'present' => array(
    'invariable' => array(),
    'irregular'  => array(),
    'patterns'   => array(),
  ),

  // Past
  'past' => array(
    'patterns' => array(
      '/^(\D+)r$/' => '$1do',
    ),
    'invariable' => array(),
    'irregular' => array(
      'mostrar' => 'muestra'
    ),
  ),
);