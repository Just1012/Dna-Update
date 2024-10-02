$(function() {
    $(".calss_order_id").click(function(){
        var id_order=$(this).attr("data-order-id");

        var start_date=$(this).closest(".order").find(".start_date").html();

        var startDate = new Date(start_date); // قم بتغيير هذا إلى تاريخ الإبداء الفعلي

        // الحصول على التاريخ الحالي
        var currentDate = new Date();

        // حساب الفرق بين التاريخين (بالأيام)
        var timeDifference = Math.floor((currentDate - startDate) / (1000 * 60 * 60 * 24)); // تحويل الفرق إلى أيام

        // إذا مرّ 3 أيام أو أكثر
        if (timeDifference >= 3 && timeDifference !== ""  && $(".edit_user_input_pro").length === 0) {

            console.log(timeDifference);

            $(".add_input_edit").append(`
                <a href="/en/show-edit-user/${id_order}" class="btn btn-primary edit_user_input_pro"><i
                class="ri-edit-line align-bottom me-1"></i> Edit</a>
                `)


            }


    });
});
