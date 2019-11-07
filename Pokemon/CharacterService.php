<?php

class CharacterService implements IServiceBase
{
    

    public function GetById($id)
    {
        $utilities = new Utilities();
        $listadoPokemones = $this->GetList();
        $elementDecode = $utilities->searchProperty($listadoPokemones, 'id', $id)[0];
        $element = new Pokemon();
        $element->set($elementDecode);
        return $element;
    }

    public function GetList()
    {
        $utilities = new Utilities();
        $listadoPokemones = array();

        if (isset($_COOKIE['Pokemones'])) {
            $listadoPokemones = json_decode($_COOKIE['Pokemones'],false); 
        } else {
            setcookie("Pokemones", json_encode($listadoPokemones), $utilities->GetCookieTime(), "/");
        }

        return $listadoPokemones;
    }
    

    public function Add($entity)
    {
        $utilities = new Utilities();
        $listadoPokemones = $this->GetList();

        $characterId = 1; //El Id del personaje que vamos a crear

        if (!empty($listadoPokemones)) { //validamos si ya hay personajes creado
            $lastCharacter = $utilities->getLastElement($listadoPokemones); //Obtenemos el ultimo elemento del listado de heroe  
            $characterId =  $lastCharacter->id + 1; //como ya existen heroes el id del nuevo heroe debe ser el id el ultimo + 1
        }

        $entity->id = $characterId;
        $entity->profilePhoto = "";

        if ($_FILES['profilePhoto']) {

            $typeReplace = str_replace("image/", "", $_FILES["profilePhoto"]["type"]);
            $type =  $_FILES["profilePhoto"]["type"];
            $size =  $_FILES["profilePhoto"]["size"];
            $name = 'img/' . $characterId . '.' . $typeReplace;

            $sucess = $utilities->uploadImage("../Personajes/img", $name, $_FILES['profilePhoto']['tmp_name'], $type, $size);

            if ($sucess) {
                $entity->profilePhoto = $name;
            }
        }

        array_push($listadoPokemones, $entity); //Agregamos el personaje al listado de personajes

        setcookie("Pokemones", json_encode($listadoPokemones), $utilities->GetCookieTime(), "/");

    }

    public function Update($id, $entity)
    {        
        $utilities = new Utilities();
        $element = $this->GetById($id);
        $listadoPokemones = $this->GetList();

        $elementIndex = $utilities->getIndexElement($listadoPokemones, 'id', $id); //Obtenemos el indice del elemento en el array del listado de heroes que vamos a editar   

        if ($_FILES['profilePhoto']) {

            if ($_FILES['profilePhoto']['error'] == 4) {
                $entity->profilePhoto = $element->profilePhoto;
            } else {
                $typeReplace = str_replace("image/", "", $_FILES["profilePhoto"]["type"]);
                $type =  $_FILES["profilePhoto"]["type"];
                $size =  $_FILES["profilePhoto"]["size"];
                $name = 'img/' . $id . '.' . $typeReplace;

                $sucess = $utilities->uploadImage("../Personajes/img", $name, $_FILES['profilePhoto']['tmp_name'], $type, $size);

                if ($sucess) {
                    $entity->profilePhoto = $name;
                }
            }
        }

        $listadoPokemones[$elementIndex] =  $entity; //Actualizamos los datos del heroe en el listado de heroes utilizando el index obtenido del elemento

        setcookie("Pokemones", json_encode($listadoPokemones), $utilities->GetCookieTime(), "/");
    }

    public function Delete($id)
    {
        $utilities = new Utilities();
        $listadoPokemones = $this->GetList();
        //Obtenemos el listado actual de heroes almacenado en la session

        $elementIndex = $utilities->getIndexElement($listadoPokemones, 'id', $id); //Obtenemos el indice del elemento en el array del listado de heroes que vamos a editar       


        unset($listadoPokemones[$elementIndex]);

        $listadoPokemones = array_values($listadoPokemones);

        setcookie("Pokemones", json_encode($listadoPokemones), $utilities->GetCookieTime(), "/");
    }
}
