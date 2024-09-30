<x-app-layout>

    <div class="container">
        @if(session('message'))
            <div class="mb-2">
                {{session('message')}}
            </div>
        @endif

        <div class="mb-2">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Название</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Количество</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                @if(!empty($products))
                    @foreach($products as $product)
                        <tr>
                            <form method="POST" action="{{ route('addToBasket') }}">
                                @csrf

                                <input type="hidden" name="prod_id" value="{{$product->id}}">
                                <td scope="row">{{$product->name}}</td>
                                <td>{{$product->price}}</td>
                                <td><input type="number" name="quantity" value="1" required></td>
                                <td>
                                    <button type="submit"> Добавить в корзину</button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                @endif

            </table>
        </div>
    </div>

</x-app-layout>
