<?php

namespace app\controllers;

use app\models\Files;
use Yii;
use app\models\Projects;
use app\models\ProjectsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
/**
 * ProjectsController implements the CRUD actions for Projects model.
 */
class ProjectsController extends BehaviorsController
{
    /**
     * @inheritdoc
     */
    

    /**
     * Lists all Projects models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Projects model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Projects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Projects();

        $dataProviderFile = \app\models\Files::find()->andFilterWhere([
            'parent_id' => $model->id,
            'parent_type' => 0
        ]);

        $dataFile = new ActiveDataProvider([
            'query' => $dataProviderFile,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/projects']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'dataFile'=>$dataFile
            ]);
        }
    }


    public function actionUpload(){
        $model = new Files();






        if (Yii::$app->request->isPost) {
            $parentID = Yii::$app->request->get('id');
            $parentType = Yii::$app->request->get('parent');
            $file = UploadedFile::getInstanceByName('file');




            //Заполняю табличку
            $model->parent_type = $parentType;
            $model->parent_id = $parentID;
            $model->file_name = $file->name;

            $model->extension = $file->getExtension();

            //Загружаю файл на сервер
            if($model->parent_type == 0){
                $directory = 'web/uploads/'.'projects/'.$model->parent_id.'/';
            } else if($model->parent_type == 1){
                $directory = 'web/uploads/'.'tasks/'.$model->parent_id.'/';
            }

            $model->url = $directory.$file->name;

            //Если нет папки, создаем
            if (!is_dir($directory)) {
                mkdir($directory);
            }

            //Сохраняем файл по пути
            $file->saveAs($directory.$file->name);

            if($model->save()){
                return '{}';
            }
            else{
                return 'gg';
            }
        }

    }

    /**
     * Updates an existing Projects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $fileModel = new Files();


        $dataProviderFile = \app\models\Files::find()->andFilterWhere([
            'parent_id' => $model->id,
            'parent_type' => 0
        ]);

        $dataFile = new ActiveDataProvider([
            'query' => $dataProviderFile,
        ]);



        if(Yii::$app->request->isAjax){
            $getChecklist = Yii::$app->request->get('checklist');
            $getCheck = Yii::$app->request->get('check');
            if($getChecklist == 1) {
                 if (Yii::$app->request->get()) {
                    $checklist = $model->checklist;
                    return $checklist;
                }
//            return json_encode(Yii::$app->request->post());
            }
            if($getCheck == 1){
                if (Yii::$app->request->post()) {
                    $checklist = json_encode(Yii::$app->request->post());
                    $model->checklist = $checklist;
                    $model->save();
                    Yii::$app->response->format = 'json';
                    return $checklist;
                }
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/projects']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'FileModel' =>$fileModel,
                'dataFile' =>$dataFile
            ]);
        }
    }

    /**
     * Deletes an existing Projects model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Projects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Projects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Projects::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
