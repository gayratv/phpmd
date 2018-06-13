<?php

/**
 * Датчик температуры, влажности и давления Aqara
 */

namespace Xiaomi\Devices;

class AqaraWeatherSensor extends AbstractDevice {

    private $temperature;
    private $humidity;
    private $pressureKPa;
    private $pressure;

    protected function updateParam($param,$value) {
        switch ($param) {
            case "temperature":
                $this->setTemperature($value);
                break;
            case "humidity":
                $this->setHumidity($value);
                break;
            case "pressure":
                $this->setPressure($value);
                break;
            default:
                echo "$param => $value\n";
        }
    }

    private function setTemperature($value) {
        $last=$this->temperature;
        $this->temperature=$value/100;
        if ($this->temperature!=$last) {
            $this->actions['temperature']=$this->temperature;
        }
    }

    private function setHumidity($value) {
        $last=$this->humidity;
        $this->humidity=$value/100;
        if ($this->humidity!=$last) {
            $this->actions['humidity']=$this->humidity;
        }
    }

    private function setPressure($value) {
        $last=$this->pressureKPa;
        $this->pressureKPa=$value;
        $this->pressure=round($value*760/101325,2);
        if ($this->pressureKPa!=$last) {
            $this->actions['pressure']=$this->pressure;
        }
    }

    public function getTemperature() {
        return $this->temperature;
    }
    
    public function getHumidity() {
        return $this->humidity;
    }
    
    public function getPressure() {
        return $this->pressure;
    }

    public function getDeviceName() {
        return "Aqara Temperature Humidity Sensor";
    }
    
    public function __toString() {
        return sprintf('Температура воздуха %+.1f &deg;C, относительная влажность %.1f%%, атмосферное давление %.1f мм.рт.ст. Батарея CR2032: %.3f В.',$this->temperature,$this->humidity,$this->pressure,$this->voltage);
    }

}
