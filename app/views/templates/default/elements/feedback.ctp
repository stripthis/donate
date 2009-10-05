      <p class="message information"><?php __('Hint: <strong class="required">*</strong> indicates a required field',true);?></p>
<?php foreach ($flashMessages as $message): ?>
      <p class="message <?php echo $message['type']; ?>"><?php echo $simpleTextile->toHtml($message['text']); ?></p>
<?php endforeach; ?>