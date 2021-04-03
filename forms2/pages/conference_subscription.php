<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=`device-width`, initial-scale=1.0">
    <title>Submit to conference!</title>
    <link rel="stylesheet" type="text/css" href="/styles/pages/conference.css">
    <?php 
        $topics_array = ['Business', 'Technnologies', 'Marketing'];
        $payment_array = ['WebMoney', 'Yandex Money', 'PayPal', 'Credit Card'];
    ?>
</head>
<body>
    <div class="general-wrapper">
        <div class="title">Submit to our conference online!</div>
        <form class="conference-form" method="POST" action="/src/register_user.php">
            <section class="contact-info">
            <label class="name">
                <div class="name__title">Name</div>
                <?php 
                    if (isset($error_fields) && $error_fields['user_name']) {
                        echo '<div class="error-warning">' . $error_fields['user_name'] . '</div>';
                        $user_name_class = 'wrong_input';
                    }
                ?>
                <input type="text" name="user_name" placeholder="Your name" <?php echo 'value="' . $user_name . '"'?>
                    <?php echo 'class="' . $user_name_class . '"' ?>>
            </label>
            <label class="surname">
                <div class="surname__title">Surname</div>
                <?php 
                    if (isset($error_fields) && $error_fields['user_surname']) {
                        echo '<div class="error-warning">' . $error_fields['user_surname'] . '</div>';
                        $user_surname_class = 'wrong_input';
                    }
                ?>
                <input type="text" name="user_surname" placeholder="Your surname" <?php echo 'value="' . $user_surname . '"'?>
                    <?php echo 'class="' . $user_surname_class . '"' ?>>   
            </label>
            <label class="mail">
                <div class="mail__title">Email</div>
                <?php 
                    if (isset($error_fields) && $error_fields['user_mail']) {
                        echo '<div class="error-warning">' . $error_fields['user_mail'] . '</div>';
                        $user_mail_class = 'wrong_input';
                    }
                ?>
                <input type="email" name="user_mail" placeholder="Your mail" <?php echo 'value="' . $user_mail . '"'?>
                    <?php echo 'class="' . $user_mail_class . '"' ?>>   
            </label>
            <label class="phone">
                <div class="phone__title">Phone Number</div>
                <?php 
                    if (isset($error_fields) && $error_fields['user_phone']) {
                        echo '<div class="error-warning">' . $error_fields['user_phone'] . '</div>';
                        $user_phone_class = 'wrong_input';
                    }
                ?>
                <input type="number" name="user_phone" placeholder="Your phone number" <?php echo 'value="' . $user_phone . '"'?>
                    <?php echo 'class="' . $user_phone_class . '"' ?>>   
            </label>
            <label class="conference-topic">
                <div class="conference-topic__title">Choose conference topic you like the most</div>
                <select name="chosen_topic" class="conference-topic__select">
                    <?php 
                        foreach ($topics_array as $value) {
                            $selected = '';
                            if ($chosen_topic === $value) {
                                $selected = 'selected';
                            } 
                            echo '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
                        }
                    ?>
                </select>   
            </label>
            </section>
            <section class="payment">
                <div class="payment__title">Choose type of payment</div>
                <select name="chosen_payment" class="payment__select">
                    <?php 
                        foreach ($payment_array as $value) {
                            $selected = '';
                            if ($chosen_payment === $value) {
                                $selected = 'selected';
                            } 
                            echo '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
                        }
                    ?>
                </select>
            </section>
            <section class="mailing">
                <label class="mailing__label">
                    <div class="mailing__title">Do you want to subscribe to receive new info?</div>
                    <input type="checkbox" class="mailing__subscribe" name="mail_subscribe"
                    <?php if ($mail_subscribe === 'on') echo 'checked'?>>
                </label>
            </section>
            <button class="submit-button">Sign up for conference</button>
        </form>
        <?php 
            $error_block_class = 'error-block none';
            if ($error_message) $error_block_class = 'error-block';
        ?>
        <div <?php echo 'class="' . $error_block_class . '"'?>><?php echo $error_message ?></div>
    </div>
</body>
</html>