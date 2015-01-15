var getcatlvllisturl ;
var addnewclassifiedurl;
    function init_other(object)
    {
        if(object.val()<='0')
        {
            $("#cat-lvl-"+object.attr("data-next-lvl")).empty();
            $("#"+object.attr("id")+"-other").removeClass("hidden").css({"height":object.css("height"),"border-radius":object.css("border-radius"),"width":object.css("width")});
            $("#"+object.attr("id")+"-other").focus();
        }
        else
        {
            $("#cat-lvl-"+object.attr("data-next-lvl")).empty();
            $("#"+object.attr("id")+"-other").addClass("hidden");
             var data = { lvl: object.attr("data-next-lvl"),
                         id : object.val()
                        }
           var paramdata= JSON.stringify(data);
           $.post(
			getcatlvllisturl,
			{ data: paramdata },
			function(data)
			{
                var result = JSON.parse(data);
                if(result.error===false)
                {
                    $("#cat-lvl-"+object.attr("data-next-lvl")).append(result.data);
                    $("#cat-lvl-"+object.attr("data-next-lvl")+"-select").change(function(){
                                  init_other($(this));
                            })  ;
                    if(result.empty===1)
                    {
                         $("#cat-lvl-"+object.attr("data-next-lvl")+"-select").val(0).trigger('change');
                    }
                }
            });
        }
    }
    function collect_step_1_data()
    {
        var data= new Array;
        for (var i=1; i<4; i++)
        {
            var select=$("#cat-lvl-"+i+"-select").val();
            if(select==='0')
            {
                var _data={
                            new_:'yes',
                            data:$("#cat-lvl-"+i+"-select-other").val()
                          };
                          data[i]=_data;
            }
            else
            {
                var _data={
                                    new_:'no',
                                    data:$("#cat-lvl-"+i+"-select").val()
                                };
                                data[i]=_data;
            }
        }
        return data;
    }
    function collect_step_2_data()
    {
        return  {
                    title :     $("#title").val(),
                    price :     $("#price").val(),
                    negotiable: $("#negotiable").is(":checked"),
                    condition:  $("#condition-select").val(),
                    brand :     $("#brand").val(),
                    model :     $("#model").val(),
                    year :      $("#year").val()
                }
    }
    function savenewpost()
    {
        var data= {
                    st1_data:collect_step_1_data(),
                    st2_data:collect_step_2_data(),
                    st3_data:{
                               description:$("#description").val(),
                               broker:$("#broker").is(":checked"),
                             }
                  }
        var paramDATA = JSON.stringify(data);
        $.post(
		addnewclassifiedurl,
		{ data: paramDATA },
		function(data) {
                    var result = JSON.parse(data);
                    alert(data);
                });
    }
//    $(document).ready(function() {
////    $('#fullpage').fullpage({
////            resize:false,
////            anchors: ['firstPage', 'secondPage', 'thirdPage', 'fourthPage'],
////            menu: '#myMenu',
////            css3: true,
////        scrollingSpeed: 1000});
//    $("#cat-lvl-1-select").change(function(){
//            init_other($(this));
//    });  
//    $("#btn-next").click(function(){
//        alert(JSON.stringify(collect_step_1_data()));
//    });
//        
//});