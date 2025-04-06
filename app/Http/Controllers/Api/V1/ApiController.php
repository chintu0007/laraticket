<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiController extends Controller
{
    
    use ApiResponses;
    use AuthorizesRequests; 
    
    protected $policyClass;

    public function include(string $relationship)
    {   
        $param = request()->get('include'); 
        if (!isset($param)) {
            return false;
        }              
        $includeValues = explode(',', $param);
        return in_array(strtolower($relationship), $includeValues);
    }

    public function isAble($ability, $targetModel) {
        
        try {
            return $this->authorize($ability, [$targetModel, $this->policyClass]);
            
        } catch (AuthorizationException $ex) {
            return false;
        }
    }
}
