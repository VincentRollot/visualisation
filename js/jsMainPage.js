var GymSuedoise = angular.module('GymSuedoise', []).controller('mainPageController', function($scope, $http){


  $scope.showModal = function(){
    $("#legende").modal('show');
  }
  
  $('#jstree').on('changed.jstree', function (e, data) {
      if(data && data.selected && data.selected.length) {
      var i, j, r = [];
      var salle_selected;
      for(i = 0, j = data.selected.length; i < j; i++) {
        r.push(data.instance.get_node(data.selected[i]).text);
        salle_selected = data.instance.get_node(data.selected[i]).text;
      }
      $scope.salle = null;
  $scope.json = null;

 
  $http.get('/GitHub/visualisation/content.php').
    success(function(data, status, headers, config) {
        $http.get('/GitHub/visualisation/recuperer_id_salle.php').
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




  var displayPlanning = function(){

  var compt = 0;
  var count = 1;
  var count_json = 0;
  var id_class = new Array();
  var start_time  = new Array();
  var end_time  = new Array();
  var json = new Array();
  var tmp = new Array();

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
      },/*
      eventRender: function (event, element) {
        element.attr('href', 'javascript:void(0);');
        element.click(function() {
            $("#startTime").html(moment(event.start).format('MMM Do h:mm A'));
            $("#endTime").html(moment(event.end).format('MMM Do h:mm A'));
            $("#eventInfo").html(event.description);
            $("#eventLink").attr('href', event.url);
            $("#eventContent").dialog({ modal: true, title: event.title, width:350});
        });
      },*/
    lang : 'fr',
    minTime : "07:30",
    maxTime : "22:30",
    columnFormat : 'dddd',
    allDaySlot : false,
    defaultView : 'agendaWeek',
    handleWindowResize : true,
    slotDuration : '00:30:00',
    aspectRatio: 1.65,
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