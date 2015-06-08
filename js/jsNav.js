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

    "plugins" : [ "search" , "types"]
    })

  var to = false;
  $('#research').keyup(function () {
    if(to) { clearTimeout(to); }
    to = setTimeout(function () {
      var v = $('#research').val();
      $('#jstree').jstree(true).search(v);
    }, 250);
  });


});