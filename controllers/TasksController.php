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
            'periodic' => 0
        ]);

        $searchModel2 = new TasksSearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
        $dataProvider2->query->andFilterWhere([
            'Status' => '2',
            'worker' => $userId,
            'periodic' => 0
        ]);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
        ]);

    }

//Все задачи
    public function actionCalendar()
    {

        if(Yii::$app->request->isAjax){
            debug(Yii::$app->request->post());
            return 'test';
        }

        $events = Tasks::find()->where([
            'Status'=>1,
             'periodic' => 0
        ])->all();

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
    //Мои задачи
    public function actionMycalendar()
    {
        $userId = Yii::$app->user->identity['id'];

        if(Yii::$app->request->isAjax){
            debug(Yii::$app->request->post());
            return 'test';
        }

        $events = Tasks::find()->where([

            'periodic' => 0,
            'worker' => $userId
        ])->all();

        $tasks = [];

        foreach ($events as $eve) {
            if ($eve->Status == 1){
                $TaskClass = '';
            } elseif($eve->Status == 2){
                $TaskClass = 'task-finished';
            }
            $event = new \yii2fullcalendar\models\Event();
            $event->id = $eve->id;
            $event->className = $TaskClass;
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
        $events = Tasks::find()->where([
            'Status'=>2,
             'periodic' => 0
        ])->all();
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
        $dataProvider->query->andFilterWhere([
            'Status' => '1',
            'periodic' => '0'
        ]);

        $searchModel2 = new TasksSearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);
        $dataProvider2->query->andFilterWhere([
            'Status' => '2',
             'periodic' => '0'
        ]);

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
        $model->project_id = $id;
        $model->created_at=date('Y-m-d');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/projects/update','id' => $id]);
        } else {
            return $this->renderAjax('period', [
                'model' => $model,
            ]);
        }
    }

    public function actionPeriodic(){




        $dataProvider = Tasks::find()->andFilterWhere([
            'periodic' => 1
        ]);


        $items = $dataProvider->all();
        $dateToday = strtotime(date('Y-m-d'));
        foreach ($items as $item) {
            $id = $item->id;
            $dateEven = strtotime($item->finish_date);
            $finalDate = date("Y-m-d",strtotime("+1 month",$dateEven));
            $date = Yii::$app->formatter->asDate($item->finish_date,'y-m-dd');
            if ($dateEven == $dateToday){
                echo $finalDate;
                echo 'равно';
                echo $dateEven;
                $model = $this->findModel($id);
                $model->finish_date = $finalDate;
                $model->save();

                $title = $model->title;
                $description = $model->description;
                $worker = $model->worker;
                $project_id = $model->project_id;
                $finish_date = $model->finish_date;


                $model = new Tasks();

                $model->title = $title;
                $model->description = $description;
                $model->worker = $worker;
                $model->Status = '1';
                $model->finish_date = $finish_date;
                $model->project_id = $project_id;
                $model->created_at = (date('Y-m-d'));
                $model->save();

            }else{
                echo 'неравно';
            }

            echo '<br>';
        }



        {
            return $this->renderAjax('periodic', [
                'dataProvider1' => $dataProvider,

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
