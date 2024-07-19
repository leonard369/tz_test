<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if (Loader::IncludeModule("iblock")) {
    $arUser = array();
    $iblock_structure = Option::get("intranet", "iblock_structure");
    $db_list = CIBlockSection::GetList(array(), array(
        "IBLOCK_ID" => $iblock_structure
    ), array(), array("UF_HEAD"));
    while ($ar_result = $db_list->GetNext()) {
        $arUser[] = $ar_result['UF_HEAD'];
    }
    $arSelectFields=array(
        'LAST_NAME', 'NAME','ID', 'PERSONAL_PHOTO'
    );
    $dbUsers = CUser::getList(
        array(),
        array(
            'ID'=>$arUser
        ),
        array(
            'SELECT'     => $arSelectFields,
            'FIELDS'     => $arSelectFields
        )
    );
    while($user=$dbUsers->Fetch()){
       
        $arResult['HEAD'][$user['ID']]=array(
          'LAST_NAME'=>$user['LAST_NAME'],
          'NAME'=>$user['NAME'],
        );
        $imageFile = CFile::GetFileArray($user['PERSONAL_PHOTO']);
        if ($imageFile !== false)
        {
            $arResult['HEAD'][$user['ID']]['PHOTO'] = CFile::ResizeImageGet(
                $imageFile,
                array("width" => 100, "height" => 100),
                BX_RESIZE_IMAGE_EXACT,
                true
            );
        }
        else{
            $arResult['HEAD'][$user['ID']]['PHOTO'] = false;
        }
    }


}
$this->IncludeComponentTemplate();