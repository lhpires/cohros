<?php

namespace App\Http\Controllers;

use App\Models\PhoneNumber;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\Request;

class PhoneNumberController extends Controller
{
    public function destroy(PhoneNumber $phoneNumber,Request $request)
    {
        $countNumbers = PhoneNumber::query()->where('contact_id',$phoneNumber->contact_id)->count();



        if(($phoneNumber->contact->user_id !== $request->user()->id) || $countNumbers <= 1){
            return response()->json([
                'error' => 'Exclusão não permitida',
            ], 401);
        }

        $phoneNumber->delete();

        return response()->json([
            'message' => 'Número deletado',
        ], 200);
    }
    
}
