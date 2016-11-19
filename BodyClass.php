<?php

namespace promo\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class BodyClass extends Widget
{
    private $addClass = [
        'no_js'
    ];

    private $controller;

    private $module;

    public function init()
    {
        $this->controller = \Yii::$app->controller;
        if ( YII_ENV_DEV ) {
            $this->controller->actionParams['viewPath'] = $this->controller->getViewPath();
        }
        $this->module = $this->controller->module->id;
        $this->addClass[] = $this->module;
        $this->addClass[] = $this->module.'-'.$this->controller->id.'-'.$this->controller->action->id;
        if ($this->controller->actionParams['node']) {
            $this->addClass[] = $this->controller->id.'-'.$this->controller->actionParams['node'];
        }

        parent::init();
        ob_start();
    }

    public function run()
    {
        $view = $this->getView();
        $view->registerJs("$('body').removeClass('no_js').addClass('js');", $view::POS_READY);

        $content = ob_get_clean();
        $text = empty($text = $this->controller->actionParams['viewPath']) ? 'Фабрика сайтов (http://promo-pr.ru)' : $text;
        $result = '<!--'.$text.'-->' . Html::tag('body', $content, ['class'=>$this->addClass]);
        return $result;
    }

}