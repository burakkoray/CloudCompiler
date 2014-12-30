<?php

class DisplayController extends BaseController {
public function showoutput()
{
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'insert':
            break;
        case 'select':
            echo "dasd";
            
            break;
                             }
                            }
	
}
                                                }   


class Ds{

function select() {
	    echo "The select function is called.";

	return array('status' => 'OK');
   
}

function insert() {
    
    echo "The insert function is called.";
	return array('status' => 'OK');


}

	
}
