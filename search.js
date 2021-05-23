function searchFunction() {
    var input, filter, table, tr, td, i, searchValue, txtValue;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    table = document.getElementById("table");
    tr = table.getElementsByTagName("tr");
    searchValue = document.getElementById("search_select").value;

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[searchValue];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}