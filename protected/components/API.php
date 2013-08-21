<?php

/**
 * API is helper class for common API functionalities.
 * @author Ramkrishna Chaulagain <rkcbabu@gmail.com>
 */
class API {

    /**
     * Import file from defined system's location eg: root/protected/data/c4_local.csv 
     * @return array File import status.
     */
    public static function importFile() {
        set_time_limit(0);
        //@unlink(Yii::getPathOfAlias('application') . DIRECTORY_SEPARATOR . 'runtime' . DIRECTORY_SEPARATOR . 'keyword.log');
            $cErrors = array();
            $ccErrors = array();
            $kErrors = array();
                if (($handle = fopen(Yii::getPathOfAlias('application.data').DIRECTORY_SEPARATOR.'uploaded.csv', "r")) !== FALSE) {
                    $columns = array();
                    while (($row = fgetcsv($handle, 0, ",")) !== FALSE) {
                        if (empty($columns)) {
                            $columns = $row;
                            continue;
                        }
                        $recipe_id = str_replace('http://www.yummly.com/recipe/', '', $row[2]);
                        $recipe_ids = explode('?', $recipe_id);
                        $json = file_get_contents('http://api.yummly.com/v1/api/recipe/'.$recipe_ids[0].'?_app_id='.Yii::app()->params->_app_id.'&_app_key='.Yii::app()->params->_app_key);
                        
                    }
                    fclose($handle);
                } else {
                    echo 'can"t read file ';
                }
            Main::out($cErrors);
            Main::out($ccErrors);
            Main::out($kErrors);
            exit;
    }
    public static function importFile1() {
        set_time_limit(0);
        //@unlink(Yii::getPathOfAlias('application') . DIRECTORY_SEPARATOR . 'runtime' . DIRECTORY_SEPARATOR . 'keyword.log');
        try {
            $cErrors = array();
            $ccErrors = array();
            $kErrors = array();
            for ($i = 1; $i <= 8; $i++) {
                if (($handle = fopen(Yii::getPathOfAlias('application.data.samples').DIRECTORY_SEPARATOR.'cikupa' . $i . '.csv', "r")) !== FALSE) {
                    $columns = array();
                    while (($row = fgetcsv($handle, 0, ",")) !== FALSE) {
                        if (empty($columns)) {
                            $columns = $row;
                            continue;
                        }
                        $customer = new Customers;
                        $customer->cust_name = $row[1];
                        $customer->cust_address = $row[2]?$row[2]:$row[3];
                        $customer->cust_phone = $row[3];
                        $customer->cust_terms = 14;
                        $customer->cust_limit = 0;
                        $customer->cust_status_id = 1;
                        $customer->deposit = 0;
                        $kecamatan = Kecamatan::model()->findByAttributes(array('kecamatan_name' => $row[6]));
                        if ($kecamatan == NULL):
                            if(!$row[6]):
                            $kErrors[$i][$row[0]] = $row[6];
                            endif;
                        else:
                            $customer->cust_kecamatan = $kecamatan->id;
                        endif;
                        $customer->save();
                        
                        if ($customer->hasErrors()):
                            $cErrors[$i][$row[0]] = $customer->getErrors();
                        endif;
                        
                        if ($row[4]):
                            $contact = new CustomersContact;
                            $contact->customer_id = $customer->id;
                            $contact->custc_contactname = $row[1];
                            $contact->custc_title = $row[1];
                            $contact->custc_phone = $row[3];
                            $contact->custc_mobile = $row[4];
                            $contact->custc_status_id = 1;
                            $contact->save();
                            if ($contact->hasErrors()):
                                $ccErrors[$i][$row[0]] = $contact->getErrors();
                            endif;
                        endif;
                    }
                    fclose($handle);
                } else {
                    echo 'can"t read file ';
                }
            }
            Main::out($cErrors);
            Main::out($ccErrors);
            Main::out($kErrors);
            exit;
        } catch (Exception $e) {
            //API::log($e->getMessage(), 'importcsv');
            return FALSE;
        }
    }

}