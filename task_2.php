<?php
use Bitrix\Main\Loader;
use Bitrix\Crm\DealTable;
use Bitrix\Crm\Service\Container;
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

Loader::IncludeModule("crm");

$dealFields = array(
    'TITLE' => 'Тестовая сделка',
    "STAGE_ID" => 'C2:PREPARATION',
);
$idDeal = 15;
//variant d7
//  не всегда подходит, так как  при создании/изменении необходимо в ручную запускать автоматизацию
$entity = new DealTable();
$res = $entity->update($idDeal,$dealFields);
if($res->isSucces()){
    echo "Сделка успешно обновлена";
}else{
    echo "Ошибка обновления: " . $res->getErrorMessages();
}
//variant factory
// Более удобный способ, можно отключить проверку прав, проверку на обязательные поля, отключить роботы и БП
$factory = Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
$class = $factory->getDataClass();
$saveResult = $class::update($idDeal, $dealFields);