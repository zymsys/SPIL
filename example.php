<?php
require_once('SPIL/Loader.php');
SPIL_Loader::registerRepository('http://repo.spil.l.vicmetcalfe.com/index.php');

$s = new SPIL_DataMapper_Serialize();

$data = array('Dasher', 'Dancer', 'Prancer', 'Vixen', 'Comet', 'Cupid', 'Donner', 'Blitzen');

echo $s->output($data);
