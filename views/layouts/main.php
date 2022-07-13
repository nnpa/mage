<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\models\Users;
use app\models\Chat;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
   <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
    <?php if(!is_null(\Yii::$app->user->identity)):?>

        <script type="text/javascript">
            $( document ).ready(function() {
                window.setInterval(function(){
                    $.get( "/chat/index/", function( data ) {
                        $( "#chat" ).html( data );
                    });
                }, 10000);

                $( "#send" ).click(function() {
                    var text = $("#message").val();
                    $.get( "/chat/send/?message=" + text, function( data ) {

                    });
                    $("#message").val("");
                });
            });
        </script>
    <?php endif;?>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <h1>Mage RPG</h1>
        <div style="margin:10px">
            <?php if(!is_null(\Yii::$app->user->identity)):?>
                <a href="/inventory/index" style="border-radius: 5px 5px 5px 5px;border:1px solid gray;padding: 5px;margin:5px;    text-decoration: none;">Инвъентарь</a>
                <a href="/shop/index" style="border-radius: 5px 5px 5px 5px;border:1px solid gray;padding: 5px;margin:5px;text-decoration: none;">Магазин</a>
                <a href="/battle/index" style="border-radius: 5px 5px 5px 5px;border:1px solid gray;padding: 5px;margin:5px;text-decoration: none;" >Поединки</a>
                <a href="/site/settings" style="border-radius: 5px 5px 5px 5px;border:1px solid gray;padding: 5px;margin:5px;text-decoration: none;">Настройки</a>
                <a href="/site/index" style="border-radius: 5px 5px 5px 5px;border:1px solid gray;padding: 5px;margin:5px;text-decoration: none;">Об игре</a>

                <a href="/site/logout" style="border-radius: 5px 5px 5px 5px;border:1px solid gray;padding: 5px;margin:5px;text-decoration: none;float:right">выход <?php echo \Yii::$app->user->identity->login;?></a>
            <?php endif;?>
        </div>
        
        <?= $content ?>
        <?php if(!is_null(\Yii::$app->user->identity)):?>

            <?php 
                $players = Users::find()->where(['>', 'active', time() ])->all();
                $chat = Chat::find()->where([])->orderBy('time')->all();
            ?>
            
            <div style="margin-top:30px;">
                <div style="float:left;width:100%;height: 25px;border: 1px solid black"><center><b>Чат</b></center></div>
                
                <div id="chat" style="overflow-x: hidden;overflow-y: auto;float:left;width:80%;height: 350px;border: 1px solid black;padding:10px">
                    <?php foreach($chat as $message):?>
                        <?php echo $message->text;?>
                    <?php endforeach;?>
                </div>
                <div style="overflow-x: hidden;overflow-y: auto;padding:10px;float:left;width:20%;height: 350px;border: 1px solid black" >
                    <center>Игроки</center>
                    <?php foreach ($players as $player):?>
                        <?php echo $player->login;?> [<?php echo $player->level;?>]
                        <a target="_blank" href="/inventory/info?id=<?php echo $player->id?>">
                            <img src="/img/info.jpg">
                        </a><br>
                    <?php endforeach;?>
                </div>
                <div style="float:left;width:100%;height: 30px;border: 1px solid black">
                    <input id="message" type="text" style="width:70%;height: 30px"><input id="send" style="height: 30px;width:10%"type="button"  value="Отправить">
                </div>
                <div style="float:left;padding: 10px">
                    <center><a href="https://vk.com/djdnkey" target="_blank" style="border-radius: 5px 5px 5px 5px;border:1px solid gray;padding: 5px;margin:5px;text-decoration: none;">Контакты</a></center>
                </div>
            </div>
        <?php endif;?>
        
    </div>

</main>

<footer class="footer mt-auto py-3 text-muted">
    
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
