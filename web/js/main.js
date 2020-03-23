$(document).ready(function () {

    $('.auth-btn').on('click', function () {
        let email = $('.email').val();
        let password = $('.password').val();
        $.ajax({
            url: "ajax/auth.php",
            type: "POST",
            data: {'email': email, 'password': password},
            success: function (data) {
                $('#message').append('<div class="alert alert-light"></div>');
                $('.alert').text(data);
                setTimeout(function () {
                    $('body').load('index.php');
                }, 2000);
            }
        })
    });

    $('.lg_out').on('click', function() {
        $('.lg_out').load('../../ajax/logout.php');
        $('body').load('index.php');
    });



    $('a').on('click', function (event) {
       event.preventDefault();
       $('.form-singin').load('../../view/reg.php').addClass('form-reg');

       $('body').on('click', '.reg_btn',  function () {
           let name = $('.name').val();
           let surname = $('.surname').val();
           let email = $('.email').val();
           let password = $('.password').val();
           let password2 = $('.password2').val();
           $.ajax({
               url: 'ajax/reg.php',
               type: 'POST',
               data: {'name': name, 'surname': surname, 'email': email,
                   'password': password, 'password2': password2},
               success: function (data) {
                   if(data.trim() == ''){
                       $('#message').append('<div class="alert alert-success">Registration successful</div>');
                       setTimeout(function () {
                           $('body').load('index.php');
                       }, 2000);
                   } else {
                       $('#message').append("<div class='alert alert-danger'></div>");
                       $('.alert').text(data);
                   }

               }
       })
       });
    });

    $("#prj_crt_btn").on("click", function () {
        let project_name = $(".prj_name").val();
        if(project_name.trim() == ''){
            $('#message').prepend('<div  class="alert alert-danger">Enter project name</div>');
            return false;
        }
        $.ajax({
            url: 'ajax/project_create.php',
            type: 'POST',
            data: {'project_name': project_name},
            success: function (data) {
                $(".prj_name").val('');
                $("#prj_list").prepend(data);
            }
        })
    });

    $('body').on("click", '.del_btn', function () {
        let pro_id = $(this).attr('prj_id');
        $.ajax({
            url: 'ajax/project_delete.php',
            type: 'POST',
            data: {'id': pro_id},
            success: function () {
                $(".prj-" + pro_id).remove();
            }
        })
    });

    $('body').on('click', '.upd_btn', function () {
        $('.pro_link').removeClass('pro_link');
        $(this).attr('disabled', true);
        let default_name = $(this).closest('.list-group-item ').children('span').text();
        $(this).closest('.list-group-item ').children('span').html('<input type="text" class="new_prj">');
        $('.new_prj').attr('value', default_name);
        $(this).closest('.list-group-item ').children('span').prepend('<input type="button" value="ok" class="submit">');
        $('.submit').on('click', function () {
            $(this).closest('.list-group-item ').children('.upd_btn').attr('disabled', false);
            let name = $('.new_prj').val();
            let id = $(this).closest('.list-group-item').children('span').attr('prj_id');
            $.ajax({
                url: 'ajax/project_update.php',
                type: 'POST',
                data: {'prj_name': name, 'prj_id': id},
                success: function () {
                    $('span.prj-id-' + id).text(name).addClass('pro_link');
                }
            })
        });
    });


    $('body').on('click', '.pro_link', function () {
        let prj_id = $(this).attr('prj_id');
        $.ajax({
            url: 'view/prj_page.php',
            type: 'POST',
            data: {'prj_id': prj_id},
            success: function (data) {
                $('.container').empty();
                $('.container').html(data);
            }

        });

        $('body').on('click', '.task_crt', function () {
            let tsk_name = $('.tsk_name').val();
            let priority = $('#priority').val();
            let d_line = $('#d_line').val();
            if(tsk_name.trim() == ''){
                $('#message').prepend('<div  class="alert alert-danger">Enter Task name</div>');
                return false;
            }
            $.ajax({
                url: 'ajax/task_create.php',
                type: 'POST',
                data: {'id': prj_id, 'tsk_name': tsk_name, 'priority': priority, 'd_line': d_line},
                success: function (data) {
                    $(".tsk_name").val('');
                    $('#tsk_list').prepend(data);
                }
            })
        });

        $('body').on('click', '.del_btn', function () {
            let tsk_id = $(this).closest('.list-group-item').children('span').attr('tsk_id');
            $.ajax({
                url: 'ajax/task_delete.php',
                type: 'POST',
                data: {'task_id': tsk_id},
                success: function (data) {
                    $('.tsk-' + tsk_id).remove();
                }
            })
        });

        $('body').on('click', '.dne_btn', function () {
            let tsk_id = $(this).closest('.list-group-item').children('span').attr('tsk_id');
            $.ajax({
                url: 'ajax/task_update.php',
                type: 'POST',
                data: {'id': tsk_id, 'data_set': 'done'},
                success: function (data) {
                    $('.tsk-' + tsk_id).css('text-decoration', 'line-through').fadeOut();
                }
            })
        });

        $('body').on('click', '.task_upd_btn', function () {
            let def_name = $(this).closest('.list-group-item').children('.tsk_name').text();
            let def_date = $(this).closest('.list-group-item').children('.dead_line').text();
            let def_prior = $(this).closest('.list-group-item').children('.priority').text();
            $(this).closest('.list-group-item ').children('.tsk_name').html('<input type="text" class="new_tsk">');
            $(this).closest('.list-group-item ').children('.dead_line').html('<input type="date" id="d_line" class="form-control new_date">');
            $(this).closest('.list-group-item ').children('.priority').html('' +
                '<select name="priority" ' + 'class="new_prior">\n' +
                    '<option value="High">High</option>\n' +
                    '<option value="Middle">Middle</option>\n' +
                    '<option value="Low">Low</option>\n' +
                '</select>');

            $('.new_tsk').attr('value', def_name);
            $('.new_date').attr('value', def_date);
            $('.new_prior option[value=' + def_prior + ']').attr('selected', 'selected');

            $(this).on('click', function () {
                let name = $('.new_tsk').val();
                let date = $('.new_date').val();
                let prior = $('.new_prior').val();
                let tsk_id = $(this).closest('.list-group-item').children('span').attr('tsk_id');
                $.ajax({
                    url: 'ajax/task_update.php',
                    type: 'POST',
                    data: {'id': tsk_id, 'task_name': name, 'dead_line': date, 'priority': prior, 'data_set': 'update'},
                    success: function () {
                        $('.tsk_name.tsk-' + tsk_id).text(name);
                        $('.priority.tsk-' + tsk_id).text(prior);
                        $('.dead_line.tsk-' + tsk_id).text(date);
                    }
                })
            })
        });

    });
});


