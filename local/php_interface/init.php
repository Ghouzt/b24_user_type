<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\EventManager;

$arLoadClasses = [
    '\\ItBuro\\UserTypeTaskBind' => '/local/php_interface/classes/UserTypeTaskBind.php',
];

foreach ($arLoadClasses as $index => $arLoadClass) {
    if (!file_exists(\Bitrix\Main\Application::getDocumentRoot() . $arLoadClass)) {
        unset($arLoadClasses[$index]);
    }
}

\Bitrix\Main\Loader::registerAutoLoadClasses(null, $arLoadClasses);

if (class_exists(\ItBuro\UserTypeTaskBind::class)) {
    $eventManager = EventManager::getInstance();

    $eventManager->addEventHandler(
        'iblock',
        'OnIBlockPropertyBuildList',
        ['ItBuro\\UserTypeTaskBind', 'GetUserTypeDescription']
    );
}
