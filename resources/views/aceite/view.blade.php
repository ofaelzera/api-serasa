<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Assinar documento:</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css	">
    <link rel="stylesheet" href="{{ asset('assets/signature-pad-main/assets/jquery.signaturepad.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0
        }

        html {
            height: 100%
        }

        p {
            color: grey
        }

        body{
            background-image: url('{{ asset('images/fundo_.png') }}');
            background-size: cover;
        }

        #heading {
            text-transform: uppercase;
            color: #673AB7;
            font-weight: normal
        }

        #msform {
            text-align: center;
            position: relative;
            margin-top: 20px
        }

        #msform fieldset {
            background: white;
            border: 0 none;
            border-radius: 0.5rem;
            box-sizing: border-box;
            width: 100%;
            margin: 0;
            padding-bottom: 20px;
            position: relative
        }

        .form-card {
            text-align: left
        }

        #msform fieldset:not(:first-of-type) {
            display: none
        }

        #msform input,
        #msform textarea {
            padding: 8px 15px 8px 15px;
            border: 1px solid #ccc;
            border-radius: 0px;
            margin-bottom: 25px;
            margin-top: 2px;
            width: 100%;
            box-sizing: border-box;
            font-family: montserrat;
            color: #2C3E50;
            background-color: #ECEFF1;
            font-size: 16px;
            letter-spacing: 1px
        }

        #msform input:focus,
        #msform textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #673AB7;
            outline-width: 0
        }

        #msform .action-button {
            width: 100px;
            background: #673AB7;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 0px 10px 5px;
            float: right
        }

        #msform .action-button:hover,
        #msform .action-button:focus {
            background-color: #311B92
        }

        #msform .action-button-previous {
            width: 100px;
            background: #616161;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 0px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px 10px 0px;
            float: right
        }

        #msform .action-button-previous:hover,
        #msform .action-button-previous:focus {
            background-color: #000000
        }

        .card {
            z-index: 0;
            border: none;
            position: relative
        }

        .fs-title {
            font-size: 25px;
            color: #673AB7;
            margin-bottom: 15px;
            font-weight: normal;
            text-align: left
        }

        .purple-text {
            color: #673AB7;
            font-weight: normal
        }

        .steps {
            font-size: 25px;
            color: gray;
            margin-bottom: 10px;
            font-weight: normal;
            text-align: right
        }

        .fieldlabels {
            color: gray;
            text-align: left
        }

        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: lightgrey
        }

        #progressbar .active {
            color: #673AB7
        }

        #progressbar li {
            list-style-type: none;
            font-size: 15px;
            width: 25%;
            float: left;
            position: relative;
            font-weight: 400
        }

        #progressbar #account:before {
            font-family: FontAwesome;
            content: "\f13e"
        }

        #progressbar #personal:before {
            font-family: FontAwesome;
            content: "\f007"
        }

        #progressbar #payment:before {
            font-family: FontAwesome;
            content: "\f030"
        }

        #progressbar #confirm:before {
            font-family: FontAwesome;
            content: "\f00c"
        }

        #progressbar li:before {
            width: 50px;
            height: 50px;
            line-height: 45px;
            display: block;
            font-size: 20px;
            color: #ffffff;
            background: lightgray;
            border-radius: 50%;
            margin: 0 auto 10px auto;
            padding: 2px
        }

        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: lightgray;
            position: absolute;
            left: 0;
            top: 25px;
            z-index: -1
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: #673AB7
        }

        .progress {
            height: 20px
        }

        .progress-bar {
            background-color: #673AB7
        }

        .fit-image {
            width: 100%;
            object-fit: cover
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center p-0 mt-3 mb-2">
                <div class="card px-5 pt-4 pb-0 mt-3 mb-3">
                    <h2 id="heading">CONTRATO DE PRESTAÇÃO DE SERVIÇO</h2>
                    <p>Visualize o documento antes de pular para próxima etapa</p>
                    <form id="msform">
                        <!-- progressbar -->
                        <ul id="progressbar">
                            <li class="active" id="account"><strong>Documento</strong></li>
                            <li id="personal"><strong>Dados</strong></li>
                            <li id="payment"><strong>Image</strong></li>
                            <li id="confirm"><strong>Finish</strong></li>
                        </ul>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                        </div> <br> <!-- fieldsets -->
                        <fieldset>
                            <div class="form-card">
                                <div class="row p-2" style="background-color: #9d9d9d;">
                                    <div class="col-12 p-4" style="background-color: #fff; max-height: 800px; overflow: scroll;">
                                        {!! $model->contrato !!}
                                    </div>
                                </div>
                            </div>
                            <input type="button" name="next" class="next action-button" value="Próximo" data-id="1" />
                        </fieldset>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="form-card">
                                        <label class="fieldlabels">Nome completo: *</label>
                                        <input type="text" name="nome" id="nome"/>
                                        <label class="fieldlabels">CPF:</label>
                                        <input type="text" name="cpf" id="cpf"/>
                                        <label class="fieldlabels">Email.: *</label>
                                        <input type="email" name="email" id="email" />
                                        <label class="fieldlabels">Telefone</label>
                                        <input type="text" name="telefone" id="telefone"/>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <input type="button" name="next" class="next action-button" value="Próximo" data-id="2" />
                            <input type="button" name="previous" class="previous action-button-previous" value="Voltar" />
                        </fieldset>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="sigPad">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="drawItDesc">Desenhe sua assinatura</p>
                                                <ul class="sigNav">
                                                    <li class="clearButton">
                                                        <a href="#clear">Limpar</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="sig sigWrapper" style="text-align: center;">
                                                    <div class="typed"></div>
                                                    <canvas class="pad" width="580" height="250"></canvas>
                                                    <input type="hidden" name="output" class="output">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <input type="button" name="next" class="next action-button" id="submit" value="Assinar" />
                            <input type="button" name="previous" class="previous action-button-previous" value="Voltar" />
                        </fieldset>
                        <fieldset>
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="fs-title">Finish:</h2>
                                    </div>
                                    <div class="col-5">
                                        <h2 class="steps">Step 4 - 4</h2>
                                    </div>
                                </div> <br><br>
                                <h2 class="purple-text text-center">
                                    <strong>SUCCESS !</strong></h2> <br>
                                <div class="row justify-content-center">
                                    <div class="col-3">
                                        <img src="https://i.imgur.com/GwStPmg.png" class="fit-image">
                                    </div>
                                </div>
                                <br><br>
                                <div class="row justify-content-center">
                                    <div class="col-7 text-center">
                                        <h5 class="purple-text text-center">You Have Successfully Signed Up</h5>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="{{ asset('assets/signature-pad-main/signaturepad.js') }}"></script>
    <script>
        $("#cpf").mask("000.000.000-00");
        $('.sigPad').signaturePad({
            lineWidth: 1,
            drawOnly:true,
            lineTop: 230,
            bgColour: '#fff',
        });

        $(document).ready(function(){

            var current_fs, next_fs, previous_fs; //fieldsets
            var opacity;
            var current = 1;
            var steps = $("fieldset").length;

            setProgressBar(current);

            $(".next").click(function(){

                current_fs = $(this).parent();
                next_fs = $(this).parent().next();
                var dataId = $(this).attr("data-id");

                if(dataId == 2){
                    var nome = $("#nome").val();
                    var cpf = $("#cpf").val();
                    var email = $("#email").val();
                    var telefone = $("#telefone").val();

                    if(nome == "" || cpf == "" || email == "" || telefone == ""){
                        alert("Preencha todos os campos");
                        return false;
                    }

                }

                //Add Class Active
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                //show the next fieldset
                next_fs.show();
                //hide the current fieldset with style
                current_fs.animate({opacity: 0}, {
                step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                'display': 'none',
                'position': 'relative'
                });
                next_fs.css({'opacity': opacity});
                },
                duration: 500
                });
                setProgressBar(++current);
            });

            $(".previous").click(function(){
                current_fs = $(this).parent();
                previous_fs = $(this).parent().prev();

                //Remove class active
                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                //show the previous fieldset
                previous_fs.show();

                //hide the current fieldset with style
                current_fs.animate({opacity: 0}, {
                step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                'display': 'none',
                'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
                },
                duration: 500
                });
                setProgressBar(--current);
            });

            function setProgressBar(curStep){
                var percent = parseFloat(100 / steps) * curStep;
                percent = percent.toFixed();
                $(".progress-bar").css("width",percent+"%")
            }

            $("#submit").click(function(){
                var nome        = $("#nome").val();
                var cpf         = $("#cpf").val();
                var email       = $("#email").val();
                var telefone    = $("#telefone").val();
                var assinatura  = generate_svg($(".output").val());
                //var assinatura  = $(".output").val()

                var data = {
                    nome: nome,
                    cpf: cpf,
                    email: email,
                    telefone: telefone,
                    assinatura: assinatura
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : "{{ route('assinar', $model->token) }}",
                    type : 'post',
                    data : data,
                    beforeSend : function(){
                        console.log('Enviando...');
                    }
                })
                .done(function(msg){
                    console.log(msg);
                })
                .fail(function(jqXHR, textStatus, msg){
                    console.log(msg);
                });
            })

        });

        function generate_svg(paths) {
            var svg = '';
            svg += '<svg width="198px" height="55px" version="1.1" xmlns="http://www.w3.org/2000/svg">\n';

            for(var i in paths) {
                var path = '';
                path += 'M' + paths[i].mx + ' ' + paths[i].my;   // moveTo
                path += ' L ' + paths[i].lx + ' ' + paths[i].ly; // lineTo
                path += ' Z';                                    // closePath
                svg += '<path d="' + path + '"stroke="blue" stroke-width="2"/>\n';
            }

            svg += '</svg>\n';
            return svg;
        }
    </script>
</body>
</html>
