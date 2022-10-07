<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
use Bitrix\Main\UI\Extension;
Extension::load('ui.bootstrap4');
CJSCore::Init();
?><!DOCTYPE html>
<html xml:lang="<?= LANGUAGE_ID; ?>" lang="<?= LANGUAGE_ID; ?>">
    <head>
        <title><?$APPLICATION->ShowTitle();?></title>
        <? $APPLICATION->ShowHead(); ?>
    </head>
    <body>
        <? $APPLICATION->ShowPanel(); ?>
