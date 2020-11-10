<?php
use Psr\Container\ContainerInterface;



return function (ContainerInterface $container)
{
  $container->set('settings',function()
  {
    $db = require __DIR__ . '/database.php';

    return [
        "db"=>$db
    ];
  });
};