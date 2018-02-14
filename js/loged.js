

function up(data,prev,e) {
    //console.log(data);
    $.post("/Loged/ajaxMoveUp",
        {
            "up": data,
            "prev": prev

        },
        function(data){
            console.log(JSON.parse(data));
            let pdiv = $(e.target).parent();
            pdiv.insertBefore(pdiv.prev());
            //           console.log($(e.target).parent());
            //$(e.target).parent().addClass("deleted")

        });
}
function down(data,next,e) {
    //console.log(data);
    $.post("/Loged/ajaxMoveDown",
        {
            "down": data,
            "next": next

        },
        function(data){
            console.log(JSON.parse(data));
            let pdiv = $(e.target).parent();
            pdiv.insertAfter(pdiv.next());
            //           console.log($(e.target).parent());
            //$(e.target).parent().addClass("deleted")

        });
}


function deleteN(data,e) {

    $.post("/Loged/ajaxRemoveWork",
        {
            "param1": data

        },
        function(data){
            console.log(JSON.parse(data));
            //           console.log($(e.target).parent());
            $(e.target).parent().addClass("deleted")

        });
}
function ajaxAdd() {

    $.post("/Loged/ajaxAddWork",
        {
            "num": $("#num").val(),
            "work": $("#work").val(),
            "date": $("#date").val(),

        },
        onAjaxSucces);
}
function onAjaxSucces(data) {
    let ret=JSON.parse(data);
    console.log(ret);
    $("#return").append('<div>'+'sort:'+ret.id+' Номер: '+ret.num+' / Дело : '+ret.work+' / Время : '+ret.date +
        '<button class="cl" value="'+ret.id+'">delete</button>' +
        '<button class="up">up</button>' +
        '<button class="down">down</button></div>'
    );
    //if(ret.status!==0) $("#return").text(ret.error);
    //else reloadPage();
    //console.log(this);
    //location.reload();
    //console.log(n1.press);

}
//console.log("begin");

$(document).ready(function(){
    //console.log("begin");

    $(document).on("click",".cl",function(e){
       // console.log($(this));
      //  $(this).text("fgh");
        //console.log($("#btn").val());
        deleteN($(this).val(),e)

    });
    $(document).on("click",".up",function(e){
        let change =$(this).parent().prev().find(".cl").val();
        if(change) up($(this).prev().val(),change,e)
    });

    $(document).on("click",".down",function(e){
        let change =$(this).parent().next().find(".cl").val();
        if(change) down($(this).prev().prev().val(),change,e)
    });


    //console.log("begin");
    // $('.cl').on("click",()=>{
    //     console.log("ok");
    // });


    $(document).on("click","#inject",ajaxAdd);

   // $("body").append('<button class="cl">FAAAAAk</button>');

    //$("body").append('<button class="cl">FAAAAAk</button>');

});