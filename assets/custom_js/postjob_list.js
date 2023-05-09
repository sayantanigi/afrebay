function getsubcategory(val) {
    var base_url = $("#base_url").val();
    var id = val;
    $.ajax({
        type:"post",
        cache:false,
        url:base_url+"Welcome/subcategory_data",
        data:{
            id:id
        },
        beforeSend:function(){},
        success:function(returndata) {
            // console.log(returndata); return false;
            $('.sub_cat').show();
            $('#subcategory_list').html(returndata);
        }
    });
}
