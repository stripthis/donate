<h1><?php echo $this->pageTitle = 'Dashboard for ' . $user['User']['login']; ?></h1>

<?php echo $html->link('&laquo; Back to Users', array('controller' => 'users', 'action' => 'index', 'admin' => 'true'), null, false, false)?>

<h2>Score: <?php echo $user['User']['score']?></h2>
<p>The User has <?php echo $user['User']['bet_points'] ?> bet points left for this round.</p>

<?php
$url = Router::url('/refer/' . $user['User']['referral_key'], true);
?>
<p>His referral url: <?php echo $html->link($url, $url); ?>


<h2>Score History:</h2>
<?php if (!empty($user['ScoringHistory'])) : ?>
	<table>
		<tr>
			<th>Type</th>
			<th>How much score</th>
			<th>Related</th>
			<th>When</th>
		</tr>
	<?php foreach ($user['ScoringHistory'] as $entry) : ?>
		<tr>
			<td><?php echo ucfirst($entry['type']) ?></td>
			<td><?php echo $entry['score']?></td>
			<td>
				<?php if ($entry['type'] == 'referral'): ?>
					<?php echo $entry['Referred']['login']?>
				<?php endif ?>
			</td>
			<td><?php echo $entry['created']?></td>
		</tr>
	<?php endforeach ?>
	</table>
<?php else : ?>
	<?php echo $this->element('warning', array('txt' => 'Sorry, nothing to show here.'))?>
<?php endif; ?>