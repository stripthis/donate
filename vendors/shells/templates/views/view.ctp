<?php
/**
 * Default Bake View Action Template
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
<div class="<?php echo $pluralVar;?> view">
<h2><?php echo "<?php  __('{$singularHumanName}');?>";?></h2>
  <div class="actions">
    <h3><?php echo "<?php echo __('Actions'); ?>";?></h3>
    <ul>
<?php
    echo "      <li><?php echo \$html->link(__('Edit {$singularHumanName}', true), array('action'=>'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class'=>'edit')); ?> </li>\n";
    echo "      <li><?php echo \$html->link(__('Delete {$singularHumanName}', true), array('action'=>'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']),  array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?> </li>\n";
    echo "      <li><?php echo \$html->link(__('List {$pluralHumanName}', true), array('action'=>'index'),array('class'=>'index')); ?> </li>\n";
    echo "      <li><?php echo \$html->link(__('New {$singularHumanName}', true), array('action'=>'add'),array('class'=>'add')); ?> </li>\n";
  
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
	<dl><?php echo "<?php \$i = 0; \$class = ' class=\"altrow\"';?>\n";?>
<?php
foreach ($fields as $field) {
	$isKey = false;
	if (!empty($associations['belongsTo'])) {
		foreach ($associations['belongsTo'] as $alias => $details) {
			if ($field === $details['foreignKey']) {
				$isKey = true;
				echo "    <dt<?php if (\$i % 2 == 0) echo \$class;?>><?php __('".Inflector::humanize(Inflector::underscore($alias))."'); ?></dt>\n";
				echo "    <dd<?php if (\$i++ % 2 == 0) echo \$class;?>>\n      <?php echo \$html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller'=> '{$details['controller']}', 'action'=>'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n      &nbsp;\n    </dd>\n";
				break;
			}
		}
	}
	if ($isKey !== true) {
		echo "    <dt<?php if (\$i % 2 == 0) echo \$class;?>><?php __('".Inflector::humanize($field)."'); ?></dt>\n";
		echo "    <dd<?php if (\$i++ % 2 == 0) echo \$class;?>>\n      <?php echo \${$singularVar}['{$modelClass}']['{$field}']; ?>\n      &nbsp;\n    </dd>\n";
	}
}
?>
	</dl>
</div>

<?php
if (!empty($associations['hasOne'])) :
	foreach ($associations['hasOne'] as $alias => $details): ?>
	<div class="related">
		<h3><?php echo "<?php  __('Related ".Inflector::humanize($details['controller'])."');?>";?></h3>
	<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])):?>\n";?>
		<dl><?php echo "  <?php \$i = 0; \$class = ' class=\"altrow\"';?>\n";?>
	<?php
			foreach ($details['fields'] as $field) {
				echo "    <dt<?php if (\$i % 2 == 0) echo \$class;?>><?php __('".Inflector::humanize($field)."');?></dt>\n";
				echo "    <dd<?php if (\$i++ % 2 == 0) echo \$class;?>>\n  <?php echo \${$singularVar}['{$alias}']['{$field}'];?>\n&nbsp;</dd>\n";
			}
	?>
		</dl>
	<?php echo "<?php endif; ?>\n";?>
		<div class="actions">
			<ul>
				<li><?php echo "<?php echo \$html->link(__('Edit ".Inflector::humanize(Inflector::underscore($alias))."', true), array('controller'=> '{$details['controller']}', 'action'=>'edit', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?></li>\n";?>
			</ul>
		</div>
	</div>
	<?php
	endforeach;
endif;
if (empty($associations['hasMany'])) {
	$associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
	$associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
$i = 0;
foreach ($relations as $alias => $details):
	$otherSingularVar = Inflector::variable($alias);
	$otherPluralHumanName = Inflector::humanize($details['controller']);
	?>
<div class="related">
	<h3><?php echo "<?php __('Related {$otherPluralHumanName}');?>";?></h3>
	<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])):?>\n";?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
<?php
			foreach ($details['fields'] as $field) {
				echo "    <th><?php __('".Inflector::humanize($field)."'); ?></th>\n";
			}
?>
		<th class="actions"><?php echo "<?php __('Actions');?>";?></th>
	</tr>
<?php
echo "  <?php
		\$i = 0;
		foreach (\${$singularVar}['{$alias}'] as \${$otherSingularVar}):
			\$class = null;
			if (\$i++ % 2 == 0) {
				\$class = ' class=\"altrow\"';
			}
		?>\n";
		echo "    <tr<?php echo \$class;?>>\n";

				foreach ($details['fields'] as $field) {
					echo "      <td><?php echo \${$otherSingularVar}['{$field}'];?></td>\n";
				}

				echo "      <td class=\"actions\">\n";
				echo "        <?php echo \$html->link(__('View', true), array('controller'=> '{$details['controller']}', 'action'=>'view', \${$otherSingularVar}['{$details['primaryKey']}'])); ?>\n";
				echo "        <?php echo \$html->link(__('Edit', true), array('controller'=> '{$details['controller']}', 'action'=>'edit', \${$otherSingularVar}['{$details['primaryKey']}'])); ?>\n";
				echo "        <?php echo \$html->link(__('Delete', true), array('controller'=> '{$details['controller']}', 'action'=>'delete', \${$otherSingularVar}['{$details['primaryKey']}']), null, sprintf(__('Are you sure you want to delete # %s?', true), \${$otherSingularVar}['{$details['primaryKey']}'])); ?>\n";
				echo "      </td>\n";
			echo "    </tr>\n";

echo "  <?php endforeach; ?>\n";
?>
	</table>
<?php echo "<?php endif; ?>\n\n";?>
	<div class="actions">
		<ul>
			<li><?php echo "<?php echo \$html->link(__('New ".Inflector::humanize(Inflector::underscore($alias))."', true), array('controller'=> '{$details['controller']}', 'action'=>'add'));?>";?> </li>
		</ul>
	</div>
</div>
<?php endforeach;?>