<?php $this->setLayoutVar('title', 'Home'); ?>

<h2>Home</h2>

<form action="<?php echo $base_url;?>/status/post" method="post">
    <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />
    <?php ?>

    <textarea name="body" rows="2" cols="60"><?php echo $this->escape($body); ?></textarea>

    <p>
        <input type="submit" value="submit" />
    </p>
</form>

<div id="statuses">
    <?php foreach($statuses as $status): ?>
    <?php $this->render('status/status', array('status' => $status)); ?>
    <?php endforeach; ?>
</div>