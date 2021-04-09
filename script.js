// The formData object provides an easy way to serialize form fields into key/value pairs.
//formData constructor
// The serialize() method creates a URL encoded text string by serializing form values. You can select one or more form elements (like input and/or text area), or the form element itself. The serialized values can be used in the URL query string when making an AJAX request.
// AJAX:- AJAX (asynchronous JavaScript and XML) is the art of exchanging data with a server and updating parts of a web page – without reloading the entire page.

// loginForm
$(document).ready(function() {
    $('#loginForm').submit(function(event) {
      // let form = document.getElementById('loginForm');
        // Create an FormData object
        let formdata = $(this).serialize();
          event.preventDefault();
        $.ajax({
            type: "POST",
            data: formdata,
            url: "proxy.php",
            dataType: 'json',
         }).done(function(e) {
                if(e.response === 200) {
                    setTimeout(function() {
                        location.reload(); // reload page
                    }, 500);
                } else if(e.response === 401) {
                    alert(e.message);
                } else if(e.response === 404) {
                    alert("No such account");
                } else {
                    alert("Login unsuccessful. Please try again");
                }
          });
      });

      // Request from API from createTransaction
    $('#transactionForm').submit( function (event) {
        const formdata = $(this).serialize();

        const date = new Date($(this).find("input")[0].value);
        // const date = $("#created").val();
        let empty = false;
        $('input[type="text"]', '#transactionForm').each(function() {
            if($(this).val()=="") {
                empty = true;
                return true;
            }
        });
        if(empty == true) {
            alert("Please complete the form");
        }
          //regex
        else if(!(/^\d{4}-\d{2}-\d{2}$/).test($(this).find("input")[0].value) || (date instanceof Date && isNaN(date.valueOf()))) {
            $(this).find("input")[0].focus();
        }
        else if(isNaN(parseFloat($(this).find("input")[2].value)) || parseInt($(this).find("input")[2].value) == 0) {
            alert("The amount should be a valid number");
            $(this).find("input")[2].focus();
        } else {
            $.ajax({
                type: "POST",
                data: formdata,
                url: "proxy.php",
                dataType: 'json',
            }).done(function(e) {
                console.log(e);
                if(e.response === 200) {
                    alert("Transaction successfully added!");
                    setTimeout(function () {
                        location.reload(); // reload page
                    }, 200);
                } else if(e.response === 407) {
                    alert("Please complete form or login");
                } else {
                    alert("transaction not complete");
                }
            });
        }

        event.preventDefault();
    });
});

// function displayLoginForm() {
    //        $("#loginForm").show();
    //        $("#transactionForm").hide();
    //    }
    //
    // function displayTransactionForm() {
    //        $("#transactionForm").show();
    //        $("#loginForm").hide();
    //    }
