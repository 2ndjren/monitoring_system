@extends('layout')
@section('title', 'Dashboard | Import File')
@section('import')
    @if (session('msg'))
        <p>{{ session('msg') }}</p>
    @endif
    <form method="POST" action="{{ url('/file/import') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" accept=".xlsx, .xls, .ods" name="excel_file">
        <button type="submit">submit</button>
    </form>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            Import()
        });

        function Import() {
            $("#fileImport").submit(function(e) {
                e.preventDefault();
                $("#fileImport span").remove();

                $.ajax({
                    url: `/file/import`,
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        showtoastMessage("text-success", "Added Successful", res.msg);
                        // get_all();
                        $(`#fileImport`).trigger("reset");
                        // $(`#addModal`).modal("hide");
                    },
                    error: function(res) {
                        var errors = res.responseJSON.errors;
                        // console.log(errors)

                        var inputs = $(
                            "#fileImport input, #fileImport select, #fileImport textarea"
                        );
                        for (input of inputs) {
                            var name = $(input).attr("name");

                            if (name in errors) {
                                for (error of errors[name]) {
                                    var error_msg = $(
                                        `<span class='text-danger'>${error}</span>`
                                    );
                                    error_msg.insertAfter($(input));
                                }
                            }
                        }
                    },
                });
            });

        }
    </script>
@endsection
