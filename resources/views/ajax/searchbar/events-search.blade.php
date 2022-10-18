<style>
    .fa-magnifying-glass{
        margin-left: -90px;
        color: #797775;
    }
</style>
<section class="search-bar">
    {{-- <form action="" method="get"> --}}
        {{-- <label for="search">Buscar Evento</label> --}}
        <input placeholder="Buscar por nome ou cidade" type="text" name="event" id="search-event">
        <button type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
    {{-- </form> --}}
</section>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    $('#search-event').keyup(function(){
        // if(this.value){
            data = this.value;
            url = 'ajax/search-events?event='+data;
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'json',
                success : function(result){
                    console.log(result);
                    // $('.panel-cards').remove();
                    // var tr = `<section class="panel-cards flex">`;
                    var tr = ``;
                    result.forEach(element => {
                        var day = new Date(element['day']);
                            day = day.getDate()+'/'
                            +(day.getMonth()+1)+'/'
                            +day.getFullYear();
                        tr+= `
                                <div class="event-card">
                                    <a href="event-detail/`+element['id']+`">
                                        <div class="event">
                                            <img src="`+element['poster']+`" alt="">
                                            <div class="data-card">
                                                <h5>`+element['name']+`</h5>
                                                <span class="location"><i class="fa-solid fa-map-location-dot"></i>`+element['city']+` - `+element['uf']+`</span>
                                                <span class="value"><i class="fa-solid fa-cart-shopping"></i> R$ `+element['value_ticket']+`</span>
                                                <span class="date"><i class="fa-solid fa-calendar"></i>`+day+` &nbsp;&nbsp;&nbsp;<i class="fa-solid fa-clock"></i>  `+element['start']+`</span>
                                            </div>
                                        </div>
                                    </a>
                                    </div>
                                </div>
                        `;
                    });
                    tr+=`</section>`;
                    $res = $(tr);
                    $('.panel-cards').html(tr);
                }
            });
        // }
    })
</script>
