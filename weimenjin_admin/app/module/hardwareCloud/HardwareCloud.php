<?php


namespace app\module\hardwareCloud;


use app\module\hardwareCloud\deivce\airSwitch;
use app\module\hardwareCloud\deivce\face;
use app\module\hardwareCloud\deivce\horn;
use app\module\hardwareCloud\deivce\lockSwitch;
use app\module\hardwareCloud\deivce\wifiLock;
use app\module\hardwareCloud\deivce\accesscontrol;

class HardwareCloud
{
    static function App(){
        return new server();
    }
    static function WifiLock(){
        return new wifiLock();
    }
  static function Face(){
        return new face();
    }

    static function AirSwitch(){
        return new airSwitch();
    }
    static function LockSwitch(){
        return new lockSwitch();
    }

    static function Horn(){
        return new horn();
    }
    static function Accesscontrol(){
        return new accesscontrol();
    }
}
