<?php 


class agenda extends bdd {

    const DAY = [
        "Monday" => "Lundi",
        "Tuesday" => "Mardi",
        "Wednesday" => "Mercredi",
        "Thursday" => "Jeudi",
        "Friday" => "Vendredi",
        "Saturday" => "Samedi", 
        "Sunday" => "Dimanche"
    ];
    const MONTH = [
        "January" => "Janvier",
        "February" => "février",
        "March" => "Mars",
        "April" => "Avril",
        "May" => "Mai",
        "June" => "Juin",
        "July" => "Juillet",
        "August" => "Août",
        "September" => "Septembre",
        "October" => "Octobre",
        "November" => "Novembre",
        "December" => "Décembre"
    ];

    const SECONDES_PERS_DAY = 86400;
    const SECONDES_PERS_WEEK = self::SECONDES_PERS_DAY * 7;

    private $date__now;

    public function __construct($date__now){
        $this->date__now = $date__now;
    }

    public function week_num($week){
        $a = (int) round($week / 7, 0, PHP_ROUND_HALF_UP);
        return $a;
    }

    public function calendar($count){

        if(empty($_POST["date"])){

            $week = $this->next_week($count);

        } else {

            $week = $this->get_day($_POST["date"]);

        }
        return $week;
    }

    public function translate($tab, $element){

        foreach($tab as $key => $value){

            if($element === $key){
                
                $element = $value;
            }
        }
        return $element;
    }

    public function focuse($day){

        if(empty($_POST["date"])){
            if($day["yday"] === getdate()["yday"] AND $day["year"] === getdate()["year"]){
                return "autofocus='focused'";
            }
        } else {
            return "autofocus='focused'";
        }
    }

    public function display_week($value){
        ?>
        <div id="day" class="<?= $value["weekday"] ?>">

                <?= $this->translate(self::DAY, $value["weekday"]) ?>
                <?= $value["mday"] ?>
                <?= $this->translate(self::MONTH, $value["month"]) ?>
                <?php if($value["weekday"] !== "Sunday") : ?>
                    <div id="sections" class="morning">
                        <textarea name="morning_<?= $value["yday"] ?>" id="morning" cols="10" rows="10" <?php if(getdate()["hours"] < 12) {echo $this->focuse($value);} ?>></textarea>
                    </div>
                    <div id="sections" class="afternoon">
                        <textarea name="afternoon_<?= $value["yday"] ?>" id="afternoon" cols="10" rows="10" <?php if(getdate()["hours"] >= 12) {echo $this->focuse($value);} ?>></textarea>
                    </div>
                <?php endif ?>
                    <input type="hidden" name="year" value="<?= $value["year"] ?>">
            </div><?php
}

    public function display_day($week, $value){
        ?>
            <div class="day">
                <div class="day-container">
                    <?= $this->translate(self::DAY, $week["weekday"]) ?>
                    <?= $week["mday"] ?>
                    <?= $this->translate(self::MONTH, $week["month"]) ?>

                    <div id="sections" class="morning">
                                                <textarea name="morning_<?= $week["yday"] ?>" id="morning" cols="10" rows="10" <?php if(getdate()["hours"] < 12) {
                                                    echo $this->focuse($value);} ?>></textarea>
                    </div>
                    <div id="sections" class="afternoon">
                        <textarea name="afternoon_<?= $week["yday"] ?>" id="afternoon" cols="10" rows="10" <?php if(getdate()["hours"] >= 12) {echo $this->focuse($value);} ?>></textarea>
                    </div>
                    <input type="hidden" name="year" value="<?= $week["year"] ?>">
                </div>
            </div>
        <?php

    }

    public function insert_day($post){

        $post = new ArrayObject($post);
        $post->ksort();
        $tab_req = [];

        foreach ($post as $key => $value){
            if(!empty($value)){
                if($key !== "year"){
                    $a = explode("_", $key);
                    $tab_req []= $value;
                    foreach($a as $values){
                        $tab_req []= $values;
                    }
                } else {
                    $tab_req []= $value;
                }
            }
        }
        dd($tab_req);

        $pdo = $this->get_pdo();

        $req = $pdo->prepare("SELECT FROM base WHERE ");
    }

//---------------------------------------------------


    private function get_date_now(){
        return $this->date__now;
    }

    private function get_day($date){
        $a = explode("/", $date);
        
        return getdate(mktime(0, 0, 0, (int) $a[1], (int) $a[0], (int) $a[2]));
    }

    private function make__week(){
        $t = [];

        $t_d = $this->remote_monday()[0];
        $a =  $t_d + self::SECONDES_PERS_WEEK;

        while ($t_d < $a){
            $t []= getdate($t_d);
            $t_d += self::SECONDES_PERS_DAY;
        }
        return $t;
    }

    private function next_week($count){

        $t = [];
        $time = $this->make__week()[0][0];

        $t_d = $time + ((self::SECONDES_PERS_WEEK * $count));

        $a =  $t_d + self::SECONDES_PERS_WEEK;
       
        while ($t_d < $a){
            $t []= getdate($t_d);
            $t_d += self::SECONDES_PERS_DAY;
        }
        return $t;
    }

    private function timestamp(){
        return $this->get_date_now()[0];
    }

    private function remote_monday(){

        $d = NULL;
        $remote = self::SECONDES_PERS_DAY;
        $time = $this->timestamp();

        while(true){
            $d = getdate($time);
            if($d["weekday"] === "Monday"){
                break;
            }
            $time -= $remote;
        }
        return $d;
    }

}