<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Http\Transformers\V2\UserTransformer;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

/**
 * User resource representation. Version 2
 *
 * @Resource("Users", uri="/users")
 */
class UserController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the users.
     *
     * @Get("/")
     * @Versions({"v2"})
     * @return \Illuminate\Http\Response
     * @Parameters({
     *      @Parameter("include", description="The entities to load per listing.", default=false),
     * })
     */
    public function index()
    {
        $users = \App\User::paginate(25);

        return $this->response->paginator($users, new UserTransformer);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     * @Post("/")
     * @Versions({"v2"})
     * @Request("username=foo&email=valid@email.com", contentType="application/x-www-form-urlencoded")
     * @Response(200, body={"id": 10, "username": "foo", "email": "valid@email.com"})
     */
    public function store(UserRequest $request)
    {
        return \App\User::create($request->only('name', 'email'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->response->item(\App\User::findOrFail($id), new UserTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = \App\User::findOrFail($id);

        $user->fill($request->only('name', 'email'));

        $user->save();

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return \App\User::destroy($id);
    }
}
