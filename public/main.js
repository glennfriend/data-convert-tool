"use strict";

/**
 * 依據 tag 的資料做 submit 的行為
 */
/*
function goSubmit(tag)
{
    console.log('go submit');
    
}
*/

/*
$(function() {

    //
    //
    //
    $('.tag').on('click', function(){

        var isset = function() {
            var a = arguments
            var l = a.length
            var i = 0
            var undef
            if (l === 0) {
                throw new Error('Empty isset')
            }
            while (i !== l) {
                if (a[i] === undef || a[i] === null) {
                    return false
                }
                i++
            }
            return true;
        };

        var tag = {};

        // dataset
        tag.data = {
            'tag':      isset(this.dataset.tag)         ? this.dataset.tag      : null,
            'value':    isset(this.dataset.value)       ? this.dataset.value    : null,
            'callback': isset(this.dataset.callback)    ? this.dataset.callback : null
        };
        tag.form = {
            'id':        isset(this.id)                 ? this.id               : null,
            'name':      isset(this.name)               ? this.name             : null,
            'value':     isset(this.value)              ? this.value            : null
        };


        // debug
        console.log(tag);

        // callback
        if (tag.data.callback) {
            window[tag.data.callback](tag);
        }


    });

});
*/

