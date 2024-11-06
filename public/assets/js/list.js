document.addEventListener("DOMContentLoaded", ()=>{
    
    $("#check-in").datepicker({minDate: 0,});
    $("#check-out").datepicker({minDate: 0,});
    
    const minGap = 10;
    const dateRegEx = /^(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])\/(19|20)\d\d$/;
    const $slider1 = document.querySelector("#slider1");
    const $slider2 = document.querySelector("#slider2");
    const $rangeMin = document.querySelector("#rangeMin");
    const $rangeMax = document.querySelector("#rangeMax");
    const $submit = document.querySelector("#submit");
    const $inputCity = document.querySelector("#city");
    const $inputRoomType = document.querySelector("#room_type");


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

    let search = new Search($inputCity.value, $inputRoomType.value, $("#check-in").val(), $("#check-out").val());

    $slider1.oninput = function(){
        if(parseInt($slider2.value)-parseInt($slider1.value) <= minGap)
            $slider1.value = parseInt($slider2.value)-minGap;
        $rangeMin.innerHTML = `${$slider1.value}&euro;`;
    }
    $slider2.oninput = function(){
        if(parseInt($slider2.value)-parseInt($slider1.value) <= minGap)
            $slider2.value = parseInt($slider1.value)+minGap;
        $rangeMax.innerHTML = `${$slider2.value}&euro;`;
    }
    $("#check-in").on("change", function() {
        search.checkIn = $(this).val();
        $("#check-out").datepicker("option", "minDate", search.checkIn);
        search.allValid();
    });
    $("#check-out").on("change", function() {
        search.checkOut = $(this).val();
        $("#check-in").datepicker("option", "maxDate", search.checkOut);
        search.allValid();
    });
    $inputCity.addEventListener("change", (e)=>{
        if(e.target.value != "none")
            search.city = e.target.value;
        else
            search.city = undefined;
        search.allValid();
    })
    $inputRoomType.addEventListener("change", (e)=>{
        if(e.target.value != "none")
            search.roomType = e.target.value;
        else
            search.roomType = undefined;
        search.allValid();
    })
})