<?php

namespace app\controllers;


use Yii;
use app\models\RegForm;
use app\models\LoginForm;
use app\models\User;
use app\models\Profile;
use app\models\ProjectList;
use app\models\Tasks;
use yii\web\UploadedFile;
use yii\imagine\Image;


class MainController extends BehaviorsController{
    public $layout = 'basic';
    public $defaultAction = 'index';



    public function actionPew()

    {

        return $this->render('pew',
            [

            ]
        );
    }


    public function actionIndex()

    {

        return $this->render('index',
        [

        ]
        );
    }
    public function actionTasks()

    {

        return $this->render('tasks',

            [

            ]
        );
    }

    public function actionChart(){
        return $this->render('chart');
    }

    public function actionProjects(){
        $arrayFck = ProjectList::getAll();
        return $this->render('Projects',
            [
                'arrayFck'=> $arrayFck,
            ]
        );
    }
    public function actionProject($id){
        $one = ProjectList::getOne($id);
        return $this->render('/main/Project',
            [
                'one'=> $one
            ]
            );
    }
    public function actionProfile(){
        $model = ($model = Profile::findOne(Yii::$app->user->id)) ? $model : new Profile();

        if($model->load(Yii::$app->request->post()) && $model->validate()):

            $imageName = User::find()->where(['id'=>$model->user_id])->one()->username;
            $Avatar = $model->avatar = UploadedFile::getInstance($model, 'avatar');
            if($Avatar){
                $model->avatar->saveAs('web/uploads/avatars/'.$imageName.'-avatar.'.$model->avatar->extension);
                $model->ava_url = 'web/uploads/avatars/'.$imageName.'-avatar.'.$model->avatar->extension;
            }
            if($model->updateProfile()):
                Yii::$app->session->setFlash('succes','Профиль изменен');

            else:
                Yii::$app->session->setFlash('error','Профиль не изменен');
                Yii::error('Ошибка записи. Профиль не изменен');
                return $this->refresh();
            endif;
        endif;
        return $this->render(
            'profile',
            [
                'model' => $model
            ]
        );
    }
    public function actionReg(){

        $model = new RegForm();

        if($model->load(Yii::$app->request->post()) && $model->validate()):
            if($user = $model->reg()):
                if($user->status === User::STATUS_ACTIVE):
                    if(Yii::$app->getUser()->login($user)):
                        return $this->goHome();
                    endif;
                endif;
            else:
                Yii::$app->session->setFlash('error','Возникла ошибка');
                Yii::error('Ошибка при регистрации');
                return $this->refresh();
            endif;
        endif;
        return $this->render(
            'reg',
            [
                'model' => $model
            ]
        );
    }
    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->redirect('/main/index');
    }
    public function actionLogin(){
        if(!Yii::$app->user->isGuest):
            return $this->goHome();
        endif;
        $model = new LoginForm();

        if($model->load(Yii::$app->request->post()) && $model->login()):
            return $this->goBack();
        endif;

        return $this->render(
            'login',
            [
                'model' => $model
            ]
        );
    }

    public function actionEdit($id){
        $one = ProjectList::getOne($id);

        if($_POST['ProjectList']){
            $one->attributes = $_POST['ProjectList'];
            if($one->validate() && $one->save()){
                return $this->redirect(['main/projects']);
            }
        }

        return $this->render('Edit',['one'=>$one]);

    }
    public function actionCreate(){
        $model = new ProjectList();
        if($_POST['ProjectList']){

            $model->attributes = $_POST['ProjectList'];
            if($model->validate() && $model->save()){
                return $this->redirect(['main/projects']);
            }
        }

        return $this->render('Create',['model'=>$model]);

    }

}
