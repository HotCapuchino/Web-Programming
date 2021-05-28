<?php
if (!isset($user_values)) {
    header('Location: http://localhost:8080/conference');
}
$topics_array = ['Business', 'Technnologies', 'Advertisement', 'Marketing', 'Engineering'];
$payment_array = ['WebMoney', 'Yandex Money', 'PayPal', 'Credit Card', 'Robo Box'];
?>
<div class="general-wrapper">
    <div class="title">Submit to our conference online!</div>
    <form class="conference-form" method="POST" action="/conference/register">
        <section class="contact-info">
            <label class="name">
                <div class="name__title">Name</div>
                <?php
                if (isset($error_fields) && $error_fields['user_name']) {
                    echo '<div class="error-warning">' . $error_fields['user_name'] . '</div>';
                    $login_name_class = 'wrong_input';
                }
                ?>
                <input type="text" name="user_name" placeholder="Your name" <?php echo 'value="' . $user_values['user_name'] . '"' ?> <?php echo 'class="' . $user_name_class . '"' ?>>
            </label>
            <label class="surname">
                <div class="surname__title">Surname</div>
                <?php
                if (isset($error_fields) && $error_fields['user_surname']) {
                    echo '<div class="error-warning">' . $error_fields['user_surname'] . '</div>';
                    $user_surname_class = 'wrong_input';
                }
                ?>
                <input type="text" name="user_surname" placeholder="Your surname" <?php echo 'value="' . $user_values['user_surname'] . '"' ?> <?php echo 'class="' . $user_surname_class . '"' ?>>
            </label>
            <label class="mail">
                <div class="mail__title">Email</div>
                <?php
                if (isset($error_fields) && $error_fields['user_mail']) {
                    echo '<div class="error-warning">' . $error_fields['user_mail'] . '</div>';
                    $user_mail_class = 'wrong_input';
                }
                ?>
                <input type="email" name="user_mail" placeholder="Your mail" <?php echo 'value="' . $user_values['user_mail'] . '"' ?> <?php echo 'class="' . $user_mail_class . '"' ?>>
            </label>
            <label class="phone">
                <div class="phone__title">Phone Number</div>
                <?php
                if (isset($error_fields) && $error_fields['user_phone']) {
                    echo '<div class="error-warning">' . $error_fields['user_phone'] . '</div>';
                    $user_phone_class = 'wrong_input';
                }
                ?>
                <input type="number" name="user_phone" placeholder="Your phone number" <?php echo 'value="' . $user_values['user_phone'] . '"' ?> <?php echo 'class="' . $user_phone_class . '"' ?>>
            </label>
            <label class="conference-topic">
                <div class="conference-topic__title">Choose conference topic you like the most</div>
                <select name="chosen_topic" class="conference-topic__select">
                    <?php
                    for ($i = 0; $i < sizeof($topics_array); $i++) {
                        $selected = '';
                        if ($user_values['chosen_topic'] == $i + 1) {
                            $selected = 'selected';
                        }
                        echo '<option value="' . ($i + 1) . '" ' . $selected . '>' . $topics_array[$i] . '</option>';
                    }
                    ?>
                </select>
            </label>
        </section>
        <section class="payment">
            <div class="payment__title">Choose type of payment</div>
            <select name="chosen_payment" class="payment__select">
                <?php
                for ($i = 0; $i < sizeof($payment_array); $i++) {
                    $selected = '';
                    if ($user_values['chosen_payment'] == $i + 1) {
                        $selected = 'selected';
                    }
                    echo '<option value="' . ($i + 1) . '" ' . $selected . '>' . $payment_array[$i] . '</option>';
                }
                ?>
            </select>
        </section>
        <section class="mailing">
            <label class="mailing__label">
                <div class="mailing__title">Do you want to subscribe to receive new info?</div>
                <input type="checkbox" class="mailing__subscribe" name="mail_subscribe" <?php if ($user_values['mail_subscribe'] === 'on') echo 'checked' ?>>
            </label>
        </section>
        <button class="submit-button">Sign up for conference</button>
    </form>
    <?php
    $error_block_class = 'error-block none';
    if ($error_message) $error_block_class = 'error-block';
    ?>
    <div <?php echo 'class="' . $error_block_class . '"' ?>><?php echo $error_message ?></div>
</div>