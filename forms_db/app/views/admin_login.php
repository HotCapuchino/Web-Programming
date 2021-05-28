<div class="general-wrapper">
    <div class="title">Enter your credentials</div>
    <form class="login-form" method="POST" action="/admin-panel/login">
        <label class="login-form__login">
            <div class="login__title">Login</div>
            <?php
            $login_class = '';
            if (isset($error_fields) && $error_fields['login']) {
                echo '<div class="error-warning">' . $error_fields['login'] . '</div>';
                $login_class = 'wrong_input';
            }
            if (isset($error_message)) {
                $login_class = 'wrong_input';
            }
            ?>
            <input type="text" name="login" placeholder="Your login" <?php echo 'class="'. $login_class . '"' ?>
                value="<?= isset($login) ? $login : '' ?>">
        </label>
        <label class="login-form__password">
            <div class="password__title">Password</div>
            <?php
            $password_class = '';
            if (isset($error_fields) && $error_fields['password']) {
                echo '<div class="error-warning">' . $error_fields['password'] . '</div>';
                $password_class = 'wrong_input';
            }
            if (isset($error_message)) {
                $password_class = 'wrong_input';
            }
            ?>
            <input type="password" name="password" placeholder="Your password" class="<?php echo $password_class?>">
        </label>
        <button class="login-form__login-btn" type="submit">Login Admin Panel</button>
    </form>
    <?php
        $error_block_class = 'error-block none';
        if ($error_message) $error_block_class = 'error-block';
    ?>
    <div <?php echo 'class="' . $error_block_class . '"' ?>><?php echo $error_message ?></div>
</div>