<?php

class upload{
    const   POLICY_KEEP = 1,
            POLICY_OVERWRITE = 2,
            POLICY_RENAME = 3,
            MIN_OWN_ERROR = 1000;

    private $error = 0,
            $file,
            $input,
            $maxSize = 0,
            $name,
            $policy = self::POLICY_OVERWRITE,
            $savedName = '',
            $target = '/home/ubuntu/imagenes/',
            $type = '';

    function __construct($input) {
        
        $this->input = $input;
        if ($input['name'][0] != '') {
            
            for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
                
                  if(isset($input) && $input['error'][$i] === 0 && $input['name'][$i] != '') {
                      echo 'const';
                    $this->file = $input;
                    $this->name = $this->file['name'][$i];
                    echo 'sadnsoaiud';
                    self::upload($i);
                    } 
            }
        }
        else {
            $this->error = 1;
            self::upload(0);
        }
               
    }
    
    private function __doUpload($i) {
        $result = false;
        switch($this->policy) {
            case self::POLICY_KEEP:
                $result = $this->__doUploadKeep($i);
                break;
            case self::POLICY_OVERWRITE:
                $result = $this->__doUploadOverwrite($i);
                break;
            case self::POLICY_RENAME:
                $result = $this->__doUploadRename($i);
                break;
        }
        if(!$result && $this->error === 0){
            $this->error = 4;
        }
        return $result;
    }
    
    private function __doUploadKeep($i) {
        $result = false;
        if(file_exists($this->target . $this->name) === false) {
            $result = move_uploaded_file($this->file['tmp_name'][$i], $this->target . $this->name);
        } else {
            $this->error = 3;
        }
        return $result;
    }
    
    private function __doUploadOverwrite($i) {
        return move_uploaded_file($this->file['tmp_name'][$i], $this->target . $this->name);
    }
    
    private function __doUploadRename($i) {
        $newName = $this->target . $this->name;
        if(file_exists($newName)) {
            $newName = self::__getValidName($newName);
        }
        $result = move_uploaded_file($this->file['tmp_name'][$i], $newName);
        if($result) {
            $nombre = pathinfo($newName);
            $nombre = $nombre['basename'];
            $this->savedName = $nombre;
        }
        return $result;
    }
    
    private static function __getValidName($file) {
        $parts = pathinfo($file);
        $extension = '';
        if(isset($parts['extension'])) {
            $extension = '.' . $parts['extension'];
        }
        $cont = 0;
        while(file_exists($parts['dirname'] . '/' . $parts['filename'] . $cont . $extension)) {
            $cont++;
        }
        return $parts['dirname'] . '/' . $parts['filename'] . $cont . $extension;
    }
    

    function getError() {
        
        return $this->error;
    }

    function getMaxSize() {
        return $this->maxSize;
    }
    
    function getName() {
       
        return $this->name;
    }


    function setMaxSize($size) {
        if(is_int($size) && $size > 0) {
            $this->maxSize = $size;
        }
        return $this;
    }

    function setName($name) {
        if(is_string($name) && trim($name) !== '') {
            $this->name = trim($name);
        }
        return $this;
    }

    function setPolicy($policy) {
        if(is_int($policy) && $policy >= self::POLICY_KEEP && $policy <= self::POLICY_RENAME) {
            $this->policy = $policy;
        }
        return $this;
    }

    function setTarget($target) {
        if(is_string($target) && trim($target) !== '') {
            $this->target = trim($target);
        }
        return $this;
    }

    function setType($type) {
        if(is_string($type) && trim($type) !== '') {
            $this->type = trim($type);
        }
        return $this;
    }

    function upload($i) {
        if ($this->file['size'][$i] >0) {
            SELF::__doUpload($i);
            echo'todo bien';
        }
        else{
            switch($this->error){
                case 1:
                    echo 'objeto mal construido , no existe o está vacio';
                    break;
                case 2:
                    echo 'objeto mal construido';
                    break;
                case 3:
                    echo 'UPLOAD KEEP ERROR';
                    break;
                case 4:
                    echo 'DO UPLOAD ERROR';
                    break;
                default:
                    echo 'El fichero no existe o está vacio';
                    break;
                    
            }
            
        }
       
    }
}
