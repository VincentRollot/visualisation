var GymSuedoise = angular.module('GymSuedoise', []).controller('mainPageController', function($scope, $http){


  $scope.showModal = function(){
    $("#legende").modal('show');
  }

    $scope.salle = null;
    $scope.json = null;
    $scope.infos = null;
    $scope.nb = null;
    $scope.nom = null;
  
  $('#jstree').on('changed.jstree', function (e, data) {
    if(data && data.selected && data.selected.length) {
    var i, j, r = [];
    var salle_selected;
    var parent_id;
    var secteur_id;
    for(i = 0, j = data.selected.length; i < j; i++) {
      r.push(data.instance.get_node(data.selected[i]).text);
      salle_selected = data.instance.get_node(data.selected[i]).text;
      parent_id = data.instance.get_node(data.selected[i]).parent;
      secteur_id = data.instance.get_node(data.selected[i]).id;
      //console.log(parent_id);
    }
    $('#details').html('Lieu : <br/>' + r.join(', '));




    $http.get('content.php'). //    /GitHub/visualisation/content.php
      success(function(data, status, headers, config) {
          $http.get('recuperer_id_salle.php?salle=' + salle_selected). //  /GitHub/visualisation/recuperer_id_salle.php?salle=
            success(function(data1, status, headers, config) {

              $scope.json = data;
              $scope.salle = data1;
              displayPlanning();                          
            }).
            error(function(data1, status, headers, config) {
              console.log('ca marche pas');
            });
          }).
          error(function(data, status, headers, config) {
            console.log('ca marche pas');
    });


  $http.get('recuperer_info_salle.php?salle=' + salle_selected). //  /GitHub/visualisation/recuperer_id_salle.php?salle=
    success(function(info, status, headers, config) {
      $scope.infos = info;
      if($scope.infos != '<br/><br/> '){
        $('#details').html(info);
      }
      $('#onglets').html('');
    }).
    error(function(info, status, headers, config) {
      console.log('infos salle ca marche pas');
  });  


  if(parent_id>1){
    //console.log(parent_id);
    $http.get('recuperer_nb_salle.php?salle=' + salle_selected). //  /GitHub/visualisation/recuperer_id_salle.php?salle=
      success(function(nb, status, headers, config) {
      $scope.nb = nb;
      if($scope.nb != 0 ){
        $('#salles').html('<ul id="onglets"></ul>');
        $http.get('recuperer_nom_salle.php?salle=' + salle_selected). //  /GitHub/visualisation/recuperer_id_salle.php?salle=
          success(function(nom, status, headers, config) {
            $scope.nom = nom;
            var nbr = 0;
            var nom_salle = "";

            while($scope.nom[nbr] != '>'){
              nom_salle += $scope.nom[nbr];
              nbr++;
            }
            $('#onglets').html('<li class="active"><a href="">'+nom_salle+'</a></li>');
            nom_salle = "";
            
            for(i = 0; i < $scope.nb-1; i++) {
              while($scope.nom[nbr] != '>'){
                nom_salle = "";
                nbr++;
              } 
              nbr++;                 
              while($scope.nom[nbr] != '<'){
                nom_salle += $scope.nom[nbr];
                nbr++;
              }
              document.getElementById('onglets').innerHTML+= '<li><a href="">'+nom_salle+'</a></li>';                            
            }
          }).
          error(function(nom, status, headers, config) {
            console.log('ca marche pas');
          });
      } 
        }).
      error(function(nb, status, headers, config) {
        console.log('ca marche pas');
      });
      
  } 

  var displayPlanning = function(){

  var compt = 0;
  var count = 1;
  var count_json = 0;
  var id_class = new Array();
  var start_time  = new Array();
  var end_time  = new Array();
  var json = new Array();
  var tmp = new Array();

  var element = document.getElementById("calendar");
  element.parentNode.removeChild(element);
  var newdiv = document.createElement('div');
  var parent = document.getElementById('planning');
  newdiv.setAttribute('id','calendar');
  parent.appendChild(newdiv);


  while(compt < Object.keys($scope.json).length){

    if($scope.json[count] == null){
      count = count + 1;
    }
    else{

      if($scope.json[count].classroom_id == $scope.salle){

        id_class.push("Cours n°"+$scope.json[count].class_id);
        start_time.push($scope.json[count].class_date+'T'+$scope.json[count].class_starttime+':00');


        var duration = $scope.json[count].class_duration;
        var start = $scope.json[count].class_starttime;
        minute = start.substr(3,5);
        hour = start.substr(0,2);
        minute = parseInt(minute);
        hour = parseInt(hour);
        duration = parseInt(duration);

        var total_minutes = (60*hour) + minute + duration;
        var hour_end = Math.floor(total_minutes / 60);
        var minute_end = total_minutes % 60;

        if (minute_end == 0) {
          minute_end = minute_end+'0';
        }

        end_time.push($scope.json[count].class_date+'T'+hour_end+':'+minute_end+':00');
      }

        compt = compt + 1;
        count = count + 1;
      }
    }

    while(count_json < id_class.length){

      var i = 0;
      var obj = {};
      tmp = ['title', 'start', 'end'];

      obj[tmp[0]] = id_class[count_json];
      obj[tmp[1]] = start_time[count_json];
      obj[tmp[2]] = end_time[count_json];

      json.push(obj);
      count_json = count_json + 1;
    }

    var planning = json;
    console.log(planning);

  $('#calendar').fullCalendar({
    header: {
        left: 'prev,next today',
        center: 'title',
        right: ''
      },

      //eventMouseover: function(event, jsEvent, view) {        
      //},

      eventRender: function (event, element) {
        element.attr('href', 'javascript:void(0);');
        element.click(function() {  
        var cours = event.title.substr(8,9);
        window.open("detailCours.php?cours="+cours,"_self"); // ../visualisation/detailCours.php
        });
      },
    lang : 'fr',
    minTime : "07:30",
    maxTime : "22:30",
    columnFormat : 'dddd',
    allDaySlot : false,
    defaultView : 'agendaWeek',
    handleWindowResize : true,
    slotDuration : '00:30:00',
    aspectRatio: 1.69,
    defaultDate: '2015-06-01',
    editable: true,
    eventLimit: true,
    eventStartEditable : false,
    eventDurationEditable : false,
    events: planning,
    eventBackgroundColor : "rgb(251,210,20)",
    eventTextColor : "rgb(17,81,160)"
    //http://fullcalendar.io/docs/event_data/Event_Object/#color-options  Pour la couleur individuelle des éléments
  });
  }
      }
  });

});

