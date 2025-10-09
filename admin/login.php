 <!DOCTYPE html>
 <html lang="en">

   <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link
       href="https://fonts.googleapis.com/css2?family=Battambang:wght@100;300;400;700;900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
       rel="stylesheet">
     <link rel="stylesheet" href="style/icon/css/all.min.css">
     <link rel="stylesheet" href="style/css/bootstrap.min.css">
     <link rel="stylesheet" href="style/style-login.css">
     <script src="js/jquery.js"></script>

   </head>

   <body>
     <section>
       <h2>Login</h2>
       <div class="frm">
         <form class="upl" action="action/login-user.php" method="POST">
           <div class="input-box">
             <span class="icon">
               <i class="fa-solid fa-envelope"></i>
             </span>
             <input type="email" name="email" id="txt-email" required>
             <label for="">User Email</label>
           </div>
           <div class="input-box">
             <span class="icon">
               <i class="fa-solid fa-lock"></i>
             </span>
             <input type="password" name="password" id="txt-password" required>
             <label for="">Password</label>
           </div>
           <div class="rememer-forgot">
             <label for="">
               <input type="checkbox" name="remember" id="txt-remember">
               Remember me
             </label>
           </div>
           <button type="submit" class="btn btn-primary">Login</button>
           <div class="forgot-pass">
             <a href="#">Forgot Password?</a>
           </div>
         </form>
       </div>
     </section>
   </body>
   <script>
   $(document).ready(function() {
     var uEmail = $('#txt-email');
     var uPass = $('#txt-password')
     //For showing the password when we input.
     $('#txt-remember').click(function() {
       uPass.attr('type', this.checked ? 'text' : 'password');
     });

     //forgot password
     // $('.forgot-pass').click(function() {
     //   if (uEmail.val() == "") {
     //     alert("Please input email.");
     //     uEmail.focus();
     //     return;
     //   }
     //   var eThis = $(this);
     //   var frm = eThis.closest('form.upl');
     //   var frm_data = new FormData(frm[0]);
     //   $.ajax({
     //     url: 'action/new-pass.php',
     //     type: 'POST',
     //     data: frm_data,
     //     contentType: false,
     //     cache: false,
     //     processData: false,
     //     dataType: "json",
     //     // beforeSend:function(){

     //     // },
     //     success: function(data) {
     //       if (data.dpl == false) {
     //         alert("Please input email or password again.");
     //         return;
     //       } else {
     //         alert("New password is send to your email.");
     //         return;
     //       }

     //     }
     //   });
     // })

     //Update login button handler
     $('.btn-primary').click(function(e) {
       e.preventDefault();
       // Prevent form submission
       if (uEmail.val() == '') {
         alert('Please input email.');
         uEmail.focus();
         return;
       } else if (uPass.val() == '') {
         alert('Please input password.');
         uPass.focus();
         return;
       }
       var eThis = $(this);
       var frm = eThis.closest('form.upl');
       var frm_data = new FormData(frm[0]);
       $.ajax({
         url: 'action/login-user.php',
         type: 'POST',
         data: frm_data,
         contentType: false,
         cache: false,
         processData: false,
         dataType: "json",
         // beforeSend:function(){

         // },
         success: function(data) {
           if (data.dpl === false) {
             alert("Please input email or password again.");
             return;
           } else {
             window.location.href = "index.php";
           }
         }
       });
     });
   });
   </script>

 </html>