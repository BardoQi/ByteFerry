<?php
/**
 * Created by PhpStorm.
 * User: Bardo
 * Date: 2019/1/24
 * Time: 18:31
 */

namespace ByteFerry\Queue;



class BaseQueue
{
    public $DEFAULT_PRIORITY=1024;
    public $DEFAULT_DELAY=0;
    public $DEFAULT_TTR=60;

    public $priority;
    public $delay;
    public $ttr;

    private static  $instance = [];

    private function __construct()
    {

    }

    public function getInstance($name){
        if(!isset(self::$instance[$name])){
            $this->initInstance($name);
        }
        return self::$instance[$name];
    }

    private function initInstance($name){
        self::$instance[$name] = new Ds\Queue();
    }
}