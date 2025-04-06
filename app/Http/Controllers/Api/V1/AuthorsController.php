<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\AuthorFilter;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreAuthorRequest;
use App\Http\Requests\Api\V1\UpdateAuthorRequest;

class AuthorsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(AuthorFilter $filters)
    {
        return UserResource::collection(            
            User::select('users.*')
                ->join('tickets', 'users.id', '=', 'tickets.user_id')
                ->filter($filters)
                ->distinct()
                ->paginate()
        );

        /*if ($this->include('tickets')) {
            return UserResource::collection(User::with('tickets')->paginate());
        }
        return UserResource::collection(User::paginate()); */
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $author)
    {
        if($this->include('tickets')) {
            return new UserResource($author->load('tickets'));
        }
        return new UserResource($author);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, User $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $author)
    {
        //
    }
}
