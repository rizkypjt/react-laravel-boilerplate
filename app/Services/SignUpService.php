<?php

namespace App\Services;

use App\Contracts\Repository\UserRepositoryContract as UserRepository,
    Illuminate\Contracts\Validation\Factory as Validator,
    Illuminate\Validation\ValidationException;

class SignUpService {
  private $validator;
  private $user;

  public function __construct(Validator $validator, UserRepository $user)
  {
    $this->validator = $validator;
    $this->user = $user;
  }

  public function signUp($data)
  {
    $validateSignupData = $this->validator->make($data, [
      'first_name' => 'required',
      'last_name' => 'required',
      'email' => 'required|email',
      'password' => 'required'
    ]);

    if($validateSignupData->fails()) {
      throw new ValidationException($validateSignupData);
    }

    $this->user->create($data);

    return $this->user;
  }
}