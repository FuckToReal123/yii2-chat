<?php


namespace tests\user;

use app\models\LoginForm;
use app\models\User;
use \PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /** @var string username админа */
    const ADMIN_NAME = 'admin';
    /** @var int id админа */
    const ADMIN_ID = 1;
    /** @var string пароль админа */
    const ADMIN_PASS = 'adminPass';

    /** @var User */
    private $model;
    /** @var LoginForm */
    private $form;

    /**
     * {@inheritDoc}
     */
    protected function setUp (): void
    {
        $this->model = new User();
        $this->form = new LoginForm();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown (): void
    {
        unset($this->model);
        unset($this->form);
    }

    public function testHasAdmin ()
    {
        $model = $this->model->find()->where(['username' => self::ADMIN_NAME])->one();

        $this->assertNotNull($model);
    }

    public function testLoginAdmin ()
    {
        $this->form->username = self::ADMIN_NAME;
        $this->form->password = self::ADMIN_PASS;

        $this->assertTrue($this->form->login());
    }

    public function testIncorrectLogin ()
    {
        $this->form->username = 'incorrectUser';
        $this->form->password = 'incoorectPass';

        $this->assertFalse($this->form->login());
    }
}
