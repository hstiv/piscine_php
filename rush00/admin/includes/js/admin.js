document.addEventListener("DOMContentLoaded", function() {

    var adminDelete = document.querySelectorAll(".admin__delete");

    if ( adminDelete.length )
        document.addEventListener("click", function(event) {
            if (event.target.className == "admin__delete")
                if ( !confirm("Are you sure you want to delete this user?") )
                    event.preventDefault();
        });
});