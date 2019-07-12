<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;

/**
 * Class UsersController.
 *
 * @package namespace App\Http\Controllers;
 */
class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserValidator
     */
    protected $validator;

    /**
     * UsersController constructor.
     *
     * @param UserRepository $repository
     * @param UserValidator $validator
     */
    public function __construct(UserRepository $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return UserResource
     */
    public function show($id)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $user = $this->repository->with(['city.province'])->find($id);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest $request
     * @param  string            $id
     *
     * @return UserResource
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(UserUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $photoUrl = null;
            if (empty($request->photo)) {
                if (!empty(Auth::user()->photo_url)) {
                    $path = public_path('/images/users/' . Auth::user()->photo_url);
                    unlink($path);
                }
            } else {
                if (is_file($request->photo)) {
                    $filename = md5(uniqid(rand(), true)) . '.' . $request->photo->getClientOriginalExtension();
                    $path = 'images/users/' . $filename;
                    if (Image::make($request->photo->getRealPath())->save($path)) {
                        $photoUrl = $filename;
                    }
                } else {
                    $photoUrl = $request->photo;
                }
            }

            $request->merge([
                'photo_url' => $photoUrl
            ]);

            $user = $this->repository->update($request->all(), $id);

            DB::commit();

            return ($this->show($user->id))->additional(['success' => true, 'message' => 'User updated.']);
        } catch (ValidatorException $e) {
            DB::rollback();
            return response()->json([
                'success'   => false,
                'message' => $e->getMessageBag()
            ]);
        }
    }

    /**
     * Update Password
     *
     * @param Requests\UserPasswordUpdateRequest $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function updatePassword(Requests\UserPasswordUpdateRequest $request) {
        try {
            DB::beginTransaction();
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);


            $request->merge([
                'password' => Hash::make($request->password)
            ]);

            $user = $this->repository->update($request->all(), Auth::user()->id);

            DB::commit();

            return ($this->show($user->id))->additional(['success' => true, 'message' => 'User updated.']);
        } catch (ValidatorException $e) {
            DB::rollback();
            return response()->json([
                'success'   => false,
                'message' => $e->getMessageBag()
            ]);
        }
    }

}
