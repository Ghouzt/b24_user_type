<?php

namespace ItBuro;

use Bitrix\Iblock;
use Bitrix\Main\Loader;

class UserTypeTaskBind
{
    public const USER_TYPE = 'tasksbind';

    /**
     * @return array
     */
    public static function GetUserTypeDescription(): array
    {
        return array(
            "PROPERTY_TYPE" => Iblock\PropertyTable::TYPE_NUMBER,
            "USER_TYPE" => self::USER_TYPE,
            "DESCRIPTION" => 'Привязка к задачам',
            "GetPropertyFieldHtml" => array(__CLASS__, "GetPropertyFieldHtml"),
            "GetPropertyFieldHtmlMulty" => array(__CLASS__, "GetPropertyFieldHtmlMulty"),
            "GetPublicEditHTML" => array(__CLASS__, "GetPublicEditHTML"),
            "GetPublicEditHTMLMulty" => array(__CLASS__, "GetPublicEditHTMLMulty"),
            "GetAdminListViewHTML" => array(__CLASS__, "GetAdminListViewHTML"),
            "GetPublicListViewHTML" => array(__CLASS__, "GetPublicListViewHTML"),
            'ConvertToDB'           	=> array(__CLASS__, 'ConvertToDB'),
            'ConvertFromDB'         	=> array(__CLASS__, 'ConvertFromDB')
        );
    }

    function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName) {
        $inputName = str_replace('[VALUE]', '', $strHTMLControlName["VALUE"]);

        $s = '';
        ob_start();
        global $APPLICATION;
        $APPLICATION->IncludeComponent(
            "bitrix:tasks.task.selector",
            "task_prop_selector",
            Array(
                "NAME" => $arProperty["CODE"],
                "MULTIPLE" => $arProperty['MULTIPLE'] == 'Y' ?? 'N',
                "INPUT_NAME" => $inputName,
                "VALUE" => $value['VALUE'],
            )
        );
        $s .= ob_get_contents();
        ob_end_clean();
        return  $s;
    }

    function GetPropertyFieldHtmlMulty($arProperty, $value, $strHTMLControlName) {
        foreach ($value as $propId => &$arProp) {
            $arProp = $arProp['VALUE'];
        }
        
        $s = '';
        ob_start();
        global $APPLICATION;
        $APPLICATION->IncludeComponent(
            "bitrix:tasks.task.selector",
            "task_prop_selector",
            Array(
                "NAME" => $arProperty["CODE"],
                "MULTIPLE" => $arProperty['MULTIPLE'] == 'Y' ?? 'N',
                "INPUT_NAME" => $strHTMLControlName["VALUE"],
                "VALUE" => $value
            )
        );
        $s .= ob_get_contents();
        ob_end_clean();
        return  $s;
    }

    function GetPublicEditHTML($arProperty, $value, $strHTMLControlName) {
        $inputName = str_replace('[VALUE]', '', $strHTMLControlName["VALUE"]);

        $s = '';
        ob_start();
        global $APPLICATION;
        $APPLICATION->IncludeComponent(
            "bitrix:tasks.task.selector",
            "task_prop_selector",
            Array(
                "NAME" => $arProperty["CODE"],
                "MULTIPLE" => $arProperty['MULTIPLE'] == 'Y' ?? 'N',
                "INPUT_NAME" => $inputName,
                "VALUE" => $value['VALUE'],
            )
        );
        $s .= ob_get_contents();
        ob_end_clean();
        return  $s;
    }

    function GetPublicEditHTMLMulty($arProperty, $value, $strHTMLControlName) {
        foreach ($value as $propId => &$arProp) {
            $arProp = $arProp['VALUE'];
        }
        
        $s = '';
        ob_start();
        global $APPLICATION;
        $APPLICATION->IncludeComponent(
            "bitrix:tasks.task.selector",
            "task_prop_selector",
            Array(
                "NAME" => $arProperty["CODE"],
                "MULTIPLE" => $arProperty['MULTIPLE'] == 'Y' ?? 'N',
                "INPUT_NAME" => $strHTMLControlName["VALUE"],
                "VALUE" => $value
            )
        );
        $s .= ob_get_contents();
        ob_end_clean();
        return  $s;
    }

    function GetAdminListViewHTML($arProperty, $value, $strHTMLControlName) {
        if (Loader::includeModule('tasks')) {
            $rsTasks = \CTasks::GetList(
                [],
                ['ID' => $value['VALUE']],
                ['ID', 'TITLE']
            );

            while ($arTask = $rsTasks->Fetch()) {
                $viewHtml .= "<span>{$arTask['TITLE']}[{$arTask['ID']}]</span>";
            }

            return $viewHtml;
        }

        return '';
    }

    function GetPublicListViewHTML($arProperty, $value, $strHTMLControlName) {
        if (Loader::includeModule('tasks')) {
            $rsTasks = \CTasks::GetList(
                [],
                ['ID' => $value['VALUE']],
                ['ID', 'TITLE']
            );

            while ($arTask = $rsTasks->Fetch()) {
                $viewHtml .= "<span>{$arTask['TITLE']}[{$arTask['ID']}]</span>";
            }

            return $viewHtml;
        }

        return '';
    }

    public static function ConvertToDB($arProperty, $arValue)
    {
        return $arValue;
    }

    public static function ConvertFromDB($arProperty, $arValue)
    {
        return $arValue;
    }
}
