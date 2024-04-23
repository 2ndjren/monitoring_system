$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    get_all()

    $('#addModal').on('show.bs.modal', function(e) {
        $('#addForm span').remove()
    })

    $('#addForm').submit(function(e) {
        e.preventDefault()
        $('#addForm span').remove()

        $.ajax({
          url: `/${ent}/add/`,
          method: 'POST',
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function (res) {
            alert(res.msg)
            get_all()
            $(`#addForm`).trigger('reset')
            $(`#addModal`).modal('hide')
          },
          error: function (res) {
            var errors = res.responseJSON.errors
            // console.log(errors)

            var inputs = $('#addForm input, #addForm select, #addForm textarea')
            for (input of inputs) {
              var name = $(input).attr('name')

              if (name in errors) {
                for (error of errors[name]) {
                    var error_msg = $(`<span class='text-danger'>${error}</span>`)
                    error_msg.insertAfter($(input))
                }
              }
            }
          },
        })    
    })   

    $('#updModal').on('show.bs.modal', function(e) {
        $('#updForm span').remove()
    })

    $('#updForm').submit(function(e) {
        e.preventDefault()
        $('#updForm span').remove()

        $.ajax({
          type: 'POST',
          url: `/${ent}/upd/`,
          data: new FormData(this),
          contentType: false,
          processData: false,
          success: function (res) {
            alert(res.msg)
            get_all()
            $(`#updForm`).trigger('reset')
            $(`#updModal`).modal('hide')
          },
          error: function (res) {
            console.log(res)
            var errors = res.responseJSON.errors
            // console.log(errors)

            var inputs = $('#updForm input, #updForm select, #updForm textarea')
            $.each(inputs, function(index, input) {
              var name = $(input).attr('name')

              if (name in errors) {
                for (error of errors[name]) {
                    var error_msg = $(`<span class='text-danger'>${error}</span>`)
                    error_msg.insertAfter($(input))
                }
              }
            })
          },
        })    
    })  

    $('#delForm').submit(function(e) {
        e.preventDefault()
        $.ajax({
          type: 'POST',
          url: `/${ent}/del/`,
          data: $(this).serialize(),
          success: function (res) {
            alert(res.msg)
            get_all()
            $(`#delModal`).modal('hide')
          },
          error: function (xhr, status, error) {

          },
        })    
    })  

    $(document).on('click', '.i_edit', function() {
        var tr = $(this).parents()[1]
        var id = $(tr).data('id')

        $('#updForm input[name=id]').val(id)
        $(`#updModal`).modal('show')

        $.ajax( {
          method:"POST",
          url: `/${ent}/edit/`,
          data: {'id' : id},
          success: function(res) {
            var record = res.record
            
            var keys = ['fname', 'lname', 'phone', 'email']

            for (key of (keys)) { $(`#updForm input[name=${key}]`).val(record[key]) }
          }
        })
    })

    $(document).on('click', '.i_del', function() {
        var tr = $(this).parents()[1]
        var id = $(tr).data('id')

        $('#delForm input[name=id]').val(id)
        $(`#delModal`).modal('show')
    })

});

var ent = $('.ent').text().toLowerCase()

function get_all() {
    $('#tbl_div').empty()

    $.ajax({
        type: 'POST',
        url: `${ent}`,
        success: function (res) {
            var records = res.records

            var tbl = $('<table>').addClass('w-100 overflow-auto').attr('id', 'tbl_records')

            var thead = $('<thead>')
            var thr = $('<tr>')
            var cols = ['#', 'First Name', 'Last Name', 'Contact Number', 'Email', 'Action']
            for (col of cols) { thr.append($('<th>').addClass('bg-success border border-dark border-5 m-1 text-center p-2').text(col)) }
            thead.append(thr)
            tbl.append(thead)

            var tbody = $('<tbody>')
            for (record of records) {
                var vals = [record.fname, record.lname, record.phone, record.email]

                var tr = $('<tr>').data('id', record.id)
                tr.append($('<td>').addClass('border border-dark border-5 text-center').html('<i class="fa-solid fa-user"></i>'))

                var td_class = 'p-2 border border-dark border-5 text-center'
                for (val of vals) { tr.append($('<td>').addClass(td_class).html(val)) }

                tr.append($('<td>').addClass(td_class).html(`
                    <i class='fa fa-pen-to-square mr-2 i_edit'></i>
                    <i class='fa-solid fa-trash i_del'></i>
                `))
                tbody.append(tr)
            }
            tbl.append(tbody)
            $('#tbl_div').append(tbl)
        },
        error: function(res) {

        }
    })
}