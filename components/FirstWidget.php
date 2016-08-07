<?php
namespace app\components;

use yii\base\Widget;

class FirstWidget extends Widget{

    public $a;
    public $b;


    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        if($this->a === null){
            $this->a = 0;
        }
        if($this->b === null){
            $this->b = 0;
        }
    }
    public function run(){
       $c = $this->a + $this->b;

        return $this->render(
            'first',
            [
                'c' => $c
            ]
        );
    }
}