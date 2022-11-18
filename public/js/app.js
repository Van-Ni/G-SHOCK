$(document).ready(function () {
    $(".nav-link.active .sub-menu").slideDown();
    // $("p").slideUp();

    $("#sidebar-menu .arrow").click(function () {
        $(this).parents("li").children(".sub-menu").slideToggle();
        $(this).toggleClass("fa-angle-right fa-angle-down");
    });

    $("input[name='checkall']").click(function () {
        var checked = $(this).is(":checked");
        $(".table-checkall tbody tr td input:checkbox").prop(
            "checked",
            checked
        );
    });
    // upload image before upload
    function filePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#uploadFile + img").remove();
                $("#store-img").html('<img src="' + e.target.result + '" width="150" height="150"/>');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#file").change(function() {
        filePreview(this);
    })
    //
});

