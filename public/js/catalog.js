$(document).ready(function () {
    var listCatalog = [];
    var listAll = [];
    var catalog_id = "";
    var name = "";
    var page = 1;
    var row, isNew;

    $(window).on('load', function() {
        if(window.location.href.includes('?'))
        {
            let Param = ((window.location.href).split('?'))[1];
            let listParams = Param.split('&');
            console.log(listParams);
            listParams.forEach(function (item) {
                let key = item.split('=')[0];
                let value = item.split('=')[1];
                if (key == "page") {
                    page = value;
                }
                else if(key == "name"){
                    name = value;
                }
            })
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'api/catalogs',
            type: 'GET',
            data:{
                'name': name,
                'page':page,
            },
            success: function (msg) {
                //set url
                if(name != "")
                {
                    url = window.location.protocol + "//" + window.location.host + window.location.pathname + "?name=" + name + "&page="+msg.pagination.currentPage;
                }
                else
                {
                    url = window.location.protocol + "//" + window.location.host + window.location.pathname + "?page="+msg.pagination.currentPage;
                }
                window.history.pushState( {} , '', url);

                //set data
                listCatalog = msg.data;
                //
                msg.data.forEach(function (item, index) {
                    $('#tbCatalog > tbody').append('<tr>' +
                        `<th scope="row">` + index + `</th>
                        <td>
                        <i class="fas fa-trash-alt" style="color: red" name = "btnDelete" data-toggle="modal" data-target="#modalDelete"></i>
                        </td>
                        <td >
                        <i class="fas fa-user-edit" style="color: #293c74" name = "btnEdit" data-toggle="modal" data-target="#modalDetailItem"></i>
                        </td><td>` +
                        item.id + '</td><td>' +
                        item.name + '</td><td>' +
                        item.parent_id + '</td><td>' +
                        item.created_at + '</td><td>' +
                        item.updated_at + '</td></tr>');
                })

                //pagination
                customPagination(msg);

                //delete
                $('[name=btnDelete]').click(function() {
                    var row = $(this).closest("tr")[0];
                    catalog_id = row.cells[3].innerText;
                    console.log(catalog_id);
                })

                //edit
                $('[name=btnEdit]').click(function() {
                    isNew = false;
                    row = $(this).closest("tr")[0];
                    catalog_id = row.cells[3].innerText;
                    //console.log(row.cells[4].innerText);
                })
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        })


        //get all catalogs
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'api/get-catalogs',
            type: 'GET',
            success: function( msg ) {
                //console.log(msg.data);
                listAll = msg.data;
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        })
    })

    function customPagination(msg) {
        $('#ul-pagination').children().remove();
        if(msg.pagination.currentPage == 1)
        {
            $('#ul-pagination').append(`<li class="page-item disabled">
                                            <a class="page-link">Previous</a>
                                            </li>`);
        }
        else
        {
            $('#ul-pagination').append(`<li class="page-item">
                                            <a class="page-link" link="${msg.pagination.links.previous}" name="btnPage">Previous</a>
                                            </li>`);
        }

        for(var i = 1; i <= msg.pagination.totalPages; i++)
        {
            if(msg.pagination.currentPage == i)
            {
                $('#ul-pagination').append(`<li class="page-item active" aria-current="page">
                                            <a class="page-link">`
                                            + i +
                                            `<a class="sr-only">(current)</a>
                                             </a>
                                             </li>`);
            }
            else
            {
                $('#ul-pagination').append(`<li class="page-item"><a class="page-link" link="http://localhost:8000/api/catalogs?page=${i}" name="btnPage">` + i + `</a></li>`);
            }
        }

        if(msg.pagination.currentPage == msg.pagination.totalPages)
        {
            $('#ul-pagination').append(`<li class="page-item disabled">
                                            <a class="page-link">Next</a>
                                            </li>`);
        }
        else
        {
            $('#ul-pagination').append(`<li class="page-item">
                                            <a class="page-link" link="${msg.pagination.links.next}" name="btnPage">Next</a>
                                            </li>`);
        }

        if($('[name=btnPage]').length !== 0 || msg.pagination.totalPages !== 0) {
            $('[name=btnPage]').click(function (e) {
                //console.log($(this).attr('link'));
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $(this).attr('link'),
                    type: 'GET',
                    success: function( msg ) {
                        //console.log(msg.data);

                        //change url
                        var url;
                        if(document.location.href.includes('?') && !document.location.href.includes('page')) {
                             url = window.location.protocol + "//" + window.location.host + window.location.pathname + "&page="+msg.pagination.currentPage;
                        }else{
                            url = window.location.protocol + "//" + window.location.host + window.location.pathname + "?page="+msg.pagination.currentPage;
                        }
                        window.history.pushState( {} , '', url);

                        $('#tbCatalog > tbody').children().remove();
                        listCatalog = msg.data;
                        //
                        msg.data.forEach(function (item, index) {
                            $('#tbCatalog > tbody').append('<tr>' +
                                `<th scope="row">` + index + `</th>
                        <td>
                        <i class="fas fa-trash-alt" style="color: red" name = "btnDelete" data-toggle="modal" data-target="#modalDelete"></i>
                        </td>
                        <td>
                        <i class="fas fa-user-edit" style="color: #293c74" name = "btnEdit" data-toggle="modal" data-target="#modalDetailItem"></i>
                        </td><td>` +
                                item.id + '</td><td>' +
                                item.name + '</td><td>' +
                                item.parent_id + '</td><td>' +
                                item.created_at + '</td><td>' +
                                item.updated_at + '</td></tr>');
                        })

                        //pagination
                        customPagination(msg);
                        $('[name=btnDelete]').click(function() {
                            var row = $(this).closest("tr")[0];
                            catalog_id = row.cells[3].innerText;
                            console.log(catalog_id);
                        })

                        $('[name=btnEdit]').click(function() {
                            isNew = false;
                            row = $(this).closest("tr")[0];
                            catalog_id = row.cells[3].innerText;
                            console.log(catalog_id);
                        })
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                })
            });
        }
        else {
            alert("Don't loaded");
        }
    }

    //modal add new items
    $('#modalDetailItem').on('show.bs.modal', function (event) {
        //clear text
        $('#catalog-name').val('');
        $("#noteName").css({display: "none"});
        $("#message-note-name").text("");
        $('#select-parent-id').children().remove();

        //set data to select option
        $('#select-parent-id').append('<option value=" " selected="selected">Không có</option>');
        listAll.forEach(function (item) {
            $('#select-parent-id').append(`<option value="${item.id}"> 
                                       ${item.name} 
                                  </option>`);
        })
        if(isNew == false)
        {
            console.log(row.cells[5].innerText);
            $('#catalog-name').val(row.cells[4].innerText);
            $('#select-parent-id').val(row.cells[5].innerText == "null" ? " " : row.cells[5].innerText);
        }
    })

    $('#btnAdd').click(function () {
        isNew = true;
    })
    
    //add item
    $('#btnSave').click(function () {
        //console.log('parent_id: ' + $('#select-parent-id').children("option:selected").val());
        if(isNew == true)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'api/catalogs',
                type: 'POST',
                data: {
                    name: $('#catalog-name').val(),
                    parent_id: $('#select-parent-id').children("option:selected").val(),
                },
                success: function( msg ) {
                    $('#modalDetailItem').modal('toggle');
                    $('#add-success').css({display: "block"});
                    setTimeout(function(){location.reload()}, 2000);
                },
                error: function(xhr) {
                    var err = JSON.parse(xhr.responseText);
                    if(err.errors.name)
                    {
                        $("#noteName").css({display: "block"});
                        $("#message-note-name").text(err.errors.name[0]);
                    }
                    console.log(err.errors.name[0]);
                }
            })
        }
        else
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'api/catalogs/' + catalog_id,
                type: 'PUT',
                data: {
                    name: $('#catalog-name').val(),
                    parent_id: $('#select-parent-id').children("option:selected").val(),
                },
                success: function( msg ) {
                    $('#modalDetailItem').modal('toggle');
                    $('#update-success').css({display: "block"});
                    setTimeout(function(){location.reload()}, 2000);
                },
                error: function(xhr) {
                    var err = JSON.parse(xhr.responseText);
                    if(err.errors.name)
                    {
                        $("#noteName").css({display: "block"});
                        $("#message-note-name").text(err.errors.name[0]);
                    }
                    console.log(err.errors.name[0]);
                }
            })
        }
    })

    $('#btnOKDel').click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'api/catalogs/' + catalog_id,
            type: 'DELETE',
            success: function( msg ) {
                $('#modalDelete').modal('toggle');
                $('#delete-success').css({display: "block"});
                setTimeout(function(){location.reload()}, 2000);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        })
    })

    $('#btnSearch').click(function () {
        name = $('#txtSearch').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'api/catalogs',
            type: 'GET',
            data:{
                'name': name
            },
            success: function( msg ) {
                var url = window.location.protocol + "//" + window.location.host + window.location.pathname + "?name="+name + "&page=1";
                window.history.pushState( {} , '', url);

                //set data
                $('#tbCatalog > tbody').children().remove();
                listCatalog = msg.data;
                //
                msg.data.forEach(function (item, index) {
                    $('#tbCatalog > tbody').append('<tr>' +
                        `<th scope="row">` + index + `</th>
                        <td>
                        <i class="fas fa-trash-alt" style="color: red" name = "btnDelete" data-toggle="modal" data-target="#modalDelete"></i>
                        </td>
                        <td >
                        <i class="fas fa-user-edit" style="color: #293c74" name = "btnEdit" data-toggle="modal" data-target="#modalDetailItem"></i>
                        </td><td>` +
                        item.id + '</td><td>' +
                        item.name + '</td><td>' +
                        item.parent_id + '</td><td>' +
                        item.created_at + '</td><td>' +
                        item.updated_at + '</td></tr>');
                })

                //pagination
                customPagination(msg);

                //delete
                $('[name=btnDelete]').click(function() {
                    var row = $(this).closest("tr")[0];
                    catalog_id = row.cells[3].innerText;
                    console.log(catalog_id);
                })

                //edit
                $('[name=btnEdit]').click(function() {
                    isNew = false;
                    row = $(this).closest("tr")[0];
                    catalog_id = row.cells[3].innerText;
                    //console.log(row.cells[4].innerText);
                })
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        })
    })
})