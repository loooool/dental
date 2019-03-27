@extends('layouts.doctor')
@section('header')
    <link rel="stylesheet" href="{{asset('css/vendor/fullcalendar.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/datatables.responsive.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/bootstrap-stars.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/nouislider.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/vendor/bootstrap-datepicker3.min.css')}}"/>

    <style>
        .scroll {
            height: 400px;
            overflow-y: scroll;
            width: 100%;
        }

        .tooth {
            opacity: 0.5;
        }

        polygon {
            margin: auto;
            display: block;
            stroke-width: 1;
            stroke: darkgrey;
            fill: transparent;
        }

        circle {
            stroke-width: 1;
            stroke: darkgrey;
            fill: white;
        }

        /*

                circle:hover {
                    fill : aqua;
                }
        */
        .lombo {
            fill: #138496;
            animation-duration: 0.3s;
        }

        .empty {
            fill: white;
            animation-duration: 0.3s;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #138496;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .line {
            margin: 10px;
            border-left: thick solid orange;
        }
    </style>

    {{--End css style gh met link file oruulna--}}
@endsection
@section('content')
    <script>
        document.getElementById('doctorTreatment').classList.add('active');
    </script>
    <div id="treatmentTypeModal" class="modal fade bd-example-modal-sm " tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body" id="modalBuri">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-center" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <br>
                    <br>
                    <h3><b>
                            <div id="buriLombo">Шүд #</div>
                        </b></h3>
                    <input type="hidden" id="hiddenDecayChart" value="">
                    <svg height="200" width="200">
                        <polygon id="pol1" points="0,0 100,100 200,0" onclick="myFunction('1')"/>
                        <polygon id="pol2" points="100,100 200,0 200,200" onclick="myFunction('2')"/>
                        <polygon id="pol4" points="0,200 100,100 200,200" onclick="myFunction('4')"/>
                        <polygon id="pol8" points="0,0 100,100 0,200" onclick="myFunction('8')"/>
                        <circle id="pol16" cx="100" cy="100" r="50" onclick="myFunction('16')"/>
                    </svg>
                    <div>
                        <br>
                        <h5 style="color: darkgrey"><b>Цоорлын зэрэг</b></h5>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-info active">
                                <input type="radio" name="decayLevel" id="option1"> 1
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" name="decayLevel" id="option2"> 2
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" name="decayLevel" id="option3"> 3
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" name="decayLevel" id="option4"> 4
                            </label>
                        </div>
                    </div>
                    <br>
                    <h5 style="color: darkgrey"><b>Сүүн шүд</b></h5>
                    <label class="switch">
                        <input type="checkbox" id="suunShudToggle">
                        <span class="slider round"></span>
                    </label>
                    <br>
                    <br>
                    <button class="btn btn-info btn-ls">ОРУУЛАХ</button>
                    <!--                                            content modal-->
                </div>
            </div>
        </div>
    </div>

    <form id="treatmentForm" method="post" action="{{url('/doctor/treatment/store')}}">
        @csrf
        <input type="hidden" name="treatment_id" value="" id="treatmentId">
        <input type="hidden" name="treatment_selection_id" value="" id="treatmentSelectionId">
        <input type="hidden" name="tooth_id" value="" id="toothId">
        <input type="hidden" name="user_id" value="{{$checkin->user_id}}" id="userId">
        <input type="hidden" name="value_id" value="" id="valueId">
        <input type="hidden" name="checkin_id" value="{{$checkin->id}}" id="checkin_id">
    </form>

    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body mb-2">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <tr>
                                @for($i = 18; $i>=11; $i--)
                                    <td style="color: grey">
                                        {{$i}}
                                    </td>
                                @endfor
                                @for($i = 21; $i<=28; $i++)
                                    <td style="color: grey">
                                        {{$i}}
                                    </td>
                                @endfor
                            </tr>
                            <tr>
                                @for($i = 18; $i>=11; $i--)
                                    <td>
                                        <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'.png')}}"
                                             onclick="changeStyle({{$i}})">
                                    </td>
                                @endfor
                                @for($i = 21; $i<=28; $i++)
                                    <td>
                                        <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'.png')}}"
                                             onclick="changeStyle({{$i}})">
                                    </td>
                                @endfor
                            </tr>
                            <tr>
                                @for($i = 18; $i>=11; $i--)
                                    <td>
                                        <input type="hidden" id="shud{{$i}}" value="16">
                                        <svg height="25" width="25">
                                            <polygon id="pol{{$i}}_0" points="0,0 12.5,12.5 25,0"
                                                     onclick="changeStyle({{$i}})"/>
                                            <polygon id="pol{{$i}}_1" points="12.5,12.5 25,0 25,25"
                                                     onclick="changeStyle({{$i}})"/>
                                            <polygon id="pol{{$i}}_2" points="0,25 12.5,12.5 25,25"
                                                     onclick="changeStyle({{$i}})"/>
                                            <polygon id="pol{{$i}}_3" points="0,0 12.5,12.5 0,25"
                                                     onclick="changeStyle({{$i}})"/>
                                            <circle id="pol{{$i}}_4" cx="12.5" cy="12.5" r="6.25"
                                                    onclick="changeStyle({{$i}})"/>
                                        </svg>
                                    </td>
                                @endfor
                                @for($i = 21; $i<=28; $i++)
                                    <td>
                                        <input type="hidden" id="shud{{$i}}" value="3">
                                        <svg height="25" width="25">
                                            <polygon id="pol{{$i}}_0" points="0,0 12.5,12.5 25,0"
                                                     onclick="changeStyle({{$i}})"/>
                                            <polygon id="pol{{$i}}_1" points="12.5,12.5 25,0 25,25"
                                                     onclick="changeStyle({{$i}})"/>
                                            <polygon id="pol{{$i}}_2" points="0,25 12.5,12.5 25,25"
                                                     onclick="changeStyle({{$i}})"/>
                                            <polygon id="pol{{$i}}_3" points="0,0 12.5,12.5 0,25"
                                                     onclick="changeStyle({{$i}})"/>
                                            <circle id="pol{{$i}}_4" cx="12.5" cy="12.5" r="6.25"
                                                    onclick="changeStyle({{$i}})"/>
                                        </svg>
                                    </td>
                                @endfor
                            </tr>
                            <tr>
                                @for($i = 48; $i>=41; $i--)
                                    <td>
                                        <input type="hidden" id="shud{{$i}}" value="7">
                                        <svg height="25" width="25">
                                            <polygon id="pol{{$i}}_0" points="0,0 12.5,12.5 25,0"
                                                     onclick="changeStyle({{$i}})"/>
                                            <polygon id="pol{{$i}}_1" points="12.5,12.5 25,0 25,25"
                                                     onclick="changeStyle({{$i}})"/>
                                            <polygon id="pol{{$i}}_2" points="0,25 12.5,12.5 25,25"
                                                     onclick="changeStyle({{$i}})"/>
                                            <polygon id="pol{{$i}}_3" points="0,0 12.5,12.5 0,25"
                                                     onclick="changeStyle({{$i}})"/>
                                            <circle id="pol{{$i}}_4" cx="12.5" cy="12.5" r="6.25"
                                                    onclick="changeStyle({{$i}})"/>
                                        </svg>
                                    </td>
                                @endfor
                                @for($i = 31; $i<=38; $i++)
                                    <td>
                                        <input type="hidden" id="shud{{$i}}" value="15">
                                        <svg height="25" width="25">
                                            <polygon id="pol{{$i}}_0" points="0,0 12.5,12.5 25,0"
                                                     onclick="changeStyle({{$i}})"/>
                                            <polygon id="pol{{$i}}_1" points="12.5,12.5 25,0 25,25"
                                                     onclick="changeStyle({{$i}})"/>
                                            <polygon id="pol{{$i}}_2" points="0,25 12.5,12.5 25,25"
                                                     onclick="changeStyle({{$i}})"/>
                                            <polygon id="pol{{$i}}_3" points="0,0 12.5,12.5 0,25"
                                                     onclick="changeStyle({{$i}})"/>
                                            <circle id="pol{{$i}}_4" cx="12.5" cy="12.5" r="6.25"
                                                    onclick="changeStyle({{$i}})"/>
                                        </svg>
                                    </td>
                                @endfor
                            </tr>
                            <tr>
                                @for($i = 48; $i>=41; $i--)
                                    <td>
                                        <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'.png')}}"
                                             onclick="changeStyle({{$i}})">
                                    </td>
                                @endfor
                                @for($i = 31; $i<=38; $i++)
                                    <td>
                                        <img id='{{$i}}' src="{{url('img/toothImages/'.$i.'.png')}}"
                                             onclick="changeStyle({{$i}})">
                                    </td>
                                @endfor
                            </tr>
                            <tr>
                                @for($i = 48; $i>=41; $i--)
                                    <td style="color: grey">
                                        {{$i}}
                                    </td>
                                @endfor
                                @for($i = 31; $i<=38; $i++)
                                    <td style="color: grey">
                                        {{$i}}
                                    </td>
                                @endfor
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- Tooth images ending-->
        <div class="col-md-3">
            <div class="card">
                <ul class="nav nav-tabs nav-justified ml-0 mb-2" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab"
                           aria-controls="first" aria-selected="true">Түүх</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="second-tab" data-toggle="tab" href="#second" role="tab"
                           aria-controls="second" aria-selected="false">Эмчилгээ</a>
                    </li>
                </ul>
                <div class="tab-content">

                    <div class="tab-pane show active scroll" id="first" role="tabpanel" aria-labelledby="first-tab">
                        @foreach($user_treatments as $user_treatment)
                        <div class="col-md-12 text-left line history{{$user_treatment->tooth_id}}">
                            <b>Шүд #{{$user_treatment->tooth_id}} - {{\App\Treatment::find($user_treatment->treatment_id)->name}}</b>
                            <br>
                            <div class="row">
                                <div class="text-muted col-md-6">
                                    @if(is_null($user_treatment->treatment_selection_id))
                                        Төрөлгүй
                                        @else
                                    {{\App\TreatmentSelections::find($user_treatment->treatment_selection_id)->name}}
                                    @endif
                                </div>
                                <div class="text-right text-muted col-md-6">
                                    {{date('Y-m-d', strtotime($user_treatment->created_at))}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="tab-pane scroll" id="second" role="tabpane2" aria-labelledby="second-tab">
                        <div class="card-body">
                            @foreach($treatments as $treatment)
                                <!--
                                In case of special treatment
                                -->
                                    @if($treatment->id == 1)
                                    <button class="btn btn-primary btn-block single" data-toggle="modal"
                                            data-target="#exampleModal">
                                        <div class="row">
                                            <div class="col-md-12 text-left" onclick="reset()">
                                                Ломбо<br> төрөлгүй
                                            </div>
                                        </div>
                                    </button>
                                    @elseif($treatment->id == 2)
                                        <button class="btn btn-primary btn-block single" data-toggle="modal"
                                                data-target="#exampleModal">
                                            <div class="row">
                                                <div class="col-md-12 text-left" onclick="reset()">
                                                    Сувгийн эмчилгээ<br> төрөлгүй
                                                </div>
                                            </div>
                                        </button>
                                    @else
                                    <button class="btn btn-primary btn-block
                                        @if($treatment->selection_type == 0)
                                            all
                                        @elseif($treatment->selection_type == 1)
                                            single
                                        @else
                                            multiple
                                        @endif"
                                            @if($treatment->treatmentSelection->count() != 0)
                                            onclick="treatmentButton('{{$treatment->id}}')"
                                        @else
                                            onclick="treatment('{{$treatment->id}}')"
                                        @endif
                                    >
                                        <div class="row">
                                            <div class="col-md-9 text-left">
                                                {{$treatment->name}}<br> {{$treatment->treatmentSelection->count()}}
                                                төрөлтэй
                                                @foreach($treatment->treatmentSelection as $selection)
                                                    <input type="hidden" value="{{$selection->name}}/{{$selection->id}}"
                                                           class="treatment_{{$treatment->id}}">
                                                @endforeach
                                            </div>
                                        </div>
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var tooths = [];
        var selectedArea = [];
        var toothClassList = ["single", "all", "multiple"]

        var single = document.getElementsByClassName(toothClassList[0]);
        var all = document.getElementsByClassName(toothClassList[1]);
        var mult = document.getElementsByClassName(toothClassList[2]);

        for (i = 0; i < all.length; i++) {
            all[i].style.display = "block";
        }
        for (i = 0; i < single.length; i++) {
            single[i].style.display = "none";
        }
        for (i = 0; i < mult.length; i++) {
            mult[i].style.display = "none";
        }

        function reset() {
            document.getElementById('treatmentSelectionId').value = null;
            document.getElementById('option1').click();

            for (i = 0; i < selectedArea.length; i++) {
                document.getElementById("pol" + selectedArea[i]).setAttribute('class', 'empty');
            }
            // document.getElementById('suunShudToggle').setAttribute('class','')
            var x = document.getElementById('suunShudToggle');
            x.checked = false;


        }

        function changeStyle(ruby) {
            //----VALIDATION-----
            if (tooths.length === 0) {
                tooths.push(ruby);
            } else {
                var check = true;
                for (var count = 0; count < tooths.length; count++) {
                    if (tooths[count] === ruby) {
                        check = false;
                    }
                }
                if (check) {
                    tooths.push(ruby);
                } else {
                    tooths.splice(tooths.indexOf(ruby), 1);
                }
            }
            document.getElementById('buriLombo').innerText = "Шүд #" + tooths[0];
            //----VALIDATION END-----
            //PAINT table using @tooths array
            console.log(tooths);
            for (var j = 1; j <= 4; j++) {
                for (var i = 10 * j + 1; i <= 10 * j + 8; i++) {
                    document.getElementById(i).setAttribute("class", "tooth");
                }
                for (var i = 10 * j + 1; i <= 10 * j + 8; i++) {
                    for (var count = 0; count < tooths.length; count++) {
                        if (tooths[count] === i) {
                            document.getElementById(i).classList.remove("tooth");
                        }
                    }
                    if (tooths.length === 0) {
                        document.getElementById(i).classList.remove("tooth");
                    }
                }

            }
            for (var z = 0; z < document.getElementsByClassName('line').length; z++) {
                document.getElementsByClassName('line')[z].style.display = 'none';
            }


            if (tooths.length === 0) {
                for (i = 0; i < all.length; i++) {
                    all[i].style.display = "block";
                }
                for (i = 0; i < single.length; i++) {
                    single[i].style.display = "none";
                }
                for (i = 0; i < mult.length; i++) {
                    mult[i].style.display = "none";
                }
                for (var j = 1; j <= 4; j++) {
                    for (var i = 10 * j + 1; i <= 10 * j + 8; i++) {
                        document.getElementById(i).classList.remove("tooth");
                    }
                }

            } else if (tooths.length === 1) {
                for (i = 0; i < all.length; i++) {
                    all[i].style.display = "none";
                }
                for (i = 0; i < single.length; i++) {
                    single[i].style.display = "block";
                }
                for (i = 0; i < mult.length; i++) {
                    mult[i].style.display = "none";
                }
            } else {
                for (i = 0; i < all.length; i++) {
                    all[i].style.display = "single";
                }
                for (i = 0; i < single.length; i++) {
                    single[i].style.display = "none";
                }
                for (i = 0; i < mult.length; i++) {
                    mult[i].style.display = "block";
                }
            }

            if (tooths.length == 0) {
                for (i = 0; i < document.getElementsByClassName('line').length; i++) {
                    document.getElementsByClassName('line')[i].style.display = 'block';
                }
            } else {
                for (i = 0; i < tooths.length; i++) {
                    var choosen = document.getElementsByClassName('history' + tooths[i]);
                    for (var d = 0; d < choosen.length; d++) {
                        choosen[d].style.display = 'block';
                    }
                }
            }


            // History start
            // var history = document.getElementsByClassName('history'+11);
            // history[0].style.display = "none";
            // History end
        }


        //LOMBO STARTING


        function sumList(array) {
            var sum = 0
            for (i = 0; i < array.length; i++) {
                var parse = parseInt(array[i]);
                sum += parse;
            }
            return sum
        }

        function myFunction(ruby) {
//            Validation start
            if (selectedArea.length === 0) {
                selectedArea.push(ruby);
            } else {
                var check = true;
                for (var count = 0; count < selectedArea.length;
                     count++) {
                    if (selectedArea[count] === ruby) {
                        check = false;
                    }
                }
                if (check) {
                    selectedArea.push(ruby);
                } else {
                    selectedArea.splice(selectedArea.indexOf(ruby), 1);
                }
            }

//            ----Validation End------
//              Change Color on click
            if (selectedArea.includes(ruby) === true) {

                document.getElementById("pol" + ruby).setAttribute('class', 'lombo');
            } else if (selectedArea.includes(ruby) === false) {

                document.getElementById("pol" + ruby).setAttribute('class', 'empty');
            }
//            sumList
            var total = sumList(selectedArea);

//            hidden value
            var x = document.getElementById('hiddenDecayChart').value = total;
            console.log(ruby);
            document.getElementById("toothId").value = tooths;
        }

        //                                integer to binary
        //Polygon
        function paint(input) {
            var s = '';
            var v = '';
            var d = parseInt(input);
            while (d > 0) {
                s = s + d % 2;
                d = parseInt(d / 2);
            }
            s = s.split("");
            return s;
        }

        for (var p = 1; p <= 4; p++) {
            for (var f = 10 * p + 1; f < 10 * p + 9; f++) {
                var x = document.getElementById('shud' + f).value;
                var list = paint(x);

                for (var i = 0; i < list.length; i++) {
                    if (list[i] == 1) {
                        document.getElementById('pol' + f + '_' + i).setAttribute('class', 'lombo');
                    } else {
                        document.getElementById('pol' + f + '_' + i).setAttribute('class', 'empty');
                    }
                }
            }
        }

        //start
        function treatmentReset() {
            var x = document.getElementsByClassName('delete');
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
        }

        // start
        function treatmentButton(treatment) {
            document.getElementById('treatmentSelectionId').value = null;
            document.getElementById('toothId').value = tooths;
            document.getElementById('treatmentId').value = treatment;
            $("#treatmentTypeModal").modal();
            treatment = parseInt(treatment);
            var n = treatment;
            console.log(treatment);
            treatmentReset();
            treatment = parseInt(treatment);
            var input = document.getElementsByClassName("treatment_" + treatment);
            for (i = 0; i < input.length; i++) {
                var buttonValue = input[i].value;
                var buttonId = buttonValue.split('/')[1];
                var buttonText = buttonValue.split('/')[0];
                var button = '<button type="button" class="delete btn btn-primary btn-block mb-1" onclick="treatment(' + buttonId + ')">' + buttonText + '</button>';
                document.getElementById('modalBuri').innerHTML += button;
            }
        }

        function treatment(id) {
            document.getElementById('treatmentSelectionId').value = id;
            document.getElementById('treatmentForm').submit();
        }

        // end

    </script>
@endsection
@section('footer')


    <script src="{{asset('js/vendor/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('js/vendor/chartjs-plugin-datalabels.js')}}"></script>
    <script src="{{asset('js/vendor/moment.min.js')}}"></script>
    <script src="{{asset('js/vendor/fullcalendar.min.js')}}"></script>
    <script src="{{asset('js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('js/vendor/owl.carousel.min.js')}}"></script>
    <script src="{{asset('js/vendor/progressbar.min.js')}}"></script>
    <script src="{{asset('js/vendor/jquery.barrating.min.js')}}"></script>
    <script src="{{asset('js/vendor/select2.full.js')}}"></script>
    <script src="{{asset('js/vendor/nouislider.min.js')}}"></script>
    <script src="{{asset('js/vendor/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('js/vendor/Sortable.js')}}"></script>
    {{--Scriptuudiig include hiiideg heseg--}}
@endsection