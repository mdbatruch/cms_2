        <footer>
            &copy; <?php echo date('Y'); ?>
        </footer>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="<?php echo url_for('/js/bootstrap.js'); ?>"></script>

        <script type="text/javascript">

        // $(document).ready(function() {
        //     alert($('form').attr('id'));
        // }); 
        
        $("#new-subject").on("submit", function(e){
            e.preventDefault();

            console.log('a submission has been tried');

                var formId = $('form').attr('id');                    
                var subject_name = $("#subject_name").val();
                var subject_position = $("#subject_position").val();

                if ( $('#subject_hidden').is(':checked') ) {

                    $('#subject_hidden').val(1);
                } else {

                    $('#subject_hidden').val(0);
                }
                var subject_hidden = $("#subject_hidden").val();

                $.ajax({
                    type: "POST",
                    url: "../../process.php",
                    dataType: "json",
                    data: {subject_name:subject_name, position:subject_position, visible:subject_hidden, id: formId},
                }).done(function(data){

                    if (!data.success) {

                            if (data.errors.subject_name) {

                                $('#name-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.subject_name + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#name-warning').html('');
                            }
                        
                            $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        
                            console.log('Subject did not submit!');

                        } else {


                            $(location).attr('href', data.redirect);
                            
                            console.log('Subject created!');

                            $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');

                        }
                    
                });

            });
    </script>
<script type="text/javascript">

