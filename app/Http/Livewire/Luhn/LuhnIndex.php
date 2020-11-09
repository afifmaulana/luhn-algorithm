<?php

namespace App\Http\Livewire\Luhn;

use CreditCardValidator;
use Faker\Calculator\Luhn as LuhnAlgortihm;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class LuhnIndex extends Component
{
    public $cc, $expiry_cc, $date, $cvv;

    public function render()
    {
        return view('livewire.luhn.luhn-index');
    }

    public function store()
    {
        $valid = LuhnAlgortihm::isValid($this->cc);

        dd($valid);
    }

    public function create(Request $request){
        $this->validate($request, [
          'vendor' => 'required',
          'cvv' => 'required|max:3',
          'card' => 'required|numeric'
        ]);

        $card = $request->card;
        $validator = CreditCardValidator::make(['visa','mastercard','american-express']);
        $cardType = $validator->getType($card);
        if($cardType){
          return $cardType->getType();
        }else {
          return "card number invalid";
        }

      }
}
