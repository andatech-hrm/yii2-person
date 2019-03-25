<?php

namespace andahrm\person\api;

use Yii;
use andahrm\person\models\Address;

class Model extends \yii\base\Object {

    public $_model;
    public $noImg = 'no-pic.jpg';

    public function __construct($arg) {
        foreach ($arg as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getModel() {
        return $this->_model;
    }

    public function getFullname($lang = 'th') {
        if ($this->_model == null) {
            return Yii::$app->user->identity->username;
        }
        switch ($lang) {
            case 'en' : $fullname = $this->_model->firstname_en . ' ' . $this->_model->lastname_en;
                break;
            default : $fullname = $this->_model->firstname_th . ' ' . $this->_model->lastname_th;
                break;
        }
        return $fullname;
    }

    public function getAddress($type = Address::TYPE_CONTACT) {
        switch ($type) {
            case Address::TYPE_BIRTH_PLACE : $address = $this->_model->addressBirthPlace;
                break;
            case Address::TYPE_REGISTER : $address = $this->_model->addressRegister;
                break;
            default : $address = $this->_model->addressContact;
                break;
        }
        if ($address === null) {
            return null;
        }

        $arr[] = $address->number;
        $arr[] .= (!empty($address->sub_road)) ? 'ซ.' . $address->sub_road : '';
        $arr[] .= (!empty($address->road)) ? 'ถ.' . $address->road : '';
        $arr[] .= (!empty($address->tambol_id)) ? 'ต.' . $address->tambol->name : '';
        $arr[] .= (!empty($address->amphur_id)) ? 'อ.' . $address->amphur->name : '';
        $arr[] .= (!empty($address->province_id)) ? 'จ.' . $address->province->name : '';

        return implode(" ", $arr);
    }

    public function getPhotoLast($original = false) {
        if ($this->_model == null) {
            return '/uploads/' . $this->noImg;
        }
        $photoLast = \andahrm\person\models\Photo::find()
                ->where(['user_id' => $this->_model->user_id])
                ->orderBy(['year' => SORT_DESC])
                ->one();

        if ($photoLast === null) {
            return null;
        }

        if ($original) {
            return $photoLast->getUploadUrl('image');
        }

        return $photoLast->getUploadUrl('image_cropped');
    }

    public function getPhoto() {
        if ($this->getPhotoLast()) {
            return $this->getPhotoLast();
        } else {
            return '/uploads/' . $this->noImg;
        }
    }

    public function getRoles() {
        if ($this->_model == null) {
            $userId = Yii::$app->user->id;
        } else {
            $userId = $this->_model->user_id;
        }
        $roles = [];
        foreach (Yii::$app->authManager->getRolesByUser($userId) as $key => $role) {
            $roles[$key] = ucfirst($role->description);
        }

        return $roles;
    }

    public function getPosition() {
        return $this->_model->position ? $this->_model->position->title : null;
    }

    public function getPositionId() {
        return $this->_model->position_id;
    }

    public function getStatus() {
        return $this->_model->status;
    }

    public function getStatusLable() {
        return $this->_model->status ? $this->_model->statusLabel : '';
    }

    public function getUser_Id() {
        return $this->_model->user_id;
    }

    public function getSection() {
        return $this->_model->position && $this->_model->position->section ? $this->_model->position->section->title : null;
    }

    public function getSectionId() {
        return $this->_model->position && $this->_model->position->section ? $this->_model->position->section_id : null;
    }

    public function getRetired() {
        return $this->_model->retired;
    }

}
