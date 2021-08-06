
let id = $("input[name*='spare_id']")
id.attr("readonly","readonly");


$(".btnedit").click( e =>{
    let textvalues = displayData(e);

    ;
    let sparename = $("input[name*='spare_name']");
    let mfgname = $("input[name*='manufacturer_name']");
    let unitprice = $("input[name*='unit_price']");

    id.val(textvalues[0]);
    sparename.val(textvalues[1]);
    mfgname.val(textvalues[2]);
    unitprice.val(textvalues[3].replace("$", ""));
});


function displayData(e) {
    let id = 0;
    const td = $("#tbody tr td");
    let textvalues = [];

    for (const value of td){
        if(value.dataset.id == e.target.dataset.id){
           textvalues[id++] = value.textContent;
        }
    }
    return textvalues;

}