    function authenticate_user()
    {
        $('#userName').hide();
    	var name = document.getElementById("name").value;
        var password = document.getElementById("password").value;

        var xmlhttp;

        if(window.XMLHttpRequest)
         {
          xmlhttp = new XMLHttpRequest();

          xmlhttp.onreadystatechange = function()
          {
            if(xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                var name=xmlhttp.responseText.split(' ');

                if(name[0]==1)
                {

                    $('#cover').hide();
                    $('#details').hide();
                    $('#userName' ).show(function(){
                        $('#userName span').html(name[1]);
                    });

                }
                else if(name[0]==2)
                {
                    $("#message").html('<div class="alert alert-danger"><p>User Id and Password do not match or such user do not exists</p></div>');
                }
                else if(name[0]==0)
                {
                    $("#message").html('<div class="alert alert-danger"><p>Fields are blank </p></div>');
                }
            }
          }
    }

    var data = "authenticate_user.php?&name=" + name + "&password=" + password;
    xmlhttp.open("get",data,true);
    xmlhttp.send();
}
