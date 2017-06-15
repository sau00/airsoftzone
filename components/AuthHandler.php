<?php
namespace app\components;

use app\models\Auth;
use app\models\User;
use app\models\Users;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();
        $email = ArrayHelper::getValue($attributes, 'email');
        $user_id = ArrayHelper::getValue($attributes, 'id');
        $nickname = ArrayHelper::getValue($attributes, 'login');

        $user = Users::findOne(['vk' => ArrayHelper::getValue($attributes, 'uid')]);

        $user->save();

        if($user) {
            $user->firstname = ArrayHelper::getValue($attributes, 'first_name');
            $user->lastname = ArrayHelper::getValue($attributes, 'last_name');
        } else {
            $user = new Users();
            $user->vk = ArrayHelper::getValue($attributes, 'uid');
            $user->firstname = ArrayHelper::getValue($attributes, 'first_name');
            $user->lastname = ArrayHelper::getValue($attributes, 'last_name');
        }

        $user->save();

        Yii::$app->user->login($user);

        Yii::$app->getResponse()->redirect(['profile/index']);
    }
}