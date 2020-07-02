@extends('layouts.app')
@section('content')
    <div id="about-project">
        <h4><b>Laravel web scrapper</b></h4>
        <p>I started this project while learning <b>Data Structures and Algorithms</b> using Javascript and thought of putting it out as a website for others to use it and interact with it to try themselves how the code is working.
            Below mentioned is the list of programs written.</p>
    </div>
    <hr>
    <h4 class="mb-2"><b>Select a company</b></h4>
    <br>
    <div class="row">
            @foreach($companies as $company)
                <div class="col-md-3 mb-4">
                    <a href="#" data-link="{{$company['link']}}" class="company-card">
                        <div class="card custom-card">
                            <div class="card-body">
                                <h5 class="card-title text-center">{{$company['name']}}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
    </div>
@endsection
