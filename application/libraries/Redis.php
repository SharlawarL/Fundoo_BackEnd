<?php


Class Redis{

    function config()
    {
        // Parameters passed using a named array:
        $client = new Predis\Client([
        'scheme' => 'tcp',
        'host'   => 'localhost',
        'port'   => 6379,
        'database' => 1
        ]);
        return $client;  

    }
    
}