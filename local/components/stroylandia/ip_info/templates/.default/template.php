<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();
?>
<div class="container">

    <?if($arResult['ERRORS']){?>
        <?foreach ($arResult['ERRORS'] as $ERROR) {?>
            <div class="alert alert-danger mt-3" role="alert">
                <?=$ERROR?>
            </div>
        <?}?>
    <?}?>

    <form action="<?=$APPLICATION->GetCurUri()?>" id = "form_<?=$arParams['AJAX_ID']?>" enctype="multipart/form-data" onsubmit="highLoadBLockFormSubmit($(this)[0]); return false;" method="post">

        <div class="form-group mt-2">
            <label>Введите IP:</label>
            <input placeholder="xxx.xxx.xxx.xx"  class="form-control" name="IP" value="<?=$arResult['REQUEST']['IP']?>" required>
        </div>

        <input type="hidden" name="HLBLOCK_ID" value="<?=$arResult['HLBLOCK_ID']?>">
        <input type="hidden" name="action" value="searchIP">
        <button type="submit" class="btn btn-primary mt-3">Найти</button>
    </form>
</div>

<?if ($arResult['IP_INFO']['UF_IPSTACK']) {?>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th><?=$arResult['REQUEST']['IP']?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>continent_name:</th>
                    <th><?=$arResult['IP_INFO']['UF_IPSTACK']['continent_name']?></th>
                </tr>
                <tr>
                    <th>country_name:</th>
                    <th><?=$arResult['IP_INFO']['UF_IPSTACK']['country_name']?></th>
                </tr>
                <tr>
                    <th>region_name:</th>
                    <th><?=$arResult['IP_INFO']['UF_IPSTACK']['region_name']?></th>
                </tr>
                <tr>
                    <th>city:</th>
                    <th><?=$arResult['IP_INFO']['UF_IPSTACK']['city']?></th>
                </tr>
            </tbody>
        </table>
    </div>
<?}?>

<script>
    BX.message({
        AJAX_ID: '<?=$arParams['AJAX_ID']?>',
    });
</script>
