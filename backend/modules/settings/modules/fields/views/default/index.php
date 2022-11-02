<?php

use yii\helpers\Html;
use rs\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use backend\modules\settings\modules\fields\models\Group;

$this->title = 'Felder';
$this->params['breadcrumbs'][] = ['label' => 'Einstellungen', 'url' => ['/settings']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['headline-buttons'] = Html::a('Neues Feld', ['new'], ['class' => 'btn btn-primary']);

?>

<?= Yii::$app->controller->renderPartial('@backend/modules/settings/modules/fields/views/groups/index', ['dataProvider' => $groupDataProvider]); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        'label',
        [
	        'attribute' => 'name',
	        'contentOptions' => ['class' => 'name']
        ],
        [
	        'attribute' => 'type',
	        'value' => function ($model) {
                return Yii::$app->fieldManager->getTypeNames()[$model->type];
            },
        ],
        [
        	'class' => 'rs\grid\ActionColumn',
		    'buttons' => [
		        'delete' => function($url, $model){
		            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
		                'data' => [
		                    'confirm' => 'Willst du das Feld wirklich löschen? Alle zugehörigen Daten des Feldes werden gelöscht. Diese Aktion kann nicht rückgängig gemacht werden.',
		                    'method' => 'post',
		                ],
		            ]);
		        }
		    ],
        ],
    ],
]); ?>