<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class DummyImageWidget extends Widget{

    public $out;
    public $cols;

    public function init()
    {
        parent::init();

        $out = '<div class="dummy-image '. ($this->cols?$this->cols:'') .'"><h3 class="dummy-title">IVATCH</h3></div>';
        $this->out = $out;
    }

    public function run(){
        return ($this->out);
    }
}
?>