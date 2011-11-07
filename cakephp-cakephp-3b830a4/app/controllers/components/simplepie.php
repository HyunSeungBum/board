<?php
/*
 * SimplePie CakePHP Component
 * Copyright (c) 2007 Matt Curry
 * www.PseudoCoder.com
 *
 * Based on the work of Scott Sansoni (http://cakeforge.org/snippet/detail.php?type=snippet&id=53)
 *
 * @author      mattc <matt@pseudocoder.com>
 * @version     1.0
 * @license     MIT
 *
 */

class SimplepieComponent extends Object {
  var $cache;
  var $site;
  var $siteLink;
  var $siteDescription;

  function __construct() {
    $this->cache = CACHE . 'rss' . DS;
  }

  function startup( &$controller ) { 
	  $this->Controller =& $controller; 
  }

  function feed($feed_url) {
    
    //make the cache dir if it doesn't exist
    if (!file_exists($this->cache)) {
      uses('folder');
      $folder = new Folder();
      $folder->create($this->cache); 
    }

    //include the vendor class
    #vendor('simplepie/simplepie');
    App::import('Vendor', 'simplepie');

    //setup SimplePie
    $feed = new SimplePie();
    $feed->set_feed_url($feed_url);
    $feed->set_cache_location($this->cache);

    //retrieve the feed
    $feed->init();

    $site = $feed->get_channel_tags('','title');
    $this->site = $site['0']['data'];
    $siteLink = $feed->get_channel_tags('','link');
    $this->siteLink = $siteLink['0']['data'];
    $siteDescription = $feed->get_channel_tags('','description');
    $this->siteDescription = $siteDescription['0']['data'];

    //get the feed items
    $items = $feed->get_items();

    //return
    if ($items) {
      return $items;
    } else {
      return false;
    }
  }

  function get_site() {
	return $this->site;	
  }

  function get_siteLink() {
	return $this->siteLink;	
  }

  function get_siteDescription() {
	return $this->siteDescription;
  }
}
?> 
