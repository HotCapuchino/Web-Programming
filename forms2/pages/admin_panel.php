<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="/styles/pages/admin_panel.css">
</head>
<body>
    <?php 
        $td_classes = ['user-name', 'user-surname', 'user-email', 'user-phone', 'chosen-topic', 'chosen-payment', 'mail-subscribe', 'delete-checkbox'];
    ?>
    <div class="general-wrapper">
        <div class="title">Conference Requests
        </div>
        <form class="table-wrapper" method="POST" action="../src/delete_user.php">
            <table class="conference-requests">
                <tbody>
                    <tr class="table-header">
                        <td class="table-header__user-name">User Name</td>
                        <td class="table-header__user-surname">User Surname</td>
                        <td class="table-header__user-email">User Email</td>
                        <td class="table-header__user-phone">User Phone</td>
                        <td class="table-header__chosen-topic">Chosen Conference Topic</td>
                        <td class="table-header__chosen-payment">Chosen Type of Payment</td>
                        <td class="table-header__mail_subscribe">Subscribed to mail</td>
                        <td class="table-header__delete-checkbox">Mark to delete candidate</td>
                    </tr>
                    <?php 
                        if (isset($users)) {
                            for ($i = 0; $i < sizeof($users); $i++) { 
                                echo '<tr class="user-data">';
                                for ($j = 0; $j < sizeof($users[$i]) - 1; $j++) { 
                                   echo '<td class="user_data__' . $td_classes[$j] . '">' . $users[$i][$j] . '</td>';
                                } 
                                $subscribed = 'No';    
                                if ($users[$i][$j] === 'on') {
                                    $subscribed = 'Yes';
                                }
                                echo '<td class="user_data__' . $td_classes[$j] . '">' . $subscribed . '</td>';
                                echo '<td> 
                                        <input type="checkbox" name="' . $i . '"/>
                                    </td>';
                                echo '</tr>';
                            }
                        }
                    ?>
                </tbody>
            </table>
            <button class="delete-button">Delete chosen</button>
        </form>
        <?php 
            $error_block_class = 'error-block none';
            if ($error_message) $error_block_class = 'error-block';
        ?>
        <div <?php echo 'class="' . $error_block_class . '"' ?> ><?php echo $error_message ?></div>   
    </div>
</body>
</html>