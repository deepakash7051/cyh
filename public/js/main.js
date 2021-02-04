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

  $('.select2').select2()

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
  })
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

});
