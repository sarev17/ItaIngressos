<section class="search-bar">
    <form action="" method="post">
        <label for="search">Buscar Evento</label>
        <input type="text" name="event" id="search-event">
        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    $('#search-event').keyup(function(){
        if(this.value != ''){
            data = this.value;
            url = 'ajax/search-events?event='+data;
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'json',
                success : function(result){
                    console.log(result);
                    // $('.panel-cards').remove();
                    var tr = `<section class="panel-cards flex">`;
                    result.forEach(element => {
                        var day = new Date(element['day']);
                            day = day.getDate()+'/'
                            +(day.getMonth()+1)+'/'
                            +day.getFullYear();
                        tr+= `
                                <div class="card">
                                    <img src="`+element['poster']+`" alt="">
                                    <br>
                                    <h5>`+element['name']+`</h5>
                                    <span>Entrada: R$ `+element['value_ticket']+`</span>
                                    <span><b>`+day+` as  `+element['start']+`</b></span>
                                    <a class="btn btn-primary" href="event-detail/`+element['id']+`">Comprar ingresso</a>
                                </div>
                        `;
                    });
                    tr+=`</section>`;
                    $res = $(tr);
                    $('.panel-cards').html(tr);
                }
            });
        }
    })
</script>
