<main role="main">

  <section class="jumbotron text-center">
    <div class="container">
      <h1>Our Event This Year</h1>
      <p class="lead text-muted">These are our event this year. Join With Us !</p>
      <?=$this->session->flashdata('message') ?>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row mb-5">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              Filter:
              <input type="text" name="" class="form-control" id="filter" placeholder="Search . . .">
            </div>
            <div class="col-md-6">
              Sort:
              <select name="" class="form-control" id="sort">
                <option value="new">Newest to old</option>
                <option value="price">Lower to highest Price</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="row" id="result"></div>
    </div>
  </div>
</main>

<script>
  $(document).ready(function(){
    var result = '';
    var token = localStorage.getItem('member-token');
    
    
    $.ajax({
        url : "<?=site_url('api/event-member') ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          if(data.length == 0){
            result = '<p class="alert alert-danger">Data is empty!</p>';
          }else{

            for(var x = 0; x < data.length; x++){
              if(token === null){
                var button = '<button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#exampleModal">Login To Join</button>'
              }else{
                  var button = '<a href="<?=site_url('order/') ?>'+data[x].id_event+'" class="btn btn-sm btn-outline-primary">Join Us</a>';
              }

              result += `
                <div class="col-md-4">
                  <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                      <h3>`+data[x].event_name+`</h3>
                    </div>
                    <div class="card-body">
                      <p class="card-text mb-1">Location : `+data[x].location+`</p>
                      <p class="card-text mb-1">Time : `+data[x].time+`</p>
                      <p class="card-text mb-1">Date : `+tgl_indo(data[x].date)+`</p>
                      <p class="card-text mb-4">Price : `+formatRupiah(data[x].price, 'IDR ')+`</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                          `+button+`
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              `;
            }
          }
          $("#result").html(result);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          console.log(jqXHR.responseJSON.message);
        }
    });
  })

  $("select").change(function(){
      var x = $(this).val();

      var result = '';
      var token = localStorage.getItem('member-token');

      if(x == 'new'){
        var url = "<?=site_url('api/event-member/new') ?>";
      }else{
        var url = "<?=site_url('api/event-member/price') ?>";
      }

      $.ajax({
          url : url,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
            if(data.length == 0){
              result = '<p class="alert alert-danger">Data is empty!</p>';
            }else{

              for(var x = 0; x < data.length; x++){
                if(token === null){
                  var button = '<button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#exampleModal">Login To Join</button>'
                }else{
                  var button = '<a href="<?=site_url('order/') ?>'+data[x].id_event+'" class="btn btn-sm btn-outline-primary">Join Us</a>';
                }

                result += `
                  <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                      <div class="card-header">
                        <h3>`+data[x].event_name+`</h3>
                      </div>
                      <div class="card-body">
                        <p class="card-text mb-1">Location : `+data[x].location+`</p>
                        <p class="card-text mb-1">Time : `+data[x].time+`</p>
                        <p class="card-text mb-1">Date : `+tgl_indo(data[x].date)+`</p>
                        <p class="card-text mb-4">Price : `+formatRupiah(data[x].price, 'IDR ')+`</p>
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="btn-group">
                            `+button+`
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                `;
              }
            }
            $("#result").html(result);
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            console.log(jqXHR.responseJSON.message);
          }
        });
  });

  $("#filter").keypress(function(){
    var y = $(this).val();
    
    var result = '';
    var token = localStorage.getItem('member-token');

    var url = "<?=site_url('api/event-member/search') ?>";
    
    $.ajax({
          url : url,
          type: "POST",
          data :{keyword : y},
          dataType: "JSON",
          success: function(data)
          {
            if(data.length == 0){
              result = '<p class="alert alert-danger">Data is empty!</p>';
            }else{

              for(var x = 0; x < data.length; x++){
                if(token === null){
                  var button = '<button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#exampleModal">Login To Join</button>'
                }else{
                  var button = '<a href="<?=site_url('order/') ?>'+data[x].id_event+'" class="btn btn-sm btn-outline-primary">Join Us</a>';
                }

                result += `
                  <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                      <div class="card-header">
                        <h3>`+data[x].event_name+`</h3>
                      </div>
                      <div class="card-body">
                        <p class="card-text mb-1">Location : `+data[x].location+`</p>
                        <p class="card-text mb-1">Time : `+data[x].time+`</p>
                        <p class="card-text mb-1">Date : `+tgl_indo(data[x].date)+`</p>
                        <p class="card-text mb-4">Price : `+formatRupiah(data[x].price, 'IDR ')+`</p>
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="btn-group">
                            `+button+`
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                `;
              }
            }
            $("#result").html(result);
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            console.log(jqXHR.responseJSON.message);
          }
        });
  });
</script>