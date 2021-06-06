<?php


namespace App\Core;


use App\Models\User;

class Authentication
{

    public static function authenticate(string $username, string $password): bool
    {

        $user = User::findByUsername($username);

        if (!is_null($user)) {

            if (password_verify($password, $user->password)) {

                self::initUserSession($user);
                return true;

            }

        }

        return false;


    }


    private static function initUserSession(User $user)
    {
        $_SESSION['user'] = [
            'username' => $user->username,
            'display_name' => $user->display_name,
            'role' => $user->role
        ];
    }

    /**
     * @param string $access
     * @return bool
     */
    public static function isAuthenticated($access = User::ROLE_USER): bool
    {
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['role'] == $access) {
                return true;
            }
        }

        return false;
    }


    public static function isLoggedInOrRedirect()
    {

        if (!(self::isAuthenticated(User::ROLE_ADMIN) || self::isAuthenticated(User::ROLE_USER) || self::isAuthenticated(User::ROLE_MANAGER))) {
            App::redirect('/login.php');
        }

    }


    public static function isAdminOrRedirect(bool $debug = false)
    {

        if ($debug) return;

        if (!self::isAuthenticated(User::ROLE_ADMIN)) {
            App::redirect('/login.php');
        }
    }

    public static function isManagerOrRedirect()
    {
        if (!(self::isAuthenticated(User::ROLE_ADMIN) || self::isAuthenticated(User::ROLE_MANAGER))) {
            App::redirect('/login.php');
        }
    }

    public static function isUserOrRedirect()
    {
        if (!(self::isAuthenticated(User::ROLE_ADMIN) || self::isAuthenticated(User::ROLE_USER) || self::isAuthenticated(User::ROLE_MANAGER))) {
            App::redirect('/login.php');
        }
    }


}
