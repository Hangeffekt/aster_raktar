$(document).ready(function(){
    let url = window.location.pathname.split("/");

    $("#add_item").click(function(){
        $(".add_item_box").css("display", "block");
    });

    $("#add_item_box_close").click(function(){
        $("#add_item_box").css("display", "none");
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var form = '#Product-Search';
    var formAdvanced = '#Product-Search-Advanced';
    let table_id = $("#product_list").attr("data-bs-target");

    $(form).on('submit', function(event){
        event.preventDefault();
        
        $.ajax({
            url: $(this).attr("data-url"),
            method: 'POST',
            data: {
                ean: $("input[name=ean]").val()
            },
            success:function(response)
            {
                $(form).trigger("reset");
                if(response["Product"] != null){
                    let html = '';
                    if(url[1] == "arrivals"){
                        html += '<form action="' + $("#product_list").attr("data-url") + '" method="post"><h5 class="mt-3">' + response["Product"]["product_name"] + '</h5><input type="hidden" name="arrival_table_id" value="' + table_id + '"><input type="hidden" name="item_id" value="' + response["Product"]["product_id"] + '"><input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '"><div class="row"><div class="col mb-3"><label for="">Net price</label><input type="text" name="net_price" class="form-control" value="' + response["Product"]["net_price"] + '"></div><div class="col mb-3"><label for="">Sale price</label><input type="text" name="sale_price" class="form-control" value="' + response["Product"]["sale_price"] + '"></div><div class="col mb-3"><label for="">Qty</label><input type="text" name="qty" class="form-control" value="1"></div><input type="submit" value="Save" class="btn btn-success"></div></form>';
                    }
                    else if(url[1] == "sales"){
                        html += '<form action="' + $("#product_list").attr("data-url") + '" method="post"><h5 class="mt-3">' + response["Product"]["product_name"] + '</h5><input type="hidden" name="sale_product_id" value="' + response["Product"]["product_id"] + '"><input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '"><div class="row"><div class="col mb-3"><label for="">Sale price</label><input type="text" name="sale_product_value" class="form-control" value="' + response["Product"]["sale_price"] + '"></div><div class="col mb-3"><label for="">Qty</label><input type="text" name="sale_product_qty" class="form-control" value="1"></div><div class="col mb-3"></div><div class="mb-3"><input type="submit" value="Save" class="btn btn-success"></div></form>';
                    }
                    else if(url[1] == "transfer"){
                        html += '<form action="' + $("#product_list").attr("data-url") + '" method="post"><h5 class="mt-3">' + response["Product"]["product_name"] + '</h5><input type="hidden" name="sale_product_id" value="' + response["Product"]["product_id"] + '"><input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '"><div class="row"><div class="col mb-3"><label for="">Sale price</label><input type="text" name="sale_product_value" class="form-control" value="' + response["Product"]["sale_price"] + '"></div><div class="col mb-3"><label for="">Qty</label><input type="text" name="sale_product_qty" class="form-control" value="1"></div><div class="col mb-3"></div><div class="mb-3"><input type="submit" value="Save" class="btn btn-success"></div></form>';
                    }
                    else if(url[1] == "inventory-adjustments"){
                        html += '<form action="' + $("#product_list").attr("data-url") + '" method="post"><h5 class="mt-3">' + response["Product"]["product_name"] + '</h5><input type="hidden" name="sale_product_id" value="' + response["Product"]["product_id"] + '"><input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '"><div class="row"><div class="col mb-3"><label for="">Sale price</label><input type="text" name="sale_product_value" class="form-control" value="' + response["Product"]["sale_price"] + '"></div><div class="col mb-3"><label for="">Qty</label><input type="text" name="sale_product_qty" class="form-control" value="1"></div><div class="col mb-3"></div><div class="mb-3"><input type="submit" value="Save" class="btn btn-success"></div></form>';
                    }
                    $('#product_list').empty('').append(html);
                }
                else{
                    $(".ean_alert").css("display", "block");
                }
            },
            error: function(response) {
                console.log(response);
            }
        });
    });

    $(formAdvanced).on('submit', function(event){
        event.preventDefault();
        
        $.ajax({
            url: $(this).attr("data-url"),
            method: 'POST',
            data: {
                product_name: $("input[name=product_name]").val(),
                brand_id: $("select[name=brand_id]").val(),
                catalog_id: $("select[name=catalog_id]").val(),
                witoutzeroqty: $("checkbox[name=witoutzeroqty]").val()
            },
            success:function(response)
            {
                console.log(response["Products"]);
                if(response["Products"] != null){
                    html = "";
                    if(url[1] == "arrivals"){
                        $.each(response["Products"], function( index, value ) {
                            html += '<form action="' + $("#product_list").attr("data-url") + '" method="post"><h5 class="mt-3">' + value["product_name"] + '</h5><input type="hidden" name="arrival_table_id" value="' + table_id + '"><input type="hidden" name="item_id" value="' + value["uuid"] + '"><input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '"><div class="row"><div class="col mb-3"><label for="">Net price</label><input type="text" name="net_price" class="form-control" value="' + value["net_price"] + '"></div><div class="col mb-3"><label for="">Sale price</label><input type="text" name="sale_price" class="form-control" value="' + value["sale_price"] + '"></div><div class="col mb-3"><label for="">Qty</label><input type="text" name="qty" class="form-control" value="1"></div><input type="submit" value="Save" class="btn btn-success"></div></form>';
                        });
                    }
                    else if(url[1] == "sales"){
                        $.each(response["Products"], function( index, value ) {
                            html += '<form action="' + $("#product_list").attr("data-url") + '" method="post"><h5 class="mt-3 ">' + value["product_name"] + '</h5><input type="hidden" name="inner_table_id" value="' + table_id + '"><input type="hidden" name="product_id" value="' + value["uuid"] + '"><input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '"><div class="row"><div class="col mb-3"><label for="">Sale price</label><input type="text" name="sale_price" class="form-control" value="' + value["sale_price"] + '"></div><div class="col mb-3"><label for="">Qty</label><input type="text" name="qty" class="form-control" value="1"></div><div class="col mb-3"></div><div class="mb-3"><input type="submit" value="Save" class="btn btn-success"></div></form>';
                        });
                    }
                    else if(url[1] == "transfer"){
                        $.each(response["Products"], function( index, value ) {
                            html += '<form action="' + $("#product_list").attr("data-url") + '" method="post"><h5 class="mt-3 ">' + value["product_name"] + '</h5><input type="hidden" name="inner_table_id" value="' + table_id + '"><input type="hidden" name="product_id" value="' + value["uuid"] + '"><input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '"><div class="row"><div class="col mb-3"><label for="">Sale price</label><input type="text" name="sale_price" class="form-control" value="' + value["sale_price"] + '"></div><div class="col mb-3"><label for="">Qty</label><input type="text" name="qty" class="form-control" value="1"></div><div class="col mb-3"></div><div class="mb-3"><input type="submit" value="Save" class="btn btn-success"></div></form>';
                        });
                    }
                    else if(url[1] == "inventory-adjustments"){
                        $.each(response["Products"], function( index, value ) {
                            html += '<form action="' + $("#product_list").attr("data-url") + '" method="post"><h5 class="mt-3 ">' + value["product_name"] + '</h5><input type="hidden" name="inner_table_id" value="' + table_id + '"><input type="hidden" name="product_id" value="' + value["uuid"] + '"><input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '"><div class="row"><div class="col mb-3"><label for="">Qty</label><input type="text" name="qty" class="form-control" value="1"></div><div class="col mb-3"></div><div class="mb-3"><input type="submit" value="Save" class="btn btn-success"></div></form>';
                        });
                    }
                    $('#product_list').empty('').append(html);
                }
            },
            error: function(response) {
                console.log(response);
            }
        });
    });

    //systemalerts
    $.ajax({
        url: '/systemalerts/-',
        method: 'GET',
        data: {},
        success:function(response)
        {
            let badge = document.getElementById('notification-badge');
            let Systemalerts = response["Systemalerts"];
            badge.innerHTML = Systemalerts.length;
            badge.style.display = 'block';
        },
        error: function(response) {
            console.log(response);
        }
    })
});