var GymSuedoise = angular.module('GymSuedoise', []).controller('mainPageController', function($scope, $http){


  $scope.showModal = function(){
    $("#legende").modal('show');
  }

  $scope.salle = 1;
  $scope.json = null;


  $http.get('/visualisation/content.php').
    success(function(data, status, headers, config) {
      $scope.json = data;
      displayPlanning();
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
  var duration  = new Array();
  var json = new Array();
  var tmp = new Array();

  while(compt < Object.keys($scope.json).length){

    if($scope.json[count] == null){
      count = count + 1;
    }
    else{

      if($scope.json[count].classroom_id == '1'){

        id_class.push($scope.json[count].class_id);
        
        if($scope.json[count].class_dayofweek == "0"){
          start_time.push('2015-06-07T'+$scope.json[count].class_starttime+':00');
          duration.push('2015-06-07T'+$scope.json[count].class_duration+':00');
        }

        if($scope.json[count].class_dayofweek == "1"){
          start_time.push('2015-06-01T'+$scope.json[count].class_starttime+':00');
          duration.push('2015-06-01T'+$scope.json[count].class_duration+':00');
        }

        if($scope.json[count].class_dayofweek == "2"){
          start_time.push('2015-06-02T'+$scope.json[count].class_starttime+':00');
          duration.push('2015-06-02T'+$scope.json[count].class_duration+':00');
        }

        if($scope.json[count].class_dayofweek == "3"){
          start_time.push('2015-06-03T'+$scope.json[count].class_starttime+':00');
          duration.push('2015-06-03T'+$scope.json[count].class_duration+':00');
        }

        if($scope.json[count].class_dayofweek == "4"){
          start_time.push('2015-06-04T'+$scope.json[count].class_starttime+':00');
          duration.push('2015-06-04T'+$scope.json[count].class_duration+':00');
        }

        if($scope.json[count].class_dayofweek == "5"){
          start_time.push('2015-06-05T'+$scope.json[count].class_starttime+':00');
          duration.push('2015-06-05T'+$scope.json[count].class_duration+':00');
        }

        if($scope.json[count].class_dayofweek == "6"){
          start_time.push('2015-06-06T'+$scope.json[count].class_starttime+':00');
          duration.push('2015-06-06T'+$scope.json[count].class_duration+':00');
        }
      }

        compt = compt + 1;
        count = count + 1;
      }
    }

    while(count_json < id_class.length){

      var i = 0;
      var obj = {};
      tmp = ['title', 'start'];

      obj[tmp[0]] = id_class[count_json];
      obj[tmp[1]] = start_time[count_json];

      json.push(obj);
      count_json = count_json + 1;
    }

    var planning = json;

  $('#calendar').fullCalendar({
    lang : 'fr',
    minTime : "07:30",
    maxTime : "22:30",
    columnFormat : 'dddd',
    header: false,
    allDaySlot : false,
    defaultView : 'agendaWeek',
    handleWindowResize : true,
    slotDuration : '00:30:00',
    aspectRatio: 1.5,
    defaultDate: '2015-06-01',
    editable: true,
    eventLimit: true, // allow "more" link when too many events
    events: planning
  });
  }

});