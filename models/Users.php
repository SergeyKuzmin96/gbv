<?php

namespace app\models;

use app\components\AuthComponent;
use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $password_hash
 * @property string|null $auth_key
 * @property string $date_add
 * @property string $date_update
 *
 * @property Comments[] $comments
 * @property Reviews[] $reviews
 * @property string $USER [char(32)]
 * @property int $CURRENT_CONNECTIONS [bigint]
 * @property int $TOTAL_CONNECTIONS [bigint]
 */
class Users extends ActiveRecord implements IdentityInterface
{

    public $password;

    const SCENARIO_AUTH = 'auth';

    const SCENARIO_REGISTER = 'register';


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password_hash'], 'required'],
            [['date_add', 'date_update'], 'safe'],
            [['email'], 'string', 'max' => 255],
            [['password_hash'], 'string', 'max' => 300],
            [['auth_key'], 'string', 'max' => 150],
            ['password', 'required'],
            [['email', 'password'], 'trim'],
            ['email','getUser', 'on' => self::SCENARIO_AUTH],
            ['password', 'validatePassword','on' => self::SCENARIO_AUTH],
            ['password', 'match', 'pattern' => '(^(?xi)
                (?=(?:.*[0-9]){2})
                (?=(?:.*[a-z]){2})
                .{6,}$
              )',
                'message' => Yii::t('app', 'Password must be at least 6 characters long and contain at least 2 numbers and 2 letters'), 'on' => self::SCENARIO_REGISTER],
            ['email', 'email'],
            ['email', 'exist', 'on' => self::SCENARIO_AUTH],
            [['email'], 'unique', 'on' => self::SCENARIO_REGISTER],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'date_add' => Yii::t('app', 'Date Add'),
            'date_update' => Yii::t('app', 'Date Update'),
            'password' => Yii::t('app', 'Password'),
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_update', 'date_add'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
                'value' => new Expression('NOW()')
            ],
        ];

    }

    /**
     * @throws InvalidConfigException
     */
    public function validatePassword()
    {
        if (!$this->hasErrors())
        {

            $user = $this->getUser();
            $component = Yii::createObject(['class' => AuthComponent::class]);

            if (!$component->checkPassword($this->password, $user->password_hash)) {
                $this->addError('email', Yii::t('app', 'User with such login and password was not found!'));
            }
        }
    }

    public function getUser()
    {
        if ( !Users::findOne(['email' => $this->email])){
            $this->addError('email', Yii::t('app', 'User with such login and password was not found!'));
            return false;
        }
        return Users::findOne(['email' => $this->email]);
    }



    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['user_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return Users::find()->andWhere(['id' => $id])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
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

}
