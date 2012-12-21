<?php return array(

  // An array of patterns to use to feminize words
  'feminize' => array(
    '/és$/' => 'ées',
    '/(.+)/' => '$1e',
  ),

  // An array of irregular feminizations
  'irregular' => array(
    'cet' => 'cette',
    'le' => 'la',
  ),

  // An array of invariable words
  'invariable' => array(
    'des', 'ces', 'la',
  ),

  // An array of female words
  'female' => array(
    'category',
    'photo',
    'localisation',
  ),
);