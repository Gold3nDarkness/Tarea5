<?php
class Pokemon
{
    public $id;
    public $name;
    public $characterTypeId;
    public $regionId;
    public $poderes;
    public $profilePhoto;  

    public function __construct() {}

    public function InitializeData(
        $id,
        $name,
        $characterTypeId,
        $regionId,
        $poderes
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->characterTypeId = $characterTypeId;
        $this->regionId= $regionId;
        $this->poderes = $poderes;
        
    }

    public function set($data) {
        foreach ($data as $key => $value) $this->{$key} = $value;
    }

    public function getEditablePoderes()
    {
        if (!empty($this->poderes)) {
            return implode(",", $this->poderes);
        } else {
            return "";
        }
    }

    public function getEditableTipos()
    {
        if (!empty($this->characterTypeId)) {
            return implode(",", $this->characterTypeId);
        } else {
            return "";
        }
    }

    public function getCharacterTypeId()
    {
        $utilities = new Utilities();

        if($this->characterTypeId != 0 && $this->characterTypeId != null){
            return $utilities->characterTypeList[$this->characterTypeId]; 
        }
    }
    public function getCharacterRegionId()
    {
        $utilities = new Utilities();

        if($this->regionId != 0 && $this->regionId != null){
            return $utilities->regionList[$this->regionTypeId]; 
        }
    }
}
