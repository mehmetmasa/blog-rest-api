<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseHelper;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthorController extends Controller
{
    /*
     *
     * Author Login
     *
     */

    public function login(Request $request)
    {
        // Validate passed parameters
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        // Get the user with the email
        $author = Author::where('username', $request['username'])->first();

        // check is user exist
        if (!isset($author))
        {
            return ResponseHelper::response(false,'Author does not exist with this details');
        }

        // confirm that the password matches
        if (!Hash::check($request['password'], $author['password']))
        {
            return ResponseHelper::response(false,'Incorrect author credentials');
        }

        // Generate Token
        $token = $author->createToken('AuthToken')->accessToken;

        // Add Generated token to user column
        Author::where('username', $request['username'])->update(array('api_token' => $token));

        return ResponseHelper::response(
            true,
            'Author Login',
            [
                'user' => $author,
                'api_token' => $token
            ]
        );
    }

    /*
    *
    *  Author Register
    *
    */

    public function register(Request $request)
    {

        $this->validate($request,[
            'name' => 'required|max:50',
            'username' => 'required|max:50|unique:authors,username,',
            'password' => 'required|max:60|required_with:password_confirmation|same:password_confirmation',
        ]);

        $authorRegister = new Author();
        $authorRegister->name = $request->name;
        $authorRegister->username = $request->username;
        $authorRegister->password = app('hash')->make($request->password);
        $authorRegister->situation = AUTHOR_ACTIVE;
        $authorRegister->save();

        if (!$authorRegister)
        {
            return ResponseHelper::response(false,'System error! Failed to create author.');
        }

        // Generate Token
        $token = $authorRegister->createToken('AuthToken')->accessToken;

        // Add Generated token to user column
        Author::where('username', $request['username'])->update(array('api_token' => $token));

        return ResponseHelper::response(
            true,
            'Register successfully',
            [
                'user' => $authorRegister,
                'api_token' => $token
            ]
        );
    }

    /*
     *
     * Show All Author
     *
     */
    public function showAllAuthor()
    {
        $authors = Author::get();
        if ($authors->isEmpty())
        {
            return ResponseHelper::response(false, 'Author not found');
        }

        return ResponseHelper::response(true, 'All Authors', $authors);
    }

    /*
     *
     *  Show One Author
     *
     */

    public function showOneAuthor($id)
    {
        $author = Author::where('id', $id)->get();

        if ($author->isEmpty())
        {
            return ResponseHelper::response(false, 'Author not found');
        }

        return ResponseHelper::response(true, 'Author Detail', $author);
    }

    /*
     *
     *  Create Author
     *
     */

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        $createAuthor = new Author();
        $createAuthor->name = $request->name;
        $createAuthor->username = $request->username;
        $createAuthor->password = app('hash')->make($request->password);
        $createAuthor->situation = AUTHOR_ACTIVE;
        $createAuthor->save();

        if (!$createAuthor)
        {
            return ResponseHelper::response(false, 'System error! Failed to create author');
        }

        // Generate Token
        $token = $createAuthor->createToken('AuthToken')->accessToken;

        // Add Generated token to user column
        Author::where('id', $createAuthor->id)->update(array('api_token' => $token));

        return ResponseHelper::response(
            true,
            'Author Added',
            [
                'author' => $createAuthor,
                'token' => $token
            ]);

    }

    /*
     *
     *  Author Update
     *
     */

    public function update(Request $request, $id)
    {
        $author = Author::where('id', $id)->get();

        if ($author->isEmpty())
        {
            return ResponseHelper::response(false, 'Author not found');
        }

        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'situation' => 'required'
        ]);


        $authorUpdate = Author::where('id', $id)
            ->update(
                [
                    'name' => $request->name,
                    'username' => $request->username,
                    'password' => app('hash')->make($request->password),
                    'situation' => $request->situation
                ]
            );


        if (!$authorUpdate)
        {
            return ResponseHelper::response(false, 'System error! Failed to update author.');
        }

        return ResponseHelper::response(true, 'Author Updated');
    }


    /*
     *
     *  Author Delete
     *
     */

    public function delete($id)
    {
        $author = Author::where('id', $id)->get();

        if ($author->isEmpty())
        {
            return ResponseHelper::response(false, 'Author not found');
        }


        $authorDelete = Author::where('id', $id)
            ->update(
                [
                    'situation' => AUTHOR_DELETE
                ]
            );

        if (!$authorDelete)
        {
            return ResponseHelper::response(false, 'System error! Failed to delete author.');
        }

        return ResponseHelper::response(true, 'Author Deleted');
    }

}
