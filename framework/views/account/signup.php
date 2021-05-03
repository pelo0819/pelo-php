<?php $this->setLayoutVar('title', 'register account'); ?>

<h2>register account</h2>

<form action="<?php echo $base_url; ?>/account/register" method="post">
    <input type="hidden" name ="_token" value="<?php echo $this->escape($_token) ?>" />
    <?php if(isset($errors) && count($errors) > 0): ?>
    <?php $this->render('errors', array('errors' => $errors)); ?>
    <?php endif; ?>
    <?php $this->render('account/input', array('user_name'=> $user_name, 'password'=> $password)); ?>
    <p>
        <input type="submit" value="register" />
    </p>
</form>