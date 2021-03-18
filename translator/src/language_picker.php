<?php 
const AVAILABLE_LANGUAGES = array(
    'ru' => 'Русский',
    'en' => 'English', 
    'it' => 'Italian', 
    'hy' => 'հայերեն',
);

const BUTTON_PHRASE = array(
    'ru' => 'Перевести',
    'en' => 'Translate',
    'it' => 'Tradurre',
    'hy' => 'թարգմանել'
);

$CURRENT_LANGUAGE = 'ru';
$CURRENT_PHRASE = '';

function changeCurrentLanguage() {
    global $CURRENT_LANGUAGE;
    if (AVAILABLE_LANGUAGES[$_GET['lang']] != null) {
        $CURRENT_LANGUAGE = $_GET['lang'];
        return true;
    }
    return false;
}

function changeCurrentPhrase() {
    global $CURRENT_LANGUAGE, $CURRENT_PHRASE;
    if (AVAILABLE_PHRASES[$CURRENT_LANGUAGE][$_GET['phrase']] != null) {
        $CURRENT_PHRASE = AVAILABLE_PHRASES[$CURRENT_LANGUAGE][$_GET['phrase']];
        return true;
    }
    return false;
}

function displayPhrase() {
    global $CURRENT_PHRASE;
    return "<h2>$CURRENT_PHRASE</h2>";
}

const AVAILABLE_PHRASES = [
    'ru' => [
        'hello' => 'привет',
        'open' => 'открыть',
        'save' => 'закрыть',
        'close_the_window' => 'закрыть окно?',
    ],
    'en' => [
        'hello' => 'hello',
        'open' => 'open',
        'save' => 'close',
        'close_the_window' => 'should the window be closed?',
    ],
    'it' => [
        'hello' => 'ciao',
        'open' => 'aperto',
        'save' => 'tenere',
        'close_the_window' => 'chiudere una finestra?',
    ],
    'hy' => [
        'hello' => 'Բարեւ Ձեզ',
        'open' => 'բաց',
        'save' => 'պահել',
        'close_the_window' => 'պատուհան փակել?',
    ]
];