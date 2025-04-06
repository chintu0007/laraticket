<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Models\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\User;
use App\Policies\V1\TicketPolicy;
use App\Traits\ApiResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketController extends ApiController
{

    protected $policyClass = TicketPolicy::class;
    public function index(TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::filter($filters)->paginate());
    }

    public function create() {}

    public function store(StoreTicketRequest $request)
    {
        try {
            User::findOrFail($request->input('data.relationships.author.data.id'));
            // policy
            $this->isAble('store', null);

            //TODO - create ticket

        } catch (ModelNotFoundException $e) {
            return $this->ok('User Not Found', [
                'error' => 'The provided user id does not exists'
            ]);
        }

        return new TicketResource($request->mappedAttributes());
        //return new TicketResource(Ticket::create($request->mappedAttributes()));
    }

    public function show(Ticket $ticket)
    {   
        if ($this->include('author')) {
            return new TicketResource($ticket->load('author'));
        }

        return new TicketResource($ticket);       
        
    }

    public function edit(Ticket $ticket)
    {
        //
    }
    public function update(UpdateTicketRequest $request, $ticket_id)
    {
        // PATCH
        try {
            $ticket = Ticket::findOrFail($ticket_id);
            //policy
            $this->isAble('update', $ticket);            
            $ticket->update($request->mappedAttributes());    
            return new TicketResource($ticket);
            
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket can not be found', 404);
        } catch (AuthorizationException $e) {
            
            //_pr($e->getMessage());
            return $this->error('You are not authorized to update that resource', 401);
        }

    }

    public function replace(ReplaceTicketRequest $request, $ticket_id) {
        //PUT
        try {
            $ticket = Ticket::findOrFail($ticket_id);

            // policy
            $this->isAble('replace', $ticket);

            $ticket->update($request->mappedAttributes());    
            return new TicketResource($ticket);            
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket can not be found', 404);
        }        
    }

    public function destroy(Ticket $ticket)
    {
        // try {
        //     $ticket =  Ticket::findOrFail($ticket_id);

        //     // policy
        //     $this->isAble('delete', $ticket);

        //     $ticket->delete();
        //     return $this->ok('Ticket deleted sucessfully');
        // } catch (ModelNotFoundException $e) {
        //     return $this->error('Ticket can not be found', 404);
        // }
        
        if ($this->isAble('delete', $ticket)) {
            $ticket->delete();

            return $this->ok('Ticket successfully deleted');
        }

        return $this->notAuthorized('You are not authorized to delete that resource');
    }
}