<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Users;
use app\models\Exp;
use app\controllers\GameController;

class SiteController extends GameController
{
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','index','settings'],
                'rules' => [
                    [
                        'actions' => ['logout','index','settings'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $exps = Exp::find()->where([])->all();
        return $this->render('index',["exps" => $exps]);
        
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }


    
    public function actionMail(){
        var_dump(\Yii::$app->user->identity);

        /**
        $to      = 'jetananas@yandex.ru';
        $subject = 'the subject';
        $message = 'hello';
        $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
         * 
         * @return type
         */
    }
    
    
    public function actionRegister(){
       $this->enableCsrfValidation = false;

       $login = "";
       $password = "";
       $password2 = "";
       $email = "";
       $errors = [];
       
       if(isset($_POST["login"])     && !empty($_POST["login"]) &&
          isset($_POST["password"])  && !empty($_POST["password"]) &&
          isset($_POST["password2"]) && !empty($_POST["password2"]) &&
          isset($_POST["email"])     && !empty($_POST["email"])){

      
            $email     = $_POST["email"];
            $login     = $_POST["login"];
            $password  = $_POST["password"];
            $password2 = $_POST["password2"];
            
            $countLogin = Users::find()->where(['login' => $login])->count();
            
            if($countLogin > 0){
                $errors[] = "Такой логин уже существует";
            }
            
            $countEmail= Users::find()->where(['email' => $email])->count();
            
            if($countEmail > 0){
                $errors[] = "Такой email уже существует";
            }
            
            if(strlen($password) < 3){
                $errors[] = "Пароль меньше 3 символов";

            }
            
            if($password != $password2){
                $errors[] = "Пароли не совпадают";

            }
            
            if(count($errors) == 0){
                $user = new Users();
                $user->level = 1;
                
                $user->confirmed = 0;
                $user->confirm_code = md5(time());
                
                $user->reset_code = "";
                $user->win = 0;
                $user->lose = 0;
                $user->exp = 0;
                $user->gold = 450;
                
                $user->strength = 5;
                $user->intuition = 5;
                $user->dexterity = 5;
                $user->endurance = 5;
                
                $user->intelligence = 0;
                $user->mental = 0;

                $user->fire = 0;
                $user->woter = 0;
                $user->earth = 0;
                $user->air = 0;

                $user->stats = 50;

                $user->login = $login;
                $user->password = $password;
                $user->email = $email;
                
                $user->hp_regen_time = -1;
                $user->mp_regen_time = -1;
                
                $user->hp = $user->endurance * 5;
                $user->mp = $user->mental * 5;

                $user->battle_id = 0;
                $user->authKey = "";
                
                $user->helm = 0;
                $user->weapon = 0;
                $user->armor = 0;
                $user->belt = 0;
                $user->earrings = 0;
                $user->necklace = 0;
                $user->ring1 = 0;
                $user->ring2 = 0;
                $user->ring3 = 0;
                $user->shild = 0;
                $user->leggings = 0;
                $user->boots = 0;
                $user->belt = 0;
                $user->defence = 0;
                $user->damage = 0;
                $user->active = 0;
                $user->text = 0;

                $user->save(false);
                
                $to      = $email;
                $subject = 'Activation code';

                $message = '<a href="http://'. Yii::$app->params['url'].'/site/activation?code='.$user->confirm_code .'">Activate</a>';
                $headers = 'From: webmaster@'. Yii::$app->params['url'].'' . "\r\n" .
                'Reply-To: webmaster@example.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
                
                $headers .= 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                

                mail($to, $subject, $message, $headers);
                
                return $this->render('message',[
                    "message" => "На вашу почту отправлен код активации проверьте папку спам"
                ]);
                
                exit;
            }
        }
       
       return $this->render('register',[
           "email" => $email,
           "login" => $login,
           "errors" => $errors
       ]);
    }
    
    public function actionActivation(){
        if(isset($_GET['code']) && !empty($_GET['code'])){
            $activation = $_GET['code'];
            $user = Users::find()->where(['confirm_code' => $activation])->one();
            
            if(!is_null($user)){
                $user->confirmed = 1;
                $user->save(false);
                return $this->render('message',[
                    "message" => "Ва аккаунт активирован можете <a href='/site/login' > авторизоваться</a>"
                ]);
                exit;
            }
        }
    }
    
    public function actionReset(){
        if(isset($_POST['email']) && !empty($_POST['email'])){
            $email = $_POST['email'];
            $code = md5(time());
            $user = Users::find()->where(['email' => $email])->one();
            
            if(!is_null($user)){
                $user->reset_code = $code;
                $user->save(false);
                
                $to      = $email;
                $subject = 'Reset code';
                
                $message = '<a href="http://'. Yii::$app->params['url'].'/site/reset2?code='.$code .'">Reset</a>';
                $headers = 'From: webmaster@'. Yii::$app->params['url'].'' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
                
                $headers .= 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                

                mail($to, $subject, $message, $headers);
                return $this->render('message',[
                    "message" => "На почту выслана ссылка для сброса пароля"
                ]);
                exit;
            }

        }
        return $this->render('reset');
    }
    
    public function actionReset2(){
        $errors = [];
        if(isset($_GET['code']) && !empty($_GET['code'])){
            $code = $_GET["code"];
            $user = Users::find()->where(['reset_code' => $code])->one();
            
            if(!is_null($user)){
                if(isset($_POST['password']) && !empty($_POST['password']) &&
                   isset($_POST['password2']) && !empty($_POST['password2'])     ){
                   $password = $_POST['password'];
                   $password2 = $_POST['password2'];
                   
                   if($password != $password2){
                       $errors[] = "Пароли не совпадают";
                   }
                   
                   if(strlen($password) < 3){
                        $errors[] = "Пароль меньше 3 символов";

                   }
                   
                   if(count($errors) == 0 ){
                       $user->password = $password;
                       $user->reset_code = md5(time());
                       $user->save(false);
                       return $this->render('message',[
                            "message" => "Пароль успешно изменен"
                       ]);   
                       
                       exit;
                   }
                   
                   
                }
            }
            
            return $this->render('reset2',["errors" => $errors]);
            
        }
    }
    
    public function actionSettings(){
            $user = Users::find()->where(['id' => \Yii::$app->user->identity->id])->one();

        $errors = [];
        if(isset($_POST['password']) && !empty($_POST['password']) &&
           isset($_POST['password2']) && !empty($_POST['password2']) ){
            $password  = $_POST['password'];
            $password2 = $_POST['password2'];
            
            
            if($password != $password2){
                $errors[] = "Пароли не совпадают";
            }
                   
            if(strlen($password) < 3){
                 $errors[] = "Пароль меньше 3 символов";

            }
            
            if(count($errors) == 0 ){
                $user->password = $password;
                $user->save(false);
            }
            
            return $this->render('message',[
                 "message" => "Пароль успешно изменен"
            ]);   

            exit;
        }
        
        if(isset($_POST["text"]) && !empty($_POST["text"])){
            $text = $_POST["text"];
            $user->text = $text;
            $user->save(false);
        }
        
        return $this->render('settings',["errors" => $errors,"user" => $user]);
    }
    
}
