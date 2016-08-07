$(function(){
   $(document).on('click','.fc-day, .fc-day-number',function(){

       var date = $(this).attr('data-date');

       $.get('  ajax',{'date':date}, function (data) {

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
        console.log(pagelink);
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
                console.log(res);
            },
            error:function(){
                alert('Error!');
            }
        })
    })
});