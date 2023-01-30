<?php

namespace App\Http\Livewire\Promotions;


use App\Models\Promotion;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListPromotions extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $promotion , $image,$identificador;
    public $search = '';
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = '10';

    public $readyToLoad = false;


    public $open_edit = false;


    protected $queryString =[
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'id'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => ''],
    ];

    protected $rules = [
        'promorion.name' => 'required',
        // 'post.image' => 'required|image|max:2048'

    ];

    protected $listeners = ['render'=> 'render','delete'];



    public function mount(){

        $this->identificador = rand();
        $this->promotion = new Promotion();
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {

        if($this->readyToLoad){

            $promotions = Promotion::with('promotionDetails')->where('name','like','%' . $this->search . '%')

                ->orderBy($this->sort,$this->direction)
                    ->paginate($this->cant);
        } else{

            $promotions = [];
        }
        return view('livewire.promotions.list-promotions',compact('promotions'));
    }


    public function loadPromotions(){
        $this->readyToLoad =true;
    }

    public function order($sort){


        if ($this->sort == $sort) {
            if($this->direction == 'desc'){
                $this->direction = 'asc';
            }
            else{
                $this->direction = 'desc';
            }

        }else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }


    }




}
