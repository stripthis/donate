      <div class="top_players">
        <table>
          <caption><?php echo __("Current Top 5 Players"); ?></caption>
          <thead>
            <tr>
              <th class="rank">#</th>
              <th class="name"><?php echo __("Player"); ?></th>
              <th class="score"><?php echo __("Score"); ?></th>
            </tr>
          </thead>
          <tbody>
<?php foreach ($topUsers as $user) : ?>
            <tr>
              <td><?php echo $user['User']['rank']?></td>
              <td><?php echo h($user['User']['name'])?></td>
              <td><?php echo $user['User']['score']?></td>
            </tr>
<?php endforeach; ?>
          <tbody>
        </table>
      </div>
