<?php
/**
 * Created by PhpStorm.
 * User: YouNext
 * Date: 28.04.2016
 * Time: 16:34
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class BehaviorsController extends Controller{
    public function behaviors()
    {
        return [
            'access' =>[
                'class' => AccessControl::className(),
                /*'denyCallback' => function($rule,$action){
                    throw new \Exception('Нет доступа.');
                },*/

                'rules' =>  [
                    [
                        'allow' => true,
                        'controllers' => ['main'],
                        'actions' => ['reg', 'login'],
                        'verbs' => ['GET','POST'],
                        'roles' => ['?']
                    ],


                    [
                        'allow' => true,
                        'controllers' => ['main'],
                        'actions' => ['profile'],
                        'verbs' => ['GET','POST'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['main'],
                        'actions' => ['tasks','projects','project','create','edit','pew','tasker'],
                        'verbs' => ['GET','POST'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['main'],
                        'actions' => ['tasks','projects','project','create','edit','pew','tasker','chart'],
                        'verbs' => ['GET','POST'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['main'],
                        'actions' => ['logout'],
                        'verbs' => ['POST'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['main'],
                        'actions' => ['index']
                    ],

                    [
                        'allow' => true,
                        'controllers' => ['tasks'],
                        'verbs' => ['GET','POST'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['projects'],

                        'verbs' => ['GET','POST'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['tasks'],
                        'actions' => ['periodic'],
                        'verbs' => ['GET','POST'],
                        'roles' => ['?']
                    ],
                ]
            ]
        ];
    }
}