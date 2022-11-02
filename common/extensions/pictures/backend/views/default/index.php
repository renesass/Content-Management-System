<?php
	
use yii\helpers\Url;
use yii\helpers\Html;
use rs\grid\GridView;

$this->title = 'Bilder';
$this->params['breadcrumbs'][] = $this->title;

$this->params['headline-buttons'] = Html::a('Neues Bild', ['new'], ['class' => 'btn btn-primary']);

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => '',
    'columns' => [
        'title',
        'location',
        [
	    	'attribute' => 'date',
			'value' => function ($model) {
	        	return $model->getDate();
	    	}
	    ],
        ['class' => 'rs\grid\ActionColumn'],
    ],
]); ?>
