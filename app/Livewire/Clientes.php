<?php

namespace App\Livewire;

use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Clientes extends Component {

    //public $clientes;
    public $pesquisa; 
    

    public function mount(){
     
    }
  
    public function render() {

        $clientes = Cliente::where('user_id', Auth::user()->id)
        ->where(function ($query) {
            $query->where('nome', 'like', "%$this->pesquisa%")
                ->orWhere('cpf', 'like', "%$this->pesquisa%")
                ->orWhere('telefone', 'like', "%$this->pesquisa%");
        })
        ->orderBy('updated_at', 'asc')
        ->orderBy('nome', 'asc')
        ->paginate(50);
        
        return view('livewire.Clientes',compact('clientes'));
    }

    public function updatedPesquisa(){
       
        /*$this->clientes = Cliente::where('nome', 'like', "%$this->pesquisa%")
                           ->orWhere('cpf', 'like', "%$this->pesquisa%")
                           ->orWhere('telefone', 'like', "%$this->pesquisa%")
                           ->paginate(10);
*/
        $this->dispatch('recarregaLista');
    }

 
}
 