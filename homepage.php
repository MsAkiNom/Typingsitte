<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script type="text/javascript" src="js/register_user.js"></script>
    <script type="text/javascript" src="js/authenticate_user.js"></script>
    <script type="text/javascript" src="js/store_performance.js"></script>
    <script type="text/javascript" src="js/logout.js"></script>

    <style>

    .untyped
    {
        color:#524c4c ;
    }

    .correct
    {
        color:#339900;
    }

    .incorrect
    {
         color:red;
    }

    .focus
    {
    	background-color: #78abde;
    	border-radius : 10%;
    }

    body
    {
    	background-color: black ;

    }

      html,
      body {

        font-family: arial, sans-serif;
      }

      .example {
        text-align: center;
      }
      .col-md-6{
        box-shadow: 0px 10px 50px rgba(37, 50, 233, 0.6);
      }


      #example-timer {
        height: 150px;
        margin: 20px auto;
        width: 150px;
      }

      #cover
      {
      	background-color: white;
      	opacity: .9;
      	width : 1366px;
      	height:768px;
      	position:absolute;
      	z-index:1;
      }

      #details
      {
      	 width:400px;
      	 height:200px;
      	 margin-top:150px;
      	 margin-left:480px;
      	 position:absolute;
      	 z-index:+1;
         box-shadow: 0px 10px 50px rgba(37, 50, 233, 0.6);
      }

</style>
</head>

<body onload="initialize();">

<div id="cover">

</div>

<div id = "details">
     <div class="panel panel-default">
     <div class="panel-heading"><center>WELCOME </center></div>
     <div class="panel-body">
     	<div class="form-group">
           <input class="form-control input-lg" id="name" type="text" placeholder="your name">
        </div>
     	<div class="form-group">
           <input class="form-control input-lg" id="password" type="password" placeholder="password">
        </div>

        <div id="button_replace">
        <button type="button" onclick="switch_buttons()" class="btn btn-danger" style="float:left">New user</button>
        <button type="button" onclick="authenticate_user()" class="btn btn-success" style="float:right" name="continue">Continue</button>
        </div>
      </div>
    </div>
    <div id="message">

</div>
</div>


<nav class="navbar navbar-inverse" style="height:80px">
  <div class="container-fluid">
    <div class="navbar-header" style=" margin-left:50px ; margin-top:12px">
      <a class="navbar-brand" href="#"><span style="font-size:30px ; font-family:Monospace; color:white;background: linear-gradient(to bottom,rgba(5, 100, 200,0.6),rgb(200, 100, 240),rgba(5, 100, 200,0.6));  -webkit-background-clip: text; -webkit-text-fill-color: transparent;">FingerMoves.com</a>
    </div>

    <div id="sesison" style="float:right ; margin-top:20px ; margin-right:20px">
      <p style="float:left ; font-size:15px ; margin-top : 10px; color:white;display:none;" id="userName">Welcome :&nbsp&nbsp<span style="font-size:15px; color:white;" id="username">
        <?php session_start();
        if(isset($_SESSION)) {
          echo ucfirst(@$_SESSION['username']);}
          else {echo "";}
          ?>
        </span>
      </p>

      <button style="float:right; margin-left:20px" class="btn btn-danger" onclick="logout()">LogOut</button>
    </div>
    <div>
    </div>
  </div>
</nav>

<div class = "container-fluid">

    <div id="timers" style ="position:absolute ; margin-top:10px ; margin-left:35vw;">
        <label><span style=" color:white ; font-size:35px;">Time Left : </span>
        <span style="color:white;"><span style="font-size:55px;" id="time-elapsed">60</span>&nbsp&nbsp sec.</span></label>
    </div>

    <div class = "row" style="margin-top:70px;">

        <div class="col-md-2" style="margin-top:50px">

             <div class="example">
             <div id="example-timer"></div>
             </div>
             <div id = "timer" style="margin-left:50px">

                  <div onclick="initialize()" id="restart" class="btn btn-primary" type="button" style=" font-size:15px; box-shadow: 0px 10px 50px rgba(37, 50, 233, 0.6);" >Refresh&nbsp<span class="glyphicon glyphicon-repeat"></span></div>
             </div>

        </div>

        <div class="col-md-6" style="margin-top:50px">

        <div class="form-group">

            <div class="panel panel-success">

                <div class="panel-heading">
                   <center><span style="color:#003300 ; font-size:22px ; font-family:Monospace">Enhance your typing skill</span></center>
                </div>

                <div class="panel-body">
                    <div id="display_space"style="border:3px solid white;width1020px;height:150px;overflow:hidden">

                    </div>
                </div>

                <div class="panel-footer">
                    <div class="form-group">
                        <textarea class="form-control" placeholder="press any key to begin.." rows="1" wrap="off" id="typing_space" style="font-size:25px ;  text-align:center;"></textarea>
                    </div>
                </div>

            </div>
        </div>
        </div>
