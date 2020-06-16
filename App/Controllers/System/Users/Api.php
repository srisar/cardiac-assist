<?php


namespace App\Controllers\System\Users;


use App\Core\Requests\Axios;
use App\Core\Requests\JSONResponse;
use App\Models\User;
use Exception;

class Api
{

    public function getAll()
    {

        $users = User::findAll();

        if ( !empty($users) ) {
            (new JSONResponse(['users' => $users]))->response();
            return;
        }

        JSONResponse::invalidResponse();

    }

    public function add()
    {

        try {
            /**
             * fields: username, display_name, password, role
             */

            $fields = Axios::get();

            // check if username already exits for another user
            if ( User::findByUsername($fields['username']) ) {
                JSONResponse::invalidResponse('Username already exist');
                return;
            }

            if ( strlen($fields['password']) < 5 ) {
                JSONResponse::invalidResponse('Password cannot be less than 5 characters');
                return;
            }

            $fields['password'] = hashPassword($fields['password']);
            $user = User::build($fields);

            $id = $user->insert();

            if ( $id != false ) {

                $user = User::find($id);

                (new JSONResponse(['user' => $user]))->response();
                return;
            }


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
        }

    }

    public function edit()
    {


        try {

            /**
             * fields: id, username, password_string, conform_password_string, role
             */
            $fields = Axios::get();

            $user = User::find($fields['id']);

            if ( !empty($user) ) {

                $temp = User::findByUsername($fields['username']);

                if ( empty($temp) || $temp->id == $user->id ) {
                    // username available

                    $user->username = $fields['username'];
                    $user->display_name = $fields['display_name'];
                    $user->role = $fields['role'];

                    if ( !empty($fields['password']) ) {
                        $user->password = hashPassword($fields['password']);
                    }

                    if ( $user->update() ) {
                        JSONResponse::validResponse();
                        return;
                    }

                    JSONResponse::invalidResponse('Update failed');
                    return;
                }
                JSONResponse::invalidResponse('Username already exist');
                return;

            }
            JSONResponse::invalidResponse();
            return;


        } catch ( Exception $exception ) {
            JSONResponse::exceptionResponse($exception);
            return;
        }

    }

}