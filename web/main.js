window.onload = function(){

    var leftBlock = document.getElementById('left-block');
    var rightBlock = document.getElementById('right-block');
    var leftBlocks = document.querySelectorAll('.left-block-item');


    console.log(leftBlocks);

    leftBlocks.forEach(function(item) {
        item.addEventListener('mousedown', function (e) {
            console.log('eeee', e.pageX, e.pageY);
            console.log('Координаты правого блока', rightBlock.getBoundingClientRect());


            item.onmousemove = function(e) {
                console.log('eeee', e.pageX, e.pageY);
            }

        });
    });

    leftBlocks.forEach(function(item) {
        item.addEventListener("mouseup", function(e){
            item.onmousemove = null
        });
    });


};
