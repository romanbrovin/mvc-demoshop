<?php

namespace app\controllers;

use app\models\User;

class UserController extends AppController
{

    public function logoutAction()
    {
        session_destroy();
        redirect('/login');
    }

    public function recoveryAction()
    {
        if (isAuth()) {
            redirect('/settings');
            exit;
        }

        if (isAjax() && isToken()) {
            $user = new User();
            $user->loadVars($_POST);

            $user->requiredVars = [
                'email',
                'captcha',
            ];

            if ($user->validateRequiredVars() && $user->checkExistEmail()) {
                $user->recovery();
                echo json_encode('ok');
            } else {
                echo json_encode($user->errors);
            }

            exit;
        }

        $meta = [
            'title' => 'Восстановление пароля',
            'robots' => 'noindex, nofollow',
            'breadcrumb' => '
                    <li class="breadcrumb-item"><a href="/login">Войти в кабинет</a></li>
                    <li class="breadcrumb-item active">Восстановление пароля</li>',
        ];

        $this->set(compact(['meta']));
    }

    public function signupAction()
    {
        if (isAuth()) {
            redirect('/login');
            exit;
        }

        if (isAjax() && isToken()) {
            $user = new User();
            $user->loadVars($_POST);

            $user->requiredVars = [
                'surname',
                'name',
                'email',
                'phone',
                'password',
                'captcha',
                'legal',
            ];

            if ($user->validateRequiredVars() && $user->checkUniqueEmail()) {
                $user->signup();
                $user->login();
                echo json_encode('ok');
            } else {
                echo json_encode($user->errors);
            }

            exit;
        }

        $meta = [
            'title' => 'Регистрация',
            'robots' => 'noindex, nofollow',
            'breadcrumb' => '
                    <li class="breadcrumb-item"><a href="/login">Войти в кабинет</a></li>
                    <li class="breadcrumb-item active">Регистрация</li>',
        ];

        $this->set(compact(['meta']));
    }

    public function loginAction()
    {
        if (isAuth()) {
            if (isAdmin()) {
                redirect('/adm');
            } else {
                redirect('/cabinet');
            }

            exit;
        }


        if (isAjax() && isToken()) {
            $user = new User();
            $user->loadVars($_POST);

            $user->requiredVars = [
                'email',
                'password',
            ];


            if ($user->validateRequiredVars() && $user->checkEmailAndPassword()) {
                $user->login();
                echo json_encode('ok');
            } else {
                echo json_encode($user->errors);
            }

            exit;
        }

        $meta = [
            'title' => 'Вход в личный кабинет',
            'robots' => 'noindex, nofollow',
            'breadcrumb' => '<li class="breadcrumb-item active">Войти в кабинет</li>',
        ];

        $this->set(compact(['meta']));
    }

    public function settingsAction()
    {
        if (!isAuth()) {
            redirect('/login');
            exit;
        }

        if (isAjax() && isToken()) {
            $user = new User();
            $user->loadVars($_POST);

            $user->requiredVars = [
                'surname',
                'name',
                'phone',
            ];

            if ($user->validateRequiredVars()) {
                $user->update();

                // введен старый пароль
                if ($user->vars['password'] != '') {
                    $user->requiredVars = [
                        'password',
                        'password_new',
                    ];

                    if ($user->validateRequiredVars() && $user->verifyPassword()) {
                        $user->setNewPassword();

                        echo json_encode('ok');
                    } else {
                        echo json_encode($user->errors);
                    }
                } else {
                    echo json_encode('ok');
                }
            } else {
                echo json_encode($user->errors);
            }

            exit;
        }

        $meta = [
            'title' => "Настройки",
            'robots' => 'noindex, nofollow',
            'breadcrumb' => '
                <li class="breadcrumb-item"><a href="/cabinet">Личный кабинет</a></li>
                <li class="breadcrumb-item active">Настройки</li>',
        ];

        $this->set(compact(['meta',]));
    }

}