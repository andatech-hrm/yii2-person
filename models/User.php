<?php
namespace  andahrm\person\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;

use \anda\user\models\Profile;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends \anda\user\models\User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username' ], 'required'],
            ['status', 'default', 'value' => self::STATUS_WAITING],
            ['status', 'in', 'range' => [
                self::STATUS_ACTIVE,
                self::STATUS_WAITING,
                self::STATUS_BANNED,
                self::STATUS_DELETED
            ]],

            [['currentPassword', 'newPassword', 'newPasswordConfirm'], 'required', 'on' => 'changePassword'],
            [['newPassword', 'newPasswordConfirm'], 'required', 'on' => 'create'],
            [['currentPassword'], 'validateCurrentPassword'],
            [['newPassword', 'newPasswordConfirm'], 'string', 'min'=>3,],
            [['newPassword', 'newPasswordConfirm'], 'filter', 'filter'=>'trim',],
            ['newPasswordConfirm', 'compare', 'compareAttribute'=>'newPassword', 'message'=>"Passwords don't match"],
            [['username', 'email'], 'unique'],
        ];
    }

  
}
