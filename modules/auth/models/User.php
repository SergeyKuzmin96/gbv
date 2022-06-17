<?php

namespace app\modules\auth\models;

use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $password_hash
 * @property string|null $auth_key
 * @property string|null $token
 * @property string $date_add
 * @property string $USER [char(32)]
 * @property int $CURRENT_CONNECTIONS [bigint]
 * @property int $TOTAL_CONNECTIONS [bigint]
 */
class User extends UserBase implements IdentityInterface
{

    public $password;

    const SCENARIO_AUTH = 'auth';

    const SCENARIO_REGISTER = 'register';


    public function rules()
    {
        return array_merge([
            ['password', 'required'],
            [['email', 'password'], 'trim'],
            ['email','getUser', 'on' => self::SCENARIO_AUTH],
            ['password', 'validatePassword','on' => self::SCENARIO_AUTH],
            ['password', 'match', 'pattern' => '(^(?xi)
                (?=(?:.*[0-9]){2})
                (?=(?:.*[a-z]){2})
                .{6,}$
              )',
                'message' => 'Пароль должен быть 6 символов и содержать минимум 2 цифры', 'on' => self::SCENARIO_REGISTER],
            ['email', 'email'],
            ['email', 'exist', 'on' => self::SCENARIO_AUTH],
            [['email'], 'unique', 'on' => self::SCENARIO_REGISTER],
        ], parent::rules());
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors())
        {

            $user = $this->getUser($attribute);

            if (!$user->checkPassword($this->password, $user->password_hash)) {

                $this->addError($attribute, 'Пароль введен неверно!!');
            }
        }
    }

    public function getUser()
    {
        if ( !User::findOne(['email' => $this->email])){
            $this->addError('email', 'Пользователь не найден!');
            return false;
        }
        return User::findOne(['email' => $this->email]); // а получаем мы его по введенному логину
    }


    public function setRegisterScenario()
    {
        $this->setScenario(self::SCENARIO_REGISTER);
    }

    public function setAuthScenario()
    {
        $this->setScenario(self::SCENARIO_AUTH);
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public static function findIdentity($id)
    {
        return User::find()->andWhere(['id' => $id])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey(): string
    {
        return $this->auth_key;
    }



    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    private function checkPassword($password, $password_hash)
    {
        return \Yii::$app->security->validatePassword($password, $password_hash);
    }
}