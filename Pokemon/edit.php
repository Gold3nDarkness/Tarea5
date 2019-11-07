<?php
//incluimos los archivos php que estaremos utilizando
require_once '../layout/layout.php';
require_once '../helpers/utilities.php';
require_once 'Pokemon.php';
require_once '../helpers/FileHandler/IFileHandler.php';
require_once '../helpers/FileHandler/SerializationFileHandler.php';
require_once '../helpers/FileHandler/JsonFileHandler.php';
require_once '../services\IServiceBase.php';
require_once 'CharacterService.php';
require_once '../Races/RaceService.php';
require_once '../Region/RegionService.php';


$layout = new Layout(true);
$utilities = new Utilities();
$service = new CharacterService();
$tipoService = new RaceService();
$regionService = new RegionService();


$containId = isset($_GET['id']); //validamos si hay un parametro id en el query string de la url
$characterId = 0;

$element = [];

if ($containId) {
    $characterId = $_GET['id']; //El Id del Pokemon que vamos a editar
    $element = $service->GetById($characterId);
}

if (isset($_POST['name']) && isset($_POST['characterType1']) && isset($_POST['characterType2']) && isset($_POST['regionId']) && isset($_POST['poderes'])) { //aqui verificamos si estamos recibiendo valores por $_POST para editar los valores del elemento en el listado de heroes de la session 

    $poderes = explode(",", $_POST['poderes']);
    $tipoTexto= $_POST['characterType1'] . "," . $_POST['characterType2'];
    $tipo= explode(",", $tipoTexto);
    $updateCharacter = new Pokemon();
    $updateCharacter->InitializeData($characterId, $_POST['name'], $tipo , $_POST['regionId'], $poderes);

    $service->Update($characterId, $updateCharacter);
   

    header("Location: ../index.php"); //enviamos a la pagina principal del website
    exit(); //esto detiene la ejecucion del php para que se realice el redireccionamiento
}
?>


<?php $layout->printHeader(); ?>

<main role="main">

    <?php if ($containId && $element != null) : ?>

        <div style="margin-top: 5%" class="card">
            <div class="card-header bg-warning text-white">
                <strong> Editando al Pokemon <?php echo $element->name ?></strong>
            </div>
            <div class="card-body">

                <form method="POST" enctype="multipart/form-data" action="edit.php?id=<?php echo $element->id ?>">

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="InputName">Nombre</label>
                            <input type="text" name="name" value="<?php echo $element->name ?>" class="form-control" id="InputName" placeholder="Introduzca el nombre ">

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="characterTypeInput"> Tipo de Pokemon </label><br>
                            <label for="characterTypeInput1"> Tipo 1: </label>

                            <select name="characterType1" class="form-control" id="characterTypeInput1">

                                <?php foreach ($tipoService->GetList() as $tipo) : ?>

                                    <?php if ($tipo->id == $element->characterTypeId[0]) : ?>
                                        <option selected value="<?php echo $tipo->id; ?>"><?php echo $tipo->name; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $tipo->id; ?>"><?php echo $tipo->name; ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>

                            </select>
                            <label for="characterTypeInput2"> Tipo 2: </label>

                            <select name="characterType2" class="form-control" id="characterTypeInput2">

                                <?php foreach ($tipoService->GetList() as $tipo) : ?>

                                    <?php if ($tipo->id == $element->characterTypeId[1]) : ?>
                                        <option selected value="<?php echo $tipo->id; ?>"><?php echo $tipo->name; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $tipo->id; ?>"><?php echo $tipo->name; ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="RegionInput"> Region </label>
                       
                            <select name="regionId" class="form-control" id="RegionInput">

                                <?php foreach ($regionService->GetList() as $region) : ?>

                                    <?php if ($region->id == $element->regionId) : ?>
                                        <option selected value="<?php echo $region->id ?>"><?php echo $region->name ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $region->id ?>"><?php echo $region->name ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="Inputpoderes">Poderes</label>
                            <textarea name="poderes" class="form-control" id="Inputpoderes" aria-describedby="poderesHelp" placeholder="Introduzca las Poderes "><?php echo $element->getEditablepoderes() ?> </textarea>
                            <small id="poderesHelp" class="form-text text-muted">Colocar poderes separados por comas</small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="characterPhoto">Foto del Pokemon</label>
                            <input type="file" name="profilePhoto" class="form-control-file" id="characterPhoto">

                            <div style="margin-top: 1%" class="card bg-dark" style="width: 18rem;">
                                <img class="bd-placeholder-img card-img-top" src="<?php echo $element->profilePhoto; ?>" width="225" height="225" alt="">
                            </div>


                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                </form>

            </div>
        </div>

    <?php else : ?>

        <h2>No existe</h2>

    <?php endif; ?>

</main>

<?php $layout->printFooter(); ?>