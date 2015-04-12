<?php
/**
 * Created by PhpStorm.
 * User: Set
 * Date: 31.03.15
 * Time: 21:57
 */
namespace webroot\widgets\watching;

use yii\base\Widget;

class WatchingPlayer extends Widget
{
    public function run()
    {
        return $this->render('index');
    }
}