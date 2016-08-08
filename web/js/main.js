var checkJson = {
    "checkItem":[

    ]
};


$(function(){

    //checkList
    function parseUrlQuery() {
        var data = {}
            ,   pair = false
            ,   param = false;
        if(location.search) {
            pair = (location.search.substr(1)).split('&');
            for(var i = 0; i < pair.length; i ++) {
                param = pair[i].split('=');
                data[param[0]] = param[1];
            }
        }
        return data;
    }




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

    $.ajax({
        url: 'update?id='+parseUrlQuery().id,
        type: "GET",
        dataType: 'json',

        success: function (data) {

            $(data.checkItem).each(function(indx){
                console.log(data.checkItem);
                //console.log(indx);
                //console.log($(data.checkItem)[indx].content);

                $(".todo-list").append('<div class="todo-item">' +
                    '<div class="todo-bg"></div>' +
                    '<div class="todo-check glyphicon glyphicon-ok"></div>' +
                    '<input type="text" class="todo-inp">' +
                    '<div class="todo-delete glyphicon glyphicon-remove"></div>' +
                    '</div>'
                );


                if(indx == 0){
                    $(".todo-delete").addClass("todo-action").removeClass("glyphicon-remove").removeClass("todo-delete")
                        .addClass("glyphicon-plus");
                }
                if (data.checkItem[indx].check == 1){
                    //console.log(data.checkItem[indx].check);
                    $(".todo-item").eq(indx).addClass("todo-checked");
                }

                $(".todo-inp").eq(indx).val(data.checkItem[indx].content);
                //console.log(data.checkItem[indx].content);
            });

        },
        error: function () {
            console.log("error");
            if($(".todo-item").length == 0){
                console.log("pew");
                $(".todo-list").append('<div class="todo-item">' +
                    '<div class="todo-bg"></div>' +
                    '<div class="todo-check glyphicon glyphicon-ok"></div>' +
                    '<input type="text" class="todo-inp">' +
                    '<div class="todo-action glyphicon glyphicon-plus"></div>' +
                    '</div>'
                );
            }else{
                console.log($(".todo-item").length);
            }
        }
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
            $(".modal-header").html("Добавить задачу");
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