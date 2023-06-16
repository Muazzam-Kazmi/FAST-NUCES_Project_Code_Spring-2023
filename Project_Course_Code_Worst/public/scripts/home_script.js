
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function account_dropdown_func() {
    document.getElementById("account_dropdown").classList.toggle("show");
  }
  
  // Close the dropdown menu if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches('.account_dropdown_btn')) {
      var dropdowns = document.getElementsByClassName("account_dropdown_content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  }