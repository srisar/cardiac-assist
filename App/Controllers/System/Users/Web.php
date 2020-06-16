<?php


namespace App\Controllers\System\Users;


use App\Core\App;
use App\Core\Requests\Request;
use App\Core\View;
use App\Models\User;

class Web
{
    /**
     * View - Display all users page
     */
    public function viewUsers()
    {

        $users = User::findAll();

        View::setData('users', $users);
        View::render("system/users/index.view");
    }


    /**
     * View - Display add new user page
     */
    public function viewAddUser()
    {
        View::render('system/users/add.view');
    }

    /**
     * View - Display edit user page
     */
    public function viewEditUser()
    {

        $id = Request::getAsInteger('id');

        if ( is_null($id) ) {
            App::redirect('/');
            return;
        }

        $user = User::find($id);

        if ( empty($user) ) {
            App::redirect('/');
            return;
        }

        View::setData('user', $user);
        View::render('system/users/edit.view');


    }
}