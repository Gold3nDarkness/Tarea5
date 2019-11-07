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
require_once '../Races/race.php';
require_once '../Races/RaceService.php';
require_once '../Region/Region.php';
require_once '../Region/RegionService.php';

$layout = new Layout(true);
$utilities = new Utilities();
$service = new CharacterService();
$RaceService = new RaceService();
$RegionService= new RegionService();


$containId = isset($_GET['id']); //validamos si hay un parametro id en el query string de la url
$characterId = 0;
$element = null;

if ($containId) {
    $characterId = $_GET['id']; //El Id del Pokemon que vamos a editar
    $element = $service->GetById($characterId);
}

?>


<?php $layout->printHeader(); ?>

<main role="main">

    <?php if ($containId && $element != null) : ?>
        <div class="row">

            <div class="col-md-1">
                &nbsp;
            </div>

            <div style="margin-top: 5%;" class="col-md-7">
                <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="card" style="width: 18rem;">

                        <h3 class="mb-0"><?php echo $element->name; ?></h3>
                        <ul class="list-group list-group-flush">
                        <li class="list-group-item bg-dark text-white">Tipo de Pokemon</li>
                                <?php foreach($element->characterTypeId as $tipo):?> 
                                        <li class="list-group-item"><?php echo  $RaceService->GetById($tipo)->name;?></li>
                                <?php endforeach;?>
                                </ul>
                                <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-dark text-white">Region</li>
                            <li class="list-group-item"><?php echo $RegionService->GetById($element->regionId)->name;?></li>

                        <div style="margin-top: 2%;" class="" style="width: 18rem;">
                            <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-dark text-white">Poderes</li>
                                    <?php $contador = 0;?>
                                   <?php foreach($element->poderes as $poderes):?> 
                                        <?php $contador++?>
                                        <li class="list-group-item"><?php echo $poderes;?></li>
                                        <?php if($contador == 4)break;?>
                                <?php endforeach;?>
                                
                            </ul>
                        </div>

                    </div>  
                    <div class="col-md-4 d-none d-lg-block">
                        <img src="<?php echo $element->profilePhoto; ?>"width="100%" height="225px" alt="">
                    </div>
                </div>
            </div>


        </div>

    <?php else : ?>

        <div style="margin-top: 5%;" class="row mb-2">
            <div class="col-md-6">
                <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">

                        <h2 class="mb-0">No existe</h2>

                    </div>
                </div>
            </div>

        </div>

    <?php endif; ?>

</main>

<?php $layout->printFooter(); ?>