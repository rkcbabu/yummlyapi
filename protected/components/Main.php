<?php

/**
 * This will handle all generic components.
 * @author Ramkrishna Chaulagain <rkcbabu@gmail.com>
 */
Class Main {

    public static function mail($name,$email,$subject,$body) {
        $name = '=?UTF-8?B?' . base64_encode($name) . '?=';
        $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        $headers = "From: $name <{$email}>\r\n" .
                "Reply-To: {$email}\r\n" .
                "MIME-Version: 1.0\r\n" .
                "Content-type: text/plain; charset=UTF-8";
        mail(Yii::app()->params['adminEmail'], $subject, $body, $headers);
    }

    public static function out($expression = null, $dump = null, $exit = null) {
        if (!is_null($dump))
            var_dump($expression);
        else {
            if ($expression == null) {
                var_dump($expression);
                $expression = $_POST;
            }
            echo '<pre>';
            print_r($expression);
            echo '</pre>';
        }
    }

    public static function thumb($model, $WSize = 50, $link = true, $print = true) {
        if ($model == null)
            return null;

        $cname = strtolower(get_class($model));

        $root = Yii::app()->params->isAdmin ? dirname(Yii::app()->baseUrl) : Yii::app()->baseUrl;

        if ($WSize <= 60)
            $size = 'small';elseif ($WSize > 60 and $WSize <= 300)
            $size = 'medium';elseif ($WSize > 300 and $WSize <= 500)
            $size = 'big';
        else
            $size = 'profile';

        //$file = $root.'/images/'.$cname.'/thumb/'.$size.'/'.$model->picture->name;
        $file = isset($model->image->name) ?
                $root . '/images/' . $cname . '/thumb/' . $size . '/' . $model->image->name :
                $root . '/images/assets/default.jpg';

        if (isset($model->title))
            $title = $model->title;
        elseif (isset($model->name))
            $title = $model->name;
        elseif (isset($model->username))
            $title = $model->username;
        elseif (isset($model->firstname))
            $title = $model->firstname;
        elseif (isset($model->company_name))
            $title = $model->company_name;
        else
            $title = $cname . '_' . $model->id;

        $image = CHtml::image($file, $cname . '_' . $model->id, array('width' => $WSize, 'title' => $title));

        if ($link) {
            /* if($cname=='individual')
              $image = CHtml::link($image,array('/'.$model->username));
              else */
            $image = CHtml::link($image, array('/' . $cname . '/' . $model->id));
        }
        if ($print)
            echo $image;
        else
            return $image;
    }

    public static function link($model = null, $print = false) {
        if ($model == null) {
            $link = Yii::app()->homeUrl;
        } else {
            $cname = strtolower(get_class($model));
            $title = ($cname == 'user') ? $model->firstname : $model->name;
            /* if (Yii::app()->params->isAdmin){
              $link = CHtml::link(ucfirst($title),dirname(Yii::app()->baseUrl).'/'.$cname.'/'.$model->id);
              }else{
              $link = CHtml::link(ucfirst($title),array('/'.$cname.'/'.$model->id));
              } */
            $link = CHtml::link(ucfirst($title), array('/' . $cname . '/' . $model->id));
        }
        if ($print)
            echo $link;
        else
            return $link;
    }

    public static function hash($security_code) {
        return sha1($security_code);
    }

    public static function adminmenu($default = null) {
        $folder = dir(Yii::getPathOfAlias('application') . '/controllers/');
        $menu = array();
        //$menu[]=array('label'=>'Frontend', 'url'=>dirname(Yii::app()->homeUrl));
        if (!Yii::app()->user->isGuest) {
            //$menu[]=array('label'=>"Dashboard", 'url'=>array('/site/index'));
            while ($folderEntry = $folder->read()) {
                $content = basename($folderEntry, 'Controller.php');
                $content = basename($content, '.');
                if ($default === null and $content == 'Site')
                    ;
                //$menu[]=array('label'=>"Dashboard", 'url'=>array('/'.strtolower($content).'/index'));
                if ($content == '.' || $content == 'Site')
                    continue;
                $menu[] = array('label' => $content, 'url' => array('/' . strtolower($content) . '/admin'));
            }
            $folder->close();
            if ($default !== null) {
                $menu[] = array('label' => 'About', 'url' => array('/site/page', 'view' => 'about'));
                $menu[] = array('label' => 'Contact', 'url' => array('/site/contact'));
            }
        }
        //$menu[]=array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest);
        //$menu[]=array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest);
        return $menu;
    }

    public static function setSession($key, $value) {
        if (!empty($key)/*  and !empty($value) */) {
            Yii::app()->user->setState($key, json_encode($value));
            return true;
        } else {
            return false;
        }
    }

    public static function getSession($key, $isArray = null) {
        return json_decode(Yii::app()->user->getState($key), $isArray);
    }

    public static function adminCLEditor($thisController, $model, $attribute) {
        $thisController->widget('frontend.extensions.cleditor.ECLEditor', array(
            'model' => $model,
            'attribute' => $attribute, //Model attribute name. Nome do atributo do modelo.
            'options' => array(
                'width' => '100%',
                'height' => '100%',
                'useCSS' => true,
            ),
            'value' => $model->{$attribute}, //If you want pass a value for the widget. I think you will. Se voc� precisar passar um valor para o gadget. Eu acho ir�.
            'htmlOptions' => array('class' => 'cleditorMain'),
        ));
    }

    public static function user() {
        if (Yii::app()->user->isGuest) {
            //$_GET['id'] must be individual id.
            if (isset($_GET['id'])) {
                return Individual::model()->findByPk($_GET['id']);
            } else {
                return null;
            }
        } else {
            return Individual::model()->findByPk(Yii::app()->user->id);
        }
    }

    public static function staticContent($key) {
        $model = StaticPages::model()->findByAttributes(array('title' => trim($key)));
        if (is_null($model)) {
            
        } else {
            echo $model->content;
        }
    }

    public static function Fdate($date) {
        return Main::date_diff($date);
    }

    public static function displayFlashes() {
        foreach (Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="nNote n' . ucfirst($key) . '"><p>' . $message . '</p></div>';
        }
    }
}
