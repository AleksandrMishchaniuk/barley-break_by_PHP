<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Пятнашки</title>
        <link href='https://fonts.googleapis.com/css?family=Underdog&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/styles.css"/>
        <script src="js/jquery-2.1.4.min.js"></script>
        <script src="js/scripts.js"></script>
    </head>
    <body>
                <?php
                    //заполнение массива $nuts числами
                    if(
                            !isset($_GET['nuts_json'])||
                            isset($_GET['new'])
                            ){
                        $nuts = [];
                        for($i=0; $i<16; $i++){
                            $nuts[] = $i+1;
                        }
                        shuffle($nuts);
                    }else{
                        $nuts = unserialize($_GET['nuts_json']);
                    }
                    
                    //определенее позиции пустой ячейки
                    $void = 0;
                    for($i=0; $i<count($nuts); $i++){
                        if($nuts[$i] === 16){
                            $void = $i;
                        }
                    }
                    
                    //передвижение фишки
                    if(isset($_GET['selected'])){
                        $sel = $_GET['selected'];
                        $tmp = $nuts[$sel];
                        $nuts[$sel] = $nuts[$void];
                        $nuts[$void] = $tmp;
                        $void = $sel;
                    }
                    //проверка на отсортерованность
                    $test_arr = $nuts;
                    sort($test_arr);
                    
//                    sort($nuts); //состояние победы для отладки стилей------------------------------------
                    
                    $is_sorted = true;
                    for($i=0; $i<count($nuts); $i++){
                        if($i===13 || $i===14){
                            continue;
                        }
                        if($test_arr[$i] !== $nuts[$i]){
                            $is_sorted = false;
                            break;
                        }
                    }
                    if($is_sorted){
                        echo "<div class='congratulation header'>!!! Поздравляю с победой !!!</div>";
                    }else{
                        echo "<div class='header'>Играй дальше</div>";
                    }
                ?>
        <form>
            <div id="wrap">
                <?php
                    //вывод массива $nuts (фишек) в форму
                    $nuts_html = '';
                    for($i=0; $i<count($nuts); $i++) {
                        //является ли фишка перетаскиваемой
                        $near = '';
                        $is_near = (($i===$void-1)&&($void%4!==0))||(($i===$void+1)&&(($void+1)%4!==0))||($i===$void-4)||($i===$void+4);
                        if($is_near){
                            $near = 'near';
                        }
                        //если массив отсортерован, то все фишки неперетаскиваемые
                        if($is_sorted){
                            $near = 'win';
                        }
                        //вывод фишки
                        if($nuts[$i] !== 16){
                            $nuts_html .= "<div class='nut $near' data-position=$i>$nuts[$i]</div>";
                        }else{
                            $nuts_html .= "<div class='void'></div>";
                        }
                    }
                    echo $nuts_html;
                    $nuts_json = serialize($nuts);
                ?>
            </div>
            <div id='panel'>
                <button type="submit" name="new" value="true">Новая игра</button>
            </div>
            <input type="hidden" name="nuts_json" value="<?php echo $nuts_json; ?>"/>
        </form>
    </body>
</html>