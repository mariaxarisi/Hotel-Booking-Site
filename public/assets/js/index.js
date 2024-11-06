document.addEventListener("DOMContentLoaded", ()=>{
    
    const dateRegEx = /^(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])\/(19|20)\d\d$/;
    const $submit = document.querySelector("#submit");
    const $inputCity = document.querySelector("#city");
    const $inputRoomType = document.querySelector("#room_type");
    $("#datepicker1").datepicker({minDate: 0,});
    $("#datepicker2").datepicker({minDate: 0,});

    class Search {
        constructor(city, roomType, checkIn, checkOut){
            this.city = city;
            this.roomType = roomType;
            this.checkIn = checkIn;
            this.checkOut = checkOut;
        }
        allValid(){
            if(dateRegEx.test(this.checkIn) && dateRegEx.test(this.checkOut) && this.city != undefined && this.roomType != undefined){
                $submit.classList.remove("disabled");
                $submit.classList.add("active");
                $submit.disabled = false;
            }
            else{
                $submit.classList.add("disabled");
                $submit.classList.remove("active");
                $submit.disabled = true;
            }
        }
    }

    let search = new Search();

    $inputCity.addEventListener("change", (e)=>{
        if(e.target.value != "none")
            search.city = e.target.value;
        else
            search.city = undefined;
        search.allValid();
    })
    $inputRoomType.addEventListener("change", (e)=>{
        if(e.target.value != 0)
            search.roomType = e.target.value;
        else
            search.roomType = undefined;
        search.allValid();
    })
    $("#datepicker1").on("change", function() {
        search.checkIn = $(this).val();
        $("#datepicker2").datepicker("option", "minDate", search.checkIn);
        search.allValid();
    });
    $("#datepicker2").on("change", function() {
        search.checkOut = $(this).val();
        $("#datepicker1").datepicker("option", "maxDate", search.checkOut);
        search.allValid();
    });

})