@extends('main')

@section('title', '| Login')

@section('content')

<div class="container-fluid signin">
    <div class="card_overlay">
        <div class="box-login manual-flip">
            <div class="card">
                <div class="front">
                    <div class="card-block">
                        <div class="title-area text-center">
                            <h2>Sign in to your account</h2>
                            <div class="separator separator-danger">✻</div>
                        </div>
                        {{ Form::open(['id' => 'login']) }}
                        <h4>Enter your e-mail address and password below to access the admin.</h4><br/>
                        <div class="d-none" id="location_after_validation">/admin/dashboard</div>
                        <div class="md-form code_form text-left mb-4">
                            <i class="fa fa-envelope prefix"></i>
                            {{ Form::email('email', null, ['class' => 'form-control', 'id' => 'email']) }}
                            {{ Form::label('email', 'Saissisez votre email:', ['class' => '']) }}
                        </div>
                        <br/>
                        <div class="md-form code_form text-left mt-5">
                            <i class="fa fa-lock prefix"></i>
                            {{ Form::password('password',  ['id' => 'password', 'class' => 'form-control']) }}
                            {{ Form::label('password', 'Saissisez votre mot de passe:', ['class' => '']) }}
                        </div>
                        <fieldset class="form-group text-right">
                            <input type="checkbox" id="color-1"/>
                            <label for="color-1">Keep me signed in</label>
                        </fieldset>

                        <div class="pull-right">
                            {{ Form::button('Login', ['type' => 'submit', 'class' => 'btn btn-outline-success btn-lg btn-rounded waves-effect pull-right']) }}
                            <br/><br/><br/>
                            <p class="text-gray info">Mot de passe oublié? <a class="text-black">Cliquer ici</a></p>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
                <div class="back">
                    <div class="card-block">
                        <div class="title-area text-center">
                            <h2>Forgot Password?</h2>
                            <div class="separator separator-danger">✻</div>
                        </div>
                        {{ Form::open([ 'id' => 'password_lost']) }}
                        <h4>Please enter your name and password to log in.</h4><br/>

                        <div class="md-form code_form text-xs-left">
                            <i class="fa fa-envelope prefix"></i>
                            {{ Form::email('email_recup', null, ['class' => 'form-control', 'id' => 'email_recup']) }}
                            {{ Form::label('email_recup', 'Saissisez votre email:', ['class' => '']) }}
                        </div>

                        <div class="pull-right">
                            <button class="btn btn-outline-success btn-lg btn-rounded waves-effect pull-right">
                                Submit
                            </button>
                            <br/><br/><br/>
                            <p class="text-gray info">Je me souviens de mon mot de passe? <a class="text-black">Cliquer ici</a></p>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Main container-->
@endsection
@section('scripts')
{!! Html::script('/js/general.js') !!}
<script>
    $(document).ready(function () {
        function rotateCard(btn) {
            var $card = $(btn).closest('.box-login');
            if ($card.hasClass('hover')) {
                $card.removeClass('hover');
            } else {
                $card.addClass('hover');
            }
        }

        $(".box-login  a").click(function () {
            rotateCard(this);
        });

        var nombre_erreur = 0, id_form = '';
        $("form").submit(function (event) {
            var form = $(this);
            event.preventDefault();
            nombre_erreur = 0;
            id_form = $(this).attr("id");
            nombre_erreur += id_form === "login" && ($("input[name=email]").val()).trim() === '' ? error_text("Un email est obligatoire.", "email") : remove_error("email");
            nombre_erreur += id_form === "password_lost" && ($("input[name=email_recup]").val()).trim() === '' ? error_text("Un email est obligatoire.", "email_recup") : remove_error("email_recup");
            nombre_erreur += id_form === "login" && ($("input[name=password]").val()).trim() === '' ? error_text("Un password est obligatoire.", "password") : remove_error("password");
            if (nombre_erreur === 0) {
                $.ajax({
                    type: 'POST',
                    url: form.attr("action"),
                    data: form.serialize() + '&action=' + id_form,
                    dataType: 'json',
                    encode: true
                })
                .done(function (data) {
                    console.log(data.test)
                    if (!data.success) {
                        data.errors.password ? error_text(data.errors.password, "password") : '';
                        data.errors.email ? error_text(data.errors.email, "email") : '';
                        data.errors.email_recup ? error_text(data.errors.email_recup, "email_recup") : '';
                    } else {
                        remove_error("password");
                        remove_error("email");
                        remove_error("email_recup");

                        if (id_form === "password_lost") {
                            $('.box-login').removeClass('hover');
                        }else{
                            window.location.href= data.redirect;
                        }
                    }
                })
                .fail(function (data) {
                    console.log("fail");
                });

            }
        });

    });

</script>
@endsection