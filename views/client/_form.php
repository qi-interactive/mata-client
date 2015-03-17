<?php

use yii\helpers\Html;
use matacms\widgets\ActiveForm;
use yii\imperavi\ClipsImperaviRedactorPluginAsset;
ClipsImperaviRedactorPluginAsset::register($this);

?>
<div class="post">

    <?php $form = ActiveForm::begin([
        "id" => "form-post"
        ]);    
    ?>

        <?= $form->field($model, 'Name') ?>
        
        <?php if(!$model->isNewRecord):?>
        
        <?= $form->field($model, 'Media')->media() ?>
    	
        <?php endif; ?>

        <?= $form->field($model, 'URI') ?>

        <?= $form->submitButton() ?>

    <?php ActiveForm::end(); ?>

</div><!-- qwdqwd -->




