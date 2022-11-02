<?php
	
use yii\helpers\Url;
use yii\helpers\Html;
use rs\grid\GridView;

$this->title = 'Erweiterungen';
$this->params['breadcrumbs'][] = ['label' => 'Einstellungen', 'url' => ['/settings']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['headline-buttons'] = Html::a('Erweiterung registrieren', ['register'], ['class' => 'btn btn-primary']);

?>

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
	        'attribute' => 'table_name',
	        'contentOptions' => ['class' => 'name']
        ],
        [
	        'attribute' => 'source',
	        'contentOptions' => ['class' => 'name']
        ],
		[
        	'class' => 'rs\grid\ActionColumn',
			'template' => '<span class="pull-right">{deregister}</span>',
		    'buttons' => [
		        'deregister' => function($url, $model){
		            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['deregister', 'id' => $model->id], [
		                'data' => [
		                    'confirm' => 'Willst du die Erweiterung wirklich deregistrieren? Alle Daten der Erweiterung werden gelöscht. Diese Aktion kann nicht rückgängig gemacht werden.',
		                    'method' => 'post',
		                ],
		            ]);
		        }
		    ],
        ],
    ],
]); ?>
