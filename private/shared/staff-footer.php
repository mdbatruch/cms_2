        <footer>
            &copy; <?php echo date('Y'); ?>
        </footer>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="<?php echo url_for('/js/bootstrap.js'); ?>"></script>

        <script type="text/javascript">
        
        $("#new-subject").on("submit", function(e){
            e.preventDefault();

            console.log('a submission has been tried');

            // function loginForm() {

                var subject_name = $("#subject_name").val();
                var subject_position = $("#subject_position").val();

                if ( $('#subject_hidden').is(':checked') ) {
                    // alert ('checked');
                    $('#subject_hidden').val(1);
                } else {
                    // alert('not checked');
                    $('#subject_hidden').val(0);
                }
                var subject_hidden = $("#subject_hidden").val();

                // var subject_hidden = $("#subject_hidden").is(':checked');

                // var formData = $('#new-subject').serialize();

                $.ajax({
                    type: "POST",
                    url: "new-subject.php",
                    dataType: "json",
                    // data: $("#new-subject").serialize(),
                    data: {subject_name:subject_name, position:subject_position, visible:subject_hidden},
                    // data: formData,
                }).done(function(data){

                    // alert('submitted');

                    if (!data.success) {

                            if (data.errors.subject_name) {

                                $('#name-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.subject_name + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#name-warning').html('');
                            }
                        
                            $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        
                            console.log('Subject did not submit!');

                        } else {

                            // $('.alert-danger').remove();

                            $(location).attr('href', data.redirect);

                            // window.location.replace(data.redirecturl);

                            // header('Location:' + data.redirecturl);
                            
                            console.log('Subject created!');
                            // alert('Just got in!');

                            $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');

                            // $('#login-form').trigger("reset");
                        }
                    
                });

            // }
            });
    </script>
    </body>
</html>


<?php

    db_disconnect($db);
?>