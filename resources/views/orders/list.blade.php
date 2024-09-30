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
                @if(!empty($orders))
                    @foreach($orders as $order)
                        <tr>

                            <input type="hidden" name="prod_id" value="{{$order->id}}">
                            <td scope="row">{{$order->product_list}}</td>
                            <td>{{$order->price}}</td>
                            <form method="POST" action="{{ route('removeOrder',['id' => $order->id]) }}">
                                @csrf
                                <td>
                                    <button type="submit"> Удалить заказ</button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                @endif

            </table>
        </div>

            <div>
                Сумма заказов: {{ $sum }}
            </div>
    </div>

</x-app-layout>
