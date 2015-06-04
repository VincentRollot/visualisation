$(function () {
  $('#jstree')
    .jstree({
    'core' : {
      'data' : {
        'url' : function (node) {
          return node.id === '#' ? 
            'root.json' : 
            'children.json';
        },
        'data' : function (node) {
          return { 'id' : node.id };
        }
      }
    },
    "types" : {
      "root" : {
        "icon" : "glyphicon glyphicon-flash",
        "valid_children" : ["default"]
      },
      "default" : {
        "icon" : "fa fa-map-marker",
        "valid_children" : ["default"]
      }
    },

    "plugins" : [ "search" , "sort" , "types"]
    })
    
    .on('changed.jstree', function (e, data) {
      if(data && data.selected && data.selected.length) {
      var i, j, r = [];
      var salle_selected;
      for(i = 0, j = data.selected.length; i < j; i++) {
        r.push(data.instance.get_node(data.selected[i]).text);
        salle_selected = data.instance.get_node(data.selected[i]).text;
      }
      $('#details').html('Information de la salle: ' + r.join(', '));
      }
    });

  var to = false;
  $('#research').keyup(function () {
    if(to) { clearTimeout(to); }
    to = setTimeout(function () {
      var v = $('#research').val();
      $('#jstree').jstree(true).search(v);
    }, 250);
  });


});