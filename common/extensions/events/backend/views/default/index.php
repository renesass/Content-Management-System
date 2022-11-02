<?php
	
use yii\helpers\Url;
use yii\helpers\Html;
use rs\grid\GridView;
use yii\bootstrap\Tabs;

$this->title = 'Termine';
$this->params['breadcrumbs'][] = $this->title;

$this->params['headline-buttons'] = Html::a('Neuer Termin', ['new'], ['class' => 'btn btn-primary']);

?>

<div class="panel panel-default">
	<?= Tabs::widget([
		'navType' => 'nav nav-tabs',
		'renderTabContent' => false,
		'items' => [
			[
				'label' => 'Zukunft',
				'options' => ['id' => 'future'],
				'active' => true,
			], 
			[
				'label' => 'Vergangenheit',
				'options' => ['id' => 'past'],
			],
		],
	]);	?>
</div>

<div class="tab-content">
    <div id="future" class="tab-pane active">
        <?= GridView::widget([
            'dataProvider' => $dataProviderFuture,
            'summary' => '',
            'columns' => [
                [
                    'attribute' => 'date',
                    'value' => function ($model) {
                        return $model->getDate();
                    }
                ],
                [
                    'attribute' => 'time',
                    'value' => function ($model) {
                        return $model->getTime();
                    }
                ],
                'type',
                'location',
                ['class' => 'rs\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
    <div id="past" class="tab-pane">
        <?= GridView::widget([
            'dataProvider' => $dataProviderPast,
            'summary' => '',
            'columns' => [
                [
                    'attribute' => 'date',
                    'value' => function ($model) {
                        return $model->getDate();
                    }
                ],
                [
                    'attribute' => 'time',
                    'value' => function ($model) {
                        return $model->getTime();
                    }
                ],
                'type',
                'location',
                ['class' => 'rs\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>