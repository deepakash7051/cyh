$(document).ready(function () {
  window._token = $('meta[name="csrf-token"]').attr('content')

  ClassicEditor.create(document.querySelector('.ckeditor'))

  moment.updateLocale('en', {
    week: {dow: 1} // Monday is the first day of the week
  })

  $('.date').datetimepicker({
    format: 'YYYY-MM-DD',
    locale: 'en'
  });

  $('.datetime').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    locale: 'en',
    sideBySide: true
  });

  $('.timepicker').datetimepicker({
    format: 'HH:mm:ss'
  });

  $('.attempts').datetimepicker({
    format: 'HH:mm',
  }).val('01:00');

  $('.select-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', 'selected')
    $select2.trigger('change')
  });

  $('.deselect-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', '')
    $select2.trigger('change')
  });

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

    $('#sametextans_for_all').change(function() {
        if($(this).is(":checked")) {
            $('.otherlangtextans').hide();
        } else {
            $('.otherlangtextans').show();
        }
    });

    $('#samemcqans_for_all').change(function() {
        if($(this).is(":checked")) {
            $('.otherlangmcqans').hide();
        } else {
            $('.otherlangmcqans').show();
        }
    });

    $('#sametextoption_for_all').change(function() {
        if($(this).is(":checked")) {
            $('.otherlangtextoption').hide();
        } else {
            $('.otherlangtextoption').show();
        }
    });

    $('#sameimgoption_for_all').change(function() {
        if($(this).is(":checked")) {
            $('.otherlangimgoption').hide();
        } else {
            $('.otherlangimgoption').show();
        }
    });

    /*$('#visible').change(function() {
        if($(this).val()=='text') {
            $('#quesattachments').hide();
            $('#questitles').show();
        } else {
            $('#quesattachments').show();
            $('#questitles').hide();
        }
    });*/

    $('#type').change(function() {
        var visible = $("#visible").val();
        if($(this).val()== '1'){
            $('#mcqcrctans').show();
            $('#mcqoptlbl').show();
            $('#shtcrctans').hide();
        } else {
            $('#mcqcrctans').hide();
            $('#mcqoptlbl').hide();
            $('#shtcrctans').show();
        }
        
    });

    $('#option_label').change(function() {
        if($(this).val()== 'text'){
            $('#ques_textoptions').show();
            $('#ques_imageoptions').hide();
        } else {
            $('#ques_textoptions').hide();
            $('#ques_imageoptions').show();
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
    //$( "#videosortable" ).disableSelection();
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

    //$( "#slidesortable" ).disableSelection();
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

    //$( "#quizsortable" ).disableSelection();
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

    //$( "#questionsortable" ).disableSelection();
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
