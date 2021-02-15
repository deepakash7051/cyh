$(document).ready(function () {
  window._token = $('meta[name="csrf-token"]').attr('content')

  ClassicEditor.create(document.querySelector('.ckeditor'))

  moment.updateLocale('en', {
    week: {dow: 1} // Monday is the first day of the week
  })

  $('.date').datetimepicker({
    format: 'YYYY-MM-DD',
    locale: 'en'
  })

  $('.datetime').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    locale: 'en',
    sideBySide: true
  })

  $('.timepicker').datetimepicker({
    format: 'HH:mm:ss'
  })

  $('.select-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', 'selected')
    $select2.trigger('change')
  })
  $('.deselect-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', '')
    $select2.trigger('change')
  })

  $('.select2').select2();

  $('.treeview').each(function () {
    var shouldExpand = false
    $(this).find('li').each(function () {
      if ($(this).hasClass('active')) {
        shouldExpand = true
      }
    })
    if (shouldExpand) {
      $(this).addClass('active')
    }
  });

    $('#same_for_all').change(function() {
        if($(this).is(":checked")) {
            $('.otherlang').hide();
        } else {
            $('.otherlang').show();
        }
    });

    $('#sameans_for_all').change(function() {
        if($(this).is(":checked")) {
            $('.otherlangans').hide();
        } else {
            $('.otherlangans').show();
        }
    });

    $('#sameoption_for_all').change(function() {
        if($(this).is(":checked")) {
            $('.otherlangoption').hide();
        } else {
            $('.otherlangoption').show();
        }
    });

    $('#visible').change(function() {
        var type = $("#type").val();
        if($(this).val()=='text') {
            $('#quesattachments').hide();
            $('#questitles').show();

            if(type=='1'){
                $('#ques_options').show();
            } else {
                $('#ques_options').hide();
            }

        } else {
            $('#ques_options').hide();
            $('#quesattachments').show();
            $('#questitles').hide();
        }
    });

    $('#type').change(function() {
        var visible = $("#visible").val();
        if($(this).val()== '1' && visible=='text') {
            /*$('#visiblesec').show();
            $('#questitles').hide();*/
            $('#ques_options').show();
        } else {
            $('#ques_options').hide();
            /*$('#visiblesec').hide();
            $('#questitles').show();*/
        }
    });

})

