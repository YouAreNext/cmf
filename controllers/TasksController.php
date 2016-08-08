<?php

namespace app\controllers;

use Yii;
use app\models\Tasks;
use app\models\TasksSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;


/**
 * TasksController implements the CRUD actions for Tasks model.
 */
class TasksController extends BehaviorsController
{
    /**
     * @inheritdoc
     */

    

    /**
     * Lists all Tasks models.
     * @return mixed
     */
    public function actionIndex()
    {
        $userId = Yii::$app->user->identity['id'];
        $searchModel = new TasksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->andFilterWhere([
            'Status' => '1',
            'worker' => $userId,
        ]);

        $searchModel2 = new TasksSearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
        $dataProvider2->query->andFilterWhere([
            'Status' => '2',
            'worker' => $userId,
        ]);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
        ]);

    }


    public function actionCalendar()
    {

        if(Yii::$app->request->isAjax){
            debug(Yii::$app->request->post());
            return 'test';
        }


        $events = Tasks::find()->where(['Status'=>1])->all();

        $tasks = [];

        foreach ($events as $eve) {
            $event = new \yii2fullcalendar\models\Event();
            $event->id = $eve->id;
            $event->url = 'update?id='.$eve->id;
            $event->title = $eve->title;
            $event->start = date($eve->finish_date);
            $tasks[] = $event;
        }
        return $this->render('calendar', [
            'events' => $tasks,
        ]);
    }
    public function actionComplete()
    {
        $events = Tasks::find()->where(['Status'=>2])->all();
        $tasks = [];

        foreach ($events as $eve) {
            $event = new \yii2fullcalendar\models\Event();
            $event->id = $eve->id;

            $event->className = 'task-finished';
            $event->title = $eve->title;
            $event->start = date($eve->finish_date);
            $tasks[] = $event;
        }
        return $this->render('complete', [
            'events' => $tasks,
        ]);
    }
    public function actionTasker()
    {
        $userId = Yii::$app->user->identity['id'];

        $searchModel = new TasksSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['Status' => '1' ]);

        $searchModel2 = new TasksSearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
        $dataProvider2->query->andFilterWhere(['Status' => '2' ]);

        return $this->render('tasker', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    /**
     * Displays a single Tasks model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionPeriod($id)
    {
        $model = new Tasks();
        $model->periodic = 1;
        $model->created_at=date('Y-m-d');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/projects/update','id' => $id]);
        } else {
            return $this->renderAjax('period', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Creates a new Tasks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Tasks();
        $model->created_at=date('Y-m-d');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionAjax($date)
    {
        $model = new Tasks();
        $model->created_at=date('Y-m-d');
        $model->finish_date=$date;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['calendar']);
        } else {
            return $this->renderAjax('ajax', [
                'model' => $model,
            ]);
        }
    }

    public function actionChecklist(){

    }

    public function actionSub($date)
    {
        $model = new Tasks();
        $model->created_at=date('Y-m-d');
        $model->prev_task=$date;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['calendar']);
        } else {
            return $this->renderAjax('sub', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tasks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tasks model.
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
     * Finds the Tasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
