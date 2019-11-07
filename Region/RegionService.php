<?php

class RegionService implements IServiceBase
{

    public function GetById($id)
    {
        $utilities = new Utilities();
        $listadoRegion = $this->GetList();
        $elementDecode = $utilities->searchProperty($listadoRegion, 'id', $id)[0];
        $element = New Region();
        $element->set($elementDecode);
        return $element;
    }

    public function GetList()
    {
        $utilities = new Utilities();
        $listadoRegion = array();

        if (isset($_COOKIE['Region'])) {
            $listadoRegion = json_decode($_COOKIE['Region'],false); 
        } else {
            setcookie("Region", json_encode($listadoRegion), $utilities->GetCookieTime(), "/");
        }

        return $listadoRegion;
    }

    public function Add($entity)
    {
        $utilities = new Utilities();
        $listadoRegion = $this->GetList();

        $RegionId = 1; //El Id del personaje que vamos a crear

        if (!empty($listadoRegion)) { //validamos si ya hay personajes creado
            $lastCharacter = $utilities->getLastElement($listadoRegion); //Obtenemos el ultimo elemento del listado de heroe  
            $RegionId =  $lastCharacter->id + 1; //como ya existen heroes el id del nuevo heroe debe ser el id el ultimo + 1
        }

        $entity->id = $RegionId;

        array_push($listadoRegion, $entity); //Agregamos el personaje al listado de personajes

        setcookie("Region", json_encode($listadoRegion), $utilities->GetCookieTime(), "/");
    }

    public function Update($id, $entity)
    {
        $utilities = new Utilities();      
        $listadoRegion = $this->GetList();
        $elementIndex = $utilities->getIndexElement($listadoRegion, 'id', $id); //Obtenemos el indice del elemento en el array del listado de heroes que vamos a editar   

    

        $listadoRegion[$elementIndex] =  $entity; //Actualizamos los datos del heroe en el listado de heroes utilizando el index obtenido del elemento

        setcookie("Region", json_encode($listadoRegion), $utilities->GetCookieTime(), "/");
    }

    public function Delete($id)
    {
        $utilities = new Utilities();
        $listadoRegion = $this->GetList();
        //Obtenemos el listado actual de heroes almacenado en la session

        $elementIndex = $utilities->getIndexElement($listadoRegion, 'id', $id); //Obtenemos el indice del elemento en el array del listado de heroes que vamos a editar       
 
    
        unset($listadoRegion[$elementIndex]);

        $listadoRegion = array_values($listadoRegion);
        setcookie("Region", json_encode($listadoRegion), $utilities->GetCookieTime(), "/");
    }
}
