<?php

use yii\widgets\ListView;
?>
<?php \yii\widgets\Pjax::begin(); ?>
<?=

ListView::widget([
    'dataProvider' => $dataProvider,
    'summary' => FALSE,
    'options' => [
        'tag' => 'div',
    ],
    'layout' => "<div class=\"row lists\">{items}</div>\n{pager}\n{summary}",
    'itemView' => function ($model, $key, $index, $widget) {
return $this->render('_item', ['model' => $model]);
},
]);
?>

<?php \yii\widgets\Pjax::end(); ?>