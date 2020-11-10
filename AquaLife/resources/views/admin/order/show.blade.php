<!-- Created by: Yhoan Alejandro Guzman -->

@extends('layouts.master')

@section("title", $data["title"])

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.order.show', $data["order"]) }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" align="center">
                <div class="card-header"><i class="fa fa-info-circle"></i> {{ __('order_show.id') }} {{ $data["order"]->getId() }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <b>{{ __('order_show.id') }}</b><br /> {{ $data["order"]->getId() }}<br />
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.user.show', ['id'=>$data['order']->getUserId()]) }}"><b>{{ __('order_show.user_id') }} </b><br /> {{ $data["order"]->getUserId() }}<br /></a>
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-4">
                            <b>{{ __('order_show.payment_type') }} </b><br /> {{ $data["order"]->getPaymentType() }}<br />
                        </div>
                        <div class="col-4">
                            <b>{{ __('order_show.total_price') }} </b><br /> {{ $data["order"]->getTotalPrice() }}<br />
                        </div>
                        <div class="col-4">
                            @if($data["order"]->getStatus() == "Completed")
                                <b>{{ __('order_show.status') }} </b><br /><strong class="order-completed"><i class="fa fa-check"></i> {{ $data["order"]->getStatus() }} </strong><br />
                            @elseif($data["order"]->getStatus() == "Pending")
                                <b>{{ __('order_show.status') }} </b><br /><strong class="order-pending"><i class="fa fa-clock"></i> {{ $data["order"]->getStatus() }} </strong><br />
                            @elseif($data["order"]->getStatus() == "Delivering")
                                <b>{{ __('order_show.status') }} </b><br /><strong class="order-delivering"><i class="fa fa-truck"></i> {{ $data["order"]->getStatus() }} </strong><br />
                            @elseif($data["order"]->getStatus() == "Canceled")
                                <b>{{ __('order_show.status') }} </b><br /><strong class="order-canceled"><i class="fa fa-times"></i> {{ $data["order"]->getStatus() }} </strong><br />
                            @endif
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-6">
                            <b>{{ __('order_show.created_at') }} </b><br /> {{ $data["order"]->getCreatedAt() }}<br />
                        </div>
                        <div class="col-6">
                            <b>{{ __('order_show.updated_at') }} </b><br /> {{ $data["order"]->getUpdatedAt() }}<br />
                        </div>
                    </div>
                    @if(!empty($data["fish"]) and count($data["fish"]) > 0)
                    <br />
                    <b>{{ __('order_show.fish_ordered') }} </b><br />
                        <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('fish_list.name') }}</th>
                                <th scope="col">{{ __('fish_list.price') }}</th>
                                <th scope="col">{{ __('order_show.quantity') }}</th>
                                <th scope="col">{{ __('order_list.subtotal') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data["fish"] as $fishOrder)
                            <tr>
                                <td>{{ $fishOrder->fish->getName() }}sf</td>
                                <td>{{ $fishOrder->fish->getPrice() }}</td>
                                <td>{{ $fishOrder->getquantity() }}</td>
                                <td>{{ $fishOrder->getSubtotal() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    <br />
                    @if(!empty($data["accessories"]) and count($data["accessories"]) > 0)
                    <b>{{ __('order_show.accessories_ordered') }} </b><br />
                        <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('accessory_list.name') }}</th>
                                <th scope="col">{{ __('accessory_list.price') }}</th>
                                <th scope="col">{{ __('order_show.quantity') }}</th>
                                <th scope="col">{{ __('order_list.subtotal') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data["accessories"] as $accessoryOrder)
                            <tr>
                                <td>{{ $accessoryOrder->accessory->getName() }}</td>
                                <td>{{ $accessoryOrder->accessory->getPrice() }}</td>
                                <td>{{ $accessoryOrder->getquantity() }}</td>
                                <td>{{ $accessoryOrder->getSubtotal() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    <div class="row">
                        <div class="col-12">
                        <form method="GET" action="{{ route('admin.order.update') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data['order']->getId() }}" />
                                @if($data["order"]->getStatus() == 'Canceled')
                                    <button type="submit" class="btn btn-primary" disabled><i class="fa fa-pencil-alt"></i> {{ __('order_show.update') }}</button>
                                @else
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-pencil-alt"></i> {{ __('order_show.update') }}</button>
                                @endif
                                
                            </form>
                        </div>
                        <div class="col-7"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection