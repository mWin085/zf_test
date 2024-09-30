<x-app-layout>

    <div class="container">
        @if(session('message'))
            <div class="mb-2">
                {{session('message')}}
            </div>
        @endif

        <div class="mb-2">
            <form method="POST" action="{{ route('saveOrder') }}">
                @csrf
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Название</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Количество</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    @if(!empty($basketItems))
                        @foreach($basketItems as $product)
                            <tr>
                                <td scope="row">  {{$product->name}}  </td>
                                <td><b>{{$product->price}}руб.</b></td>
                                <td>  {{ $product->quantity }} шт.</td>
                            </tr>
                        @endforeach
                    @endif

                </table>
                <div>
                    Сумма: <b>{{ number_format($sum, 2) }} руб. </b>
                </div>


                <button class="border" type="submit"> Оформить заказ</button>
            </form>
        </div>
    </div>

</x-app-layout>
