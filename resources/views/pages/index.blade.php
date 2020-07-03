@extends('layouts.app')
@section('content')
    <div id="about-project">
        <div class="row card info-card">
            <div class="col-md-12">
                <h4><b>Laravel web scrapper</b></h4>
                <p>I started this project while learning <b>Data Structures and Algorithms</b> using Javascript and thought of putting it out as a website for others to use it and interact with it to try themselves how the code is working.
                    Below mentioned is the list of programs written.</p>
            </div>
        </div>
    </div>
    <hr>

    <div class="row" id="companies-row">
        {{--Select company type Row--}}
        <div class="col-md-12 card info-card" id="select-company-type-container">
            <h4 class="mb-4"><b>Select a company</b></h4>
            <ul class="list-group">
                @foreach($companies as $company)
                        <li class="list-group-item company-item" data-link="{{$company['link']}}" data-name="{{urlencode($company['name'])}}">
                            {{$company['name']}}
                        </li>
                @endforeach
            </ul>
        </div>
    </div>

@endsection
