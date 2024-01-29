<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        
        $contacts = Contact::query()->where('user_id',$request->user()->id)
        ->with(['PhoneNumbers'])
        ->orderBy('id', 'asc')
        ->get();

        return response()->json([
            'contacts' => $contacts
        ], 200);
    }

    public function show(Request $request)
    {
        $contact = Contact::query()->where('user_id',$request->user()->id)
        ->where('id',$request->id)
        ->with(['PhoneNumbers'])
        ->first();

        return response()->json([
            'contact' => $contact
        ], 200);                
    }

    public function store(StoreContactRequest $contact)
    {
        $user_id = (int) $contact->user()->id;

        $validated = $contact->validated();

        $contact = new Contact();
        $contact->user_id = $user_id;
        $contact->name = $validated['name'];
        $contact->email = $validated['email'];
        $contact->address = $validated['address'];
        $contact->save();
    
        if($contact->id){

            foreach($validated['phone_numbers'] as $numbers)
            {

                $phoneNumber = new PhoneNumber();
                $phoneNumber->contact_id = $contact->id;
                $phoneNumber->number = $numbers['number'];
                $phoneNumber->save();
        
                unset($phoneNumber);
            }

        }else{
            return response()->json([
                'error' => 'Erro ao cadastrar contato',
            ], 400);
        }


        return response()
        ->json([
            'message' => 'Cadastrado com sucesso',
        ]);
    }

    public function update(StoreContactRequest $request)
    {
        
        $validated = $request->validated();
        
        $contact = Contact::query()
        ->where('user_id',$request->user()->id)
        ->where('id',$request->id)
        ->first();

        if(!$contact){
            return response()->json([
                'error' => 'Contato não encontrado',
            ], 404);
        }

        $contact->name = $validated['name'];
        $contact->email = $validated['email'];
        $contact->address = $validated['address'];
        $contact->save();


        if(count($validated['phone_numbers']) > 0){

            foreach($validated['phone_numbers'] as $numbers)
            {

                if((int) $numbers['id'] > 0){
              
                    $phoneNumber = PhoneNumber::query()->where('id',$numbers['id'])
                    ->where('contact_id',$request->id)
                    ->firstOrFail();
                    $phoneNumber->number = $numbers['number'];
                    $phoneNumber->save();
                }else{
                    // Cadastrando novo número
                    $phoneNumber = new PhoneNumber();
                    $phoneNumber->contact_id = $request->id;
                    $phoneNumber->number = $numbers['number'];
                    $phoneNumber->save();
                }
        
                unset($phoneNumber);
            }

        }

        
        // $contact->name;
        // $contact->email;
        // $contact->address;

        return response()
        ->json([
            'message' => 'Atualizado com sucesso',
        ]);
    }

    public function destroy(Contact $contact,Request $request)
    {

        if($contact->user_id !== $request->user()->id){
            return response()->json([
                'error' => 'Exclusão não permitida',
            ], 401);
        }

        $contact->delete();

        return response()->json([
            'message' => "Deletado com sucesso"
        ], 200);    
        
    }
}
