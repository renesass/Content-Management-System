<?php
	
use common\extensions\pictures\frontend\assets\PicturesAsset;
	
$this->title = 'Bilder';
$this->params['breadcrumbs'][] = $this->title;

PicturesAsset::register($this); 

foreach ($pictures as $picture) {
	?>
	<div class="image">
		<img src="<?= $picture->getImageUrl($extension); ?>">
		<?= $picture->title; ?> (<?= $picture->location ?>, <?= $picture->getDate() ?>)
	</div>
	<?php
}
	
?>