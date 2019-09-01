<?php 
require "bdd.php";
require "calendar.php";
require "functions.php";

session_start();

$day_date = getdate();
$calendar = new agenda($day_date);
$bdd = new bdd();


$_SESSION["count"] = ($_SESSION["count"]) ? $_SESSION["count"] : 0;

if(!empty($_POST)){
    $calendar->insert_day($_POST);
    if(empty($_POST["date"])){

        $control = $_POST["control"];

        if($control === '→' ){
            $_SESSION["count"]++;

        }
        if ($control === '←') {
            $_SESSION["count"]--;
        }
    }
}

$week = $calendar->calendar($_SESSION["count"]);
$year = "";
$value = "";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
    <body>
        <div class="site-content">
            <form action="" method="POST">
                <div class="calendar-container">
                    <div class="calendar is-animate">

                    <?php if(empty($_POST["date"])) : ?>

                        <?php foreach($week as $key => $value) : ?>

                            <?php $calendar->display_week($value); ?>

                            <?php $year = $value["year"];?>
                            <?php $week__N = $calendar->week_num($value["yday"]); ?>

                        <?php endforeach ?>

                    <?php else : ?>

                        <?php $calendar->display_day($week, $value) ?>

                        <?php $year = $week["year"];?>
                        <?php $week__N = ($calendar->week_num($week["yday"])) ? $calendar->week_num($week["yday"]) : 53 ?>

                    <?php endif ?>

                        <span class="year">Année  <?= $year ?></span>
                        <span class="weeks">Semaine  <?= $week__N ?></span>
                        <div class="buttons">
                            <input type="datetime" name="date" id="date" value="<?php if(!empty($_POST["date"])){echo $_POST["date"];} ?>">
                            <input name="control" type="submit" value="&larr;">
                            <input name="control" type="submit" value="&rarr;">
                        </div>
                    </div>
                </div>


                <div class="submit">
                    <input type="submit" value="Chercher un jour">
                    <input type="submit" value="Mettre à jour">
                </div>
            </form>
        </div>
        <script src="js/animation.js"></script>
    </body>
</html>