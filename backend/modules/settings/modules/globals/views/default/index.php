<?php

use yii\helpers\Html;
use rs\grid\GridView;

$this->title = 'Globale Variablen';
$this->params['breadcrumbs'][] = ['label' => 'Einstellungen', 'url' => ['/settings']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['headline-buttons'] = Html::a('Neue Gruppe', ['new'], ['class' => 'btn btn-primary']);

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        'label',
        [
	        'attribute' => 'name',
	        'contentOptions' => ['class' => 'name'],
        ],
        [
        	'class' => 'rs\grid\ActionColumn',
		    'buttons' => [
		        'delete' => function($url, $model){
		            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
		                'data' => [
		                    'confirm' => 'Willst du die Gruppe wirklich löschen? Alle zugehörigen Daten von den Feldern der Gruppe werden gelöscht. Diese Aktion kann nicht rückgängig gemacht werden.',
		                    'method' => 'post',
		                ],
		            ]);
		        }
		    ],
        ],
    ],
]); ?>