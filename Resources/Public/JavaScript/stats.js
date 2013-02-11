function graphByCount( containerId ) {
  var height = 220;
  var width  = 560;

  var x = 20;
  var y = 20;
  var gutter = 10; //Math.floor((width - 2 * gutter) / 20)

  var r = Raphael( containerId, 560, height ), txtattr = { font:"10px sans-serif" };

  //r.text( 280, 10, "Top Downloads" ).attr( txtattr );

  // Show only 10 slices of pie
  var pieEntries = 10;

  var container = $( '#' + containerId );
  var values = $.map( container.attr( 'data-graph' ).split( ',' ), function( value ) {
    return parseInt( value, 10 );
  } );

  var remaining = values.slice( pieEntries - 1 );
  values = values.slice( 0, pieEntries - 1 );

  var total = 0;
  $.each( remaining, function() {
    total += this;
  } );
  values.push( total );


  var labels = container.attr( 'data-labels' ).split( ',' ).slice( 0, pieEntries - 1 );
  labels.push( "Andere" );
  // Add count to labels
  labels = $.map( labels, function( item, index ){ return "##x " + item; } );

  var pie = r.piechart( 110, 110, 100,
    values,
    { legend:labels, legendpos: "east" }
  ).attr( txtattr );

  pie.hover(function () {
    this.sector.stop();
    this.sector.scale(1.1, 1.1, this.cx, this.cy);

    if (this.label) {
      this.label[0].stop();
      this.label[0].attr({ r: 7.5 });
      this.label[1].attr({ "font-weight": "bold" });
    }
  }, function () {
    this.sector.animate({ transform: 's1 1 ' + this.cx + ' ' + this.cy }, 500, "bounce");

    if (this.label) {
      this.label[0].animate({ r: 5 }, 500, "bounce");
      this.label[1].attr({ "font-weight": "normal" });
    }
  });
}

function graphByDate( containerId ) {
  var height = 220;
  var width  = 560;
  var gutter = 10;
  var x = 20;
  var y = 20;


  var r = Raphael( containerId, width, height ), txtattr = { font:"12px sans-serif" };

  //r.text( 290, 10, "Downloads pro Tag" ).attr( txtattr );

  var pastDate = new Date();
  pastDate.setDate( pastDate.getDate() - 30 );

  var daysInMonth = 30;
  var days = [];
  var labels = [];

  for( var i = 0; i < daysInMonth + 1; ++i ) {
    days[ i ] = i;// pastDate.getDate();
    labels[ i ] = pastDate.getDate();
    pastDate.setDate( pastDate.getDate() + 1 );
  }

  var container = $( '#' + containerId );
  var values = $.map( container.attr( 'data-graph' ).split(','), function( value ) {
    return parseInt(value, 10);
  });

  var chart = r.linechart( x, y, width - x, height - y*2, days, values, { axis:"0 0 0 1", shade:true, symbol:"circle", width:3 } ).hoverColumn(
    function() {
      this.tags = r.set();

      for (var i = 0, ii = this.y.length; i < ii; i++) {
        this.tags.push(r.tag(this.x, this.y[i], this.values[i], 160, 10).insertBefore(this).attr([{ fill: "#fff" }, { fill: this.symbols[i].attr("fill") }]));
      }
    },
    function() {
      this.tags && this.tags.remove();
    }
  );
  chart.symbols.attr({ r: 4 });


  Raphael.g.axis( x + gutter, height - y-gutter, width - x*2, 0, 29, 30, 0, labels, r);
}

/**
 * Renders a pie chart that shows the top referrers.
 * @param containerId The ID of the DOM element in which the rendering will be placed.
 */
function graphByReferrer( containerId ) {
  var height = 220;
  var width  = 560;

  var x = 20;
  var y = 20;
  var gutter = 10; //Math.floor((width - 2 * gutter) / 20)

  var r = Raphael( containerId, 560, height ), txtattr = { font:"10px sans-serif" };

  //r.text( 280, 10, "Top Referrer" ).attr( txtattr );

  // Show only 10 slices of pie
  var pieEntries = 10;

  var container = $( '#' + containerId );
  var values = $.map( container.attr( 'data-graph' ).split( ',' ), function( value ) {
    return parseInt( value, 10 );
  } );

  var remaining = values.slice( pieEntries - 1 );
  values = values.slice( 0, pieEntries - 1 );

  var total = 0;
  $.each( remaining, function() {
    total += this;
  } );
  values.push( total );


  var labels = container.attr( 'data-labels' ).split( ',' ).slice( 0, pieEntries - 1 );
  labels.push( "Andere" );
  // Add count to labels
  labels = $.map( labels, function( item, index ){ return "##x " + item; } );

  var pie = r.piechart( 110, 110, 100,
    values,
    { legend:labels, legendpos: "east" }
  ).attr( txtattr );

  pie.hover(function () {
    this.sector.stop();
    this.sector.scale(1.1, 1.1, this.cx, this.cy);

    if (this.label) {
      this.label[0].stop();
      this.label[0].attr({ r: 7.5 });
      this.label[1].attr({ "font-weight": "bold" });
    }
  }, function () {
    this.sector.animate({ transform: 's1 1 ' + this.cx + ' ' + this.cy }, 500, "bounce");

    if (this.label) {
      this.label[0].animate({ r: 5 }, 500, "bounce");
      this.label[1].attr({ "font-weight": "normal" });
    }
  });
}