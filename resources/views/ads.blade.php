<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="_token" content="{{ csrf_token() }}">

    <title>lun.ua</title>

    <!-- Styles -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/multiselect/bootstrap-multiselect.css">

    <link rel="stylesheet" type="text/css" href="/css/app.css">
</head>

<body>
    <div class="container">
        <div>
            <div class="panel-body">
                <button class="btn btn-warning pull-right" id="statistics">show/hide statistics</button>
                <h1>LUN</h1>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <form action="/filter-ads" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="street_id" id="street_id">
                    <input type="hidden" name="house" id="house">

                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-1 control-label">Search</label>
                            <div class="col-sm-8">
                                <input type="text" name="address" id="address" class="col-sm-12" value="{{ isset($filters['address']) ? $filters['address'] : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        PRICE
                    </div>
                    <div class="form-inline col-sm-11">
                        <div class="form-group">
                            <label>from</label>
                            <input type="number" name="price_from" class="form-control" value="{{ isset($filters['price_from']) ? $filters['price_from'] : '' }}">
                        </div>
                        <div class="form-group">
                            <label>to</label>
                            <input type="number" name="price_to" class="form-control" value="{{ isset($filters['price_to']) ? $filters['price_to'] : '' }}">
                        </div>
                        <div class="form-group">
                            <label>currency</label>
                            <select name="currency" class="form-control">
                                <option value="uah">UAH</option>
                                <option value="usd">$</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="col-sm-1">
                        AREA
                    </div>
                    <div class="form-inline col-sm-11">
                        <div class="form-group">
                            <label>from</label>
                            <input type="number" name="area_from" class="form-control" value="{{ isset($filters['area_from']) ? $filters['area_from'] : '' }}">
                        </div>
                        <div class="form-group">
                            <label>to</label>
                            <input type="number" name="area_to" class="form-control" value="{{ isset($filters['area_to']) ? $filters['area_to'] : '' }}">
                        </div>
                        <div class="form-group">
                            <label>rooms</label>
                            <select name="rooms[]" id="multiselect" multiple size="1" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5+</option>
                            </select>
                        </div>
                    </div>
                    <input type="submit" value="Find" class="btn btn-success btn-lg pull-right"></input>

                </form>
            </div>
        </div>

        <div>
            <div class="panel-body text-center">
                Found - <b>{{ $ads->total() }}</b> ads
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                @foreach ($ads as $ad)
                    <div class="container-fluid">
                        <div class="col-sm-2">{{ $ad->price }} {{ $ad->currency }}</div>
                        <div class="col-sm-1">{{ $ad->rooms_number }} rooms</div>
                        <div class="col-sm-1">{{ $ad->area }} m2</div>
                        <div class="col-sm-5">{{ $ad->street }} {{ $ad->house }}</div>
                        <div class="col-sm-3"><a href="{{ $ad->url }}" target="_link">{{ $ad->url }}</a></div>
                    </div>
                    <div class="panel">
                        <div class="panel-body">
                            {{ $ad->description }}
                        </div>
                    </div>
                    <hr>
                    <hr>
                @endforeach
            </div>
        </div>

        <div class="panel">
            <div class="panel-body">
                <nav aria-label="Page navigation" class="text-center">

                    @if ($ads->hasPages())
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($ads->onFirstPage())
                                <li class="disabled"><span>&laquo;</span></li>
                            @else
                                <li><a href="{{ $ads->pages_links['previous'] }}">&laquo;</a></li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($ads->pages as $key => $page)
                                @if ($page == $ads->currentPage())
                                    <li class="active"><a href="{{ $ads->pages_links['pages'][$key] }}">{{ $page }}</a></li>
                                @else
                                    <li><a href="{{ $ads->pages_links['pages'][$key] }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                             {{--Next Page Link--}}
                            @if ($ads->hasMorePages())
                                <li><a href="{{ $ads->pages_links['next'] }}">&raquo;</a></li>
                            @else
                                <li class="disabled"><span>&raquo;</span></li>
                            @endif
                        </ul>
                    @endif

                </nav>
            </div>
        </div>
    </div>



<!-- JavaScripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="/multiselect/bootstrap-multiselect.js"></script>

<script src="/js/app.js"></script>

</body>
</html>
