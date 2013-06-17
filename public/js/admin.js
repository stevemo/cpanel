$(function() {

    $('a[rel=tooltip]').tooltip();

        //Apply twitter bootstrap alike style to select element
    $('.select2').select2({
        'width':'element',
        'placeholder' : 'Select'
    });

});

/**
 * Create a confirm modal
 * We want to send an HTTP DELETE request
 *
 * @usage  <a href="posts/2" data-method="delete"
 *         	data-modal-text="Are you sure you want to delete"
 *         >
 *
 *
 * @author Steve Montambeault
 * @link   http://stevemo.ca
 *
 */
(function() {

	var laravel =
	{
		initialize: function()
		{
		    this.methodLinks = $('a[data-method]');
		    this.registerEvents();
		},

		registerEvents: function()
		{
		    this.methodLinks.on('click', this.handleMethod);
		},

		handleMethod: function(e)
		{
		    e.preventDefault();
		    var link = $(this);

		    var httpMethod = link.data('method').toUpperCase();
		    var allowedMethods = ['PUT', 'DELETE'];
		    var extraMsg = link.data('modal-text');
		    var msg  = '<i class="icon-warning-sign modal-icon"></i>&nbsp;Are you sure you want to&nbsp;' + extraMsg;

		    // If the data-method attribute is not PUT or DELETE,
		    // then we don't know what to do. Just ignore.
		    if ( $.inArray(httpMethod, allowedMethods) === - 1 )
		    {
		        return;
		    }

		    bootbox.dialog(msg,
		    [
		    	{
		    		"label": "OK",
		    		"class": "btn-danger",
		    		"callback": function()
		    		{
		    			var form =
					        $('<form>', {
					            'method': 'POST',
					            'action': link.attr('href')
					        });

					    var hiddenInput =
					        $('<input>', {
					            'name': '_method',
					            'type': 'hidden',
					            'value': link.data('method')
					        });

					    form.append(hiddenInput).appendTo('body').submit();
		    		}
		    	},
		    	{
		    		"label": "Cancel",
		    		"class": "btn-default"
		    	}
		    ],
		    {
		    	"header": "Please Confirm"
		    });
		}
	};

	laravel.initialize();

})();
