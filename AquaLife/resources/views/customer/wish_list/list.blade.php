<!-- Created by: Daniel Felipe Gomez Martinez -->

@extends('layouts.master')

@section("title", $data["title"])

@section('content')
<button class="btn btn-info col-1" onclick="topFunction()" id="goToTopBtn" title="Go to top"><i class="fa fa-arrow-up"></i> {{__('navigation.go_to_top')}}</button>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('util.message')
            @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>{{ $error }}</strong>
                        </div>
                    @endforeach
            @endif
            @foreach($data["fish"] as $fish)
                @if($loop->index == 0)
                <div class="card-deck">
                @endif
                @if(($loop->index != 0) && ($loop->index)%3 == 0)
                </div><br />
                @if(($loop->index) != sizeof($data["fish"]))
                <div class="card-deck">
                @endif
                @endif
                    <div class="card" align="center">
                        <img src="{{ asset('/images/'.$fish->getImage()) }}" class="card-img-top">
                        <div class="card-body">
                            <hr/><h5 class="card-title">{{ $fish->getName() }}</h5><hr/>
                            <div class="row">
                                <p class="card-text col-6"><strong>{{ __('fish_show.color') }}</strong><br/> {{ $fish->getColor() }}</p>
                                <p class="card-text col-6"><strong>{{ __('fish_show.size') }}</strong><br/> {{ $fish->getSize() }}</p>
                            </div><hr/>
                            <div class="row">
                                <p class="card-text col-6"><strong>{{ __('fish_show.temperament') }}</strong><br/> {{ $fish->getTemperament() }}</p>
                                <p class="card-text col-6"><strong>{{ __('fish_show.price') }}</strong><br/> {{ $fish->getPrice() }}</p>
                            </div><hr/>
                            @if($fish->getInStock() > 0)
                            <p class="card-text green-color">{{ __('fish_list.in_stock') }}</p>
                            @else
                            <p class="card-text red-color">{{ __('fish_list.sold_out') }}</p>
                            @endif
                            <form method="POST" action="{{ route('customer.wish_list.delete') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <input type="hidden" name="id" value="{{ $fish->getId() }}" />
                                        <button type="submit" class="btn btn-danger col-12"><i class="fa fa-minus" aria-hidden="true"></i> {{ __('wish_list_fish.delete') }}</button>
                                    </div>
                                </div>
                            </form><br/>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">{{ $fish->getSpecies() }}</small>
                        </div>
                    </div>
                @if(($loop->index + 1) == sizeof($data["fish"]))
                </div>
                @endif
            @endforeach
            <br>
            <div class="d-flex justify-content-center">
                <div >
                    <form action="{{ route('customer.fish.list') }}">
                        <button type="submit" class="btn btn-info"><i class="fa fa-arrow-left"></i> {{ __('navigation.go_back_to_fish_list')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection