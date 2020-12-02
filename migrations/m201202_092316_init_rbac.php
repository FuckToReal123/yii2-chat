<?php

use app\models\User;
use app\rbac\UserGroupRule;
use yii\db\Migration;

/**
 * Class m201202_092316_init_rbac
 */
class m201202_092316_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $readMessages = $auth->createPermission('readMessages');
        $readMessages->description = 'Read messages in chat';
        $auth->add($readMessages);

        $sendMessages = $auth->createPermission('sendMessages');
        $sendMessages->description = 'Read and send messages in chat';
        $auth->add($sendMessages);


        $administer = $auth->createPermission('administer');
        $administer->description = 'Administer chat';
        $auth->add($administer);

        $guest = $auth->createRole('guest');
        $auth->add($guest);
        $auth->addChild($guest, $readMessages);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $sendMessages);
        $auth->addChild($user, $guest);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $administer);
        $auth->addChild($admin, $user);

        $userGroupRule = new UserGroupRule();
        $auth->add($userGroupRule);

        $guest->ruleName = $userGroupRule->name;
        $user->ruleName = $userGroupRule->name;
        $admin->ruleName = $userGroupRule->name;

        if (!$adminUser = User::findByUsername('admin')) {
            // Назначение роли админу.
            $adminUser = new User();
            $adminUser->username = 'admin';
            $adminUser->email = 'admin@admin.ru';
            $adminUser->setPassword('adminPass');
            $adminUser->generateAuthKey();
            $adminUser->save();

            $auth->assign($admin, $adminUser->id);
        } else {
            $auth->assign($admin, $adminUser->id);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
