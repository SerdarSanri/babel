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
      '/^(\D+)(a|e|i|o|u)$/' => '$1$2d',
      '/^(\D+)$/' => '$1ed',
    ),
    'invariable' => array(),
    'irregular' => array(
      'submit' => 'submitted',
    ),
  ),
);