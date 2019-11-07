<?php
//incluimos los archivos php que estaremos utilizando

require_once '../layout/layout.php';
require_once '../helpers/utilities.php';
require_once '../helpers/FileHandler/IFileHandler.php';
require_once '../helpers/FileHandler/SerializationFileHandler.php';
require_once '../helpers/FileHandler/JsonFileHandler.php';
require_once 'Pokemon.php';
require_once '../services\IServiceBase.php';
require_once 'CharacterService.php';
require_once '../Races/RaceService.php';
require_once '../Region/RegionService.php';

$layout = new Layout(true);
$utilities = new Utilities();
$service = new CharacterService();
$raceService = new RaceService();
$regionService = new RegionService();


//Validamos si existen valores en la variable de $_POST 
if (isset($_POST['name']) && isset($_POST['characterType1']) && isset($_POST['regionId']) && isset($_POST['poderes'])) {

    $poderes = explode(",", $_POST['poderes']);
    $tipoTexto= $_POST['characterType1'] . "," . $_POST['characterType2'];
    $tipo= explode(",", $tipoTexto);
    $newPokemon = new Pokemon();

    $newPokemon->InitializeData(0, $_POST['name'], $tipo , $_POST['regionId'], $poderes);

    $service->Add($newPokemon);

    header("Location: ../index.php"); //enviamos a la pagina principal del website
    exit(); //esto detiene la ejecucion del php para que se realice el redireccionamiento
}

?>

<?php $layout->printHeader(); ?>

<main role="main">

    <div style="margin-top: 10%;margin-bottom: 5%;" class="card">
        <div class="card-header text-white bg-primary">
            Registra un nuevo Pokemon
        </div>
        <div class="card-body">


            <form method="POST" action="add.php" enctype="multipart/form-data">

                <div class="col-md-4">
                    <div class="form-group">

                        <label for="InputName">Nombre</label>
                        <input type="text" name="name" class="form-control" id="InputName" placeholder="Introduzca el nombre ">

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label > Tipo de Pokemon </label><br>   
                       <label  for="characterTypeInput1" >Tipo 1:</Label> <select name="characterType1" class="form-control" id="characterTypeInput1">
                        <?php foreach ($raceService->GetList() as $race) : ?>
                            <option value="<?php echo $race->id ?>"><?php echo $race->name ?></option> 
                            <?php endforeach; ?>

                        </select>
                        <label  for="characterTypeInput2" >Tipo 2:</Label>
                        <select name="characterType2" class="form-control" id="characterTypeInput2">

                        <?php foreach ($raceService->GetList() as $race) : ?>
                                <option value="<?php echo $race->id ?>"><?php echo $race->name ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="regionInput"> Region </label>

                        <select name="regionId" class="form-control" id="regionInput">

                            <?php foreach ($regionService->GetList() as $region) : ?>
                                <option value="<?php echo $region->id ?>"><?php echo $region->name ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">

                        <label for="Inputpoderes">Poderes</label>
                        <textarea name="poderes" class="form-control" id="Inputpoderes" aria-describedby="poderesHelp" placeholder="Introduzca los poderes "> </textarea>
                        <small id="poderesHelp" class="form-text text-muted">Colocar poderes separados por comas</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="characterPhoto">Foto del Pokemon</label>
                        <input type="file" name="profilePhoto" class="form-control-file" id="characterPhoto">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa fa-plus-square"></i> Crear</button>
            </form>

        </div>
    </div>

</main>

<?php $layout->printFooter(); ?>