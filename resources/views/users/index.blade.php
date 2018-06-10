@extends('main', ['body_class' => 'fixed-sn slight-blue-skin'])

@section('title', '| ' . $pagetitle)

@section('content')

@include('partials._navadmin')

 <!--/.Double navigation-->
<!--Main layout-->
<main class="admin">
    <div class="container-fluid">
        <!-- Section: Create Page -->
         <section class="section">
           <form method="POST" enctype="multipart/form-data" action="" class="w-100">
                    <!-- First row -->
                    <div class="row">
                      
                            <!-- First column -->
                            <div class="col-lg-4">

                                <!-- Card -->
                                <div class="card contact-card card-cascade narrower mb-r">
                                    <div class="admin-panel info-admin-panel">
                                        <!-- Card title -->
                                        <div class="view primary-color">
                                            <h5>Edit Photo</h5>
                                        </div>
                                        <!-- /.Card title -->

                                        <!-- Card content -->
                                        <div class="card-block text-xs-center">
                                            <div class="row avatar_overlay">
                                                <div class="col-xs-12">
                                                    <div class="view overlay hm-white-slight">
                                                        <img class="avatar_image img-fluid mx-auto d-block" src="/blog_ressources/avatar/{{ $user->avatar }}"/>
                                                        <input type="hidden" name="old_photo" value="{{ $user->avatar }}"/>
                                                        <a>
                                                            <div class="mask waves-effect waves-light"></div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12">
                                                    <a class="btn btn-primary file-btn" type="button">
                                                        <i class="fa fa-folder-open-o"></i> 
                                                        <input type="file" id="upload" value="Choose a file" accept="image/*">
                                                    </a>
                                                    <button type="button" class="btn btn-danger cancel_avatar d-none" data-deg="90"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    <button type="button" class="btn btn-primary rotate_left d-none" data-deg="90"><i class="fa fa-repeat" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.Card content -->
                                    </div>
                                </div>
                                <!-- /.Card -->

                            </div>
                            <!-- /.First column -->
                            <!-- Second column -->
                            <div class="col-lg-8">
                                <!--Card-->
                                <div class="card card-cascade narrower mb-r">
                                    <div class="admin-panel info-admin-panel">
                                        <!--Card image-->
                                        <div class="view primary-color">
                                            <h5>Edit Account</h5>
                                        </div>
                                        <!--/Card image-->
                                        <!--Card content-->
                                        <div class="card-block">
                                            <!-- Edit Form -->

                                            <!--First row-->
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="material-icons prefix">face</i>
                                                        <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $user->first_name }}"/>
                                                        <label for="first_name">Prénom</label>
                                                    </div>
                                                </div>
                                                <!--Second column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="fa fa-user prefix"></i>
                                                        <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $user->last_name }}"/>
                                                        <label for="last_name">Nom</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/.First row-->
                                            <!--First row-->
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="fa fa-envelope prefix"></i>
                                                        <input type="text" id="email" name="email" class="form-control" value="{{ $user->email }}"/>
                                                        <label for="email">Email</label>
                                                    </div>
                                                </div>
                                                <!--Second column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="material-icons prefix">web</i>
                                                        <input type="text" id="website" name="website" class="form-control"  value="{{ $user->website }}"/>
                                                        <label for="website">Website</label>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="row">
                                                <!--First column-->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="checkbox" class="filled-in" id="show-email" name="show-email" {{ $user->show_email ? 'checked="checked"' : '' }} >
                                                        <label for="show-email">Montrer mon email</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/.First row-->
                                            <!--Third row-->
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-12">
                                                    <div class="md-form">
                                                        <i class="material-icons prefix">title</i>
                                                        <textarea type="text" id="description" name="description" class="md-textarea">{{ $user->description }}</textarea>
                                                        <label for="description">Description</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-12">
                                                    <div class="md-form">
                                                        <i class="material-icons prefix">title</i>
                                                        <textarea type="text" id="description_eng" name="description_eng" class="md-textarea">{{ $user->description_eng }}</textarea>
                                                        <label for="description_eng">English description</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/.Third row-->
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="fa fa-google prefix"></i>
                                                        <input type="text" id="google" name="google" class="form-control"  value="{{ $user->google }}"/>
                                                        <label for="google">Google+</label>
                                                    </div>
                                                </div>
                                                <!--Second column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="fa fa-linkedin prefix"></i>
                                                        <input type="text" id="linkedin" name="linkedin" class="form-control"  value="{{ $user->linkedin }}"/>
                                                        <label for="linkedin">Linkedin</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="fa fa-facebook prefix"></i>
                                                        <input type="text" id="facebook" name="facebook" class="form-control"  value="{{ $user->facebook }}"/>
                                                        <label for="facebook">Facebook</label>
                                                    </div>
                                                </div>
                                                <!--Second column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <i class="fa fa-twitter prefix"></i>
                                                        <input type="text" id="twitter" name="twitter" class="form-control"  value="{{ $user->twitter }}"/>
                                                        <label for="twitter">Twitter</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Fourth row -->
                                            <div class="row">
                                                <div class="col-md-12 text-xs-center">
                                                    <button type="submit" value="Update Account" class="btn btn-primary">Update Account</button>
                                                </div>
                                            </div>
                                            <!-- /.Fourth row -->

                                            <!-- Edit Form -->
                                        </div>
                                        <!--/.Card content-->
                                    </div>
                                </div>
                                <!--/.Card-->
                            </div>
                            <!-- /.Second column -->
                       
                    </div>
                    <!-- /.First row -->
                     </form>
                </section>
                <!-- /.Section: Edit Account -->
    </div>
