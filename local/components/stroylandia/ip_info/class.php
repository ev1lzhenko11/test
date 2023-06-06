<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Error;
use Bitrix\Main\Web\HttpClient;

/**
 * Class GetIPInfo
 */
class GetIPInfo extends CBitrixComponent
{
    private $HLBLOCK_ID;
    private $ENTITY;
    private $ENTITY_DATA_CLASS;

    /**
     * GetIPInfo constructor.
     * @param CBitrixComponent|null $component
     */
    public function __construct(?CBitrixComponent $component = null)
    {
        parent::__construct($component);
        $this->errorCollection = new ErrorCollection;
    }

    /**
     * @param $arParams
     * @return array
     */
    public function onPrepareComponentParams($arParams): array
    {
        return $arParams;
    }

    public function executeComponent(): void
    {
        if (CModule::IncludeModule('highloadblock')) {
            if ($this->ENTITY = $this->getEntity()) {
                $this->getRequest();
                if ($this->arResult["REQUEST"]["action"] === 'searchIP') {
                    if($this->validateIP($this->arResult["REQUEST"]["IP"])) {
                        if($result = $this->searchIPTable($this->arResult["REQUEST"]["IP"])) {
                            $result['UF_IPSTACK'] = json_decode($result['UF_IPSTACK'], true);
                            $this->arResult['IP_INFO'] = $result;
                        } else {
                            $response = $this->getIPstack($this->arResult["REQUEST"]["IP"]);
                            $responseArray = json_decode($response, true);
                            if ($responseArray['success'] !== false) {
                                $this->addIPTable($this->arResult["REQUEST"]["IP"], $response);
                            } else {
                                $this->arResult['ERRORS'][] = $responseArray['error']['info'];
                            }
                        }
                    } else {
                        $this->arResult['ERRORS'][] = 'Введенный IP адрес не прошел проверку валидации';
                    }
                }
                $this->includeComponentTemplate();
            }
        } else {
            $this->__showError('Модуль highloadblock не найден.');
        }
    }

    public function getIPstack($IP)
    {
        $httpClient = new HttpClient();
        return $httpClient->get('http://api.ipstack.com/'.$IP.'?access_key='.$this->arParams['IPSTACK_KEY'].'');
    }

    public function addIPTable($IP, $INFO)
    {
        $arr = [
            "UF_IP" => $IP,
            "UF_IPSTACK" => $INFO
        ];
        $this->ENTITY_DATA_CLASS::add($arr);
        $arr['UF_IPSTACK'] = json_decode($arr['UF_IPSTACK'], true);
        $this->arResult['IP_INFO'] = $arr;
    }

    public function searchIPTable($IP)
    {
        $rsData = $this->ENTITY_DATA_CLASS::getList(array(
            'select' => array('UF_IP', 'UF_IPSTACK'),
            'filter' => array('UF_IP' => $IP)
        ));
        if($el = $rsData->fetch()){
            return $el;
        } else {
            return false;
        }
    }

    public function validateIP($IP)
    {
        return boolval(filter_var($IP, FILTER_VALIDATE_IP));
    }

    public function getEntity()
    {
        $rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter'=>array('NAME'=>$this->arParams['ENTITY_NAME'])));
        if ( !($arData = $rsData->fetch()) ){
            $this->__showError('Хайлоад "'.$this->arParams['ENTITY_NAME'].'" не найден.');
            return false;
        } else {
            $this->HLBLOCK_ID = $arData['ID'];
            $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arData);
            $this->ENTITY_DATA_CLASS = $entity->getDataClass();
            return $entity;
        }
    }

    public function getRequest()
    {
        $this->arResult['REQUEST'] = \Bitrix\Main\Context::getCurrent()->getRequest()->getPostList()->toArray();
    }
}


