<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("1С-Битрикс: Управление сайтом");
?>

<?
$APPLICATION->IncludeComponent(
    "stroylandia:ip_info",
    "",
    [
        "ENTITY_NAME" => "IPInfo",
        "IPSTACK_KEY" => "e3444ef56382930039399cd045ff4b0e",
        "AJAX_MODE" => "Y"
    ],
    false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>