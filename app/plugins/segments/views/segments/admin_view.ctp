<div class="content" id="segments_view">
	<h1><?php echo $this->pageTitle = sprintf('Segment: %s', $segment['Segment']['name']); ?></h1>
	
	<?php if (empty($segment['SegmentItem'])) : ?>
		<p><?php echo __('Sorry, there are no items in this segment!', true); ?>
	<?php else : ?>
		<?php
		$models = Configure::read('Segments.models');
		$items = array();
		foreach ($models as $model) {
			$items[$model] = Set::extract('/SegmentItem/' . $model, $segment);
		}
		?>
		<?php foreach ($items as $model => $rows) : ?>
			<h2><?php echo Inflector::pluralize($model)?></h2>
			<?php
			$plural = low(Inflector::tableize($model));
			echo $this->element('../' . $plural . '/from_element', array($plural => $rows));
			?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>