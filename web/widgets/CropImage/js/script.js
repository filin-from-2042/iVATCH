// Переменные
var canvas, ctx;
var image;
var iMouseX, iMouseY = 1;
var theSelection;

// Определяем конструктор Selection
function Selection(x, y, w, h){
    this.x = x; // Начальное положение
    this.y = y;
    this.w = w; // и размер
    this.h = h;

    this.px = x; // Дополнительные переменные для вычисления при "перетаскивании" маркоеров
    this.py = y;

    this.csize = 6; // Размер маркеров
    this.csizeh = 10; // Размер маркеров при наведении курсора

    this.bHow = [false, false, false, false]; // Статусы наведения курсора
    this.iCSize = [this.csize, this.csize, this.csize, this.csize]; // Размеры маркеров
    this.bDrag = [false, false, false, false]; // Статусы перетаскивания
    this.bDragAll = false; // Статус пермещения всего выделения
}

// Метод draw
Selection.prototype.draw = function(canImg){

    ctx.strokeStyle = '#000';
    ctx.lineWidth = 2;
    ctx.strokeRect(this.x, this.y, this.w, this.h);

    // выводим часть оригинального изображения
    if (this.w > 0 && this.h > 0) {
        ctx.drawImage(canImg, this.x, this.y, this.w, this.h, this.x, this.y, this.w, this.h);
    }

    // Выводим маркеры
    ctx.fillStyle = '#fff';
    ctx.fillRect(this.x - this.iCSize[0], this.y - this.iCSize[0], this.iCSize[0] * 2, this.iCSize[0] * 2);
    ctx.fillRect(this.x + this.w - this.iCSize[1], this.y - this.iCSize[1], this.iCSize[1] * 2, this.iCSize[1] * 2);
    ctx.fillRect(this.x + this.w - this.iCSize[2], this.y + this.h - this.iCSize[2], this.iCSize[2] * 2, this.iCSize[2] * 2);
    ctx.fillRect(this.x - this.iCSize[3], this.y + this.h - this.iCSize[3], this.iCSize[3] * 2, this.iCSize[3] * 2);
}

function drawScene() { // Осоновная функция drawScene

    var contWidth = $('#crop-image-widget #image_container').width();
    var contHeight = $('#crop-image-widget #image_container').height();
    var scale;
    var imgHeight, imgWidht;
    var selX=150, selY=150, selHeight=200, selWidth=200;

    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height); // cОчищаем эолемент canvas
    if(image.naturalWidth > image.naturalHeight)
    {
        scale = parseFloat((image.naturalWidth/contWidth).toFixed(2));
        imgHeight = Math.round(image.naturalHeight/scale);

        canvas.width = contWidth;
        canvas.height = imgHeight;

        ctx.drawImage(image, 0, 0, contWidth, imgHeight);

        if(imgHeight < selHeight) selHeight = imgHeight;
        //if(imgHeight < selWidth) selWidth = imgHeight;
    }
    else
    {
        scale = parseFloat((image.naturalHeight/contHeight).toFixed(2));
        imgWidht = Math.round(image.naturalWidth/scale);

        canvas.width = imgWidht;
        canvas.height = contHeight;

        ctx.drawImage(image, 0, 0, imgWidht, contHeight);

        if(imgWidht < selWidth) selWidth = imgWidht;
    }

    var canImg = new Image();
    canImg.src = canvas.toDataURL();

    // и затеняем его
    ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
    ctx.fillRect(0, 0, ctx.canvas.width, ctx.canvas.height);

    // Создаем исходное выделение
    theSelection = new Selection(200, 200, 200, 200);
    // Выводим выделение
    theSelection.draw(canImg);
}