$("#edit-subject").on("submit", function(e){
    e.preventDefault();

    console.log('a subject edit has been attempted');

        var formId = $('form').attr('id');                    
        var subject_name = $("#subject_name").val();
        var subject_position = $("#subject_position").val();
        var subjectId = $("#value").val();

        if ( $('#subject_hidden').is(':checked') ) {

            $('#subject_hidden').val(1);
        } else {

            $('#subject_hidden').val(0);
        }
        var subject_hidden = $("#subject_hidden").val();

        $.ajax({
            type: "POST",
            url: "../../process.php",
            dataType: "json",
            data: {subject_name:subject_name, position:subject_position, visible:subject_hidden, id: formId, subject_id: subjectId},
        }).done(function(data){

            if (!data.success) {

                    if (data.errors.subject_name) {

                        $('#name-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.subject_name + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $('#name-warning').html('');
                    }
                
                    $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                
                    console.log('Subject did not submit!');

                } else {


                    $(location).attr('href', data.redirect);
                    
                    console.log('Subject edited successfully!');

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');

                }
            
        });

    });
</script>
<script type="text/javascript">
        
    $("#new-page").on("submit", function(e){
        e.preventDefault();

        console.log('a page submission has been tried');
            
            var formId = $('form').attr('id');
            var page_name = $("#page-name").val();
            var page_position = $("#page-position").val();
            var subject_id = $("#subject-id").val();
            var subject_name = $("#subject-name").val();
            var pageId = $("#page_id").val();

            if ( $('#page-visible').is(':checked') ) {

                $('#page-visible').val(1);
            } else {

                $('#page-visible').val(0);
            }
            var page_hidden = $("#page-visible").val();
            var page_content = $("#page-content").val();

            $.ajax({
                type: "POST",
                url: "../../process.php",
                dataType: "json",
                data: {name:page_name, position:page_position, visible:page_hidden, subject_id:subject_id, content:page_content, id:formId, page_id:pageId, subject_name:subject_name},
            }).done(function(data){

            if (!data.success) {

                    if (data.errors.name) {

                        $('#name-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.name + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $('#name-warning').html('');
                    }
                
                    $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                
                    console.log('Subject did not submit!');

                } else {

                    $(location).attr('href', data.redirect);
                    
                    console.log('Page created!');

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');
                }
            
        });

    });
</script>

<script type="text/javascript">
        
    $("#edit-page").on("submit", function(e){
        e.preventDefault();

        console.log('a page edit has been tried');
            
            var formId = $('form').attr('id');
            var page_name = $("#page-name").val();
            var page_position = $("#page-position").val();
            var subject_id = $("#subject-id").val();
            var subject_name = $("#subject-name").val();
            var pageId = $("#value").val();

            if ( $('#page-visible').is(':checked') ) {

                $('#page-visible').val(1);
            } else {

                $('#page-visible').val(0);
            }
            var page_hidden = $("#page-visible").val();
            var page_content = $("#page-content").val();

            $.ajax({
                type: "POST",
                url: "../../process.php",
                dataType: "json",
                data: {name:page_name, position:page_position, visible:page_hidden, subject_id:subject_id, content:page_content, id:formId, page_id: pageId, subject_name:subject_name},
            }).done(function(data){

            if (!data.success) {

                    if (data.errors.name) {

                        $('#name-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.name + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $('#name-warning').html('');
                    }
                
                    $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                
                    console.log('Page was not successfully edited!');

                } else {

                    // $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');

                    $(location).attr('href', data.redirect);
                    
                    console.log('Page has been successfully edited!');

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');
                }
            
        });

    });
</script>

<script type="text/javascript">
        
    $("#login").on("submit", function(e){
        e.preventDefault();

        console.log('a login has been attempted');

        // function loginForm() {

            var formData = {
                'username'         : $('input[name=username]').val(),
                'password'         : $('input[name=password]').val(),
                'id'               : $('form').attr('id')
            };
            // var username = $("#username").val();
            // var password = $("#password").val();

            $.ajax({
                type: "POST",
                url: "../process.php",
                dataType: "json",
                // data: $("#new-subject").serialize(),
                data: formData,
                // data: formData,
            }).done(function(data){

                // alert('submitted');

                if (!data.success) {

                        if (data.errors.username) {
                            $('#username-error').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.username + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else {
                            $('#username-error').html('');
                        }

                        if (data.errors.password) {
                            $('#password-error').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.password + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else {
                            $('#password-error').html('');
                        }
                    
                        $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    
                        console.log('Login Not Successful!');

                    } else {

                        // $('.alert-danger').remove();

                        $(location).attr('href', data.redirect);

                        // window.location.replace(data.redirecturl);

                        // header('Location:' + data.redirecturl);
                        
                        console.log('Login Successful!');
                        // alert('Just got in!');

                        $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');

                        // $('#login-form').trigger("reset");
                    }
                
            });

        // }
        });
</script>
<script type="text/javascript">
        
        $("#new-admin").on("submit", function(e){
            e.preventDefault();
    
            console.log('admin account creation has been tried');
                
                // var formId = $('form').attr('id');
                // var first_name = $("#name").val();
                // var last_name = $("#lastname").val();
                // var email = $("#email").val();
                // var username = $("#username").val();
                // var password = $("#password").val();
                // var confirm_password = $("password-confirm").val();

                var formData = {
                    'id' : $('form').attr('id'),
                    'first_name' : $("#firstname").val(),
                    'last_name' : $("#lastname").val(),
                    'email' : $("#email").val(),
                    'username' : $("#username").val(),
                    'password' : $("#password").val(),
                    'password_confirm' : $("#password-confirm").val()
                }
    
                $.ajax({
                    type: "POST",
                    url: "../../process.php",
                    dataType: "json",
                    data: formData,
                    // data: {name:page_name, position:page_position, visible:page_hidden, subject_id:subject_id, content:page_content, id:formId, page_id:pageId},
                }).done(function(data){
    
                if (!data.success) {
    
                        if (data.errors.name) {
    
                            $('#name-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.name + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else {
                            $('#name-warning').html('');
                        }

                        if (data.errors.last_name) {

                            $('#last-name-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.last_name + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else {
                            $('#last-name-warning').html('');
                        }

                        if (data.errors.email) {
                            
                            $('#email-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.email + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else {
                            $('#email-warning').html('');
                        }

                        if (data.errors.username) {
                            
                            $('#username-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.username + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else {
                            $('#username-warning').html('');
                        }

                        if (data.errors.password) {
                            
                            $('#password-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.password + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else {
                            $('#password-warning').html('');
                        }

                        if (data.errors.password_confirm) {
                            
                            $('#password-confirm-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.password_confirm + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else {
                            $('#password-confirm-warning').html('');
                        }
                    
                        $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    
                        console.log('admin account did not submit!');
    
                    } else {
    
                        $(location).attr('href', data.redirect);
                        
                        console.log('Admin created!');
    
                        $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');
                    }
                
            });
    
        });
    </script>
<script type="text/javascript">
        
    $("#edit-admin").on("submit", function(e){
        e.preventDefault();

        console.log('admin account update has been tried');
            
            // var formId = $('form').attr('id');
            // var first_name = $("#name").val();
            // var last_name = $("#lastname").val();
            // var email = $("#email").val();
            // var username = $("#username").val();
            // var password = $("#password").val();
            // var confirm_password = $("password-confirm").val();

            var formData = {
                'id' : $('form').attr('id'),
                'current_id' : $("#current_id").val(),
                'first_name' : $("#firstname").val(),
                'last_name' : $("#lastname").val(),
                'email' : $("#email").val(),
                'username' : $("#username").val(),
                'password' : $("#password").val(),
                'password_confirm' : $("#password-confirm").val()
            }

            $.ajax({
                type: "POST",
                url: "../../process.php",
                dataType: "json",
                data: formData,
                // data: {name:page_name, position:page_position, visible:page_hidden, subject_id:subject_id, content:page_content, id:formId, page_id:pageId},
            }).done(function(data){

            if (!data.success) {

                    if (data.errors.name) {

                        $('#name-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.name + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $('#name-warning').html('');
                    }

                    if (data.errors.last_name) {

                        $('#last-name-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.last_name + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $('#last-name-warning').html('');
                    }

                    if (data.errors.email) {
                        
                        $('#email-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.email + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $('#email-warning').html('');
                    }

                    if (data.errors.username) {
                        
                        $('#username-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.username + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $('#username-warning').html('');
                    }

                    if (data.errors.password) {
                        
                        $('#password-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.password + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $('#password-warning').html('');
                    }

                    if (data.errors.password_confirm) {
                        
                        $('#password-confirm-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.password_confirm + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $('#password-confirm-warning').html('');
                    }
                
                    $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                
                    console.log('admin account did not submit!');

                } else {

                    $(location).attr('href', data.redirect);
                    
                    console.log('Admin created!');

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');
                }
            
        });

    });
</script>
    </body>
</html>


<?php

    db_disconnect($db);
?>