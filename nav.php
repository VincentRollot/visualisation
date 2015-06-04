<link rel="stylesheet" type="text/css" href="css/customMainPage.css" />
<link rel="stylesheet" type="text/css" href="css/customAccueil.css" />
<link rel="stylesheet" href="dist/themes/default/style.min.css" />
<script src="dist/jstree.min.js"></script>
<div  class="col-md-2" id="nav">
  <div class="form-group">
    <div class="input-group">
      <span class="input-group-addon">
      <i class="fa fa-search"></i></span>
      <input id="research"
             type="text"
             class="form-control bordure"
             ng-model="search"
             placeholder="Rechercher...">
    </div>
  </div>
  <div id="jstree">    
  </div>

  <script>
  $(function () {
    // 6 create an instance when the DOM is ready
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
  </script>
</div>
