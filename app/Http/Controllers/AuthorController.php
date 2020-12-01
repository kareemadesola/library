<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function store()
    {
        Author::create($this->validateRequest());
    }

    /**
     * @return array
     */
    private function validateRequest(): array
    {
        return \request()->validate([
            'name' => 'required',
            'dob' => 'required'
        ]);
    }
}
