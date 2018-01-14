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
    <link rel="stylesheet" href="/multiselect/bootstrap-multiselect.css">

    <link rel="stylesheet" type="text/css" href="{{ url('css/styles.css') }}">
</head>

<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-1 control-label">Geo</label>
                        <div class="col-sm-8">
                            <input type="text" name="geo" list="geo" class="col-sm-12">
                            <datalist id="geo">
                                <option value="1">
                                <option value="2">
                            </datalist>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1">
                    PRICE
                </div>
                <div class="form-inline col-sm-11">
                    <div class="form-group">
                        <label>from</label>
                        <input type="text" class="form-control" id="" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>to</label>
                        <input type="email" class="form-control" id="" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail2">currency</label>
                        <select class="form-control">
                            <option>$</option>
                            <option>UAH</option>
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
                        <input type="text" class="form-control" id="" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>to</label>
                        <input type="text" class="form-control" id="" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>rooms</label>
                        <select id="multiselect" multiple="multiple" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5+</option>
                        </select>
                    </div>
                </div>
                <a href="#" class="btn btn-success btn-lg pull-right">find</a>

            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                @foreach ($ads as $ad)
                    <div class="container-fluid">
                        <div class="col-sm-2">{{ $ad->price }} {{ $ad->nominative }}</div>
                        <div class="col-sm-2">{{ $ad->price }} {{ $ad->nominative }}</div>
                        <div class="col-sm-1">{{ $ad->room_count }} rooms</div>
                        <div class="col-sm-1">{{ $ad->area_total }} m2</div>
                        <div class="col-sm-5">{{ $ad->street }} {{ $ad->house }}</div>
                        <div class="col-sm-3"><a href="{{ $ad->url }}">{{ $ad->url }}</a></div>
                    </div>
                    <div class="panel">
                        <div class="panel-body">
                            {{ $ad->text }}
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>

        <div class="panel">
            <div class="panel-body">
                <nav aria-label="Page navigation" class="text-center">
                    {{ $ads->links() }}
                    {{--<ul class="pagination">--}}
                        {{--<li>--}}
                            {{--<a href="#" aria-label="Previous">--}}
                                {{--<span aria-hidden="true">&laquo;</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li><a href="#">1</a></li>--}}
                        {{--<li class="active"><a href="#">2</a></li>--}}
                        {{--<li><a href="#">3</a></li>--}}
                        {{--<li><a href="#">4</a></li>--}}
                        {{--<li><a href="#">5</a></li>--}}
                        {{--<li>--}}
                            {{--<a href="#" aria-label="Next">--}}
                                {{--<span aria-hidden="true">&raquo;</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                </nav>
            </div>
        </div>
    </div>



<!-- JavaScripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
{{--<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>--}}
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="/multiselect/bootstrap-multiselect.js"></script>

<script src="/js/app.js"></script>

</body>
</html>
