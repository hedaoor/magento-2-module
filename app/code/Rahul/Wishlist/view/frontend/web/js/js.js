require([
        "jquery"
        ], function($){
            $(document).ready(function(){
                $('.towishlist').click(function(event){
                    // alert(123);
                    event.preventDefault();
                    event.stopPropagation();
                    var data = $(this).attr('data-post');
                    var obj = jQuery.parseJSON(data);
                    // console.log(obj);
                    // console.log(obj.action);

                    $.ajax({
                    url : obj.action,
                    data : {'product':obj.data},
                    type : "post",
                    dataType : 'json',
                    showLoader:true,
                    success : function(data)
                    {
                        // console.log(data);
                       if(data.status == 'not_logged_in'){
                         window.location.href = data.redirect;
                       }
                    }
                });
                });
            });
        });