<?php return array(

  // Present
  'present' => array(
    'invariable' => array(),
    'irregular'  => array(),
    'patterns' => array(
      '/^(\D+)er$/' => '$1',
    ),
  ),

  // Past
  'past' => array(
    'patterns' => array(
      '/^(\D+)er$/' => '$1é',
    ),
    'invariable' => array(),
    'irregular' => array(
      'soumettre' => 'soumis',
    ),
  ),
);