$(function () {
    $('.decimalp3').on('input', function(e) {
        if (/^(\d+(\.\d{0,3})?)?$/.test($(this).val())) {
            // Input is OK. Remember this value
            $(this).data('prevValue', $(this).val());
        } else {
            // Input is not OK. Restore previous value
            $(this).val($(this).data('prevValue') || '');
        }
    }).trigger('input'); // Initialise the `prevValue` data properties

    $('.decimalp2').on('input', function(e) {
        if (/^(\d+(\.\d{0,2})?)?$/.test($(this).val())) {
            // Input is OK. Remember this value
            $(this).data('prevValue', $(this).val());
        } else {
            // Input is not OK. Restore previous value
            $(this).val($(this).data('prevValue') || '');
        }
    }).trigger('input'); // Initialise the `prevValue` data properties

    $('.onlynumeric').on('input', function(e) {
        if (/^\d*$/.test($(this).val())) {
            // Input is OK. Remember this value
            $(this).data('prevValue', $(this).val());
        } else {
            // Input is not OK. Restore previous value
            $(this).val($(this).data('prevValue') || '');
        }
    }).trigger('input'); // Initialise the `prevValue` data properties

    $('.numericspace').on('input', function(e) {
        if (/^[0-9\s]*$/.test($(this).val())) {
            // Input is OK. Remember this value
            $(this).data('prevValue', $(this).val());
        } else {
            // Input is not OK. Restore previous value
            $(this).val($(this).data('prevValue') || '');
        }
    }).trigger('input'); // Initialise the `prevValue` data properties

    //$( "#sortable" ).sortable();
    $( "#videosortable" ).disableSelection();
    $('#videosortable').sortable({
        start: function(event, ui) {
            var start_pos = ui.item.index();
            ui.item.data('start_pos', start_pos);
        },
        change: function(event, ui) {
            var start_pos = ui.item.data('start_pos');
            var index = ui.placeholder.index();
            if (start_pos < index) {
                $('#videosortable li:nth-child(' + index + ')').addClass('highlights');
            } else {
                $('#videosortable li:eq(' + (index + 1) + ')').addClass('highlights');
            }
        },
        update: function(event, ui) {
            $('#videosortable li').removeClass('highlights');
        },
        stop: function(event, ui) {  
            //var total = $('#videosortable li').length;
            //console.log(total);
            var videoplaces = [];
            $('#videosortable li').each(function (index, key) {
                videoplaces.push(key.dataset.val);
            });
            $.ajax(
            {
                type:'post',
                url: $("#base_url").val() +"/admin/arrangevideos",
                data: {_token: _token, 'videoplaces' : videoplaces},
                success:function(result)
                {
                    console.log(result);
                }
            });
        }
    });

    $( "#slidesortable" ).disableSelection();
    $('#slidesortable').sortable({
        start: function(event, ui) {
            var start_pos = ui.item.index();
            ui.item.data('start_pos', start_pos);
        },
        change: function(event, ui) {
            var start_pos = ui.item.data('start_pos');
            var index = ui.placeholder.index();
            if (start_pos < index) {
                $('#slidesortable li:nth-child(' + index + ')').addClass('highlights');
            } else {
                $('#slidesortable li:eq(' + (index + 1) + ')').addClass('highlights');
            }
        },
        update: function(event, ui) {
            $('#slidesortable li').removeClass('highlights');
        },
        stop: function(event, ui) {  
            //var total = $('#videosortable li').length;
            //console.log(total);
            var slideplaces = [];
            $('#slidesortable li').each(function (index, key) {
                slideplaces.push(key.dataset.val);
            });
            $.ajax(
            {
                type:'post',
                url: $("#base_url").val() +"/admin/arrangeslides",
                data: {_token: _token, 'slideplaces' : slideplaces},
                success:function(result)
                {
                    console.log(result);
                }
            });
        }
    });

    $( "#quizsortable" ).disableSelection();
    $('#quizsortable').sortable({
        start: function(event, ui) {
            var start_pos = ui.item.index();
            ui.item.data('start_pos', start_pos);
        },
        change: function(event, ui) {
            var start_pos = ui.item.data('start_pos');
            var index = ui.placeholder.index();
            if (start_pos < index) {
                $('#quizsortable li:nth-child(' + index + ')').addClass('highlights');
            } else {
                $('#quizsortable li:eq(' + (index + 1) + ')').addClass('highlights');
            }
        },
        update: function(event, ui) {
            $('#quizsortable li').removeClass('highlights');
        },
        stop: function(event, ui) {  
            //var total = $('#videosortable li').length;
            //console.log(total);
            var quizplaces = [];
            $('#quizsortable li').each(function (index, key) {
                quizplaces.push(key.dataset.val);
            });
            $.ajax(
            {
                type:'post',
                url: $("#base_url").val() +"/admin/arrangequizzes",
                data: {_token: _token, 'quizplaces' : quizplaces},
                success:function(result)
                {
                    console.log(result);
                }
            });
        }
    });

    $( "#questionsortable" ).disableSelection();
    $('#questionsortable').sortable({
        start: function(event, ui) {
            var start_pos = ui.item.index();
            ui.item.data('start_pos', start_pos);
        },
        change: function(event, ui) {
            var start_pos = ui.item.data('start_pos');
            var index = ui.placeholder.index();
            if (start_pos < index) {
                $('#questionsortable li:nth-child(' + index + ')').addClass('highlights');
            } else {
                $('#questionsortable li:eq(' + (index + 1) + ')').addClass('highlights');
            }
        },
        update: function(event, ui) {
            $('#questionsortable li').removeClass('highlights');
        },
        stop: function(event, ui) {  
            //var total = $('#videosortable li').length;
            //console.log(total);
            var questionplaces = [];
            $('#questionsortable li').each(function (index, key) {
                questionplaces.push(key.dataset.val);
            });
            $.ajax(
            {
                type:'post',
                url: $("#base_url").val() +"/admin/arrangequestions",
                data: {_token: _token, 'questionplaces' : questionplaces},
                success:function(result)
                {
                    console.log(result);
                }
            });
        }
    });

});
