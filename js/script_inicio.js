$(document).ready(function(){

	$.widget( "custom.catcomplete", $.ui.autocomplete, {
	    _create: function() {
	      this._super();
	      this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
	    },
	    _renderMenu: function( ul, items ) {
	      var that = this,
	        currentCategory = "";
	      $.each( items, function( index, item ) {
	        var li;
	        if ( item.category != currentCategory ) {
	          ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
	          currentCategory = item.category;
	        }
	        li = that._renderItemData( ul, item );
	        if ( item.category ) {
	          li.attr( "aria-label", item.category + " : " + item.label );
	        }
	      });
	    }
 	});

	$('.auto').live('click focus',function(){
		prod=$(this);
		$(this).catcomplete({
			source: function( request, response ) {
			    $.ajax({
			        url: "libs/acc_producto",
			        data: {q: request.term},
			        dataType: "json",
			        success: function( data ) {
			            response( $.map( data.myData, function( item ) {
			                return {
			                    category: item.categoria,
			                    label: item.producto
			                }
			            }));
			        }
			    });
			},
			select: function(event, ui) {
				setTimeout(function(){
					if(prod.val()=='No hay resultados')
						prod.val('');
					else
						$('#busqueda1').submit()
				},0.9);

            }
		});

	})

	$('.df1').on('mouseover',function() {
		$(this).fadeOut(0,function(){
				$(this).next().fadeTo('slow',1)
			})
	});

	$('.df2').on('mouseleave',function(event) {
		$(this).fadeOut(0,function(){
			$(this).prev().fadeTo('fast',1)
		})
	});

	$('.catsegunda').on('click',function(){
		$('<form action="resultado-busqueda" method="POST">' +
   				 '<input type="hidden" name="categoria[]" value="' + $(this).prop('id')+ '">' +
     	'</form>').appendTo('body').submit();
	})
})