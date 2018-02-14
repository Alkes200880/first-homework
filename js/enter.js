function hidePass($pass){
    return $pass
}
function reloadPage() {
    $("#return").text("перегрузим страницу");
    setTimeout(()=>{
        location.reload();
    }, 2000);

}

function ajaxLogin() {

    $.post("/welcome/ajaxLogin",
        {
            "Login": $("#Login").val(),
            "Pass": hidePass($("#Pass").val())

        },
        onAjaxSucces);
}
function onAjaxSucces(data) {
    let ret=JSON.parse(data);
    console.log(ret);
    if(ret.status!==0) $("#return").text(ret.error);
    else reloadPage();
    //console.log(this);
    //location.reload();
    //console.log(n1.press);

}
//console.log("begin");

$(document).ready(function(){
    //console.log("begin");

    // $(document).on("click",".cl",function(){
    //     console.log($(this));
    //     $(this).text("fgh");
    //     console.log($("#btn").val());
    //
    // });

    //console.log("begin");
    // $('.cl').on("click",()=>{
    //     console.log("ok");
    // });


    $(document).on("click","#enter",ajaxLogin);

   // $("body").append('<button class="cl">FAAAAAk</button>');

    //$("body").append('<button class="cl">FAAAAAk</button>');

});