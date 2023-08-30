<?php


namespace app\module\hardwareCloud;


use app\module\hardwareCloud\deivce\airSwitch;
use app\module\hardwareCloud\deivce\face;
use app\module\hardwareCloud\deivce\horn;
use app\module\hardwareCloud\deivce\wifiLock;

class HardwareClout
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

    static function Horn(){
        return new horn();
    }
}
