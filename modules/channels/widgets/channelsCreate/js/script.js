/**
 * Created by Set on 19.04.15.
 */

channelsList = function(){

    var listID = 'channelList';

    var init = function()
    {
        $("[name='broadcasting-now']").bootstrapSwitch();
        addOrderListeners();
        addSwitcherListener();
        addScrollListener();
    };

    /*---------------------------------------------------- ADD ORDER EVENT LISTENERS----------------------------------*/
    /**
     *  Callback function for 'joined' event
     * @param message - message object
     */
    var addOrderListeners = function()
    {
        $('body').undelegate('#' + listID + 'select[name="order"],' + '#' + listID + 'select[name="direction"]','change');
        $('body').delegate('#' + listID + ' select[name="order"],' + '#' + listID + ' select[name="direction"]','change',refreshList);
    };


    /*---------------------------------------------------- ADD SWITCHER EVENT LISTENER --------------------------------*/
    var addSwitcherListener = function()
    {
        $('body').undelegate('#' + listID +' input[name="broadcasting-now"]','switchChange.bootstrapSwitch');
        $('body').delegate('#' + listID +' input[name="broadcasting-now"]','switchChange.bootstrapSwitch',refreshList);
    };

    /*---------------------------------------------------- ADD SCROLL EVENT LISTENER ----------------------------------*/
    var addScrollListener = function()
    {
        $('#'+listID+' .channels_container').on('scroll',
            function()
            {
                var nContainerHeight = parseInt($(this).height());
                var nWrapHeight = parseInt($(this).find('#channels_wrap').height());
                var nLoadLevel = nWrapHeight - nContainerHeight - 100;

                if( this.scrollTop >= nLoadLevel )
                {
                    $(this).unbind('scroll');

                    var cOrder = $('#'+listID+' .controls_container select[name="order"]').val(),
                        cDirection = $('#'+listID+' .controls_container select[name="direction"]').val(),
                        bBroadcastingOnly = $('#'+listID+' .controls_container input[name="broadcasting-now"]').prop('checked'),
                        cExistCont = $('#'+listID+' .channels_container .channel_preview').length;

                    $.post('/web/index.php?r=channels/ajax/segment',
                        {
                            order:cOrder,
                            direction:cDirection,
                            broadcasting:bBroadcastingOnly,
                            count:cExistCont
                        },
                        function(response)
                        {
                            $('#' + listID + ' #channels_wrap').append(JSON.parse(response)['content']);
                            addScrollListener();
                        }
                    );
                }
            }
        );
    };

    /*---------------------------------------------------- REFRESH LIST ----------------------------------------------*/
    var refreshList = function()
    {
        var cOrder = $('#'+listID+' .controls_container select[name="order"]').val(),
            cDirection = $('#'+listID+' .controls_container select[name="direction"]').val(),
            bBroadcastingOnly = $('#'+listID+' .controls_container input[name="broadcasting-now"]').prop('checked'),
            cExistCont = $('#'+listID+' .channels_container .channel_preview').length;

        $.post('/web/index.php?r=channels/ajax/filter',
            {
                order:cOrder,
                direction:cDirection,
                broadcasting:bBroadcastingOnly,
                count:cExistCont
            },
            function(response)
            {
                $('#' + listID + ' #channels_wrap').html(JSON.parse(response)['content']);
                $('#'+listID+' .channels_container').animate({scrollTop:0},'slow');
            }
        );
    };


    return {
        init:init,
        addOrderListeners:addOrderListeners,
        addSwitcherListener:addSwitcherListener,
        addScrollListener:addScrollListener,
        refreshList:refreshList
    };

}();



$(document).ready(
    function()
    {
        channelsList.init()
    }
);