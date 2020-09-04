<!-- Created by: Juan Sebastián Pérez Salazar -->

@extends('layouts.master')

@section("title", $data["title"])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="fa fa-info-circle"></i> {{ $data["accessory"]["name"] }}</div>

                <div class="card-body">
                    @if(strlen($data['accessory']['image']) < 3)
                        <img class="show_image" src="{{ asset('/images/noavailable_img.png')}}"><br />
                    @else
                        <img class="show_image" src="{{ asset('/images/'.$data['accessory']['image'])}}"><br />
                    @endif
                    <b>Accessory name:</b> {{ $data["accessory"]["name"] }}<br />
                    <b>Accessory category:</b> {{ $data["accessory"]["category"] }}<br />
                    <b>Accessory price:</b> {{ $data["accessory"]["price"] }}<br /><br /> 
                    <form method="POST" action="{{ route('admin.accessory.delete') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $data['accessory']->getId() }}" />
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash-alt"></i> Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
