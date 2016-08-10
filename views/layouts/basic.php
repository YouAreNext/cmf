<?php
use app\assets\AppAsset;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
$this->beginPage();
$userIdTask = Yii::$app->user->identity['id'];
$MyTaskCount = \app\models\Tasks::find()->where([
    'Status' => 1,
    'worker'=> $userIdTask
    ])
    ->count();
?>
<!-- @var $content string -->
<!--@var $this \yii\web\View -->
<!doctype html>
<html lang="<?= yii::$app->language ?>">
<head>
    <link href='https://fonts.googleapis.com/css?family=Cuprum:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700&subset=cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,500,300,700&subset=cyrillic,cyrillic-ext' rel='stylesheet' type='text/css'>
    <meta charset="UTF-8">
    <title><?= yii::$app->name ?></title>
    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>
</head>
<body>
<div class="side-panel">
    <a href="/main/profile" class="side-panel-item side-panel-profile"></a>
    <a href="/tasks" class="side-panel-item side-panel-list"></a>
    <div class="side-panel-item side-panel-calendar-popup for-popup-side">
        <div class="popup-side">
            <a href="/tasks/mycalendar" class="side-panel-item side-panel-mycalendar">
                <span class="task-count"><?=$MyTaskCount?></span>
                Мои задачи
            </a>
            <a href="#" class="side-panel-item side-panel-oncheck">Задачи на проверке</a>
            <a href="/tasks/calendar" class="side-panel-item side-panel-calendar">Все задачи</a>
            <a href="/tasks/complete" class="side-panel-item side-panel-complete">Выполненные задачи</a>

        </div>
    </div>


</div>
<?php $this->beginBody(); ?>
    <div class="wrap">
        <?php

            NavBar::begin(
                [
                    'brandLabel' => 'LastHope',
                ]
            );

            if (YII::$app->user->isGuest):

            $menuItems = [];
            
            else:
            $menuItems = [

                [
                    'label' => 'SEO проекты',
                    'url' => ['/projects']
                ],
                [
                    'label' => 'Мои задачи',
                    'url' => ['/tasks/index']
                ],
                [
                    'label' => 'Задачи',
                    'url' => ['/tasks/tasker']
                ],
                [
                    'label' => 'Контрагенты',
                    'url' => ['/contractors']
                ],


                [
                    'label' => 'Профиль',
                    'url' => ['/main/profile']
                ],


            ];
            endif;
            if (Yii::$app->user->isGuest):
                $menuItems[] = [
                    'label' => 'Регистрация',
                    'url' =>['/main/reg']
                ];
                $menuItems[] = [
                    'label' => 'Войти',
                    'url' =>['/main/login']
                ];
            else:
                $menuItems[] = [
                    'label' => 'Выйти ('.Yii::$app->user->identity['username'].')',
                    'url' => ['/main/logout'],
                    'linkOptions' =>[
                        'data-method' => 'post'
                    ]
                ];
            endif;

            echo Nav::widget([
                'items' => $menuItems,
                'encodeLabels' => false,
                'options' => [
                    'class' => 'navbar-nav navbar-right'
                ]
            ]);

            Modal::begin([
                'header' => '<h2>Клац!</h2>',
                'id' => 'modal'
            ]);
            Modal::end();
            NavBar::end();

        ?>

        <div class="container">
            <?php
                echo Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);
            ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <span class="badge">
                <span class="glyphicon glyphicon-copyright-mark">
                IT-INVEST <?= date('Y')?>
                </span>
            </span>
        </div>
    </footer>
<?php $this->endBody(); ?>
</body>

</html>

<?php
    $this->endPage();
?>