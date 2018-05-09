<?php
/**
 * Created by whlphper.
 * User: Administrator
 * Date: 2018/5/9 0009
 * Time: 下午 12:54
 * Desc: XML 文件相关操作类
 */

class Conf{
    private $file;
    private $xml;
    private $lastmatch;
    private $xmlArray;

    public function __construct($file)
    {
        if(!file_exists($file)){
            throw new FileException($file.'file not exists');
        }
        $this->file = $file;
        $this->xml = simplexml_load_file($file);
        if(!is_object($this->xml)){
            throw new XmlException(libxml_get_last_error());
        }
        if(!count($this->xml->xpath("/conf"))){
            throw new ConfException("conf node does not exists");
        }
    }

    function write()
    {
        if(!is_writeable($this->file)){
            throw new FileException($this->file.'is not writeable');
        }
        file_put_contents($this->file,$this->xml->asXML());
    }

    function get($str)
    {
        $matchs = $this->xml->xpath("/conf/item[@name=\"$str\"]");
        if(count($matchs)){
            $this->lastmatch = $matchs[0];
            return (string)$matchs[0];
        }
        return null;
    }

    function set($key,$value)
    {
        if(!is_null($this->get($key))){
            $this->lastmatch[0] = $value;
            return;
        }
        $conf = $this->xml->conf;
        $this->xml->addChild('item',$value)->addAttribute('name',$key);
    }

    function getXmlTostring()
    {

    }
}

class XmlException extends Exception{

    private $error;

    function __construct(LibXMLError $error)
    {
        $shortFile = basename($error->file);
        $msg = "[{$shortFile}, line {$error->line} , col {$error->column}] {$error->message}";
        $this->error = $error;
        parent::__construct($msg, $error->code);
    }
}

class FileException extends Exception{}
class ConfException extends Exception{}

class Runner{
    static function init()
    {
        try{
            $conf = new Conf(dirname(__FILE__).'/conf/conf01.xml');
            print "user:".$conf->get('user');
            $conf->set('newpass','newpass');
            $conf->write();
        }catch(FileException $e){
            echo $e->getMessage();
        }catch(XmlException $e){
            echo $e->getMessage();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
}

$res = Runner::init();