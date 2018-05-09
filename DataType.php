<?php
/**
 * Created by whlphper.
 * User: Administrator
 * Date: 2018/5/7 0007
 * Time: 下午 1:37
 * Desc:
 */
class DataType{

    private $address = ['209.131.36.159','74.125.19.106'];

    function outputAddress($resolve)
    {
        foreach ($this->address as $address){
            print $address;
            if($resolve){
                echo 'true<br />';
                print "(".gethostbyaddr($address).")";
            }
            echo "<br />";
        }
    }
}

//数组转XML
function arrayToXml($arr)
{
    $xml = "<xml>";
    foreach ($arr as $key=>$val)
    {
        if (is_numeric($val)){
            $xml.="<".$key.">".$val."</".$key.">";
        }else{
            $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        }
    }
    $xml.="</xml>";
    return $xml;
}

//将XML转为array
function xmlToArray($xml)
{
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $values;
}
echo '<pre>';
$settings = simplexml_load_file("./settings.xml");
$manager = new DataType();
$xmlList = $settings->addAttribute('aaaaa','aaaaaa');
var_dump($settings);
var_dump($settings->aaaaa);
var_dump((bool)$settings->settings->resolvedomains);
echo($settings->settings->resolvedomains);echo '<br />';
var_dump((bool)$settings->settings->resolvedomains);exit;
$manager->outputAddress((bool)$settings->settings->resolvedomains);


/**
 * 20180507 0207  ERROR INFORMATION
 *
Deprecated: Automatically populating $HTTP_RAW_POST_DATA is deprecated and will be removed in a future version. To avoid this warning set 'always_populate_raw_post_data' to '-1' in php.ini and use the php://input stream instead. in Unknown on line 0

Warning: Cannot modify header information - headers already sent in Unknown on line 0
 */