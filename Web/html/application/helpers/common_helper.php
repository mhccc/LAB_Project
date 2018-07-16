<?php
defined('BASEPATH') OR exit('No direct script access allowed');
function enumToInt($str){
        switch ($str) {
                case 'Y':
                        return 1;
                        break;

                case 'N':                       
                default:
                        return 0;
                        break;
        }
}

?>