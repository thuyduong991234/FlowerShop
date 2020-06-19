$(document).ready(function () {
    var listFlower = [];
    var listAll = [];
    var flower_id = "";
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
            url: 'api/flowers',
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
                listFlower = msg.data;
                //
                msg.data.forEach(function (item, index) {
                    $('#tbFlower > tbody').append('<tr>' +
                        `<th scope="row">` + index + `</th>
                        <td>
                        <i class="fas fa-trash-alt" style="color: red" name = "btnDelete" data-toggle="modal" data-target="#modalDelete"></i>
                        </td>
                        <td >
                        <i class="fas fa-user-edit" style="color: #293c74" name = "btnEdit" data-toggle="modal" data-target="#modalDetailItem"></i>
                        </td><td>` +
                        item.id + '</td><td>' +
                        item.catalog_id + '</td><td>' +
                        item.name + '</td><td>' +
                        item.color + '</td><td>' +
                        item.price + '</td><td>' +
                        item.discount + '</td><td>' +
                        item.avatar + '</td><td>' +
                        item.images + '</td><td>' +
                        item.view + '</td><td>' +
                        item.created_at + '</td><td>' +
                        item.updated_at + '</td></tr>');
                })

                //pagination
                customPagination(msg);

                //delete
                $('[name=btnDelete]').click(function() {
                    var row = $(this).closest("tr")[0];
                    flower_id = row.cells[3].innerText;
                    console.log(flower_id);
                })

                //edit
                $('[name=btnEdit]').click(function() {
                    isNew = false;
                    row = $(this).closest("tr")[0];
                    flower_id = row.cells[3].innerText;
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
                if(window.location.href.includes('?'))
                {
                    let Param = ((window.location.href).split('?'))[1];
                    let listParams = Param.split('&');
                    listParams.forEach(function (item) {
                        let key = item.split('=')[0];
                        let value = item.split('=')[1];
                        if(key == "name"){
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
                    url: $(this).attr('link'),
                    type: 'GET',
                    success: function( msg ) {
                        //console.log(msg.data);

                        //change url
                        if(name != "")
                        {
                            url = window.location.protocol + "//" + window.location.host + window.location.pathname + "?name=" + name + "&page="+msg.pagination.currentPage;
                        }
                        else
                        {
                            url = window.location.protocol + "//" + window.location.host + window.location.pathname + "?page="+msg.pagination.currentPage;
                        }
                        window.history.pushState( {} , '', url);

                        $('#tbFlower > tbody').children().remove();
                        listFlower = msg.data;
                        //
                        msg.data.forEach(function (item, index) {
                            $('#tbFlower > tbody').append('<tr>' +
                                `<th scope="row">` + index + `</th>
                        <td>
                        <i class="fas fa-trash-alt" style="color: red" name = "btnDelete" data-toggle="modal" data-target="#modalDelete"></i>
                        </td>
                        <td >
                        <i class="fas fa-user-edit" style="color: #293c74" name = "btnEdit" data-toggle="modal" data-target="#modalDetailItem"></i>
                        </td><td>` +
                                item.id + '</td><td>' +
                                item.catalog_id + '</td><td>' +
                                item.name + '</td><td>' +
                                item.color + '</td><td>' +
                                item.price + '</td><td>' +
                                item.discount + '</td><td>' +
                                item.avatar + '</td><td>' +
                                item.images + '</td><td>' +
                                item.view + '</td><td>' +
                                item.created_at + '</td><td>' +
                                item.updated_at + '</td></tr>');
                        })

                        //pagination
                        customPagination(msg);

                        //delete
                        $('[name=btnDelete]').click(function() {
                            var row = $(this).closest("tr")[0];
                            flower_id = row.cells[3].innerText;
                            console.log(flower_id);
                        })

                        //edit
                        $('[name=btnEdit]').click(function() {
                            isNew = false;
                            row = $(this).closest("tr")[0];
                            flower_id = row.cells[3].innerText;
                            //console.log(row.cells[4].innerText);
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

})