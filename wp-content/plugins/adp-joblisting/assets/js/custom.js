jQuery(document).ready(function($) {
    // var jobs = '';
    // $.getScript("https://abpjobs.elvirainfotech.live/wp-content/plugins/adp-joblisting/assets/data.js", function() {
    //      console.log(jobdata.jobRequisitions.length); 
    //     console.log(jobdata);
    //     //console.log(typeof jobdata.jobRequisitions['0']);


    //     // $.each(jobdata.jobRequisitions, function(index, value) {
    //     //     console.log("---------------------------");
    //     //     $.each(value, function(k, v) {
    //     //         if(typeof v === "object"){
    //     //             console.log('object2');
    //     //     $.each(v, function(i, j)  {   
    //     //         console.log(j)  
    //     //             $.each(j, function(k1, l) {
                        
    //     //             console.log("Key: " + k1 + ", Value: " + l);
    //     //             });
    //     //         });
    //     //         }else{
    //     //             console.log("Key: " + k + ", Value: " + v);
    //     //         }
                
    //     //     });
    //     //     console.log("---------------------------");

    //     // })

});
//console.log(jobdata);

document.querySelectorAll(".accordion-item").forEach((item) => {
    item.querySelector(".accordion-item-header").addEventListener("click", () => {
      item.classList.toggle("open");
    });
  });  