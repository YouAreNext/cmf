var checkJson = {
    "checkItem":[

    ]
};


$(function(){

    //checkList





    $("body").on("click",".todo-check",function () {
        var todoParent = $(this).parent(".todo-item");
        if (todoParent.hasClass("todo-checked")){
            todoParent.removeClass("todo-checked")
        }else{
            todoParent.addClass("todo-checked");
        }
    })
    $("body").on("click",".todo-action",function(){
        var todoItem = '<div class="todo-item"><div class="todo-bg"></div><div class="todo-check glyphicon glyphicon-ok"></div><input type="text" class="todo-inp" required><div class="todo-delete glyphicon glyphicon-remove"></div></div>'
        $(".todo-list").append(todoItem);
    })
    $("body").on("click",".todo-delete",function(){
        $(this).parent(".todo-item").remove();
    })




    $(".check-confirm").click(function(){
        var jsonLength = checkJson.checkItem.length;
        var dataId = $(this).attr("data-id");


        checkJson.checkItem.splice(0,jsonLength);

       $(".todo-list .todo-item").each(function(){
           if ($(this).hasClass("todo-checked")){
                var todoCheck = 1;

           }else{
               var todoCheck = 0;
           }
           var todoContent = $(this).children(".todo-inp").val();
           checkJson.checkItem.push(
               {
                   "check":todoCheck,
                   "content": todoContent,
               }
           )
       })

        $.ajax({
            url: 'update?id='+dataId,
            type: "POST",
            data: checkJson,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                alert("Чек-лист обновлен!");
            },

        })

    });



   $(document).on('click','.fc-day, .fc-day-number',function(){

       var date = $(this).attr('data-date');

       $.get('  ajax',{'date':date}, function (data) {

           $('#modal').modal('show');
           $(".modal-header").html("Добавить задачу");
           $(".modal-body").html(data);

       });
   });
    $(document).on('click','.add-task-period',function(){

        var date = $(this).attr('data-id');

        $.get('../tasks/period',{'id':date}, function (data) {

            $('#modal').modal('show');
            $(".modal-header").html("Добавить периодическую задачу");
            $(".modal-body").html(data);

        });
    });

    $(document).on('click','.add-task-project',function(){

        var date = $(this).attr('data-date');

        $.get('../tasks/ajax',{'date':date}, function (data) {

            $('#modal').modal('show');
            $(".modal-header").html("Добавить задачу");
            $(".modal-body").html(data);

        });
    });

    $(document).on('click','.add-task-sub',function(){

        var prev_task = $(this).attr('data-id');
        var pagelink = 'http://'+window.location.host+'/tasks/sub';
        //console.log(pagelink);
        $.get(pagelink,{'date':prev_task}, function (data) {
            $('#modal').modal('show');
            $(".modal-header").html("Добавить задачу");
            $(".modal-body").html(data);
        });
    });


});

$(document).ready(function(){
    $(".btn-test-ajax").on("click",function(){

        $.ajax({
            url: 'calendar',
            data: {test:'123'},
            type:'POST',
            success:function(res){
                //console.log(res);
            },
            error:function(){
                alert('Error!');
            }
        })
    })




});