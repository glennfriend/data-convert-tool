"use strict";

$(function() {

    /**
     * 點擊 label 的時候
     * 觸發相對應的 radio button
     */
    $('label').on('click', function(){
        var prevElement = this.previousElementSibling;
        $(prevElement).click();
    });

});

