<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequst;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\StoreTicketRequest;



class AuthorTicketController extends ApiController
{
    
    public function index($author_id, TicketFilter $filters)
    {

        return TicketResource::collection(Ticket::where('user_id', $author_id)->filter($filters)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($author_id, StoreTicketRequest $request)
    {
        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $author_id
        ];

        return new TicketResource(Ticket::create($model));
    }

    public function destroy($author_id, $ticket_id)
    {
        try {
            $ticket =  Ticket::findOrFail($ticket_id);
            if ($ticket->user_id == $author_id) {
                $ticket->delete();
                return $this->ok('Ticket deleted sucessfully');
            }          
        } catch (ModelNotFoundException $e) {
            //
        }
        return $this->error('Ticket can not be found', 404);
    }

    //put
    public function replace(ReplaceTicketRequst $request, $author_id, $ticket_id) {
        //PUT      
        try {            
            $ticket = Ticket::findOrFail($ticket_id);
            if ($ticket->user_id == $author_id) {
                $ticket->update($request->mappedAttributes());    
                return new TicketResource($ticket);
            }  
            
            //TODO: ticket doesn't belong to user 
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket can not be found', 404);
        }        
    }

    public function update(UpdateTicketRequest $request, $author_id, $ticket_id)
    {
        // PATCH
        try {            
            $ticket = Ticket::findOrFail($ticket_id);
            if ($ticket->user_id == $author_id) {
                $ticket->update($request->mappedAttributes());    
                return new TicketResource($ticket);
            }  
            
            //TODO: ticket doesn't belong to user 
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket can not be found', 404);
        }  

    }
}