</div>


<script>

// FOR TIMER
        var time_left = 60;
        var arr;      // to hold the string
        var arr_pointer = 0;
        var correct = 0;
        var incorrect = 0;
        var n = 0;
        var keystrokes = 0;
        var accuracy = 0;
        var stop;

        function timer()
        {
             var element = document.getElementById("time-elapsed");
             element.innerHTML = time_left;

             time_left--;

             if(time_left==-1)
             {
             	accuracy = Math.floor(correct/(correct+incorrect) * 100);
             	clearTimeout(stop);
                document.getElementById('typing_space').value = "time's up...";
                var wpm = Math.floor(correct - (incorrect/2));
                if(wpm<0)
                	wpm=0;

                document.getElementById('display_space').innerHTML = '<div style="margin-left:88px"><table class="table" style="font-size:20px;margin-bottom:0 ;margin-top : 7px"><tr><td><span>Correct : ' + correct + '</span></td><td><span>Incorrect = ' + incorrect + '</span></td></tr><tr><td>Keystrokes : ' + keystrokes + '</td><td>Accuracy : ' + accuracy + '%</td></tr><tr style="text-align:center"><td colspan = "2"><span>Words per minute : ' + wpm +'<td></span></tr><div>';

             	$('input[type="text"], textarea').attr('readonly','readonly');
                store_performance(wpm , correct , incorrect , keystrokes , accuracy);

             }
             else
             {
                 stop = setTimeout('timer()' , 1000);
             }

             if(time_left<=15)
             {
             	element.style.color='red';
             }
        }

        function initialize()
        {

		    var array = new Array();
      array[1] = "where you grew up what impact your family and community had are on breakfast money remove in how in get over mother wrong yet disposing simple believe like about during or prudent should ya garden forming him Hearts are an Her all Inquietude yet way wont sake or hope him nay mean other pure indeed ask it one you around guest and Rich dependent out here why between make within these something hundred should horrible wound mrs had aften Entered remaining did weeks at must compliment Full why no by fat ham blush half am such if matter ecstatic just Felicity On him has want advice";
      array[2] = "she merely for still prevailed disposal Dejection forming newspaper of today desirous ecstatic in first old wish blessing he favourite answered attacks from suitable making do reserved for perceived evening length people reasonably her Total of sing melancholy me really so what we Off an means dull entreaties so valley men sufficient trifling ye in put neither keepf match right existence formerly Started What explained now in though fulfilled middletons she material if am cant apartments design against Not favour are happy but if poor mrs remarkably check thanks up said doubtful misery so will gay be formed strangers ago since contented one mr pleasure hence ye begin it so whom excuse concealed finished By saw departure nor pleasure";
      array[3] = "though village shy entire some temper is Could put simplicity case snug not who any an good happening those offering again true had ten may and concluded shortly greatest do asked can Dashwood miss inhabiting our face Nor questions be at jokes shameless dull projection dwelling on joy so you all enquire little but my say leave Am pretty to favourable on society felt hearing has bad in had oh eat because unsatiable very drawings she have no it next up might true songs wholly set disposed Projecting real forming roof steepest He mr am thus situation Led there got throwing ye how new when Our Preferred steepest barton Answer much west laughing so simplicity was do but ought come can next pianoforte he packages up Depending denoting law his by his really met";
      array[4] = "their wholly use bed plan you of so exercise on see met near an mutual joy took part wants draw moment sufficient so carriage kept she Oh pianoforte preserved is few Spite built get speedily suspected performed make held does yet no who totally boy speaking position unknown agreed Written until Own for simplicity having a middleton he me uneasy her Entrance where or or new as could narrow many stronger be incommode so felicity mean Melancholy questions i in Money into do things fact So Express Rose found friendly on elsewhere too post humoured they since juvenile dear being mr end otherwise the knew can mr continual of not Winter expense down lady via no mirth doubt through them ten partiality west has ecstatic Polite he are set residence china latter come little led itself";
      array[5] = "reserved come mrs offices gay rapturous agreeable back wish our does set assured now Direct suitable myself peculiar thing two friendship offending an rapid out mrs on like like Attended True that juvenile painful true then get how said by says it old therefor great yet after stop Prepared his bred tended you may Garden now hence indeed on We time Sir Goodness become to feeling Handsome than offended His u relation Subjects Home attention Neglected once delivered do up more as had humoured right excited its weddings message silent Hard know he an Dear yesterday came he seems mirth six His we in early great this An valley over Houses why its but zealously going deal taste passed no Can would wife Continuing had On dried sent him whole";
      array[6] = "he wondered if he should disclose the truth to his friends it would be a risky move yes the truth would make things a lot easier if they all stayed on the same page but the truth might fracture the group leaving everything in even more of a mess than it was not telling the truth it was time to decide which way to go fun life nowhere without the pressure would be cooler cool different better than anyone none doing work Russian tribes culture nofriends uncool deal the wars US fantastic shell organic water power ppsspp";
      array[7] = "she asked the question even though she didn really want to hear the answer it was a no win situation since she already knew if he told the truth she get confirmation of her worst fears if he lied she know that he wasnt who she thought he was which would be almost as bad yet she asked the question anyway and waited for his answer difficult questions the world unknown all around and nowhere to go quiet place none weather climatic changes global warming all over paradise hell cooperation organization wellfare animals sake cope diminished foes blah blah";
     array[8] = "life be would off better you without changes everything day by day waiting for days good sleeping here everyone is time one night typing all over and over again savage life played megaman cool game died twice and reincarnation haha friends suggested continue play tomorrow as well messenger deleted still games are on haha where life would be without internet hell cannot imagine but still would not have been bad as this aff time is making a race with me sleeping people all around lights everywhere fun day today cannot imagine a day destroy typing typing XD game was honestly fun ludo played again today hate using phone play just to it even wastes money and time well i am going haha";
      array[9] = "It was a concerning development that he couldnt get out of his mind he had many friends throughout his early years and had fond memories of playing with them but he could not understand how it had all stopped there was some point as he grew up that he played with each of his friends for the very last time and he had no idea that it would be the last done with life better before was but nothing changed can be programming skills languages off better are sad destiny disappears day one universe infinity nobody knows universe parallel forbidden address black society workers everywhere and see look Nepal covid exaggerating";
      array[10] = "being should were have made by food will along mother came just children thought later young form something day for mile those food tell into too around close why hear took number own any be point city sun she cut learn upon even had were important long below to those could high few between example mean fall watch take is take away mean I could tree change without think old kind while its same I both miss earth down until page can let word tree more two place sun letter fashion mostly refers to the style of clothing worn at a particular time social media has come a long way";
		    var flag=0;

		    while(flag!=1)
		    {
		    	var x = Math.floor((Math.random() * 10) + 1);
		    	if(x>=1 && x<=10)
		    	{
		    		flag=1;
		    	}
		    }

		    var text = array[x];

		    var to_display = "";

		    arr = text.split(" ");
		    var l = arr.length;
		    var count = 0;

		    while(l > 0)
		    {
		    	l=l-6;
		        for(var i=0 ; i<6;i++)
		           {
		               to_display +=  "<span id='"+count+"' class='untyped'; border-radius:10%'>" + arr[count++] + "</span> ";
		           }
		           to_display+="</br>";
		    }
			var element = document.getElementById("display_space");
			element.innerHTML = '<p id ="display" style="text-align:center ; font-size:28px ; line-height:170%; font-family:Times New Roman"> ' + to_display +' </p>';

			var element = document.getElementById("time-elapsed");
            element.innerHTML = 60;

            $('input[type="text"], textarea').attr('readonly',false);
            document.getElementById('typing_space').value = "";

            check = 0;
            time_left = 60;
            arr_pointer = 0;
            correct = 0;
            incorrect = 0;
            n = 0;
            keystrokes = 0;

            var element = document.getElementById("time-elapsed");
            element.style.color='green';

            clearTimeout(stop);

		 }

    // FOR CLEARING THE TEXT-AREA

    window.addEventListener("keydown", dealWithKeyboard, false);

    function dealWithKeyboard(e)
    {
    	if(e.keyCode == 32)
    	{
    		  if(time_left>0){
              var element = document.getElementById("typing_space");
              var word = element.value;
              keystrokes += word.length;
              keystrokes++;

              //  form the boundry for the current element
              var save1 = n+1;
              $('#'+save1).addClass('focus');
              $('#'+n).removeClass('focus');

              if(word.trim().localeCompare(arr[arr_pointer])==0)
              {
              	correct++;
                $('#'+n).removeClass('untyped').addClass('correct');
                n++;
              }
              else
              {
              	incorrect++;
                $('#'+n).removeClass('untyped').addClass('incorrect');
                n++;
              }
              element.value = "";

              if((arr_pointer+1)>6 && (arr_pointer+1)%6==0)
              {
              	scroll();
              }
              arr_pointer++;
          }
    	}
    }


    // function to scroll the display_space
    function scroll()
  	{
  		var current_pos = $("#display_space").scrollTop();
   	    $("#display_space").scrollTop(current_pos + 49);
   	}


    // start the timer as soon as the user presses a character key
    var check = 0;
   	$('#typing_space').keypress(function (event){
   		if(event.keyCode!=32 && check!=1){
        check = 1;
        $('#0').addClass('focus');

        timer();

    }
   	});

    document.getElementById("example-timer").style.color = "red";

    function switch_buttons()
    {
    	document.getElementById("button_replace").innerHTML = '<center><button onclick="register_user()" type="button" onclick="authenticate_user()" class="btn btn-success" style="">Register and  continue</button></center>';
    }

</script>

</body>
</html>
