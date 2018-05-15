<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 21:38
 */
require_once ('Collection.php');
class Singer{

    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

}

class NightClub{

    public $name;
    public $singers;

    public function __construct($name)
    {
        $this->name = $name;
        $this->singers = new Collection();
        $this->singers->setLoadCallback('loadSingers',$this);
    }

    public function loadSingers(Collection $col)
    {
        print "(We're loading the singers!)<br />";
        $col->addItem(new Singer('Frank Sinatra'));
        $col->addItem(new Singer('Dean Martin'));
        $col->addItem(new Singer('Sammy Davis, Jr.'));
    }
}

$objNightClub = new NightClub('The Sands');
print "Welcome to ".$objNightClub->name . "<br>";
print "We have ".$objNightClub->singers->length() . " singers " . "for your listening pleasure this evening ";