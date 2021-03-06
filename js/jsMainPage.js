var GymSuedoise = angular.module('GymSuedoise', []).controller('mainPageController', function($scope, $http){


  $scope.showModal = function(){
    $("#legende").modal('show');
  }
  $scope.error = false;

  $scope.salle = null;
  $scope.intervenant = null;
  $scope.json = null;
  $scope.infos = null;
  $scope.nb = null;
  $scope.nom = null;
  $scope.err = [];
  $scope.typeplanning = null;
  $scope.mode = 0;
  $scope.rsalles=[];
  $scope.limit = 7;
  $scope.groupe1 ='salle';
  $scope.rintervenants = [];
  $scope.dispo = null;
  $scope.nb_dispo = null;
  $scope.erreurs_region = null;
  $scope.intensite = null;
  $scope.erreurs_semaine = null;
  $scope.erreurs_region_semaine = null;
  $scope.dateMaj = null;


  $scope.submitSalle = function(salle_ID){
    $scope.typeplanning = 0;

    chargerDonneesSalle(salle_ID);
    afficherDetailsSalle(salle_ID);
    afficherOnglets(105, salle_ID);
  }

  $scope.submitIntervenant = function(int_ID_intervenant){
    $scope.typeplanning = 1;
    $scope.intervenant = int_ID_intervenant;
    var nom_intervenant = $(this).attr("id");
    chargerDonneesIntervenant();
    afficherDetailsIntervenant(int_ID_intervenant);
  }


  document.getElementById("bRefresh").onclick = function() {refresh()};

  function refresh() {
    $("#body").hide();
    //window.open("../visualisation/essai.php","_self");
    //alert("Lancement du chargement, veuillez attendre..."); 
    $http.get('initStockBDD.php')
      .success(function(status){
        $("#body").show();
        //window.open("../visualisation/mainPage.php","_self");
        location.reload();
        alert('Mise à jour réussie');  
        getDateMaj();      
      })
      .error(function(status){        
        alert('Erreur de chargement : '+status);        
      })
  }

  function getDateMaj(){
    $http.get('recuperer_date_maj.php')
      .success(function(data, status){
        $scope.dateMaj = data;
        $(dateMaj).html("Mise à jour : "+$scope.dateMaj);
        
      })
      .error(function(data, status){
        alert('Erreur');        
      })
  }

  getDateMaj();


 function getSalles(){
    $http.get('encode_salle.php')
      .success(function(data, status){
        $scope.rsalles = data;
        
      })
      .error(function(data, status){
        $scope.rsalles = data;
        $scope.status = status;
        $scope.error = true;
        alert('Erreur');        
      })
  }
  getSalles();

  function getIntervenant(){
    $http.get('encode_intervenant.php')
      .success(function(data, status){
         $scope.rintervenants = data;
                
      })
      .error(function(data, status){
        $scope.rintervenants = data;
        $scope.status = status;
        $scope.error = true;
        alert('Erreur');        
      })

  }
  getIntervenant();


  
  $('#jstree').on('changed.jstree', function (e, data) {
    if(data && data.selected && data.selected.length) {
      var i, j;
      var r = [];
      var salle_selected;
      var parent_id;
      $scope.typeplanning = 0;

      for(i = 0, j = data.selected.length; i < j; i++) {
        r.push(data.instance.get_node(data.selected[i]).text);
        salle_selected = data.instance.get_node(data.selected[i]).text;
        parent_id = data.instance.get_node(data.selected[i]).parent;
      }


      afficherOnglets(parent_id, salle_selected);
      chargerDonneesSalle(salle_selected);
      afficherDetailsSalle(salle_selected, r);
      
    }
  });


  $("#onglets").on('click', 'li.onglet', function (event) {
    var r = [];
    $scope.typeplanning = 0;
    var salle_selected = $(this).attr("id");

    $(".active").attr("class", "onglet");
    $(this).attr("class", "active onglet");

    chargerDonneesSalle(salle_selected);
    afficherDetailsSalle(salle_selected, r);
  });



  var chargerDonneesSalle = function(salle_selected){
    $http.get('content.php'). //    /GitHub/visualisation/content.php
      success(function(data, status, headers, config) {
        $http.get('recuperer_id_salle.php?salle=' + salle_selected). //  /GitHub/visualisation/recuperer_id_salle.php?salle=
          success(function(data1, status, headers, config) {
            $scope.json = data;
            $scope.salle = data1;
            displayPlanning();
            indicateursSalle(data1);        
            $http.get('recuperer_erreurs.php'). //    /GitHub/visualisation/content.php
              success(function(data2, status, headers, config) {
                $scope.json = data;
                $scope.salle = data1;
                $scope.err = data2.split(',');
                var count_err = $scope.err.length;
                $scope.err[0] = $scope.err[0].replace('[','');
                $scope.err[count_err - 1] = $scope.err[count_err - 1].replace(']','');
                var i = 0;
                while(i<count_err){
                  $scope.err[i] = $scope.err[i].replace('"','');
                  $scope.err[i] = $scope.err[i].replace('"','');
                  i = i + 1;
                }
                displayPlanning();  
                indicateursSalle(data1);  
              }).
              error(function(data2, status, headers, config) {
                console.log('ca marche pas');
            });                       
          }).
          error(function(data1, status, headers, config) {
            console.log('ca marche pas');
        });
      }).
      error(function(data, status, headers, config) {
        console.log('ca marche pas');
    });
  }

  var chargerDonneesIntervenant = function(){
    $http.get('content.php'). //    /GitHub/visualisation/content.php
      success(function(data, status, headers, config) {
        $http.get('recuperer_erreurs.php'). //    /GitHub/visualisation/content.php
          success(function(data1, status, headers, config) {
            $http.get('recuperer_disponibilites_enseignant.php?intervenant='+$scope.intervenant). //    /GitHub/visualisation/content.php
              success(function(data2, status, headers, config) {
                $scope.json = data;
                $scope.err = data1.split(',');

                var count_err = $scope.err.length;
                $scope.err[0] = $scope.err[0].replace('[','');
                $scope.err[count_err - 1] = $scope.err[count_err - 1].replace(']','');

                var i = 0;
                while(i<count_err){
                  $scope.err[i] = $scope.err[i].replace('"','');
                  $scope.err[i] = $scope.err[i].replace('"','');
                  i = i + 1;
                }

                displayPlanning(); 
                indicateursIntervenant($scope.intervenant);
              }).
            error(function(data2, status, headers, config) {
              console.log('ca marche pas');
          });
        }).
        error(function(data1, status, headers, config) {
            console.log('ca marche pas');
        });
      }).
      error(function(data, status, headers, config) {
        console.log('ca marche pas');
    });
  }



  var afficherDetailsSalle = function(salle_selected){
    $http.get('recuperer_info_salle.php?salle=' + salle_selected). //  /GitHub/visualisation/recuperer_id_salle.php?salle=
      success(function(info, status, headers, config) {
        $scope.infos = info;
        if($scope.infos != '<br/><br/> '){
          $('#details').html(info);
        }
      }).
      error(function(info, status, headers, config) {
        console.log('infos salle ca marche pas');
    });  
  }

  var afficherDetailsIntervenant = function(int_ID_intervenant){
    $http.get('recuperer_info_intervenant.php?intervenant=' + int_ID_intervenant). //  /GitHub/visualisation/recuperer_id_salle.php?salle=
      success(function(info, status, headers, config) {
        $scope.infos = info;
        console.log(info);
        if($scope.infos != '<br/><br/> '){
          $('#details').html(info);
        }
      }).
      error(function(info, status, headers, config) {
        console.log('infos salle ca marche pas');
    });  
  }

  var afficherOnglets = function(parent_id, salle_selected){
    $('#onglets').html('');
    if(parent_id>1){
      $http.get('recuperer_nb_salle.php?salle=' + salle_selected). //  /GitHub/visualisation/recuperer_id_salle.php?salle=
        success(function(nb, status, headers, config) {
          $scope.nb = nb;
          $http.get('recuperer_nom_salle.php?salle=' + salle_selected). //  /GitHub/visualisation/recuperer_id_salle.php?salle=
            success(function(nom, status, headers, config) {
              $scope.nom = nom;
              var nbr = 0;
              var nom_salle = "";

              while($scope.nom[nbr] != '>'){
                nom_salle += $scope.nom[nbr];
                nbr++;
              }
              nom_salle = nom_salle.slice(0,-4);
              $('#onglets').html('<li class="active onglet" id="'+nom_salle+'"><a href="">'+nom_salle+'</a></li>');
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
                document.getElementById('onglets').innerHTML+= '<li class="onglet" id="'+nom_salle+'"><a href="">'+nom_salle+'</a></li>';                            
              }
              var salle_selected = $(".active").attr("id");
              var r = [];
              chargerDonneesSalle(salle_selected);
              afficherDetailsSalle(salle_selected, r);
            }).
            error(function(nom, status, headers, config) {
              console.log('ca marche pas');
            });        
        }).
        error(function(nb, status, headers, config) {
          console.log('ca marche pas');
      });
    } 
  }



  var erreursCours = function(cours){

  $http.get('recuperer_liste_erreurs.php?cours='+cours). //    /GitHub/visualisation/content.php
      success(function(data, status, headers, config) {
        if(data.length == 7){
          $("#indic").html("<strong>Erreur(s) : </strong>Pas d'erreur.");
          var button = $('<div class = "col-md-offset-4"><a id="bouton_detail" class="btn btn-default" href="detailCours.php?cours='+cours+'" role="button">Détails Cours</a></div>');
          $("#indic").append(button);
        }

        else{
          $scope.erreurs = data.split(',');
          var count_erreurs = $scope.erreurs.length;
          $scope.erreurs[0] = $scope.erreurs[0].replace('[','');
          $scope.erreurs[count_erreurs - 1] = $scope.erreurs[count_erreurs - 1].replace(']','');
          var i = 0;
          while(i<count_erreurs){
            $scope.erreurs[i] = $scope.erreurs[i].replace('"','');
            $scope.erreurs[i] = $scope.erreurs[i].replace('"','');
            i = i + 1;
          }

          $("#indic").html('<strong>Erreur(s) : </strong><ul>');

          i = 0;
          while(i < count_erreurs){
            var erreur = $('<li>'+$scope.erreurs[i]+'</li>');
            $("#indic").append(erreur);
            i = i + 1;
          }
          var liste = $('</ul>');
          $("#indic").append(liste);
          var button = $('<div class = "col-md-offset-4"><a id="bouton_detail" class="btn btn-default" href="detailCours.php?cours='+cours+'" role="button">Détails Cours</a></div>');
          $("#indic").append(button);
        }
      }).
      error(function(data, status, headers, config) {
        console.log('ca marche pas');
    });
  }

  var indicateursSalle = function(salle_id){
    var moment = $('#calendar').fullCalendar('getDate');

    $http.get('recuperer_nb_erreurs_salle.php?salle='+salle_id). //    /GitHub/visualisation/content.php
      success(function(data, status, headers, config) {
        $http.get('recuperer_nb_erreurs_region.php?salle='+salle_id). //    /GitHub/visualisation/content.php
          success(function(data1, status, headers, config) {
            $http.get('recuperer_liste_intensite.php?salle='+salle_id+'&date='+moment.format()). //    /GitHub/visualisation/content.php
              success(function(data2, status, headers, config) {
                $http.get('recuperer_nb_erreurs_region_semaine.php?salle='+salle_id+'&date='+moment.format()). //    /GitHub/visualisation/content.php
                  success(function(data3, status, headers, config) {
                    $http.get('recuperer_nb_erreurs_salle_semaine.php?salle='+salle_id+'&date='+moment.format()). //    /GitHub/visualisation/content.php
                      success(function(data4, status, headers, config) {

                        $("#indic").html('');
                        $scope.erreurs = data;
                        $scope.erreurs_region = data1;
                        $scope.intensite = data2;
                        $scope.erreurs_semaine = data4;
                        $scope.erreurs_region_semaine = data3;
                        var count_intensite = $scope.intensite.length;
                        var i = 0;

                        var erreur = $('<div id="erreur"><strong>Erreur salle sur l\'année : </strong>'+$scope.erreurs[0]+' cours avec erreur sur '+$scope.erreurs[1]+' cours.</div>');
                        $("#indic").append(erreur);
                        var erreur_region = $('<div id="erreur"><strong>Erreur région sur l\'année : </strong>'+$scope.erreurs_region[0]+' cours avec erreur sur '+$scope.erreurs_region[1]+' cours.</div></br>');
                        $("#indic").append(erreur_region);
                        var erreur = $('<div id="erreur"><strong>Erreur salle sur la semaine : </strong>'+$scope.erreurs_semaine[0]+' cours avec erreur sur '+$scope.erreurs_semaine[1]+' cours.</div>');
                        $("#indic").append(erreur);
                        var erreur_region = $('<div id="erreur"><strong>Erreur région sur la semaine : </strong>'+$scope.erreurs_region_semaine[0]+' cours avec erreur sur '+$scope.erreurs_region_semaine[1]+' cours.</div></br>');
                        $("#indic").append(erreur_region);

                        var intensite = $('<div id="erreur"><strong>Intensités : </strong></br>');
                        $("#indic").append(intensite);
                        while(i < count_intensite){
                          var intensite = $('<div>'+$scope.intensite[i]+' : '+$scope.intensite[i+1]+' cours.</div>');
                          $("#indic").append(intensite);
                          i = i + 2;
                        }
                        var intensite = $('</div>');
                        $("#indic").append(intensite);
                      }).
                      error(function(data4, status, headers, config) {
                      console.log('ca marche pas');
                    });
                  }).
                  error(function(data3, status, headers, config) {
                    console.log('ca marche pas');
                });
              }).
                error(function(data2, status, headers, config) {
                  console.log('ca marche pas');
            });
          }).
          error(function(data1, status, headers, config) {
            console.log('ca marche pas');
        });
      }).
      error(function(data, status, headers, config) {
        console.log('ca marche pas');
    });
  }

  var indicateursIntervenant = function(int_ID_intervenant){
    var moment = $('#calendar').fullCalendar('getDate');

    $http.get('recuperer_nombre_cours_sur_disponibilite.php?id_intervenant='+int_ID_intervenant+'&date_debut_semaine='+moment.format()). //    /GitHub/visualisation/content.php
      success(function(data, status, headers, config) {
        $scope.nb_dispo = data;
        if($scope.nb_dispo.length == 10){
          $("#indic").html("<strong>Indicateur : </strong></br>L'intervenant ne donne pas de cours cette semaine.");
        }
        else{
          $("#indic").html("<strong>Indicateur : </strong></br>L'intervenant donne "+$scope.nb_dispo[1]+" cours pour "+$scope.nb_dispo[4]+" disponibilités.");
        }
      }).
      error(function(data, status, headers, config) {
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
  var color = new Array();
  var text_color = new Array();
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

          if($scope.typeplanning == 0){
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

              var nb_err = $scope.err.length;
              var count_err = 0;
              var flag = true;

              while((count_err < nb_err) && (flag == true)){
                if($scope.err[count_err] == $scope.json[count].class_id){
                  flag = false;
                }
                count_err = count_err + 2;
              }

              if (flag == false) {
                color.push("rgb(207,16,26)");
                text_color.push("rgb(251,210,20)");
              }

              else if(flag == true){
                color.push("rgb(251,210,20)");
                text_color.push("rgb(17,81,160)");
              }
            }
          }

          else if($scope.typeplanning == 1){
            var nb_intervenant = $scope.json[count].teacher_list.length;
            var count_inter = 0;
            var nb_hote = $scope.json[count].host_list.length;
            var count_hote = 0;

            while(count_inter < nb_intervenant){

              if($scope.json[count].teacher_list[count_inter] == $scope.intervenant){

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
                var nb_err = $scope.err.length;
                var count_err = 0;
                var flag = true;

                while((count_err < nb_err) && (flag == true)){
                  if($scope.err[count_err] == $scope.json[count].class_id){
                    flag = false;
                  }
                  count_err = count_err + 2;
                }

                if (flag == false) {
                  color.push("rgb(207,16,26)");
                  text_color.push("rgb(251,210,20)");
                }

                else if(flag == true){
                  color.push("rgb(251,210,20)");
                  text_color.push("rgb(17,81,160)");
                }
              }
              count_inter = count_inter + 1;
            }

            while(count_hote < nb_hote){

              if($scope.json[count].host_list[count_hote] == $scope.intervenant){

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
              count_hote = count_hote + 1;
            }
          }

            compt = compt + 1;
            count = count + 1;
          }
        }
        
    while(count_json < id_class.length){

      var i = 0;
      var obj = {};
      tmp = ['title', 'start', 'end', 'color', 'textColor'];

      obj[tmp[0]] = id_class[count_json];
      obj[tmp[1]] = start_time[count_json];
      obj[tmp[2]] = end_time[count_json];
      obj[tmp[3]] = color[count_json];
      obj[tmp[4]] = text_color[count_json];

      json.push(obj);
      count_json = count_json + 1;
    }

    var planning = json;

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
          erreursCours(cours);

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
    aspectRatio: 1.59,
    defaultDate: '2015-03-02',
    editable: true,
    eventLimit: true,
    eventStartEditable : false,
    eventDurationEditable : false,
    events: planning,
    eventBackgroundColor : "rgb(251,210,20)",
    eventBorderColor : "rgb(17,81,160)",
    eventTextColor : "rgb(17,81,160)"
    //http://fullcalendar.io/docs/event_data/Event_Object/#color-options  Pour la couleur individuelle des éléments
  });
    
    $(".fc-button-group").on('click', function (event) {
      if($scope.typeplanning == 0){
        indicateursSalle($scope.salle);
      }
      else if($scope.typeplanning == 1){
        indicateursIntervenant($scope.intervenant);
      }
    });
  }


  $( document ).ready(function() {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == "intervenant") 
        {
          $scope.typeplanning = 1;
          $scope.intervenant = sParameterName[1];
          chargerDonneesIntervenant();
          afficherDetailsIntervenant(sParameterName[1]);
        }
    }
});
});
