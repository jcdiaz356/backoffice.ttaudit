<div>

    <div wire:init="loadPromotions">
        <div wire:loading wire:target="loadPromotions,cant,search" class="alert bg-yellow-100 rounded-lg py-5 px-6 mb-3 text-base text-yellow-700 inline-flex items-center w-full alert-dismissible fade show" role="alert">
{{--            <strong class="mr-1">Imagen cargando ! </strong> Espere un momento--}}
            <svg aria-hidden="true" class="inline w-4 h-4 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
            Cargando datos...
        </div>

    </div>
    <x-table>

        <div class="px-6 py-4 flex items-center">
            <div class="flex items-center">

                    <span>
                        mostrar
                    </span>
                <select wire:model="cant" class="mx-2 form-control" name="" id="">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <x-jet-input class="flex-1 mx-4 " type="text" placeholder="Ingresa lo que buscará" wire:model="search">
            </x-jet-input>

            {{--            @livewire('create-post')--}}
        </div>
        @if(count($promotions))
            <table class=" w-full table-auto">
                <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="w-20 py-3 px-6 text-left cursor-pointer" wire:click="order('id')">
                        ID
                        @if($sort == 'id')
                            @if($direction == 'asc')
                                <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                            @else
                                <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                            @endif
                        @else
                            <i class="fas fa-sort float-right mt-1"></i>
                        @endif
                    </th>
                    <th class="py-3 px-6 text-left text-xs cursor-pointer" wire:click="order('name')">
                        TITULO
                        @if($sort == 'name')
                            @if($direction == 'asc')
                                <i class="fas fa-sort-alpha-down-alt float-right mt-1"></i>
                            @else
                                <i class="fas fa-sort-alpha-up-alt float-right mt-1"></i>
                            @endif
                        @else
                            <i class="fas fa-sort float-right mt-1"></i>
                        @endif

                    </th>
                    <th class="py-3 px-6 text-center">Actions</th>


                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                @foreach($promotions as $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                         width="24" height="24"
                                         viewBox="0 0 48 48"
                                         style=" fill:#000000;">
                                        <path fill="#80deea" d="M24,34C11.1,34,1,29.6,1,24c0-5.6,10.1-10,23-10c12.9,0,23,4.4,23,10C47,29.6,36.9,34,24,34z M24,16	c-12.6,0-21,4.1-21,8c0,3.9,8.4,8,21,8s21-4.1,21-8C45,20.1,36.6,16,24,16z"></path><path fill="#80deea" d="M15.1,44.6c-1,0-1.8-0.2-2.6-0.7C7.6,41.1,8.9,30.2,15.3,19l0,0c3-5.2,6.7-9.6,10.3-12.4c3.9-3,7.4-3.9,9.8-2.5	c2.5,1.4,3.4,4.9,2.8,9.8c-0.6,4.6-2.6,10-5.6,15.2c-3,5.2-6.7,9.6-10.3,12.4C19.7,43.5,17.2,44.6,15.1,44.6z M32.9,5.4	c-1.6,0-3.7,0.9-6,2.7c-3.4,2.7-6.9,6.9-9.8,11.9l0,0c-6.3,10.9-6.9,20.3-3.6,22.2c1.7,1,4.5,0.1,7.6-2.3c3.4-2.7,6.9-6.9,9.8-11.9	c2.9-5,4.8-10.1,5.4-14.4c0.5-4-0.1-6.8-1.8-7.8C34,5.6,33.5,5.4,32.9,5.4z"></path><path fill="#80deea" d="M33,44.6c-5,0-12.2-6.1-17.6-15.6C8.9,17.8,7.6,6.9,12.5,4.1l0,0C17.4,1.3,26.2,7.8,32.7,19	c3,5.2,5,10.6,5.6,15.2c0.7,4.9-0.3,8.3-2.8,9.8C34.7,44.4,33.9,44.6,33,44.6z M13.5,5.8c-3.3,1.9-2.7,11.3,3.6,22.2	c6.3,10.9,14.1,16.1,17.4,14.2c1.7-1,2.3-3.8,1.8-7.8c-0.6-4.3-2.5-9.4-5.4-14.4C24.6,9.1,16.8,3.9,13.5,5.8L13.5,5.8z"></path><circle cx="24" cy="24" r="4" fill="#80deea"></circle>
                                    </svg>
                                </div>
                                <span class="font-medium">{{$item->id}}</span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <div class="flex items-start">
                                <x-jet-nav-link href="{{ route('promotions/promotions_details',['id'=>$item->id]) }}" :active="request()->routeIs('dashboard')">
                                    {{$item->name}}
                                </x-jet-nav-link>
                            </div>
                        </td>

                        <td class="py-3 px-6 ">
                            <div class="flex item-center justify-center">

                                {{--                                    @livewire('edit-post', ['post' => $item], key($item->id))--}}

                                {{--                                <a class="btn btn-green" wire:click="edit({{$item}})">--}}
                                {{--                                    <i class="fas fa-edit"></i>--}}
                                {{--                                </a>--}}

                                {{--                                <a class="btn btn-red ml-2" wire:click="$emit('deletePost',{{$item->id}})">--}}
                                {{--                                    <i class="fas fa-trash"></i>--}}
                                {{--                                </a>--}}

                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>

            {{--            //Paginador--}}
            @if($promotions->hasPages()) {{-- // Si no encuentra paginaciones entonces no muestra --}}

            <div class="px-6 py-6">
                {{$promotions->links()}} {{-- Mostrando paginador --}}
            </div>
            @endif
        @else
            <div class="px-4 py-6">
                no existe registros
            </div>
        @endif

    </x-table>
    </div>

</div>