$(function(){
    $("#channels-image-path").on("change",
    function()
    {
        // Загружаем исходное изображение
        image = new Image();
        image.onload =
        function ()
        {

            // Создаем элемент canvas и объект context
            canvas = document.getElementById('panel');
            $("#crop-image-widget img#dummy").hide();
            $(canvas).show();
            ctx = canvas.getContext('2d');


            $('#panel').mousemove(function(e) { // Привязываем событие мыши
                var canvasOffset = $(canvas).offset();
                iMouseX = Math.floor(e.pageX - canvasOffset.left);
                iMouseY = Math.floor(e.pageY - canvasOffset.top);

                // Для случая перемещения всего селектора
                if (theSelection.bDragAll) {
                    theSelection.x = iMouseX - theSelection.px;
                    theSelection.y = iMouseY - theSelection.py;
                }

                for (i = 0; i < 4; i++) {
                    theSelection.bHow[i] = false;
                    theSelection.iCSize[i] = theSelection.csize;
                }

                //Наведение курсора мыши на маркер
                if (iMouseX > theSelection.x - theSelection.csizeh && iMouseX < theSelection.x + theSelection.csizeh &&
                    iMouseY > theSelection.y - theSelection.csizeh && iMouseY < theSelection.y + theSelection.csizeh) {

                    theSelection.bHow[0] = true;
                    theSelection.iCSize[0] = theSelection.csizeh;
                }
                if (iMouseX > theSelection.x + theSelection.w-theSelection.csizeh && iMouseX < theSelection.x + theSelection.w + theSelection.csizeh &&
                    iMouseY > theSelection.y - theSelection.csizeh && iMouseY < theSelection.y + theSelection.csizeh) {

                    theSelection.bHow[1] = true;
                    theSelection.iCSize[1] = theSelection.csizeh;
                }
                if (iMouseX > theSelection.x + theSelection.w-theSelection.csizeh && iMouseX < theSelection.x + theSelection.w + theSelection.csizeh &&
                    iMouseY > theSelection.y + theSelection.h-theSelection.csizeh && iMouseY < theSelection.y + theSelection.h + theSelection.csizeh) {

                    theSelection.bHow[2] = true;
                    theSelection.iCSize[2] = theSelection.csizeh;
                }
                if (iMouseX > theSelection.x - theSelection.csizeh && iMouseX < theSelection.x + theSelection.csizeh &&
                    iMouseY > theSelection.y + theSelection.h-theSelection.csizeh && iMouseY < theSelection.y + theSelection.h + theSelection.csizeh) {

                    theSelection.bHow[3] = true;
                    theSelection.iCSize[3] = theSelection.csizeh;
                }

                // Для случая пермешениея маркера
                var iFW, iFH;
                if (theSelection.bDrag[0]) {
                    var iFX = iMouseX - theSelection.px;
                    var iFY = iMouseY - theSelection.py;
                    iFW = theSelection.w + theSelection.x - iFX;
                    iFH = theSelection.h + theSelection.y - iFY;
                }
                if (theSelection.bDrag[1]) {
                    var iFX = theSelection.x;
                    var iFY = iMouseY - theSelection.py;
                    iFW = iMouseX - theSelection.px - iFX;
                    iFH = theSelection.h + theSelection.y - iFY;
                }
                if (theSelection.bDrag[2]) {
                    var iFX = theSelection.x;
                    var iFY = theSelection.y;
                    iFW = iMouseX - theSelection.px - iFX;
                    iFH = iMouseY - theSelection.py - iFY;
                }
                if (theSelection.bDrag[3]) {
                    var iFX = iMouseX - theSelection.px;
                    var iFY = theSelection.y;
                    iFW = theSelection.w + theSelection.x - iFX;
                    iFH = iMouseY - theSelection.py - iFY;
                }

                if (iFW > theSelection.csizeh * 2 && iFH > theSelection.csizeh * 2) {
                    theSelection.w = iFW;
                    theSelection.h = iFH;

                    theSelection.x = iFX;
                    theSelection.y = iFY;
                }

                drawScene();
            });

            $('#panel').mousedown(function(e) { // Привязываем событие мыши
                var canvasOffset = $(canvas).offset();
                iMouseX = Math.floor(e.pageX - canvasOffset.left);
                iMouseY = Math.floor(e.pageY - canvasOffset.top);

                theSelection.px = iMouseX - theSelection.x;
                theSelection.py = iMouseY - theSelection.y;

                if (theSelection.bHow[0]) {
                    theSelection.px = iMouseX - theSelection.x;
                    theSelection.py = iMouseY - theSelection.y;
                }
                if (theSelection.bHow[1]) {
                    theSelection.px = iMouseX - theSelection.x - theSelection.w;
                    theSelection.py = iMouseY - theSelection.y;
                }
                if (theSelection.bHow[2]) {
                    theSelection.px = iMouseX - theSelection.x - theSelection.w;
                    theSelection.py = iMouseY - theSelection.y - theSelection.h;
                }
                if (theSelection.bHow[3]) {
                    theSelection.px = iMouseX - theSelection.x;
                    theSelection.py = iMouseY - theSelection.y - theSelection.h;
                }


                if (iMouseX > theSelection.x + theSelection.csizeh && iMouseX < theSelection.x+theSelection.w - theSelection.csizeh &&
                    iMouseY > theSelection.y + theSelection.csizeh && iMouseY < theSelection.y+theSelection.h - theSelection.csizeh) {

                    theSelection.bDragAll = true;
                }

                for (i = 0; i < 4; i++) {
                    if (theSelection.bHow[i]) {
                        theSelection.bDrag[i] = true;
                    }
                }
            });

            $('#panel').mouseup(function(e) { // Привязываем событие мыши
                theSelection.bDragAll = false;

                for (i = 0; i < 4; i++) {
                    theSelection.bDrag[i] = false;
                }
                theSelection.px = 0;
                theSelection.py = 0;
            });

            drawScene();
        }

        var reader = new FileReader();
        reader.onload = function(e)
        {
            image.src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
    });

});

function getResults() {
    var temp_ctx, temp_canvas;
    temp_canvas = document.createElement('canvas');
    temp_ctx = temp_canvas.getContext('2d');
    temp_canvas.width = theSelection.w;
    temp_canvas.height = theSelection.h;
    temp_ctx.drawImage(image, theSelection.x, theSelection.y, theSelection.w, theSelection.h, 0, 0, theSelection.w, theSelection.h);
    var vData = temp_canvas.toDataURL();
    $('#crop_result').attr('src', vData);
    $('#results h2').text('Отлично, у нас есть обрезанное изображение и его теперь можно сохранить');
}