</main>
<!--/Main layout-->


@endsection

@section('scripts')
{!! Html::script('/js/general.js') !!}
{!! Html::script('/js/admin.js') !!}

<script>
$(document).ready(function () {

    new WOW().init();

    var nombre_erreur = 0, imageCrop = '', old_photo = '', new_photo = '';

    $('form').submit(function (event) {
        var form = $(this);
        new_photo = $(".avatar_image").attr("src") === $("#avatar_image").html() ? '&new_photo=' + $(".avatar_image").attr("src") : '';
        event.preventDefault();
        nombre_erreur = 0;
        nombre_erreur += $("input[name=last_name]").length > 0 && ($("input[name=last_name]").val()).trim() === '' ? error_text("Un last_name est obligatoire.", "last_name") : remove_error("last_name");
        nombre_erreur += $("input[name=first_name]").length > 0 && ($("input[name=first_name]").val()).trim() === '' ? error_text("Un prénom est obligatoire.", "first_name") : remove_error("first_name");
        nombre_erreur += $("input[name=email]").length > 0 && ($("input[name=email]").val()).trim() === '' ? error_text("Une adresse e-mail est obligatoire.", "email") : remove_error("email");

        if (nombre_erreur === 0) {
            if ($(".avatar_overlay .cr-boundary").length) {
                imageCrop.croppie('result', {
                    type: 'blob',
                    size: 'viewport',
                    /*size: 'original',converse aspect ratio*/
                    /*size:  { width: 1920, height: 1080 },*/
                    quality: 0.8,
                    format: "jpeg",
                    circle: false
                }).then(function (resp) {
                    blobToDataURL(resp, function (dataurl) {

                        $.ajax({
                            url: form.attr("action"),
                            type: form.attr('method'),
                            data: 'type_action=edit&' + form.serialize() + '&' + $.param({'avatar_image': dataurl}),
                            dataType: 'json',
                            encode: true
                        })
                        .done(function (data) {

                            if (data.success) {
                                remove_error("email");
                                swal({
                                    title: 'Confirmée!',
                                    text: "Votre compte a bien été mis à jour",
                                    type: 'success',
                                    allowOutsideClick: true,
                                    allowEscapeKey: true
                                }).then(function () {
                                    reset_avatar(imageCrop);
                                    $(".avatar_image").attr({"src": data.new_avatar});
                                    $("input[name=old_photo]").val(data.new_avatar);
                                });
                            }else{
                                data.errors.email ? error_text(data.errors.email, "email") : '';
                            }
                        })
                        .fail(function (data) {
                        });
                    });
                });
            }else{
                $.ajax({
                    url: form.attr("action"),
                    data: 'type_action=edit&' + form + new_photo,
                    type: form.attr('method'),
                    dataType: 'json',
                    encode: true
                })
                .done(function (data) {
                    if (data.success) {
                        remove_error("email");
                        console.log(data.test);
                        var new_avatar = data.new_avatar ? data.new_avatar : (new_photo ? $("#avatar_image").html() : '');
                        swal({
                            title: 'Confirmée!',
                            text: "Votre compte a bien été mis à jour",
                            type: 'success',
                            allowOutsideClick: true,
                            allowEscapeKey: true
                        }).then(function () {
                            reset_avatar(imageCrop);
                            new_photo ? $(".cancel_avatar").addClass("hidden-xs-up") : '';
                            if (new_avatar) {
                                $(".avatar_image").attr({"src": new_avatar});
                                $("input[name=old_photo]").val(new_avatar);
                            }
                        });
                    }else{
                        data.errors.email ? error_text(data.errors.email, "email") : '';
                    }
                })
                .fail(function (data) {
                });
            }
        }
    });

    /*upload avatar*/
    $('#upload').on('change', function () {
        old_photo = $(".avatar_image").attr("src");
        var selected_file_name = $(this).val();
        if (selected_file_name.length > 0) {
            /* Some file selected */
            var reader = new FileReader();
            reader.onload = function (e) {
                if (!$(".avatar_overlay .cr-boundary").length) {
                    imageCrop = initCrop();
                    $(".cancel_avatar i").removeClass("fa-trash").addClass("fa-ban");
                    $(".cancel_avatar").removeClass("hidden-xs-up");
                    $('.avatar_image').removeClass("img-fluid mx-auto d-block");
                    $(".avatar_overlay .rotate_left").removeClass("hidden-xs-up");
                }
                imageCrop.croppie('bind', {
                    url: e.target.result
                });
            };
            reader.readAsDataURL(this.files[0]);

        }
        $(this).val('');
    });

    /*rotate the image*/
    $('.rotate_left').on('click', function (ev) {
        imageCrop.croppie('rotate', parseInt($(this).data('deg')));
    });

    /*Supprimer avatar / cancel upload*/
    $(".cancel_avatar").on('click', function (ev) {
        if ($(".avatar_overlay .cr-boundary").length) {
            reset_avatar(imageCrop);
            old_photo === $("#avatar_image").html() ? $(".cancel_avatar").addClass("hidden-xs-up") : '';
        }else{
            if ($(".avatar_image").attr("src") !== $("#avatar_image").html()) {
                $(".avatar_image").attr({"src": $("#avatar_image").html()});
                $(".cancel_avatar").addClass("hidden-xs-up");
            }
        }
    });
}); 
</script>
@endsection