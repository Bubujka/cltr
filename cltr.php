<?php
require "vendor/autoload.php";

def_accessor('cltr\pdo_host');
def_accessor('cltr\pdo_dbname');
def_accessor('cltr\pdo_user');
def_accessor('cltr\pdo_password');
def_accessor('cltr\pdo_table');

def_memo('cltr\pdo', function(){
  $db = new PDO('mysql:host='.cltr\pdo_host().';dbname='.cltr\pdo_dbname(), cltr\pdo_user(), cltr\pdo_password());
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
  $db->query('set names utf8');
  return $db;
});

def_accessor('cltr\time_start');
def('cltr\start', function(){
  cltr\time_start(microtime(true));
});

def('cltr\uri', function(){
  if(isset($_SERVER['REQUEST_URI']))
    return $_SERVER['REQUEST_URI'];
});

def('cltr\host', function(){
  if(isset($_SERVER['HTTP_HOST']))
    return $_SERVER['HTTP_HOST'];
});
def('cltr\time', function(){
  return microtime(true) - cltr\time_start();
});

def('cltr\stop', function(){
  try{
    if(!cltr\pdo_host())
      return;
    if(!cltr\time_start())
      return;
    $db = cltr\pdo();
    $db->query('
      CREATE TABLE IF NOT EXISTS `'.cltr\pdo_table().'` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `host` varchar(255) DEFAULT NULL,
        `uri` varchar(1024) DEFAULT NULL,
        `time` float(8,5) DEFAULT NULL,
        `memory` int(11) DEFAULT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;');

    $db->query('insert into `'.cltr\pdo_table().'` (host, uri, memory, time) values(
      '.$db->quote(cltr\host()).',
      '.$db->quote(cltr\uri()).',
      '.$db->quote(memory_get_peak_usage()).',
      '.$db->quote(cltr\time()).')');
  }catch(Exception $e){

  }
});
