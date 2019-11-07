<?php
class Region
{
    public $id;
    public $name;
    public $color;
  

    public function __construct() {}

    public function InitializeData(
        $id,
        $name,
        $color
    
    ) {
        $this->id = $id;
        $this->name = $name;    
        $this->color = $color;    
    }

    public function set($data) {
        foreach ($data as $key => $value) $this->{$key} = $value;
    }

  

   
}
