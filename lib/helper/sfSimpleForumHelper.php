<?php

function forum_breadcrumb($params, $options = array())
{
  if(!$params) return;
  
  $first = true;
  $title = '';
  $id = isset($options['id']) ? $options['id'] : 'forum_navigation';
  $html = '<ul id="'.$id.'">';
  $html .= '<li>'.sfConfig::get('app_sfSimpleForumPlugin_breadcrumb_separator', ' &raquo; ').'</li>';
  foreach ($params as $step) 
  { 
    $separator = $first ? '' : sfConfig::get('app_sfSimpleForumPlugin_breadcrumb_separator', ' &raquo; ');
    $first = false;
    $html .= '<li>'.$separator;
    $title .= $separator;
    if(is_array($step))
    {
      $html .= link_to($step[0], $step[1]);
      $title .= $step[0];
    }
    else
    {
      $html .= $step;
      $title .= $step;
    }
    $html .= '</li>';
  }
  $html .= '</ul>';

  return $html;
}

function forum_rank($rankArray=array(),$nb_posts=0)
{

  $choosedRank=null;
  foreach($rankArray as $rank)
  {
    if($rank['nb_posts']<=$nb_posts)
    {
      $choosedRank=$rank;
    }

  }

  return $choosedRank;
}
