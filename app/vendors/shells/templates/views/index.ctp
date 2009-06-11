<?php
/**
 * Default Bake Index Template
 * Copyright (c)  GREENPEACE INTERNATIONAL 2009
 *
 * Licensed under The General Public Licence v3 onwards.
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Greenpeace International
 * @license     GPL3 onwards - http://www.opensource.org/licenses/gpl-license.php
 * @author      remy.bertot@greenpeace.org
 */
?>
  <div class="<?php echo $pluralVar;?> index">
  <h2><?php echo "<?php __('{$pluralHumanName}');?>";?></h2>
  <div class="actions">
    <h3><?php echo "<?php echo __('Actions'); ?>";?></h3>
    <ul>
      <li><?php echo "<?php echo \$html->link(__('New {$singularHumanName}', true), array('action'=>'add'),array('class'=>'add')); ?>";?></li>
  <?php
    $done = array();
    foreach ($associations as $type => $data) {
      foreach ($data as $alias => $details) {
        if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
          echo "    <li><?php echo \$html->link(__('List ".Inflector::humanize($details['controller'])."', true), array('controller'=> '{$details['controller']}', 'action'=>'index')); ?> </li>\n";
          echo "    <li><?php echo \$html->link(__('New ".Inflector::humanize(Inflector::underscore($alias))."', true), array('controller'=> '{$details['controller']}', 'action'=>'add')); ?> </li>\n";
          $done[] = $details['controller'];
        }
      }
    }
  ?>
    </ul>
  </div>
  <table cellpadding="0" cellspacing="0">
  <tr>
  <?php  foreach ($fields as $field):?>
  	<th><?php echo "<?php echo \$paginator->sort('{$field}');?>";?></th>
  <?php endforeach;?>
  	<th class="actions"><?php echo "<?php __('Actions');?>";?></th>
  </tr>
<?php
echo "<?php
\$i = 0;
foreach (\${$pluralVar} as \${$singularVar}):
	\$class = null;
	if (\$i++ % 2 == 0) {
		\$class = ' class=\"altrow\"';
	}
?>\n";
	echo "  <tr<?php echo \$class;?>>\n";
		foreach ($fields as $field) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						echo "    <td>\n      <?php echo \$html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller'=> '{$details['controller']}', 'action'=>'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n    </td>\n";
						break;
					}
				}
			}
			if ($isKey !== true) {
				echo "    <td>\n      <?php echo \${$singularVar}['{$modelClass}']['{$field}']; ?>\n    </td>\n";
			}
		}

		echo "    <td class=\"actions\">\n";
		echo "      <?php echo \$html->link(__('View', true), array('action'=>'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('class'=>'view')); ?>\n";
	 	echo "      <?php echo \$html->link(__('Edit', true), array('action'=>'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('class'=>'edit')); ?>\n";
	 	echo "      <?php echo \$html->link(__('Delete', true), array('action'=>'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
		echo "    </td>\n";
	echo "  </tr>\n";

echo "<?php endforeach; ?>\n";
?>
  </table>
  </div>
  <div class="paging">
  <?php echo "  <?php echo \$paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>\n";?>
   | <?php echo "  <?php echo \$paginator->numbers();?>\n"?>
  <?php echo "  <?php echo \$paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>\n";?>
  </div>
  <p>
  <?php echo "<?php
  echo \$paginator->counter(array(
  'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
  ));
  ?>";?>
  </p>
