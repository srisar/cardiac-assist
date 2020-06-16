<?php


namespace App\Controllers\System;


use App\Core\App;
use App\Core\Messages\SessionError;
use App\Core\Messages\SessionForm;
use App\Core\Requests\Axios;
use App\Core\Requests\JSONResponse;
use App\Core\Requests\Request;
use App\Core\View;
use App\Models\User;

class UsersController
{




    /**
     * Process - Add a new user
     */
    public function processAddUser()
    {

        $fields = [
            'username' => Request::getAsString('username'),
            'password' => Request::getAsString('password'),
            'display_name' => Request::getAsString('display_name'),
            'role' => Request::getAsString('user_role'),
        ];

        $isValid = true;

        if ( User::findByUsername($fields['username']) ) {
            $isValid = false;
            SessionError::push('username_exists', 'Username is not available');

            SessionForm::push('username', $fields['username']);
            SessionForm::push('display_name', $fields['display_name']);


            App::redirect('/users/add');
            return;
        }

        if ( strlen($fields['password']) < 5 ) {
            $isValid = false;
            SessionError::push('password_length', 'Password cannot be less than 6 letters');

            SessionForm::push('username', $fields['username']);
            SessionForm::push('display_name', $fields['display_name']);


            App::redirect('/users/add');
            return;
        }

        if ( $isValid ) {

            $fields['password'] = hashPassword($fields['password']);
            $user = User::build($fields);

            if ( $user->insert() ) {
                App::redirect('/users');
            }

        }

    }

    public function apiProcessAddUser()
    {

        $fields = Axios::get();

        if ( User::findByUsername($fields['username']) ) {

            JSONResponse::invalidResponse(["data" => "Username is not available"]);
            return;
        }

        if ( strlen($fields['password']) < 5 ) {
            JSONResponse::invalidResponse(["data" => "Invalid password: minimum 5 characters."]);
            return;
        }

        $fields['password'] = hashPassword($fields['password']);
        $user = User::build($fields);

        if ( $user->insert() ) {
            (new JSONResponse(['data' => "User added."]))->response();
        }

    }


    public function processEditUser()
    {

        $fields = [
            'id' => Request::getAsInteger('id'),
            'username' => Request::getAsString('username'),
            'password' => Request::getAsString('password'),
            'display_name' => Request::getAsString('display_name'),
            'role' => Request::getAsString('user_role'),
        ];

        // the user tuple we are about to update
        $user = User::find($fields['id']);

        // check if new username exists for another user
        $tempUser = User::findByUsername($fields['username']);

        if ( empty($tempUser) || $tempUser->id == $user->id ) {
            // new username is available to the user,
            // proceed to update the user

            $user->username = $fields['username'];
            $user->display_name = $fields['display_name'];
            $user->role = $fields['role'];

            // check if password field is empty: keep the existing password
            // if not, update the password
            if ( !empty($fields['password']) ) {

                if ( strlen($fields['password']) < 5 ) {
                    $isValid = false;
                    SessionError::push('password_length', 'Password cannot be less than 6 letters');
                    App::redirect('/users/edit', ['id' => $user->id]);
                    return;
                }

                $fields['password'] = hashPassword($fields['password']);
                $user->password = $fields['password'];
            }

            if ( $user->update() ) {
                App::redirect('/users');
                return;
            }

        } else {
            SessionError::push('username_exists', 'Username already exists.');
            App::redirect('/users/edit', ['id' => $user->id]);
            return;
        }

    }


    public function getAllUsers()
    {


    }

}