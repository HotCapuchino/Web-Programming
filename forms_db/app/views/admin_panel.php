<?php
$td_classes = ['user-name', 'user-surname', 'user-email', 'user-phone', 'chosen-topic', 'chosen-payment', 'mail-subscribe', 'delete-checkbox'];
?>
<header class="header-wrapper">
    <form class="logout-form" method="POST" action="/admin-panel/logout">
        <button type="submit" class="logout-form__logout-btn">Log Out</button>
    </form>
</header>
<div class="general-wrapper">
    <div class="title">Registered Users</div>
    <form class="table-wrapper" method="POST" action="/admin-panel/delete">
        <table class="conference-requests">
            <tbody>
                <tr class="table-header">
                    <td class="table-header__user-name">Firstname</td>
                    <td class="table-header__user-surname">Lastname</td>
                    <td class="table-header__user-email">User email</td>
                    <td class="table-header__user-phone">User phone</td>
                    <td class="table-header__chosen-topic">Chosen topic</td>
                    <td class="table-header__chosen-payment">Chosen payment type</td>
                    <td class="table-header__mail_subscribe">Subscribed to mail</td>
                    <td class="table-header__delete-checkbox">Mark to delete</td>
                </tr>
                <?php
                if (isset($users)) {
                    for ($i = 0; $i < sizeof($users); $i++) {
                        echo '<tr class="user-data">';
                        for ($j = 1; $j < sizeof($users[$i]) - 1; $j++) {
                            echo '<td class="user_data__' . $td_classes[$j] . '">' . $users[$i][$j] . '</td>';
                        }
                        $subscribed = 'No';
                        if ($users[$i][$j] != 0) {
                            $subscribed = 'Yes';
                        }
                        echo '<td class="user_data__' . $td_classes[$j] . '">' . $subscribed . '</td>';
                        echo '<td> 
                                        <input type="checkbox" name="' . $users[$i][0] . '"/>
                                    </td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
        <button class="delete-button" type="submit">Delete chosen</button>
    </form>
    <?php
    $error_block_class = 'error-block none';
    if ($error_message) $error_block_class = 'error-block';
    ?>
    <div <?php echo 'class="' . $error_block_class . '"' ?>><?php echo $error_message ?></div>
</div>