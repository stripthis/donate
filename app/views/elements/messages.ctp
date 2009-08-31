<?php if (!isset($flashMessages) || empty($flashMessages)): ?>
      <div class="messages empty"></div>
<?php else : ?>
      <ul class="messages">
<?php foreach ($flashMessages as $message): ?>
        <li class="<?php echo $message['type']; ?>"><?php echo $simpleTextile->toHtml($message['text']); ?></li>
<?php endforeach; ?>
      </ul>
<?php endif; ?>