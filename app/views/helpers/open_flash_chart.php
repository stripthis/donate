<?php
class OpenFlashChartHelper extends AppHelper {
	function build($options = array()) {
		if (empty($options)) {
			return false;
		}

		require_once WWW_ROOT . 'php-ofc-library/open-flash-chart.php';

		$chart = new open_flash_chart();

		if (isset($options['title']['txt'])) {
			$title = new title($options['title']['txt']);

			if (isset($options['title']['style'])) {
				$title->set_style("{" . $options['title']['style'] . "}");
			}

			$chart->set_title($title);
		}

		if (isset($options['chart']['bg'])) {
			$chart->set_bg_colour($options['chart']['bg']);
		}			if (isset($xOptions['color'])) {
				$x->colour($xOptions['color']);
			}
			if (isset($xOptions['grid_colour'])) {
				$x->grid_colour($xOptions['grid_colour']);
			}

		$col = isset($options['color']) ? $options['color'] : null;
		$outlineCol = isset($options['outline_col']) ? $options['outline_col'] : null;

		if (isset($options['charts'])) {
			foreach ($options['charts'] as $chartOpts) {
				$type = isset($chartOpts['type']) ? $chartOpts['type'] : 'bar_filled';
				$diagram = new $type($chartOpts['col'], $chartOpts['outline']);

				if ($type == 'bar_3d') {
					$diagram->colour = $col;
				}
				$diagram->set_values($chartOpts['values']);

				if (isset($chartOpts['key'])) {
					$diagram->key($chartOpts['key'], 12);
				}
				$xAxis = $this->xAxis($options);
				if ($xAxis !== null) {
					$chart->set_x_axis($xAxis);
				}

				$yAxis = $this->yAxis($options);
				if ($xAxis !== null) {
					$chart->set_y_axis($yAxis);
				}

				if (isset($chartOpts['tooltip'])) {
					$diagram->set_tooltip($chartOpts['tooltip']);
				}

				$chart->add_element($diagram);
			}
		}

		return $chart->toPrettyString();
	}
/**
 * undocumented function
 *
 * @param string $options 
 * @return void
 * @access public
 */
	function xAxis($options) {
		$x = null;

		if (isset($options['x_axis'])) {
			$x = new x_axis();

			$xOptions = $options['x_axis'];

			if (isset($xOptions['color'])) {
				$x->colour($xOptions['color']);
			}
			if (isset($xOptions['grid_colour'])) {
				$x->grid_colour($xOptions['grid_colour']);
			}
			if (isset($xOptions['tick_height'])) {
				$x->tick_height($xOptions['tick_height']);
			}
			if (isset($xOptions['stroke'])) {
				$x->stroke($xOptions['stroke']);
			}
			if (isset($xOptions['labels'])) {
				$x->set_labels_from_array($xOptions['labels']);
				if (isset($xOptions['label_direction'])) {
					$x->labels->set_vertical();
				}
			}
		}

		return $x;
	}
/**
 * undocumented function
 *
 * @param string $options 
 * @return void
 * @access public
 */
	function yAxis($options) {
		$y = null;

		if (isset($options['y_axis'])) {
			$y = new y_axis();

			$yOptions = $options['y_axis'];

			if (isset($yOptions['peaks'])) {
				$min = $yOptions['peaks'][0];
				$max = $yOptions['peaks'][1];
				$y->set_range(0, $max);

				if (isset($yOptions['num_steps'])) {
					$step = $this->ySteps($max, $yOptions['num_steps'], true);
					$y->set_steps($step);
				}
			}

			if (isset($yOptions['colors'])) {
				$col = $yOptions['colors'][0];
				$gridCol = $yOptions['colors'][1];
				$y->set_colours($col, $gridCol);
			}
		}

		return $y;
	}
/**
 * undocumented function
 *
 * @param string $min 
 * @param string $max 
 * @param string $numSteps 
 * @return void
 * @access public
 */
	function ySteps($max, $numSteps, $stepOnly = false) {
		if ($numSteps == 0) {
			return array();
		}

		$dividers = array(1, 2, 5, 10);
		$divider = false;
		$currentDistance = false;
		$multiplier = false;

		foreach ($dividers as $div) {
			$multipl = $max / $div;
			$distance = abs($multipl - $numSteps);

			if ($currentDistance !== 0 && ($currentDistance == false || $distance < $currentDistance)) {
				$multiplier = $multipl;
				$divider = $div;
				$currentDistance = $distance;
			}
		}

		$count = $numSteps;
		$step = $divider;

		if ($divider == 1) {
			if ($stepOnly) {
				return 1;
			}
			return range(1, $max);
		}

		$step = ceil($max / $multiplier);

		if ($step * ($numSteps + 1) < $max) {
			$i = ceil($max / $numSteps);
			$i = ceil($i / $divider);
			$step = $i * $divider;
		}
		$count = ceil($max / $step);

		if ($stepOnly) {
			return $step;
		}

		$steps = array();
		for ($i = 1; $i < $count + 1; $i++) {
			$steps[] = $i * $step;
		}
		return $steps;
	}
}
?>
