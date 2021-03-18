<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vocabulary</title>
    <link rel="stylesheet" type="text/css" href="styles/index.css">
</head>

<body>
    <?php include 'src/language_picker.php' ?>
    <div class="general-wrapper">
        <form method="GET" action="index.php">
            <label>Choose language:</label>
            <select name="lang">
                <?php
                changeCurrentLanguage();
                foreach (AVAILABLE_LANGUAGES as $key => $value) {
                    if ($CURRENT_LANGUAGE === $key) {
                        echo "<option selected value=\"$key\">$value</option>";
                    } else {
                        echo "<option value=\"$key\">$value</option>";
                    }
                }
                ?>
            </select>
            <label>Choose phrase:</label>
            <select name="phrase">
                <?php
                changeCurrentPhrase();
                foreach (AVAILABLE_PHRASES[$CURRENT_LANGUAGE] as $key => $value) {
                    if ($CURRENT_PHRASE === $value) {
                        echo "<option selected value=\"$key\">$value</option>";
                    } else {
                        echo "<option value=\"$key\">$value</option>";
                    }
                }
                ?>
            </select>
            <button type="submit">
                <?php echo BUTTON_PHRASE[$CURRENT_LANGUAGE] ?>
            </button>
        </form>
        <?php echo displayPhrase() ?>
    </div>
</body>

</html>
