<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\ReplaceTicketRequst;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Policies\V1\TicketPolicy;
use App\Traits\ApiResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Models\User;

class AuthorTicketsController extends ApiController
{
    protected $policyClass = TicketPolicy::class;

    public function index($author_id, TicketFilter $filters) {
        return TicketResource::collection(
            Ticket::where('user_id', $author_id)->filter($filters)->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request, $author_id)
    {
        if ($this->isAble('store', Ticket::class)) {
            return new TicketResource(Ticket::create($request->mappedAttributes([
                'author' => $author_id
            ])));
        }

        return $this->notAuthorized('You are not authorized to create that resource');


        // try {
        //     // policy
        //      $this->isAble('store', targetModel: Ticket::class);
 
        //      return new TicketResource(Ticket::create($request->mappedAttributes([
        //         'author' => 'user_id'
        //      ])));
        //  } catch (AuthorizationException $ex) {
        //      return $this->error('You are not authorized to create that resource', 401);
        //  }
    }

    public function replace(ReplaceTicketRequest $request, $author_id,  $ticket_id) {
        // PUT
        try {
            $ticket = Ticket::where('id', $ticket_id)
                            ->where('user_id', $author_id)
                            ->firstOrFail();

            $this->isAble('replace', $ticket);
                
            $ticket->update($request->mappedAttributes());
            return new TicketResource($ticket);
    
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found.', 404);
        } catch (AuthorizationException $ex) {
            return $this->error('You are not authorized to update that resource', 401);
        }
    }

    public function update(UpdateTicketRequest $request, $author_id,  $ticket_id) {
        // PUT
        try {
            $ticket = Ticket::where('id', $ticket_id)
                            ->where('user_id', $author_id)
                            ->firstOrFail();

            $this->isAble('update', $ticket);

            $ticket->update($request->mappedAttributes());
            return new TicketResource($ticket);    
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found.', 404);
        } catch (AuthorizationException $ex) {
            return $this->error('You are not authorized to update that resource', 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $author, Ticket $ticket)
    { 
        // try {
        //     $ticket = Ticket::where('id', $ticket_id)
        //                     ->where('user_id', $author_id)
        //                     ->firstOrFail();

        //     $this->isAble('delete', $ticket);

        //     $ticket->delete();
        //     return $this->ok('Ticket successfully deleted');            
        // } catch (ModelNotFoundException $exception) {
        //     return $this->error('Ticket cannot found.', 404);
        // } catch (AuthorizationException $ex) {
        //     return $this->error('You are not authorized to delete that resource', 401);
        // }

        if ($this->isAble('delete', $ticket)) {
            $ticket->delete();
            return $this->ok('Ticket successfully deleted');       
        }

        return $this->notAuthorized('You are not authorized to delete that resource');
    }
}