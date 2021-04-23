@extends('layouts.suplay')
@section('content')
    <style>
       /* a {
            text-decoration: none;
            color: blue;
            background-color: transparent;
        }

        a:hover {
            text-decoration: none;
            color: #233dd2;
        }

        a:not([href]):not([tabindex]) {
            text-decoration: none;
            color: inherit;
        }

        a:not([href]):not([tabindex]):hover,
        a:not([href]):not([tabindex]):focus {
            text-decoration: none;
            color: inherit;
        }

        a:not([href]):not([tabindex]):focus {
            outline: 0;
        }*/
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            font-size: 1rem;
            position: absolute;
            z-index: 1000;
            top: 100%;
            left: 0;
            display: none;
            float: left;
            min-width: 10rem;
            margin: .125rem 0 0;
            padding: .5rem 0;
            list-style: none;
            text-align: left;
            color: #525f7f;
            border: 0 solid rgba(0, 0, 0, .15);
            border-radius: .4375rem;
            background-color: #fff;
            background-clip: padding-box;
            box-shadow: 0 50px 100px rgba(50, 50, 93, .1), 0 15px 35px rgba(50, 50, 93, .15), 0 5px 15px rgba(0, 0, 0, .1);
        }

        .dropdown-menu-right {
            right: 0;
            left: auto;
        }

        .dropdown-menu[x-placement^='top'],
        .dropdown-menu[x-placement^='right'],
        .dropdown-menu[x-placement^='bottom'],
        .dropdown-menu[x-placement^='left'] {
            right: auto;
            bottom: auto;
        }

        .dropdown-item {
            font-weight: 400;
            display: block;
            clear: both;
            width: 100%;
            padding: .25rem 1.5rem;
            text-align: inherit;
            white-space: nowrap;
            color: #212529;
            border: 0;
            background-color: transparent;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            text-decoration: none;
            color: #16181b;
            background-color: #f6f9fc;
        }

        .dropdown-item.active,
        .dropdown-item:active {
            text-decoration: none;
            color: #fff;
            background-color: #5e72e4;
        }

        .dropdown-item.disabled,
        .dropdown-item:disabled {
            color: #8898aa;
            background-color: transparent;
        }

    </style>
    <div class="container">

        <div class="align-middle ml-auto my-auto">
            H
            <div class="dropdown">
                <a class="btn btn-sm btn-icon-only text" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-download"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="#">480</a>
                    <a class="dropdown-item" href="#">720</a>
                    <a class="dropdown-item" href="#">1024</a>
                </div>
            </div>
        </div>
@endsection
