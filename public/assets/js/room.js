document.addEventListener("DOMContentLoaded", ()=>{
    const $form = document.querySelector("form");
    const $textarea = document.querySelector("#review");
    const $stars = document.querySelectorAll(".add-review  i");
    const $submit = document.querySelector("#submit");
    const $starCount = document.querySelector("#starCount");

    class Review{
        constructor(stars, reviewText, date){
            this.stars = stars;
            this.reviewText = reviewText;
            this.date = date;
        }
        reset(){
            this.stars = 0;
            this.reviewText = "";
            this.date = 0;
        }
        allValid(){
            if(this.stars!=0 && this.reviewText!=0){
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

    let reviews = new Array();
    let review = new Review(0, "", 0);
    
    $stars.forEach((star, index) => {
        star.addEventListener("mouseenter", ()=>{
            for(let i=1; i<=index+1; i++)
                document.querySelector(`#star${i}`).classList.add("yellow-star");
        })
        star.addEventListener("mouseleave", ()=>{
            for(let i=1; i<=5; i++)
                document.querySelector(`#star${i}`).classList.remove("yellow-star");
        })
    });
    $stars.forEach((star, index)=>{
        star.addEventListener("click", (e)=>{
            for(let i=1; i<=index+1; i++)
                document.querySelector(`#star${i}`).style.color = "#ffd000";
            for(let i=index+2; i<6; i++)
                document.querySelector(`#star${i}`).style.color = "rgb(192, 191, 191)";
            review.stars = index+1;
            $starCount.value = review.stars;
            review.allValid();
        })
    })
    $textarea.addEventListener("input", (e)=>{
        review.reviewText = e.target.value;
        review.allValid();
    })
    $form.addEventListener("submit", (e)=>{
        e.preventDefault();
        review.date = new Date();
        reviews.push(new Review(review.stars, review.reviewText, review.date));
        review.reset();
        review.allValid();
        $textarea.value = "";
        $stars.forEach((star)=>{
            star.style.color = "";
        })
    })
})  