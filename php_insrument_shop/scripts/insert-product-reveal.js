function showInsertSection() {
    let section = document.getElementById("insert-product-adminsect");

    if(section.style.display === "none") {
        section.style.display = "block";
    } else {
        section.style.display = "none";
    }
}